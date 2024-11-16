<?php
session_start();
include "kozos.php";
$fiokok = loadUsers("users.txt");

$hibak = [];

// űrlapfeldolgozás

if (isset($_POST["regiszt"])) {
    if (!isset($_POST["felhasznalonev"]) || trim($_POST["felhasznalonev"]) === "")
        $hibak[] = "A felhasználónév megadása kötelező!";

    if (!isset($_POST["jelszo"]) || trim($_POST["jelszo"]) === "" || !isset($_POST["jelszo2"]) || trim($_POST["jelszo2"]) === "")
        $hibak[] = "A jelszó és az ellenőrző jelszó megadása kötelező!";

    if (!isset($_POST["eletkor"]) || trim($_POST["eletkor"]) === "")
        $hibak[] = "Az életkor megadása kötelező!";

    if (!isset($_POST["nem"]) || trim($_POST["nem"]) === "")
        $hibak[] = "A nem megadása kötelező!";

    if (!isset($_POST["hobbik"]) || count($_POST["hobbik"]) < 2)
        $hibak[] = "Legalább 2 hobbit kötelező kiválasztani!";

    $felhasznalonev = $_POST["felhasznalonev"];
    $jelszo = $_POST["jelszo"];
    $jelszo2 = $_POST["jelszo2"];
    $eletkor = $_POST["eletkor"];
    $nem = NULL;
    $hobbik = NULL;

    if (isset($_POST["nem"]))
        $nem = $_POST["nem"];
    if (isset($_POST["hobbik"]))
        $hobbik = $_POST["hobbik"];

    foreach ($fiokok as $fiok) {
        if ($fiok["felhasznalonev"] === $felhasznalonev)
            $hibak[] = "A felhasználónév már foglalt!";
    }

    if (strlen($jelszo) < 8)
        $hibak[] = "A jelszónak legalább 8 karakter hosszúnak kell lennie!";

    if ($jelszo !== $jelszo2)
        $hibak[] = "A jelszó és az ellenőrző jelszó nem egyezik!";

    if ($eletkor < 18)
        $hibak[] = "Csak 18 éves kortól lehet regisztrálni!";

    $fajlfeltoltes_hiba = "";               // változó a fájlfeltöltés során adódó esetleges hibaüzenet tárolására
    uploadProfilePicture($felhasznalonev);  // a kozos.php-ban definiált profilkép feltöltést végző függvény meghívása

    if ($fajlfeltoltes_hiba !== "")         // ha volt hiba a fájlfeltöltés során, akkor hozzáírjuk a hibaüzenetet a $hibak tömbhöz
        $hibak[] = $fajlfeltoltes_hiba;

    if (count($hibak) === 0) {   // sikeres regisztráció
        $jelszo = password_hash($jelszo, PASSWORD_DEFAULT);
        $fiokok[] = ["felhasznalonev" => $felhasznalonev, "jelszo" => $jelszo, "eletkor" => $eletkor, "nem" => $nem, "hobbik" => $hobbik];
        saveUsers("users.txt", $fiokok);
        $siker = TRUE;
        header("Location: login.php");
    } else {                    // sikertelen regisztráció
        $siker = FALSE;
    }
}
?>




<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Regisztracio</title>
    <link rel="stylesheet" href="css/style.css?v2 ">
    <link rel="icon" type="image/x-icon" href="img/Circle-icons-computer.png">
</head>
<body class="reghatter">

<header>
    <nav id="header-nav">
        <ul>
            <li class="regisztracio-inactive"><a href="index.php">Főoldal</a></li>
            <li class="regisztracio-inactive"><a href="asztali_szamitogepek.php">Asztali PC</a></li>
            <li class="regisztracio-inactive"><a href="laptopok.php">Laptopok</a></li>
            <li class="regisztracio-active"><a href="signup.php">Regisztráció</a></li>
            <li class="regisztracio-inactive"><a href="login.php">Bejelentkezés</a></li>
        </ul>
    </nav>
</header>

<h1 id="regh1">Regisztráció</h1>

<div class="hiba-container">
    <div class="hiba-szin">
        <?php
        if (isset($siker) && $siker === TRUE) {  // ha nem volt hiba, akkor a regisztráció sikeres
            echo "<p>Sikeres regisztráció!</p>";
        } else {                                // az esetleges hibákat kiírjuk egy-egy bekezdésben
            foreach ($hibak as $hiba) {
                echo "<p>" . $hiba . "</p>";
            }
        }
        ?>
    </div>
</div>


<form action="signup.php" method="post">
    <fieldset>
        <label><input type="text" name="felhasznalonev" placeholder="Felhasználónév"/></label> <br/>
        <label><input type="password" name="jelszo" placeholder="Jelszó (Minimum 8 karakter)"/></label> <br/>
        <label><input type="password" name="jelszo2"placeholder="Jelszó ismét (Meg kell egyezzen a jelszóval)"/></label> <br/>
        <label>Életkor: <input type="number" name="eletkor" placeholder="18 éves kortól"/></label> <br/>
        Nem - Egyet ki kell választani:
        <label><input type="radio" name="nem" value="F"/> Férfi</label>
        <label><input type="radio" name="nem" value="N"/> Nő</label>
        <label><input type="radio" name="nem" value="E"/> Egyéb</label> <br/>
        Hobbik - Minimum 2 kiválasztása kötelező:
        <label><input type="checkbox" name="hobbik[]" value="sport"/> sport</label>
        <label><input type="checkbox" name="hobbik[]" value="főzés"/> főzés</label>
        <label><input type="checkbox" name="hobbik[]" value="filmek"/> filmek</label>
        <label><input type="checkbox" name="hobbik[]" value="rajzolás"/> rajzolás</label>
        <label><input type="checkbox" name="hobbik[]" value="kirándulás"/> kirándulás</label> <br/>
        <input type="submit" name="regiszt" value="Regisztráció"/> <br/><br/>
        <input type="reset" name="reset" value="Reset"/>
    </fieldset>
</form>


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
