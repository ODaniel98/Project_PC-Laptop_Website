<?php
session_start();
include "kozos.php";

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
    <link rel="stylesheet" href="css/style.css?v2">
    <link rel="icon" type="image/x-icon" href="img/Circle-icons-computer.png">
</head>
<body class="profile-body">
<header>
    <nav id="header-nav">
        <ul>
            <li class="profile-inactive"><a href="index.php">Főoldal</a></li>
            <li class="profile-inactive"><a href="asztali_szamitogepek.php">Asztali PC</a></li>
            <li class="profile-inactive"><a href="laptopok.php">Laptopok</a></li>
            <?php if (isset($_SESSION["user"])) { ?>
                <li class="profile-active"><a href="profile.php">Profilom</a></li>
                <li class="profile-inactive"><a href="listUsers.php">Felhasználók</a></li>
                <li class="profile-inactive"><a href="kosar.php">Kosár (<?php echo $kosarDarab; ?>)</a></li>
                <li class="profile-inactive"><a href="logout.php">Kijelentkezés</a></li>
            <?php } else { ?>
                <li class="profile-inactive"><a href="signup.php">Regisztráció</a></li>
                <li class="profile-inactive"><a href="login.php">Bejelentkezés</a></li>
            <?php } ?>
        </ul>
    </nav>
</header>

<h1 class="profile-h1">Profiladatok</h1>

<section id="content">
    <h2>Profilom</h2>
    <hr/>

    <?php
    // a profilkép elérési útvonalának eltárolása egy változóban

    $profilkep = "images/default.png";      // alapértelmezett kép, amit akkor jelenítünk meg, ha valakinek nincs feltöltött profilképe
    $utvonal = "images/" . $_SESSION["user"]["felhasznalonev"]; // a kép neve a felhasználó nevével egyezik meg

    $kiterjesztesek = ["png", "jpg", "jpeg"];     // a lehetséges kiterjesztések, amivel egy profilkép rendelkezhet

    foreach ($kiterjesztesek as $kiterjesztes) {  // minden kiterjesztésre megnézzük, hogy létezik-e adott kiterjesztéssel profilképe a felhasználónak
        if (file_exists($utvonal . "." . $kiterjesztes)) {
            $profilkep = $utvonal . "." . $kiterjesztes;  // ha megtaláltuk a felhasználó profilképét, eltároljuk annak az elérési útvonalát egy változóban
        }
    }
    ?>

    <table class="profile-data">
        <tr>
            <th colspan="2">
                <img src="<?php echo $profilkep; ?>" alt="Profilkép" height="200"/>
                <?php if ($_SESSION["user"]["felhasznalonev"] !== "default") { /* a "default" nevű példa felhasználó esetén ne engedélyezzük a profilkép módosítását */ ?>
                    <form action="profile.php" method="POST" enctype="multipart/form-data">
                        <input type="file" name="profile-pic" accept="image/*"/>
                        <input type="submit" name="upload-btn" value="Profilkép módosítása"/>
                    </form>
                <?php } ?>
            </th>
        </tr>
        <tr>
            <th>Felhasználónév:</th>
            <td><?php echo $_SESSION["user"]["felhasznalonev"]; ?></td>
        </tr>
        <tr>
            <th>Életkor:</th>
            <td><?php echo $_SESSION["user"]["eletkor"]; ?></td>
        </tr>
        <tr>
            <th>Nem:</th>
            <td><?php echo nemet_konvertal($_SESSION["user"]["nem"]); ?></td>
        </tr>
        <tr>
            <th>Hobbik:</th>
            <td><?php echo implode(", ", $_SESSION["user"]["hobbik"]); ?></td>
        </tr>
    </table>

    <?php
    // a profilkép módosítását elvégző PHP kód

    if (isset($_POST["upload-btn"]) && is_uploaded_file($_FILES["profile-pic"]["tmp_name"])) {  // ha töltöttek fel fájlt...
        $fajlfeltoltes_hiba = "";                                       // változó a fájlfeltöltés során adódó esetleges hibaüzenet tárolására
        uploadProfilePicture($_SESSION["user"]["felhasznalonev"]);      // a kozos.php-ban definiált profilkép feltöltést végző függvény meghívása

        $kit = strtolower(pathinfo($_FILES["profile-pic"]["name"], PATHINFO_EXTENSION));    // a feltöltött profilkép kiterjesztése
        $utvonal = "images/" . $_SESSION["user"]["felhasznalonev"] . "." . $kit;            // a feltöltött profilkép teljes elérési útvonala

        // ha nem volt hiba a fájlfeltöltés során, akkor töröljük a régi profilképet, egyébként pedig kiírjuk a fájlfeltöltés során adódó hibát

        if ($fajlfeltoltes_hiba === "") {
            if ($utvonal !== $profilkep && $profilkep !== "images/default.png") {   // az ugyanolyan névvel feltöltött képet és a default.png-t nem töröljük
                unlink($profilkep);                         // régi profilkép törlése
            }

            header("Location: profile.php");              // weboldal újratöltése
        } else {
            echo "<p>" . $fajlfeltoltes_hiba . "</p>";
        }
    }
    ?>
</section>

