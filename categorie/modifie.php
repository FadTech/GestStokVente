<?php
session_start();
require_once("../config/connexion.php");
if(!isset($_SESSION['user'])) header("Location: ../auth/login.php");

$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT * FROM categories WHERE categorie_id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$cat = $stmt->get_result()->fetch_assoc();

if(isset($_POST['modifier'])){
    $nom = $_POST['nom'];
    $description = $_POST['description'];

    $sql = "UPDATE categories SET nom=?, description=? WHERE categorie_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nom, $description, $id);
    $stmt->execute();

    header("Location: liste.php");
}
?>

<?php include("../includes/header.php"); ?>
<?php include("../includes/navbar.php"); ?>

<div class="container mt-4">
    <h3>Modifier la catégorie</h3>
    <form method="POST">
        <div class="mb-2">
            <input type="text" name="nom" class="form-control" value="<?= $cat['nom'] ?>" required>
        </div>
        <div class="mb-2">
            <textarea name="description" class="form-control" rows="3"><?= $cat['description'] ?></textarea>
        </div>
        <button class="btn btn-warning" name="modifier">Modifier</button>
        <a href="listes.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<?php include("../includes/footer.php"); ?>