<?php
session_start();
require_once("../config/connexion.php");
if(!isset($_SESSION['user'])) header("Location: ../auth/login.php");

if(isset($_POST['ajouter'])){
    $nom = $_POST['nom'];
    $description = $_POST['description'];

    $sql = "INSERT INTO categories(nom, description) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nom, $description);
    $stmt->execute();

    header("Location: liste.php");
}
?>

<?php include("../includes/header.php"); ?>
<?php include("../includes/navbar.php"); ?>

<div class="container mt-4">
    <h3>Ajouter une catégorie</h3>
    <form method="POST">
        <div class="mb-2">
            <input type="text" name="nom" class="form-control" placeholder="Nom de la catégorie" required>
        </div>
        <div class="mb-2">
            <textarea name="description" class="form-control" placeholder="Description" rows="3"></textarea>
        </div>
        <button class="btn btn-success" name="ajouter">Ajouter</button>
        <a href="listes.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<?php include("../includes/footer.php"); ?>