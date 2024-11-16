<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Termék értékelése</title>
</head>
<body>
<h1>Termék értékelése</h1>
<form action="" method="post">
    <label for="rating">Értékelés (1-5):</label>
    <input type="number" name="rating" id="rating" min="1" max="5" required><br><br>
    <label for="comment">Megjegyzés:</label><br>
    <textarea name="comment" id="comment" rows="5" cols="50"></textarea><br><br>
    <input type="submit" value="Értékelés elküldése">
</form>
</body>
</html>

<?php
// Ellenőrizzük, hogy a felhasználó már értékelt-e korábban
if(isset($_COOKIE['product_rating'])) {
    echo "Már értékelted ezt a terméket!<br>";
    echo "Az értékelésed: ".$_COOKIE['product_rating']."/5<br>";
    echo "Megjegyzésed: ".$_COOKIE['product_comment']."<br>";
} else {
    if(isset($_POST['rating']) && isset($_POST['comment'])) {
        // Az űrlap adatokat eltároljuk a cookie-ban
        setcookie('product_rating', $_POST['rating'], time() + 3600);
        setcookie('product_comment', $_POST['comment'], time() + 3600);
        echo "Az értékelésed sikeresen el lett küldve!<br>";
        echo "Az értékelésed: ".$_POST['rating']."/5<br>";
        echo "Megjegyzésed: ".$_POST['comment']."<br>";
    }
}
?>