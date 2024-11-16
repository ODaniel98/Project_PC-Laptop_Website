<?php
session_start();
session_unset();
session_destroy();

if (isset($_COOKIE["kosar" . $_SESSION["user"]["felhasznalonev"]])) {
    $kosar = json_decode($_COOKIE["kosar" . $_SESSION["user"]["felhasznalonev"]], true);
    setcookie("kosar" . $_SESSION["user"]["felhasznalonev"], json_encode($kosar), time() + (86400 * 30), "/"); // 30 napos érvényességi idővel hozzuk létre az új cookie-t
}

foreach ($_SESSION as $key => $value) {
    unset($_SESSION[$key]);
}

header("Location: login.php");    // átirányítás
?>
