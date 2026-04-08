<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Marché</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="/GestMagasin/assets/css/bootstrap.min.css">

    <!-- Ton CSS -->
    <link rel="stylesheet" href="/GestMagasin/assets/css/style.css">
</head>

<body class="bg-light">