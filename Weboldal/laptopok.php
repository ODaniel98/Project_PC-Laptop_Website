<?php
session_start();
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
    <title>Laptopok</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/x-icon" href="img/Circle-icons-computer.png">
</head>
<body class="laptophatter">

<header>
    <nav id="header-nav">
        <ul>
            <li class="laptopok-inactive"><a href="index.php">Főoldal</a></li>
            <li class="laptopok-inactive"><a href="asztali_szamitogepek.php">Asztali PC</a></li>
            <li class="laptopok-active"><a href="laptopok.php">Laptopok</a></li>
            <?php if (isset($_SESSION["user"])) { ?>
                <li class="laptopok-inactive"><a href="profile.php">Profilom</a></li>
                <li class="laptopok-inactive"><a href="listUsers.php">Felhasználók</a></li>
                <li class="laptopok-inactive"><a href="kosar.php">Kosár (<?php echo $kosarDarab; ?>)</a></li>
                <li class="laptopok-inactive"><a href="logout.php">Kijelentkezés</a></li>
            <?php } else { ?>
                <li class="laptopok-inactive"><a href="signup.php">Regisztráció</a></li>
                <li class="laptopok-inactive"><a href="login.php">Bejelentkezés</a></li>
            <?php } ?>
        </ul>
    </nav>

</header>
<h1>Laptop Kínálatunk</h1>
<div class="Laptopok" id="l1">
    <img src="img/Asus_G15.jpeg" alt="asus-rog-strix-g15">
    <p>
        Típus: asus-rog-strix-g15<br>
        Processzor: AMD Ryzen™ 7 6800H<br>
        Memória mérete:DDR 5 8 GB <br>
        Háttértár: 256 GB<br>
        Háttértár Típusa: HDD<br>
        Kijelző mérete 15.6"<br>
        Kijelző felbontása 1920 x 1080<br>
        Videókártya: nVidia GeForce RTX 3050<br>
    <p class="laptopar">Ár: 359.000,-</p>
    <form class="rating-submit" action="" method="get">
        <input type="hidden" name="id" value="l1">
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
    <?php if(isset($ertekeles["l1"])) { ?>
        <p class="ertekeles">Az Ön értékelése: <?php echo $ertekeles["l1"]; ?> csillag</p>
    <?php } ?>

    <form class="kosarba-button" action="" method="get">
        <input type="hidden" name="id" value="l1">
        <?php if (in_array("l1", $kosar)) { ?>
            <button type="submit" disabled>Kosárba <span>&#10003;</span></button>
        <?php } else { ?>
            <button type="submit" name="kosarba" value="1">Kosárba</button>
        <?php } ?>
    </form>
</div>

<div class="Laptopok" id="l2">
    <img src="img/Lenovo-IdeaPad.jpeg" alt="Lenovo IdeaPad Gaming 3 82K101CTHV Notebook">
    <p>
        Típus: Lenovo IdeaPad Gaming 3 82K101CTHV Notebook<br>
        Processzor: Intel<sup>®</sup> i5 11320H<br>
        Memória mérete:DDR 4 8 GB <br>
        Háttértár: 256 GB<br>
        Háttértár Típusa: SSD<br>
        Kijelző mérete 15.6"<br>
        Kijelző felbontása Full HD<br>
        Videókártya: GTX 1650<br>
    <p class="laptopar">Ár: 310.290,-</p>
    <form class="rating-submit" action="" method="get">
        <input type="hidden" name="id" value="l2">
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
    <?php if(isset($ertekeles["l2"])) { ?>
        <p class="ertekeles">Az Ön értékelése: <?php echo $ertekeles["l2"]; ?> csillag</p>
    <?php } ?>
    <form class="kosarba-button" action="" method="get">
        <input type="hidden" name="id" value="l2">
        <?php if (in_array("l2", $kosar)) { ?>
            <button type="submit" disabled>Kosárba <span>&#10003;</span></button>
        <?php } else { ?>
            <button type="submit" name="kosarba" value="1">Kosárba</button>
        <?php } ?>
    </form>
