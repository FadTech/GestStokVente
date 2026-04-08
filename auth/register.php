<?php
require_once("../config/connexion.php");

if(isset($_POST['register'])){
    $nom = $_POST['nom'];
    $prenoms = $_POST['prenoms'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO utilisateurs(nom, prenoms, email, mot_de_passe, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nom, $prenoms, $email, $password, $role);
    $stmt->execute();

    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="col-md-5 mx-auto card p-4 shadow">
        <h3 class="text-center">Inscription</h3>

        <form method="POST">
            <input type="text" name="nom" class="form-control mb-2" placeholder="Nom" required>
            <input type="text" name="prenoms" class="form-control mb-2" placeholder="Prénoms" required>
            <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
            <input type="password" name="password" class="form-control mb-2" placeholder="Mot de passe" required>

            <select name="role" class="form-control mb-2">
                <option value="admin">Admin</option>
                <option value="gestionnaire">Gestionnaire</option>
            </select>

            <button class="btn btn-success w-100" name="register">S'inscrire</button>
        </form>
    </div>
</div>

</body>
</html>