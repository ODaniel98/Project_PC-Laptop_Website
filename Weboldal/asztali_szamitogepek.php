<?php
session_start();

if(isset($_SESSION["user"])){
    $azonosito = $_SESSION["user"]["felhasznalonev"];
}

if (isset($_COOKIE["kosar" . $azonosito])) {
    $kosar = json_decode($_COOKIE["kosar".$azonosito], true);
    $kosarDarab = count($kosar);
} else {
    $kosar = array();
    $kosarDarab = 0;
}
if (isset($_GET["id"]) && isset($_GET["kosarba"]) && $_GET["kosarba"] == 1) {
    if (!in_array($_GET["id"], $kosar)) {
        array_push($kosar, $_GET["id"]);
        setcookie("kosar".$azonosito, json_encode($kosar), time() + 3600);
    }
}
if(isset($_COOKIE["ertekeles" . $azonosito])){
    $ertekeles = json_decode($_COOKIE["ertekeles".$azonosito], true);
} else {
    $ertekeles = array();
}

if (isset($_GET["id"]) && isset($_GET["ertekeles"])) {
    $id = $_GET["id"];
    $ertek = $_GET["ertekeles"];
    $ertekeles[$id] = $ertek;
    setcookie("ertekeles".$azonosito, json_encode($ertekeles), time() + 3600);
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Asztali PC</title>
    <link rel="stylesheet" href="css/style.css?v2">
    <link rel="icon" type="image/x-icon" href="img/Circle-icons-computer.png">
</head>
<body class="pchatter">

<header>
    <nav id="header-nav">
        <ul>
            <li class="asztalipc-inactive"><a href="index.php">Főoldal</a></li>
            <li class="asztalipc-active"><a href="asztali_szamitogepek.php">Asztali PC</a></li>
            <li class="asztalipc-inactive"><a href="laptopok.php">Laptopok</a></li>
            <?php if (isset($_SESSION["user"])) { ?>
                <li class="asztalipc-inactive"><a href="profile.php">Profilom</a></li>
                <li class="asztalipc-inactive"><a href="listUsers.php">Felhasználók</a></li>
                <li class="asztalipc-inactive"><a href="kosar.php">Kosár (<?php echo $kosarDarab; ?>)</a></li>
                <li class="asztalipc-inactive"><a href="logout.php">Kijelentkezés</a></li>
            <?php } else { ?>
                <li class="asztalipc-inactive"><a href="signup.php">Regisztráció</a></li>
                <li class="asztalipc-inactive"><a href="login.php">Bejelentkezés</a></li>
            <?php } ?>
        </ul>
    </nav>
</header>
<h1>Asztali Számítógépek</h1>
<div class="asztalipc" id="a1">
    <img src="img/HP_Elite.jpeg" alt="HP-Elite">
    <p>
        Típus: HP-Elite<br>
        Processzor: Intel<sup>®</sup> Core™ I5-3570<br>
        Memória mérete: 8 GB<br>
        Háttértár: 256 GB<br>
        Háttértár Típusa: HDD<br>
        Videókártya: GTX 960<br>
    </p>
    <p class="pcar">Ár: 132.000,-</p>
    <form class="rating-submit" action="" method="get">
        <input type="hidden" name="id" value="a1">
        <select class="ertekeles-button" name="ertekeles" id="ertekeles-a1">
            <option value="">Válasszon</option>
            <option value="1">1 csillag</option>
            <option value="2">2 csillag</option>
            <option value="3">3 csillag</option>
            <option value="4">4 csillag</option>
            <option value="5">5 csillag</option>
        </select>
        <input class="rating" type="submit" value="Értékel">
    </form>
    <?php if(isset($ertekeles["a1"])) { ?>
        <p class="ertekeles">Az Ön értékelése: <?php echo $ertekeles["a1"]; ?> csillag</p>
    <?php } ?>

    <form class="kosarba-button" action="" method="get">
        <input type="hidden" name="id" value="a1">
        <?php if (in_array("a1", $kosar)) { ?>
            <button type="submit" disabled>Kosárba <span>&#10003;</span></button>
        <?php } else { ?>
            <button type="submit" name="kosarba" value="1">Kosárba</button>
        <?php } ?>
    </form>
</div>

<div class="asztalipc" id="a2">
    <img src="img/Asus_G10DK.jpeg" alt="Asus_G10DK">
    <p>
        Típus: Asus_G10DK<br>
        Processzor: AMD Ryzen5 5600X<br>
        Memória mérete: 8 GB<br>
        Háttértár: 256 GB<br>
        Háttértár Típusa: SSD<br>
        Videókártya: RTX 2060 Super<br>
        <p class="pcar">Ár: 139.000,-</p>
    <form class="rating-submit" action="" method="get">
        <input type="hidden" name="id" value="a2">
        <select class="ertekeles-button" name="ertekeles" id="ertekeles-a1">
            <option value="">Válasszon</option>
            <option value="1">1 csillag</option>
            <option value="2">2 csillag</option>
            <option value="3">3 csillag</option>
            <option value="4">4 csillag</option>
            <option value="5">5 csillag</option>
        </select>
        <input class="rating" type="submit" value="Értékel">
    </form>
    <?php if(isset($ertekeles["a2"])) { ?>
        <p class="ertekeles">Az Ön értékelése: <?php echo $ertekeles["a2"]; ?> csillag</p>
    <?php } ?>

    <form class="kosarba-button" action="" method="get">
        <input type="hidden" name="id" value="a2">
        <?php if (in_array("a2", $kosar)) { ?>
            <button type="submit" disabled>Kosárba <span>&#10003;</span></button>
        <?php } else { ?>
            <button type="submit" name="kosarba" value="1">Kosárba</button>
        <?php } ?>
    </form>
</div>


<div class="asztalipc" id="a3">
    <img src="img/Lenovo.jpeg" alt="Lenovo">
    <p>
        Típus: Lenovo<br>
        Processzor: Intel<sup>®</sup> Core™ i5 - 10400<br>
        Memória mérete: 16 GB<br>
        Háttértár: 512 GB<br>
        Háttértár Típusa: SSD<br>
        Videókártya: RTX 3070 <br>
        <p class="pcar">Ár: 188.000,-</p>
    <form class="rating-submit" action="" method="get">
        <input type="hidden" name="id" value="a1">
        <select class="ertekeles-button" name="ertekeles" id="ertekeles-a1">
            <option value="">Válasszon</option>
            <option value="1">1 csillag</option>
            <option value="2">2 csillag</option>
            <option value="3">3 csillag</option>
            <option value="4">4 csillag</option>
            <option value="5">5 csillag</option>
        </select>
        <input class="rating" type="submit" value="Értékel">
    </form>
    <?php if(isset($ertekeles["a3"])) { ?>
        <p class="ertekeles">Az Ön értékelése: <?php echo $ertekeles["a3"]; ?> csillag</p>
    <?php } ?>

    <form class="kosarba-button" action="" method="get">
        <input type="hidden" name="id" value="a3">
        <?php if (in_array("a3", $kosar)) { ?>
            <button type="submit" disabled>Kosárba <span>&#10003;</span></button>
        <?php } else { ?>
            <button type="submit" name="kosarba" value="1">Kosárba</button>
        <?php } ?>
    </form>
</div>
<div class="asztalipc" id="a4">
    <img src="img/HP_Omen.png" alt="HP OMEN 45L">
    <p>
        Típus: HP-Omen 45L<br>
        Processzor: Intel<sup>®</sup> Core™ i9 - 12900K<br>
        Memória mérete: 64 GB<br>
        Háttértár: 8 TB + 2 TB<br>
        Háttértár Típusa: HDD + M.2 SSD<br>
        Videókártya: RTX 4090 <br>
    <p id="athuzottar">Ár: 789.000,-</p>
    <p><mark>AKCIÓ: 645.990,-</mark></p>
    <form class="rating-submit" action="" method="get">
        <input type="hidden" name="id" value="a3">
        <select class="ertekeles-button" name="ertekeles" id="ertekeles-a1">
            <option value="">Válasszon</option>
            <option value="1">1 csillag</option>
            <option value="2">2 csillag</option>
            <option value="3">3 csillag</option>
            <option value="4">4 csillag</option>
            <option value="5">5 csillag</option>
        </select>
        <input class="rating" type="submit" value="Értékel">
    </form>
    <?php if(isset($ertekeles["a4"])) { ?>
        <p class="ertekeles">Az Ön értékelése: <?php echo $ertekeles["a4"]; ?> csillag</p>
    <?php } ?>

    <form class="kosarba-button" action="" method="get">
        <input type="hidden" name="id" value="a4">
        <?php if (in_array("a4", $kosar)) { ?>
            <button type="submit" disabled>Kosárba <span>&#10003;</span></button>
        <?php } else { ?>
            <button type="submit" name="kosarba" value="1">Kosárba</button>
        <?php } ?>
    </form>
</div>
    <div class="macpc">Mac Számítógépek</div>
    <div class="asztalipc" id="a5">
        <img src="img/Mac-Mini.jpeg" alt="Mac-Mini">
        <p>
            Típus: Mac-Mini<br>
            Processzor: M2<br>
            Memória mérete: 32 GB<br>
            Háttértár: 1 TB<br>
            Háttértár Típusa: SSD<br>
            Videókártya: 16 Magos Integrált <br>
        <p class="pcar">Ár: 459.000,-</p>
        <form class="rating-submit" action="" method="get">
            <input type="hidden" name="id" value="a5">
            <select class="ertekeles-button" name="ertekeles" id="ertekeles-a1">
                <option value="">Válasszon</option>
                <option value="1">1 csillag</option>
                <option value="2">2 csillag</option>
                <option value="3">3 csillag</option>
                <option value="4">4 csillag</option>
                <option value="5">5 csillag</option>
            </select>
            <input class="rating" type="submit" value="Értékel">
        </form>
        <?php if(isset($ertekeles["a5"])) { ?>
            <p class="ertekeles">Az Ön értékelése: <?php echo $ertekeles["a5"]; ?> csillag</p>
        <?php } ?>

        <form class="kosarba-button" action="" method="get">
            <input type="hidden" name="id" value="a5">
            <?php if (in_array("a5", $kosar)) { ?>
                <button type="submit" disabled>Kosárba <span>&#10003;</span></button>
            <?php } else { ?>
                <button type="submit" name="kosarba" value="1">Kosárba</button>
            <?php } ?>
        </form>
    </div>
    <div class="asztalipc" id="a6">
        <img src="img/Mac-Studio.jpeg" alt="Mac-Studio">
        <p>
            Típus: Mac Studio<br>
            Processzor: M2 Ultra<br>
            Memória mérete: 64 GB<br>
            Háttértár: 2 TB<br>
            Háttértár Típusa: SSD<br>
            Videókártya: 32 Magos Integrált <br>
        <p class="pcar">Ár: 889.000,-</p>
        <form class="rating-submit" action="" method="get">
            <input type="hidden" name="id" value="a6">
            <select class="ertekeles-button" name="ertekeles" id="ertekeles-a1">
                <option value="">Válasszon</option>
                <option value="1">1 csillag</option>
                <option value="2">2 csillag</option>
                <option value="3">3 csillag</option>
                <option value="4">4 csillag</option>
                <option value="5">5 csillag</option>
            </select>
            <input class="rating" type="submit" value="Értékel">
        </form>
        <?php if(isset($ertekeles["a6"])) { ?>
            <p class="ertekeles">Az Ön értékelése: <?php echo $ertekeles["a6"]; ?> csillag</p>
        <?php } ?>

        <form class="kosarba-button" action="" method="get">
            <input type="hidden" name="id" value="a6">
            <?php if (in_array("a6", $kosar)) { ?>
                <button type="submit" disabled>Kosárba <span>&#10003;</span></button>
            <?php } else { ?>
                <button type="submit" name="kosarba" value="1">Kosárba</button>
            <?php } ?>
        </form>
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