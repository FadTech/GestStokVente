<?php
session_start();  // Démarre la session

// Détruire toutes les données de session
$_SESSION = array();
session_destroy();

// Redirection vers la page de connexion
header("Location: login.php");
exit();
?>