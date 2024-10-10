<?php

require "db.php";
global $conn;

$start = 0;
$limit = 18;

$sql = "
        SELECT * 
        FROM buecher AS b, kategorien AS k, zustaende AS z
        WHERE b.kategorie = k.id 
        AND b.zustand = z.zustand 
        AND 1=1
        ";

if (isset($_GET['submit'])) {
    // Buchnummer suche
    if (!empty($_GET['search']) && is_numeric($_GET['search'])) {
        $search_term = mysqli_real_escape_string($conn, $_GET['search']);
        $sql .= " AND (nummer = $search_term)";
    } else {
        // Suche durch Buchname und Autor
        $search_term = mysqli_real_escape_string($conn, $_GET['search']);
        $sql .= " AND (autor LIKE '%{$search_term}%' OR kurztitle LIKE '%{$search_term}%') ";
    }
    // Filerung
    if (!empty($_GET['kategorie'])) {
        $category = mysqli_real_escape_string($conn, $_GET['kategorie']);
        $sql .= " AND k.kategorie = '{$category}'";
    }
    if (!empty($_GET['verkauft'])) {
        $verkauft = intval($_GET['verkauft']); // Ensure integer value
        $sql .= " AND verkauft = {$verkauft}";
    }
    if (!empty($_GET['zustand'])) {
        $condition = mysqli_real_escape_string($conn, $_GET['zustand']);
        $condition = strtoupper($condition[0]);
        $sql .= " AND z.zustand = '{$condition}'";
    }

    // Sortierung
    $sortierBei = $_GET['sortieren'] ?? 'b.id';
    $sortOrder = (isset($_GET['order']) && $_GET['order'] === 'desc') ? 'DESC' : 'ASC';

    $splaten = ['kurztitle', 'nummer', 'katalog', 'zustand'];
    if (in_array($sortierBei, $splaten)) {
        $sql .= " ORDER BY $sortierBei $sortOrder";
    } else {
        $sql .= " ORDER BY b.id ASC ";
    }

    $sql .= " LIMIT $start, $limit";

    $resultat = $conn->query($sql);
    if ($resultat) {
        $buecher = mysqli_fetch_all($resultat, MYSQLI_ASSOC);
    } else {
        echo "Fehler in query: " . mysqli_error($conn);
    }
}
else {
    $buecher = $conn->query($sql);
}

// pagination
$alleBuecher = $conn->query("SELECT COUNT(*) FROM buecher")->fetch_row()[0];
$seiten = ceil($alleBuecher / $limit);

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $seite = $_GET['page'];
    $start = ($seite - 1) * $limit;
} else {
    $seite = 1;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Bookstore</title>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="description" content="" />
    <link rel="stylesheet" href="styles.css" id="theme">
    <link rel="icon" href="./../assets/buch.png">
</head>
<body>

<?php include "./../components/Navbar.php"; ?>

<form method="get" action="website.php" class="filter">
    <div class="search-bar">
        <div class="part-1">
            <img src="../assets/search.svg" alt="Suchen" />
            <input type="text" name="search" placeholder="Suche nach Buchname, Autor oder Nummer">
        </div>
        <img src="../assets/filter.svg" alt="Filtern" id="filter-icon" />
    </div>
    <div id="filter-ui">
<?php
        $kategorien = $conn->query("SELECT DISTINCT kategorie FROM kategorien");
        $zustaende = $conn->query("SELECT DISTINCT SUBSTRING(zustand, 1, 1) as zustand FROM zustaende");
        $verkauft = $conn->query("SELECT DISTINCT verkauft FROM buecher");
?>
        <select name="kategorie">
            <option value="">Alle Kategorien</option>
            <?php while ($row = $kategorien->fetch_assoc()): ?>
                <option value="<?php echo $row['kategorie']; ?>">
                    <?php echo $row['kategorie']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <select name="zustand">
            <option value="">Alle Zustände</option>
            <?php while ($row = $zustaende->fetch_assoc()): ?>
                <option value="<?php echo $row['zustand']; ?>">
                    <?php echo $row['zustand']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <select name="verkauf">
            <option value="">Alle Verkäufen</option>
            <?php while ($row = $verkauft->fetch_assoc()): ?>
                <option value="<?php echo $row['verkauf']; ?>">
                    <?php echo $row['verkauf']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <div class="filtering">
            <label for="filtering-ui">
                Sortieren
            </label>
            <select id="filtering-ui" name="sortieren">
                <option value="all">Auswählen</option>
                <option value="kurztitle&order=asc">Titel A-Z</option>
                <option value="kurztitle&order=desc">Titel Z-A</option>
                <option value="?sort=z.zustand&order=asc">Zustand</option>
                <option value="?sort=nummer&order=asc">Nummer</option>
                <option value="?sort=katalog&order=asc">Katalog</option>
            </select>
        </div>

        <input type="submit" name="submit" value="Suchen">
        <button type="reset" name="reset">Zurücksetzen</button>
    </div>
</form>

<section class="books">
    <?php foreach ($buecher as $buch): ?>
        <a href='detail.php?id=<?= $buch['id'] ?>' class='book'>
            <div>
                <img src='../assets/book-cover.jpg' alt='book'>
                <p><?= substr($buch['kurztitle'], 0, 30) ?></p>
                <p><?= $buch['zustand'] ?></p>
            </div>
        </a>
    <?php endforeach; ?>
</section>

<section class="pagination-parent">
<?php

echo "<div class='pagination'>";

// Always display pages 1, 2, 3
for ($x = 1; $x <= 3; $x++) {
    if ($x == $seite) {
        echo "<a href='?page=$x' class='active'>$x</a>";
    } else {
        echo "<a href='?page=$x'>$x</a>";
    }
}

if ($seiten > 3) {
    echo "<span> ... </span>";
}

if ($seite > 1) {
    if ($seite == $seiten) {
        echo "<a href='?page=$seiten' class='active'>$seiten</a>";
    } else {
        echo "<a href='?page=$seite'>$seiten</a>";
    }
}

echo "</div>";
?>
</section>

<script src="toggleEvents.js"></script>
</body>
</html>