</div>
<div class="Laptopok" id="l3">
    <img src="img/Asus_Zephyrus.jpeg" alt="ASUS ROG Zephyrus G14 GA402RJ-L4086 Notebook">
    <p>
        Típus: ASUS ROG Zephyrus G14 GA402RJ-L4086 Notebook<br>
        Processzor: AMD Ryzen 7 6800HS<br>
        Memória mérete:DDR 5 16 GB <br>
        Háttértár: 512 GB<br>
        Háttértár Típusa: SSD<br>
        Kijelző mérete 14"<br>
        Kijelző felbontása 1920 x 1200<br>
        Videókártya: AMD Radeon RX 6700S<br>
    <p class="laptopar">Ár: 669 900,-</p>
    <form class="rating-submit" action="" method="get">
        <input type="hidden" name="id" value="l3">
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
    <?php if(isset($ertekeles["l3"])) { ?>
        <p class="ertekeles">Az Ön értékelése: <?php echo $ertekeles["l3"]; ?> csillag</p>
    <?php } ?>
    <form class="kosarba-button" action="" method="get">
        <input type="hidden" name="id" value="l3">
        <?php if (in_array("l3", $kosar)) { ?>
            <button type="submit" disabled>Kosárba <span>&#10003;</span></button>
        <?php } else { ?>
            <button type="submit" name="kosarba" value="1">Kosárba</button>
        <?php } ?>
    </form>
</div>
<div class="Laptopok" id="l4">
    <img src="img/Asus_TUF.jpeg" alt="ASUS TUF Gaming A17 FA707RE-HX037 Notebook">
    <p>
        Típus: Lenovo IdeaPad Gaming 3 82K101CTHV Notebook<br>
        Processzor: AMD Ryzen 7 6800H<br>
        Memória mérete:DDR 5 16 GB <br>
        Háttértár: 512 GB<br>
        Háttértár Típusa: SSD<br>
        Kijelző mérete 17"<br>
        Kijelző felbontása 1920 x 1080<br>
        Videókártya: Nvidia GeForce RTX 3050 Ti<br></p>
    <p class="laptopar">Ár: 479 900,-</p>
    <form class="rating-submit" action="" method="get">
        <input type="hidden" name="id" value="l4">
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
    <?php if(isset($ertekeles["l4"])) { ?>
        <p class="ertekeles">Az Ön értékelése: <?php echo $ertekeles["l4"]; ?> csillag</p>
    <?php } ?>
    <form class="kosarba-button" action="" method="get">
        <input type="hidden" name="id" value="l4">
        <?php if (in_array("l4", $kosar)) { ?>
            <button type="submit" disabled>Kosárba <span>&#10003;</span></button>
        <?php } else { ?>
            <button type="submit" name="kosarba" value="1">Kosárba</button>
        <?php } ?>
    </form>
</div>

<div class="macpc">Mac Laptopjaink</div>

<div class="Laptopok" id="l5">
    <img src="img/MacBook_Air.jpeg" alt="Apple MacBook Air M2 256GB MLY33 Notebook">
    <p>
        Típus: Apple MacBook Air M2<br>
        Processzor: M2<br>
        Memória mérete:DDR5 8 GB <br>
        Háttértár: 256 GB<br>
        Háttértár Típusa: SSD<br>
        Kijelző mérete 13.6"<br>
        Kijelző felbontása 2560 X 1664<br>
        Videókártya: Integrált<br>
    <p class="laptopar">Ár: 618 173,-</p>
    <form class="rating-submit" action="" method="get">
        <input type="hidden" name="id" value="l5">
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
    <?php if(isset($ertekeles["l5"])) { ?>
        <p class="ertekeles">Az Ön értékelése: <?php echo $ertekeles["l5"]; ?> csillag</p>
    <?php } ?>
    <form class="kosarba-button" action="" method="get">
        <input type="hidden" name="id" value="l5">
        <?php if (in_array("l5", $kosar)) { ?>
            <button type="submit" disabled>Kosárba <span>&#10003;</span></button>
        <?php } else { ?>
            <button type="submit" name="kosarba" value="1">Kosárba</button>
        <?php } ?>
    </form>
</div>

<div class="Laptopok" id="l6">
    <img src="img/MacBook_Pro.jpeg" alt="Apple MacBook Pro">
    <p>
        Típus: MacBook Pro 16"<br>
        Processzor: M2 Pro<br>
        Memória mérete:64 GB <br>
        Háttértár: 2 TB SSD<br>
        Kijelző mérete 16"<br>
        Kijelző felbontása 3456 x 2234<br>
        Videókártya: Integrált<br>
    <p id="athuzottar">Ár: 1 249 990,-</p>
    <p><mark>AKCIÓ: 1 059 990,-</mark></p>
    <form class="rating-submit" action="" method="get">
        <input type="hidden" name="id" value="l6">
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
    <?php if(isset($ertekeles["l6"])) { ?>
        <p class="ertekeles">Az Ön értékelése: <?php echo $ertekeles["l6"]; ?> csillag</p>
    <?php } ?>
    <form class="kosarba-button" action="" method="get">
        <input type="hidden" name="id" value="l6">
        <?php if (in_array("l6", $kosar)) { ?>
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