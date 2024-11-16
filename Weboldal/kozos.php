<?php
// a regisztrált felhasználók fájlból való betöltéséért felelő függvény

function loadUsers($path) {
    $users = [];

    $file = fopen($path, "r");
    if ($file === FALSE)
        die("HIBA: A fájl megnyitása nem sikerült!");

    while (($line = fgets($file)) !== FALSE) {
        $user = unserialize($line);
        $users[] = $user;
    }

    fclose($file);
    return $users;
}

function nemet_konvertal($betujel) {		// egy segédfüggvény, amely visszaadja a betűjelnek megfelelő nemet
    switch ($betujel) {
        case "F" : return "férfi"; break;
        case "N" : return "nő"; break;
        case "E" : return "egyéb"; break;
    }
}

function listUsers($path) {
    $result = "";


    $file = fopen($path, "r");
    if ($file === FALSE)
        die("HIBA: A fájl megnyitása nem sikerült!");

    while (($line = fgets($file)) !== FALSE) {
        $user = unserialize($line);

        if($_SESSION["user"]["felhasznalonev"] != "admin"){
            if($_SESSION["user"]["felhasznalonev"] == $user["felhasznalonev"]){
                $result .= "<div class=\"users-div\">".
                    "<h1 class=\"users-h1-own\">".$user["felhasznalonev"]."</h1>".
                    "<h2 class=\"users-h2-own\">".$user["eletkor"]."</h2>".
                    "<h2 class=\"users-h2-own\">".nemet_konvertal($user["nem"])."</h2>".
                    "<h2 class=\"users-h2-own\">".implode(", ", $user["hobbik"])."</h2>".
                    "</div>";
            }else{
                $result .= "<div class=\"users-div\">".
                    "<h1 class=\"users-h1\">".$user["felhasznalonev"]."</h1>".
                    "<h2 class=\"users-h2\">".$user["eletkor"]."</h2>".
                    "<h2 class=\"users-h2\">".nemet_konvertal($user["nem"])."</h2>".
                    "<h2 class=\"users-h2\">".implode(", ", $user["hobbik"])."</h2>".
                    "</div>";
            }

        }else{
            if($user["felhasznalonev"] == "admin"){
                $result .= "<div class=\"users-div\">".
                "<h1 class=\"users-h1\">".$user["felhasznalonev"]."</h1>".
                "<h2 class=\"users-h2\">".$user["eletkor"]."</h2>".
                "<h2 class=\"users-h2\">".nemet_konvertal($user["nem"])."</h2>".
                "<h2 class=\"users-h2\">".implode(", ", $user["hobbik"])."</h2>".
                "<form action=\"profile.php\" method=\"post\">".
                "</form>".
                "</div>";
            }else{
                $result .= "<div class=\"users-div\">".

                    "<h1 class=\"users-h1\">".$user["felhasznalonev"]."</h1>".
                    "<h2 class=\"users-h2\">".$user["eletkor"]."</h2>".
                    "<h2 class=\"users-h2\">".nemet_konvertal($user["nem"])."</h2>".
                    "<h2 class=\"users-h2\">".implode(", ", $user["hobbik"])."</h2>".
                    "<form action=\"profile.php\" method=\"post\">".
                    "<input type=\"hidden\" name=\"felhasznalonev\" value=\"".$user["felhasznalonev"]."\"/>".
                    "<input type=\"submit\" name=\"delete_as_admin\" value=\"Felhasználói fiók törlése\"/> <br/><br/>".
                    "</form>".
                    "</div>";
            }
        }
    }

    fclose($file);
    return $result;
}



// a regisztrált felhasználók adatait fájlba író függvény

function saveUsers($path, $users) {
    $file = fopen($path, "w");
    if ($file === FALSE)
        die("HIBA: A fájl megnyitása nem sikerült!");

    foreach($users as $user) {
        $serialized_user = serialize($user);
        fwrite($file, $serialized_user . "\n");
    }

    fclose($file);
}

function deleteUsers($path, $sessionuser){
    $users = loadUsers("users.txt");
    $result = "";
    $users = array_filter($users, function ($user) use ($sessionuser) {
        return $user["felhasznalonev"] !== $sessionuser["felhasznalonev"];
    });

    foreach ($users as $user){
        $result .= $user["eletkor"]."<br>";
    }

    $file = fopen($path, "w+");
    if ($file === FALSE)
        die("HIBA: A fájl megnyitása nem sikerült!");

    foreach($users as $user) {
        $serialized_user = serialize($user);
        fwrite($file, $serialized_user . "\n");
    }

    fclose($file);

    return $result;
}

// a profilkép feltöltését végző függvény

function uploadProfilePicture($username) {
    global $fajlfeltoltes_hiba;    // ez a változó abban a fájlban található, amiben ezt a függvényt meghívjuk, ezért újradeklaráljuk globálisként

    if (isset($_FILES["profile-pic"]) && is_uploaded_file($_FILES["profile-pic"]["tmp_name"])) {  // ha töltöttek fel fájlt...
        $allowed_extensions = ["png", "jpg", "jpeg"];                                           // az engedélyezett kiterjesztések tömbje
        $extension = strtolower(pathinfo($_FILES["profile-pic"]["name"], PATHINFO_EXTENSION));  // a feltöltött fájl kiterjesztése

        if (in_array($extension, $allowed_extensions)) {      // ha a fájl kiterjesztése megfelelő...
            if ($_FILES["profile-pic"]["error"] === 0) {        // ha a fájl feltöltése sikeres volt...
                if ($_FILES["profile-pic"]["size"] <= 31457280) { // ha a fájlméret nem nagyobb 30 MB-nál
                    $path = "images/" . $username . "." . $extension;   // a cél útvonal összeállítása

                    if (!move_uploaded_file($_FILES["profile-pic"]["tmp_name"], $path)) { // fájl átmozgatása a cél útvonalra
                        $fajlfeltoltes_hiba = "A fájl átmozgatása nem sikerült!";
                    }
                } else {
                    $fajlfeltoltes_hiba = "A fájl mérete túl nagy!";
                }
            } else {
                $fajlfeltoltes_hiba = "A fájlfeltöltés nem sikerült!";
            }
        } else {
            $fajlfeltoltes_hiba = "A fájl kiterjesztése nem megfelelő!";
        }
    }
}
?>