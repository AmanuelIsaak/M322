<?php

include 'db.php';
global $conn;


$buchID = $_GET['id'] ?? die('BuchID fehlt.');

$query = "    
    SELECT *, z.beschreibung AS zustandsbeschreibung 
    FROM buecher AS b, kategorien AS k, zustaende AS z
    WHERE b.kategorie = k.id
    AND b.zustand = z.zustand
    AND b.id = ?
    ";


$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $buchID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$buecher = mysqli_fetch_assoc($result);

if(!$buecher) {
    echo "Kein Buch gefunden";
} else {
?>
    <!DOCTYPE html>
    <html lang="de" id="theme">
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
<div>
<section class="detail">

<img src="./../assets/book-cover.jpg" alt="Buchcover" class="image">

    <div>
    <h1><?php echo $buecher['kurztitle']; ?></h1>
    <p>Autor: <?php echo $buecher['autor']; ?></p>
        <div class="tags">
            <p><?php echo $buecher['kategorie'];?></p>
            <p><?php echo $buecher['zustandsbeschreibung']; ?></p>
            <p><?php echo $buecher['nummer']; ?></p>
        </div>
        <div class="beschreibung">
            <p>Beschreibung: <?php echo $buecher['title']; ?></p>
        </div>
    </div>
</section>
</div>
<script src="toggleEvents.js"></script>
    </body>
    </html>
    <?php
}
?>