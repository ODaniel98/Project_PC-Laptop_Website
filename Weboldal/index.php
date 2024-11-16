<?php
session_start();
$latogatasok = 1;
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

// ha már van egy, az eddigi látogatások számát tároló sütink, akkor betöltjük annak az értékét
if (isset($_COOKIE["visits"])) {
    $latogatasok = $_COOKIE["visits"] + 1;  // az eddigi látogatások számát megnöveljük 1-gyel
}
if (isset($_COOKIE["kosar".$azonosito])) {
    $kosar = json_decode($_COOKIE["kosar".$azonosito], true);
    $kosarDarab = count($kosar);
} else {
    $kosar = array();
    $kosarDarab = 0;
}

// egy "visits" nevű süti a látogatásszám tárolására, amelynek élettartama 30 nap
setcookie("visits", $latogatasok, time() + 86400, "/");
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Szamitogepes Webaruhaz</title>
    <link rel="stylesheet" href="css/style.css?v1">
    <link rel="icon" type="image/x-icon" href="img/Circle-icons-computer.png">
</head>

<body id="home-body">
<header>
    <nav id="header-nav">
        <ul>
            <li class="home-active"><a href="index.php">Főoldal</a></li>
            <li class="home-inactive"><a href="asztali_szamitogepek.php">Asztali PC</a></li>
            <li class="home-inactive"><a href="laptopok.php">Laptopok</a></li>
            <?php if (isset($_SESSION["user"])) { ?>
                <li class="home-inactive"><a href="profile.php">Profilom</a></li>
                <li class="home-inactive"><a href="listUsers.php">Felhasználók</a></li>
                <li class="home-inactive"><a href="kosar.php">Kosár (<?php echo $kosarDarab; ?>)</a></li>
                <li class="home-inactive"><a href="logout.php">Kijelentkezés</a></li>
            <?php } else { ?>
                <li class="home-inactive"><a href="signup.php">Regisztráció</a></li>
                <li class="home-inactive"><a href="login.php">Bejelentkezés</a></li>
            <?php } ?>
        </ul>
    </nav>
</header>




<h1>Főoldal</h1>

<div class="latogatasok"><br>
    <?php
    if ($latogatasok > 1) {     // ha már korábban járt a felhasználó a weboldalunkon...
        echo "Üdvözöllek ismét! A mai nap ez a(z) $latogatasok. látogatásod.";
    } else {                    // ha első alkalommal látogatja meg a weboldalunkat...
        echo "Üdvözöllek a weboldalamon! Ez az 1. látogatásod.";
    }
    ?>
</div>

<h2>Köszöntő</h2>

<audio controls>
    <source src="./hanganyag/Koszonto.m4a">
</audio><br><br>


<div class="table">
    <table id="pc-table">
        <caption><a id="pc-table-name" href="asztali_szamitogepek.php">Asztali Számítógépeink</a></caption>
        <tr class="fejlec-pc">
            <th rowspan="2">Típus</th>
            <th colspan="4">Konfiguráció</th>
            <th rowspan="2" id="Ar">Ár</th>
        </tr>
        <tr class="config-pc">
            <td>Processzor</td>
            <td>Memória</td>
            <td>Háttértár</td>
            <td>Grafikus meghajtó</td>
        </tr>
        <tr>
            <td>HP-Elite</td>
            <td>Intel</td>
            <td>8 GB</td>
            <td>256 GB SSD</td>
            <td>GTX 960</td>
            <td headers="Ar">132.000,-</td>
        </tr>
        <tr>
            <td>Asus-G10DK</td>
            <td>AMD</td>
            <td>8 GB</td>
            <td>256 GB SSD</td>
            <td>RTX 2060 Super</td>
            <td headers="Ar">139.000,-</td>
        </tr>
        <tr>
            <td>Lenovo</td>
            <td>Intel</td>
            <td>16 GB</td>
            <td>512 GB SSD</td>
            <td>RTX 3070</td>
            <td headers="Ar">188.000,-</td>
        </tr>
        <tr>
            <td>HP-Omen 45L</td>
            <td>Intel</td>
            <td>64 GB</td>
            <td>HDD + SSD</td>
            <td>RTX 4090</td>
            <td headers="Ar">789.000,-</td>
        </tr>
        <tr>
            <td>Mac-Mini</td>
            <td>ARM M1</td>
            <td>32 GB</td>
            <td>1 TB SSD</td>
            <td>16 Magos</td>
            <td headers="Ar">459.000,-</td>
        </tr>
        <tr>
            <td>Mac Studio</td>
            <td>ARM M2</td>
            <td>64 GB</td>
            <td>2 TB SSD</td>
            <td>32 Magos</td>
            <td headers="Ar">889.000,-</td>
        </tr>
    </table>
</div>


<div class="table">
    <table id="laptop-table">
        <caption><a id="laptopok-table-name" href="laptopok.php">Laptopjaink</a></caption>
            <tr class="fejlec-laptop">
                <th rowspan="2">Gyártó</th>
                <th colspan="7">Konfiguráció</th>
                <th rowspan="2">Ár</th>
            </tr>
            <tr class="config-laptop">
                <td>Processzor</td>
                <td>Memória</td>
                <td>Háttértár</td>
                <td>Grafikus meghajtó</td>
                <td>Kijelző mérete</td>
                <td>Kijelző felbontása</td>
                <td>Üzemidő</td>
            </tr>
            <tr>
                <td>Asus</td>
                <td>AMD Ryzen™ 7 6800H</td>
                <td>8 GB</td>
                <td>256 GB HDD</td>
                <td>RTX 3050</td>
                <td>15.6"</td>
                <td>1920 x 1080</td>
                <td>5 óra</td>
                <td>359.000 .-</td>
            </tr>
            <tr>
                <td>Lenovo</td>
                <td>Intel<sup>®</sup> i5 11320H</td>
                <td>8 GB</td>
                <td>256 GB SSD</td>
                <td>GTX 1650</td>
                <td>15.6"</td>
                <td>Full HD</td>
                <td>5 óra</td>
                <td>310.290,-</td>
            </tr>
            <tr>
                <td>Asus</td>
                <td>AMD Ryzen 7 6800HS</td>
                <td>16 GB</td>
                <td>512 GB SSD</td>
                <td>RX 6700S</td>
                <td>14"</td>
                <td>1920 x 1200</td>
                <td>5 óra</td>
                <td>669 900,-</td>
            </tr>
            <tr>
                <td>Lenovo</td>
                <td>AMD Ryzen 7 6800H</td>
                <td>16 GB</td>
                <td>512 GB SSD</td>
                <td>RTX 3050 Ti</td>
                <td>17"</td>
                <td>1920 x 1080</td>
                <td>5 óra</td>
                <td>479 900,-</td>
            </tr>

            <tr>
                <td>MacBook Air</td>
                <td>ARM M2</td>
                <td>8 GB</td>
                <td>256 GB SSD</td>
                <td>Integrált</td>
                <td>13.6"</td>
                <td>2560 X 1664</td>
                <td>18 óra</td>
                <td>618 173,-</td>
            </tr>
            <tr>
                <td>MacBook Pro</td>
                <td>M2 Pro</td>
                <td>64 GB</td>
                <td>2 TB SSD</td>
                <td>Integrált</td>
                <td>16"</td>
                <td>3456 x 2234</td>
                <td>16 óra</td>
                <td>1 249 990,-</td>
            </tr>
    </table>
</div>

<div class="Macbook-video">MacBook Air Bemutató Videó

<video controls>
    <source src="./videok/MacBook-Air.mp4">
</video>

</div>


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