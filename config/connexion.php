<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "geststock_vente";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}
?>
