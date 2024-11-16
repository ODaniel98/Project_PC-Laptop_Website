<?php
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

if (isset($_GET["id"]) && isset($_GET["kosarba"]) && $_GET["kosarba"] == 1) {
    if (!in_array($_GET["id"], $kosar)) {
        array_push($kosar, $_GET["id"]);
        setcookie("kosar" . $azonosito, json_encode($kosar), time() + 3600);
    }
}
if (isset($_GET["kosarbol_torles"])) {
    $toroltElem = $_GET["id"];
    if (($key = array_search($toroltElem, $kosar)) !== false) {
        unset($kosar[$key]);
        setcookie("kosar" . $azonosito, json_encode($kosar), time() + 3600);
    }
    header("Location: kosar.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Asztali PC</title>
    <link rel="stylesheet" href="css/style.css?v1">
    <link rel="icon" type="image/x-icon" href="img/Circle-icons-computer.png">
</head>
<body class="kosarhatter">

<header>
    <nav id="header-nav">
        <ul>
            <li class="kosar-inactive"><a href="index.php">Főoldal</a></li>
            <li class="kosar-inactive"><a href="asztali_szamitogepek.php">Asztali PC</a></li>
            <li class="kosar-inactive"><a href="laptopok.php">Laptopok</a></li>
            <?php if (isset($_SESSION["user"])) { ?>
                <li class="kosar-inactive"><a href="profile.php">Profilom</a></li>
                <li class="kosar-inactive"><a href="listUsers.php">Felhasználók</a></li>
                <li class="kosar-active"><a href="kosar.php">Kosár (<?php echo $kosarDarab; ?>)</a></li>
                <li class="kosar-inactive"><a href="logout.php">Kijelentkezés</a></li>
            <?php } else { ?>
                <li class="kosar-inactive"><a href="signup.php">Regisztráció</a></li>
                <li class="kosar-inactive"><a href="login.php">Bejelentkezés</a></li>
            <?php } ?>
        </ul>
    </nav>
</header>

<h1>A Kosár Tartalma</h1>

<?php
if (!empty($kosar)) {
    foreach ($kosar as $item) {
        switch ($item) {
            case "a1":
                echo '<div class="asztalipc" id="' . $item . '">';
                echo '<img src="img/HP_Elite.jpeg" alt="HP-Elite">';
                echo '<p>';
                echo 'Típus: HP-Elite<br>';
                echo 'Processzor: Intel<sup>®</sup> Core™ I5-3570<br>';
                echo 'Memória mérete: 8 GB<br>';
                echo 'Háttértár: 256 GB<br>';
                echo 'Háttértár Típusa: HDD<br>';
                echo 'Videókártya: GTX 960<br>';
                echo '<form class="kosarba-button" action="" method="get">';
                echo '<input type="hidden" name="id" value="' . $item . '">';
                echo '<button type="submit" name="kosarbol_torles" value="1">Törlés a kosárból</button>';
                echo '</form>';
                echo '</p>';
                echo '<p class="pcar">Ár: 132.000,-</p>';
                echo '</div>';
                break;
            case "a2":
                echo '<div class="asztalipc" id="' . $item . '">';
                echo '<img src="img/Asus_G10DK.jpeg" alt="Asus_G10DK">';
                echo '<p>';
                echo 'Típus: Asus_G10DK<br>';
                echo 'Processzor: AMD Ryzen5 5600X<br>';
                echo 'Memória mérete: 8 GB<br>';
                echo 'Háttértár: 256 GB<br>';
                echo 'Háttértár Típusa: SSD<br>';
                echo 'Videókártya: RTX 2060 Super<br>';
                echo '<form class="kosarba-button" action="" method="get">';
                echo '<input type="hidden" name="id" value="' . $item . '">';
                echo '<button type="submit" name="kosarbol_torles" value="1">Törlés a kosárból</button>';
                echo '</form>';
                echo '</p>';
                echo '<p class="pcar">Ár: 139.000,-</p>';
                echo '</div>';
                break;
            case "a3":
                echo '<div class="asztalipc" id="' . $item . '">';
                echo '<img src="img/Lenovo.jpeg" alt="Lenovo">';
                echo '<p>';
                echo 'Típus: Lenovo<br>';
                echo 'Processzor: Intel<sup>®</sup> Core™ i5 - 10400<br>';
                echo 'Memória mérete: 16 GB<br>';
                echo 'Háttértár: 512 GB<br>';
                echo 'Háttértár Típusa: SSD<br>';
                echo 'Videókártya: RTX 3070 <br>';
                echo '<form class="kosarba-button" action="" method="get">';
                echo '<input type="hidden" name="id" value="' . $item . '">';
                echo '<button type="submit" name="kosarbol_torles" value="1">Törlés a kosárból</button>';
                echo '</form>';
                echo '</p>';
                echo '<p class="pcar">Ár: 188.000,-</p>';
                echo '</div>';
                break;
            case "a4":
                echo '<div class="asztalipc" id="' . $item . '">';
                echo '<img src="img/HP_Omen.png" alt="HP OMEN 45L">';
                echo '<p>';
                echo 'Típus: HP-Omen 45L<br>';
                echo 'Processzor: Intel<sup>®</sup> Core™ i9 - 12900K<br>';
                echo 'Memória mérete: 64 GB<br>';
                echo 'Háttértár: 8 TB + 2 TB<br>';
                echo 'Háttértár Típusa: HDD + M.2 SSD <br>';
                echo 'Videókártya: RTX 4090 <br>';
                echo '<form class="kosarba-button" action="" method="get">';
                echo '<input type="hidden" name="id" value="' . $item . '">';
                echo '<button type="submit" name="kosarbol_torles" value="1">Törlés a kosárból</button>';
                echo '</form>';
                echo '</p>';
                echo '<p class="pcar">Ár: 645.990,-</p>';
                echo '</div>';
                break;
            case "a5":
                echo '<div class="asztalipc" id="' . $item . '">';
                echo '<img src="img/Mac-Mini.jpeg" alt="Mac-Mini">';
                echo '<p>';
                echo 'Típus: Mac-Mini<br>';
                echo 'Processzor: M2<br>';
                echo 'Memória mérete: 32 GB<br>';
                echo 'Háttértár: 1 TB<br>';
                echo 'Háttértár Típusa: SSD<br>';
                echo 'Videókártya: 16 Magos Integrált <br>';
                echo '<form class="kosarba-button" action="" method="get">';
                echo '<input type="hidden" name="id" value="' . $item . '">';
                echo '<button type="submit" name="kosarbol_torles" value="1">Törlés a kosárból</button>';
                echo '</form>';
                echo '</p>';
                echo '<p class="pcar">Ár: 459.000,-</p>';
                echo '</div>';
                break;
            case "a6":
                echo '<div class="asztalipc" id="' . $item . '">';
                echo '<img src="img/Mac-Studio.jpeg" alt="Mac-Studio">';
                echo '<p>';
                echo 'Típus: Mac Studio<br>';
                echo 'Processzor: M2 Ultra<br>';
                echo 'Memória mérete: 64 GB<br>';
                echo 'Háttértár: 2 TB<br>';
                echo 'Háttértár Típusa: SSD<br>';
                echo 'Videókártya: 32 Magos Integrált <br>';
                echo '<form class="kosarba-button" action="" method="get">';
                echo '<input type="hidden" name="id" value="' . $item . '">';
                echo '<button type="submit" name="kosarbol_torles" value="1">Törlés a kosárból</button>';
                echo '</form>';
                echo '</p>';
                echo '<p class="pcar">Ár: 889.000,-</p>';
                echo '</div>';
                break;
            case "l1":
                echo '<div class="asztalipc" id="' . $item . '">';
                echo '<img src="img/Asus_G15.jpeg" alt="asus-rog-strix-g15">';
                echo '<p>';
                echo 'Típus: asus-rog-strix-g15<br>';
                echo 'Processzor: AMD Ryzen™ 7 6800H<br>';
                echo 'Memória mérete: DDR 5 8 GB<br>';
                echo 'Háttértár: 256 GB<br>';
                echo 'Háttértár Típusa: HDD<br>';
                echo 'Kijelző felbontása 1920 x 1080<br>';
                echo 'Videókártya: nVidia GeForce RTX 3050 <br>';
                echo '<form class="kosarba-button" action="" method="get">';
                echo '<input type="hidden" name="id" value="' . $item . '">';
                echo '<button type="submit" name="kosarbol_torles" value="1">Törlés a kosárból</button>';
                echo '</form>';
                echo '</p>';
                echo '<p class="pcar">Ár: 359.000,-</p>';
                echo '</div>';
                break;
            case "l2":
                echo '<div class="asztalipc" id="' . $item . '">';
                echo '<img src="img/Lenovo-IdeaPad.jpeg" alt="Lenovo IdeaPad Gaming 3 82K101CTHV Notebook">';
                echo '<p>';
                echo 'Típus: Lenovo IdeaPad Gaming 3 82K101CTHV Notebook<br>';
                echo 'Processzor: Intel<sup>®</sup> i5 11320H<br>';
                echo 'Memória mérete: DDR 4 8 GB<br>';
                echo 'Háttértár: 256 GB<br>';
                echo 'Háttértár Típusa: SSD<br>';
                echo 'Kijelző felbontása Full HD<br>';
                echo 'Videókártya: GTX 1650 <br>';
                echo '<form  class="kosarba-button" action="" method="get">';
                echo '<input type="hidden" name="id" value="' . $item . '">';
                echo '<button type="submit" name="kosarbol_torles" value="1">Törlés a kosárból</button>';
                echo '</form>';
                echo '</p>';
                echo '<p class="pcar">Ár: 310.290,-</p>';
                echo '</div>';
                break;
            case "l3":
                echo '<div class="asztalipc" id="' . $item . '">';
                echo '<img src="img/Asus_Zephyrus.jpeg" alt="ASUS ROG Zephyrus G14 GA402RJ-L4086 Notebook">';
                echo '<p>';
                echo 'Típus: ASUS ROG Zephyrus G14 GA402RJ-L4086 Notebook<br>';
                echo 'Processzor: AMD Ryzen 7 6800HS<br>';
                echo 'Memória mérete: DDR 5 16 GB<br>';
                echo 'Háttértár: 512 GB<br>';
                echo 'Háttértár Típusa: SSD<br>';
                echo 'Kijelző mérete 14"<br>';
                echo 'Videókártya: AMD Radeon RX 6700S<br>';
                echo '<form class="kosarba-button" action="" method="get">';
                echo '<input type="hidden" name="id" value="' . $item . '">';
                echo '<button type="submit" name="kosarbol_torles" value="1">Törlés a kosárból</button>';
                echo '</form>';
                echo '</p>';
                echo '<p class="pcar">Ár: 669 900,-</p>';
                echo '</div>';
                break;
            case "l4":
                echo '<div class="asztalipc" id="' . $item . '">';
                echo '<img src="img/Asus_TUF.jpeg" alt="ASUS TUF Gaming A17 FA707RE-HX037 Notebook">';
                echo '<p>';
                echo 'Típus: Lenovo IdeaPad Gaming 3 82K101CTHV Notebook<br>';
                echo 'Processzor: AMD Ryzen 7 6800H<br>';
                echo 'Memória mérete: DDR 5 16 GB<br>';
                echo 'Háttértár: 512 GB<br>';
                echo 'Háttértár Típusa: SSD<br>';
                echo 'Kijelző mérete 17"<br>';
                echo 'Videókártya: Nvidia GeForce RTX 3050 Ti<br>';
                echo '<form class="kosarba-button" action="" method="get">';
                echo '<input type="hidden" name="id" value="' . $item . '">';
                echo '<button type="submit" name="kosarbol_torles" value="1">Törlés a kosárból</button>';
                echo '</form>';
                echo '</p>';
                echo '<p class="pcar">Ár: 479 900,-</p>';
                echo '</div>';
                break;
            case "l5":
                echo '<div class="asztalipc" id="' . $item . '">';
                echo '<img src="img/MacBook_Air.jpeg" alt="Apple MacBook Air M2 256GB MLY33 Notebook">';
                echo '<p>';
                echo 'Típus: Apple MacBook Air M2<br>';
                echo 'Processzor: M2<br>';
                echo 'Memória mérete: DDR 5 8 GB<br>';
                echo 'Háttértár: 256 GB<br>';
                echo 'Háttértár Típusa: SSD<br>';
                echo 'Kijelző mérete 13.6"<br>';
                echo 'Videókártya: Integrált<br>';
                echo '<form class="kosarba-button" action="" method="get">';
                echo '<input type="hidden" name="id" value="' . $item . '">';
                echo '<button type="submit" name="kosarbol_torles" value="1">Törlés a kosárból</button>';
                echo '</form>';
                echo '</p>';
                echo '<p class="pcar">Ár: 618 173,-</p>';
                echo '</div>';
                break;
            case "l6":
                echo '<div class="asztalipc" id="' . $item . '">';
                echo '<img src="img/MacBook_Pro.jpeg" alt="Apple MacBook Pro">';
                echo '<p>';
                echo 'Típus: MacBook Pro 16"<br>';
                echo 'Processzor: M2 Pro<br>';
                echo 'Memória mérete: 64 GB<br>';
                echo 'Háttértár: 2 TB SSD<br>';
                echo 'Kijelző mérete 16"<br>';
                echo 'Videókártya: Integrált<br>';
                echo '<form class="kosarba-button" action="" method="get">';
                echo '<input type="hidden" name="id" value="' . $item . '">';
                echo '<button type="submit" name="kosarbol_torles" value="1">Törlés a kosárból</button>';
                echo '</form>';
                echo '</p>';
                echo '<p class="pcar">Ár: 1 249 990,-</p>';
                echo '</div>';
                break;

            // Egyéb termékek esetén itt kellene megadni az adatokat
        }
    }
}else{
    echo "<h2>jelenleg üres</h2>";
}
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