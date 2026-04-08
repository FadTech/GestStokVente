<?php
session_start();
require_once("../config/connexion.php");
if(!isset($_SESSION['user'])) header("Location: ../auth/login.php");

$id = $_GET['id'] ?? 0;
$prodSql = "SELECT * FROM produits WHERE produit_id = ?";
$stmt = $conn->prepare($prodSql);
$stmt->bind_param("i", $id);
$stmt->execute();
$prod = $stmt->get_result()->fetch_assoc();

// Catégories
$catSql = "SELECT * FROM categories";
$catResult = $conn->query($catSql);

if(isset($_POST['modifier'])){
    $nom = $_POST['nom'];
    $categorie_id = $_POST['categorie_id'];
    $prix_achat = $_POST['prix_achat'];
    $prix_vente = $_POST['prix_vente'];
    $quantite = $_POST['quantite'];
    $statut = ($quantite == 0) ? "rupture" : (($quantite < 5) ? "faible" : "en stock");

    $sql = "UPDATE produits SET nom=?, categorie_id=?, prix_achat=?, prix_vente=?, quantite=?, statut=? WHERE produit_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siddisi", $nom, $categorie_id, $prix_achat, $prix_vente, $quantite, $statut, $id);
    $stmt->execute();

    header("Location: liste.php");
}
?>

<?php include("../includes/header.php"); ?>
<?php include("../includes/navbar.php"); ?>

<div class="container mt-4">
    <h3>Modifier le produit</h3>
    <form method="POST">
        <div class="mb-2">
            <input type="text" name="nom" class="form-control" value="<?= $prod['nom'] ?>" required>
        </div>
        <div class="mb-2">
            <select name="categorie_id" class="form-control" required>
                <?php while($cat = $catResult->fetch_assoc()): ?>
                    <option value="<?= $cat['categorie_id'] ?>" <?= ($prod['categorie_id']==$cat['categorie_id'])?'selected':'' ?>>
                        <?= $cat['nom'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-2">
            <input type="number" name="prix_achat" class="form-control" value="<?= $prod['prix_achat'] ?>" required>
        </div>
        <div class="mb-2">
            <input type="number" name="prix_vente" class="form-control" value="<?= $prod['prix_vente'] ?>" required>
        </div>
        <div class="mb-2">
            <input type="number" name="quantite" class="form-control" value="<?= $prod['quantite'] ?>" required>
        </div>
        <button class="btn btn-warning" name="modifier">Modifier</button>
        <a href="listes.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<?php include("../includes/footer.php"); ?>