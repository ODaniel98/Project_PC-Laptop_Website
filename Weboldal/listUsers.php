<?php
include "kozos.php";
session_start();
if (!isset($_SESSION["user"])) {
    // ha a felhasználó nincs belépve (azaz a "user" munkamenet-változó értéke nem került korábban beállításra), akkor a login.php-ra navigálunk
    header("Location: login.php");
}
if(isset($_SESSION["user"])){
    $azonosito = $_SESSION["user"]["felhasznalonev"];
}

if (isset($_COOKIE["kosar" . $azonosito])) {
    $kosar = json_decode($_COOKIE["kosar" . $azonosito], true);
    $kosarDarab = count($kosar);
} else {
    $kosar = array();
    $kosarDarab = 0;
}
?>


<!DOCTYPE html>
<html lang="hu">
<head>
    <title>Profilom</title>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="css/style.css?v3">
    <link rel="icon" type="image/x-icon" href="img/Circle-icons-computer.png">
</head>
<body class="userlist-body">
<header>
    <nav id="header-nav">
        <ul>
            <li class="listUsers-inactive"><a href="index.php">Főoldal</a></li>
            <li class="listUsers-inactive"><a href="asztali_szamitogepek.php">Asztali PC</a></li>
            <li class="listUsers-inactive"><a href="laptopok.php">Laptopok</a></li>
            <?php if (isset($_SESSION["user"])) { ?>
                <li class="listUsers-inactive"><a href="profile.php">Profilom</a></li>
                <li class="listUsers-active"><a href="listUsers.php">Felhasználók</a></li>
                <li class="listUsers-inactive"><a href="kosar.php">Kosár (<?php echo $kosarDarab; ?>)</a></li>
                <li class="listUsers-inactive"><a href="logout.php">Kijelentkezés</a></li>
            <?php } else { ?>
                <li class="listUsers-inactive"><a href="signup.php">Regisztráció</a></li>
                <li class="listUsers-inactive"><a href="login.php">Bejelentkezés</a></li>
            <?php } ?>
        </ul>
    </nav>
</header>
<h1 class="userlist-h1">Felhasználók</h1>
<?php
echo listUsers("users.txt");

?>
<footer class="container">
    <div>
        <span>Nyitvatartás</span><br><br>
        H-P: 8:00-16:00<br>
        Sz: 11:00-14:00<br>
        V: Zárva
    </div>
    <div>
        <span>Telephely</span><br><br>
        6723, Szeged<br>
        Aramkor u. 101.
    </div>
    <div>
        <span>Vélemények:</span><br><br>
        <p id="velemeny">"A legjobb pc szaküzlet a környéken. Csak ajánlani tudom!"</p>
    </div>
</footer>
</body>
</html>