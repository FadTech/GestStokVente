<?php
session_start();
require_once("../config/connexion.php");
if(!isset($_SESSION['user'])) header("Location: ../auth/login.php");

// Récupérer catégories
$catSql = "SELECT * FROM categories";
$catResult = $conn->query($catSql);

if(isset($_POST['ajouter'])){
    $nom = $_POST['nom'];
    $categorie_id = $_POST['categorie_id'];
    $prix_achat = $_POST['prix_achat'];
    $prix_vente = $_POST['prix_vente'];
    $quantite = $_POST['quantite'];
    $statut = ($quantite == 0) ? "rupture" : (($quantite < 5) ? "faible" : "en stock");

    $sql = "INSERT INTO produits(nom, categorie_id, prix_achat, prix_vente, quantite, statut) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siddis", $nom, $categorie_id, $prix_achat, $prix_vente, $quantite, $statut);
    $stmt->execute();

    header("Location: listes.php");
}
?>

<?php include("../includes/header.php"); ?>
<?php include("../includes/navbar.php"); ?>

<div class="container mt-4">
    <h3>Ajouter un produit</h3>
    <form method="POST">
        <div class="mb-2">
            <input type="text" name="nom" class="form-control" placeholder="Nom du produit" required>
        </div>
        <div class="mb-2">
            <select name="categorie_id" class="form-control" required>
                <option value="">Sélectionner une catégorie</option>
                <?php while($cat = $catResult->fetch_assoc()): ?>
                    <option value="<?= $cat['categorie_id'] ?>"><?= $cat['nom'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-2">
            <input type="number" name="prix_achat" class="form-control" placeholder="Prix d'achat" required>
        </div>
        <div class="mb-2">
            <input type="number" name="prix_vente" class="form-control" placeholder="Prix de vente" required>
        </div>
        <div class="mb-2">
            <input type="number" name="quantite" class="form-control" placeholder="Quantité" required>
        </div>
        <button class="btn btn-success" name="ajouter">Ajouter</button>
        <a href="listes.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<?php include("../includes/footer.php"); ?>