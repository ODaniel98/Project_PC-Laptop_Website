<?php
session_start();
include "kozos.php";              // a loadUsers() függvény ebben a fájlban van
$fiokok = loadUsers("users.txt"); // betöltjük a regisztrált felhasználók adatait, és eltároljuk őket a $fiokok változóban

$uzenet = "";                     // az űrlap feldolgozása után kiírandó üzenet

if (isset($_POST["login"])) {    // miután az űrlapot elküldték...
    if (!isset($_POST["felhasznalonev"]) || trim($_POST["felhasznalonev"]) === "" || !isset($_POST["jelszo"]) || trim($_POST["jelszo"]) === "") {
        // ha a kötelezően kitöltendő űrlapmezők valamelyike üres, akkor hibaüzenetet jelenítünk meg
        $uzenet = "<strong>Hiba:</strong> Adj meg minden adatot!";
    } else {
        // ha megfelelően kitöltötték az űrlapot, lementjük az űrlapadatokat egy-egy változóba
        $felhasznalonev = $_POST["felhasznalonev"];
        $jelszo = $_POST["jelszo"];

        // bejelentkezés sikerességének ellenőrzése
        $uzenet = "Sikertelen belépés! A belépési adatok nem megfelelők!";  // alapból azt feltételezzük, hogy a bejelentkezés sikertelen
        foreach ($fiokok as $fiok) {
            if ($fiok["felhasznalonev"] === $felhasznalonev && password_verify($jelszo, $fiok["jelszo"])) {
                $uzenet = "Sikeres belépés!";
                $_SESSION["user"] = $fiok;
                header("Location: index.php");          // átirányítás az index.php oldalra
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Bejelentkezes</title>
    <link rel="stylesheet" href="css/style.css?v2">
    <link rel="icon" type="image/x-icon" href="img/Circle-icons-computer.png">
</head>
<body class="bejelentkezes-hatter">

<header>
    <nav id="header-nav">
        <ul>
            <li class="bejelentkezes-inactive"><a href="index.php">Főoldal</a></li>
            <li class="bejelentkezes-inactive"><a href="asztali_szamitogepek.php">Asztali PC</a></li>
            <li class="bejelentkezes-inactive"><a href="laptopok.php">Laptopok</a></li>
            <li class="bejelentkezes-inactive"><a href="signup.php">Regisztráció</a></li>
            <li class="bejelentkezes-active"><a href="login.php">Bejelentkezés</a></li>
        </ul>
    </nav>
</header>


<form id="login-form" action="login.php" method="post">
    <h1 id="login-h1">Bejelentkezés</h1>
    <div class="login-msg"><?php echo $uzenet . "<br/>"; ?></div>
    <label class="loginlabel">Felhasználónév:</label>
    <label class= "loginlabel" for="login-username"></label><input type="text" id="login-username" name="felhasznalonev" required />
    <label class="loginlabel">Jelszó:</label>
    <label class= "loginlabel" for="login-password"></label><input type="password" id="login-password" name="jelszo" required />
    <input type="submit" id="login-submit" name="login" value="Bejelentkezés" />
    <p id="login-p">Nincs még fiókja? <a href="#">Regisztráció</a></p>
</form>


<footer class="container" id="login-footer">
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