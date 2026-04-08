<?php
session_start();
require_once("../config/connexion.php");
if(!isset($_SESSION['user'])) header("Location: ../auth/login.php");

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("DELETE FROM produits WHERE produit_id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: listes.php");
exit();
?>