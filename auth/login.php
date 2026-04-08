<?php
require_once("../config/connexion.php");
session_start();

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $user = $result->fetch_assoc();

        if(password_verify($password, $user['mot_de_passe'])){
            $_SESSION['user'] = $user;
            header("Location: ../index.php");
        } else {
            $error = "Mot de passe incorrect";
        }
    } else {
        $error = "Email introuvable";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="col-md-4 mx-auto card p-4 shadow">
        <h3 class="text-center">Connexion</h3>

        <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <form method="POST">
            <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
            <input type="password" name="password" class="form-control mb-2" placeholder="Mot de passe" required>

            <button class="btn btn-primary w-100" name="login">Se connecter</button>
        </form>

        <a href="register.php" class="text-center mt-2">Créer un compte</a>
    </div>
</div>

</body>
</html>