<div>
    <h2> Adatok Megváltoztatása </h2><br>
    <form action="profile.php" method="post">
        <fieldset>
            <label><input type="text" name="felhasznalonev" placeholder="Felhasználónév"/></label>
            <label>Életkor: <input type="number" name="eletkor" placeholder="Minimum 18"/></label>
            <label><input type="password" name="current_jelszo" placeholder="Jelszó (Minimum 8 karakter)"/></label> <br/>
            <label><input type="password" name="jelszo" placeholder="Jelszó (Minimum 8 karakter)"/></label> <br/>
            <label><input type="password" name="jelszo2"placeholder="Jelszó ismét (Meg kell egyezzen a jelszóval)"/></label> <br/>
            <input type="submit" name="change" value="Megváltoztatás"/> <br/><br/>
        </fieldset>
</div>
<?php

$fiokok = loadUsers("users.txt"); // betöltjük a regisztrált felhasználók adatait, és elmentjük őket a $fiokok változóban

if(isset($_POST['change'])) {
    $new_username = $_POST['felhasznalonev'];
    $new_eletkor = $_POST['eletkor'];
    $current_password = $_POST['current_jelszo'];
    $new_password = $_POST['jelszo'];
    $confirm_new_password = $_POST['jelszo2'];

    $confirmusername = false;
    $confirmage = false;
    $confirmpassword = false;

    // Ellenőrizzük, hogy az új felhasználónév nem üres
    if(empty($new_username)) {
        echo "Az új felhasználónév nem lehet üres!";
    } else {
        // Ellenőrizzük, hogy az új felhasználónév már nem foglalt-e
        $is_username_taken = false;
        foreach ($fiokok as $fiok) {
            if ($fiok["felhasznalonev"] === $new_username){
                $is_username_taken = true;
                break;
            }
        }

        if($is_username_taken) {
            echo "Az új felhasználónév már foglalt!";
        } else {
            // Frissítjük az aktuális felhasználó felhasználónevét
            foreach ($fiokok as &$fiok) {
                if ($fiok["felhasznalonev"] === $_SESSION["user"]["felhasznalonev"]){
                    $fiok["felhasznalonev"] = $new_username; // felülírjuk a jelenlegi felhasználónevet az újjal
                    saveUsers("users.txt", $fiokok); // mentjük a módosított felhasználói adatokat
                    $_SESSION["user"]["felhasznalonev"] = $new_username; // frissítjük az aktuális felhasználó felhasználónevét a session változóban
                }
            }
            $confirmusername = true;

        }
    }
    if (empty($new_eletkor) || $new_eletkor < 18) {
        echo "Az új életkor nem megfelelő!";
    } else {
        // Frissítjük az aktuális felhasználó életkorát
        foreach ($fiokok as &$fiok) {
            if ($fiok["eletkor"] === $_SESSION["user"]["eletkor"]) {
                $fiok["eletkor"] = $new_eletkor; // felülírjuk a jelenlegi felhasználó életkort az újjal
                saveUsers("users.txt", $fiokok); // mentjük a módosított felhasználói adatokat
                $_SESSION["user"]["eletkor"] = $new_eletkor; // frissítjük az aktuális felhasználó felhasználónevét a session változóban
                $confirmage = true;
            }
        }
    }

    if(isset($_POST['change'])) {

        // Ellenőrizzük a jelenlegi jelszó helyességét
        if(password_verify($current_password, $_SESSION["user"]["jelszo"])) {
            // Hash-eljük az új jelszót
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Frissítjük az aktuális felhasználó jelszavát
            if(strlen($new_password) < 8) {
                echo "Az új jelszónak legalább 8 karakter hosszúnak kell lennie!";
            } else {
                foreach ($fiokok as &$fiok) {
                    if ($fiok["felhasznalonev"] === $_SESSION["user"]["felhasznalonev"]){
                        $fiok["jelszo"] = $hashed_new_password; // felülírjuk a jelenlegi jelszót az újjal
                        saveUsers("users.txt", $fiokok); // mentjük a módosított felhasználói adatokat
                        $_SESSION["user"]["jelszo"] = $hashed_new_password; // frissítjük az aktuális felhasználó jelszavát a session változóban
                        $confirmpassword = true;
                    }
                }
            }
        } else {
            echo "A megadott jelenlegi jelszó helytelen!";
        }
    }
    if($confirmage && $confirmusername&& $confirmpassword){
        header("Location: profile.php");
    }
}
?>
<br>
<div class="delete">
    <form action="profile.php" method="post">
    <input type="submit" name="delete" value="Felhasználói fiók törlése"/> <br/><br/>
    </form>
</div>
<?php

        if(isset($_POST['delete'])){
            $users  = loadUsers("users.txt");
            foreach($users as $user){
                if($user["felhasznalonev"] == $_SESSION["user"]["felhasznalonev"]){
                    echo deleteUsers("users.txt", $_SESSION["user"]);
                    session_destroy();
                    header("Location: index.php");
                }
            }
        }

        if(isset($_POST['delete_as_admin'])){
            $users  = loadUsers("users.txt");
            foreach($users as $user){
                if($user["felhasznalonev"] == $_POST["felhasznalonev"]){
                    echo deleteUsers("users.txt", $user);
                    header("Location: listUsers.php");
                }
            }
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
