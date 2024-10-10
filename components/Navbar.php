<!DOCTYPE html>
<html lang="en" id="theme">
<head>
    <meta charset="UTF-8"/>
    <title>Bookstore</title>
    <meta name="viewport" content="width=device-width,initial-scale=1"/>
    <meta name="description" content=""/>
    <link rel="stylesheet" href="../src/styles.css">
    <link rel="icon" href="">
    <script defer src="../src/toggleEvents.js"></script>
</head>
<nav>
    <h1 class="logo"><a href="../src/index.php" >Bookstore</a></h1>
    <ul class="links">
        <li><a href="../src/website.php">Home</a></li>
        <li><a href="../src/ueberuns.php">Über uns</a></li>
        <li><a href="../src/impressum.php">Impressum</a></li>
        <li><a href="../src/admin.php">Admin</a></li>
    </ul>
    <a href="#" id="account-toggle"><img src="../assets/account.svg" alt="Menu"></a>
</nav>

<div id="account-menu">
    <button>
        <img src="../assets/account.svg"><li><a href="../src/account.php">Account</a> </li>
    </button>

    <button>
        <img src="../assets/info.svg"><li><a href="../src/ueberuns.php">Über uns</a></li>
    </button>

    <button>
        <img src="../assets/logout.svg">
        Abmelden
    </button>

    <button id="toggleTheme">
        <img src="../assets/dark.svg" id="themeIcon">
        <span id="themeName">Dunkel</span>
    </button>
    <script defer src="../src/toggleEvents.js"></script>
</div>
