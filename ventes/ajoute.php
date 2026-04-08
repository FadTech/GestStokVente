<?php
session_start();
require_once("../config/connexion.php");
if(!isset($_SESSION['user'])) header("Location: ../auth/login.php");

// Récupérer produits
$prodSql = "SELECT * FROM produits WHERE quantite > 0";
$prodResult = $conn->query($prodSql);

if(isset($_POST['ajouter'])){
    $produit_id = $_POST['produit_id'];
    $quantite_vendue = $_POST['quantite'];

    // Récupérer infos produit
    $stmt = $conn->prepare("SELECT prix_vente, quantite FROM produits WHERE produit_id=?");
    $stmt->bind_param("i", $produit_id);
    $stmt->execute();
    $prod = $stmt->get_result()->fetch_assoc();

    if($quantite_vendue > $prod['quantite']){
        $error = "Quantité insuffisante en stock !";
    } else {
        $montant_total = $quantite_vendue * $prod['prix_vente'];

        // Enregistrer vente
        $sql = "INSERT INTO ventes(produit_id, date_vente, quantite, montant_total) VALUES (?, NOW(), ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iid", $produit_id, $quantite_vendue, $montant_total);
        $stmt->execute();

        // Mettre à jour stock
        $newQty = $prod['quantite'] - $quantite_vendue;
        $statut = ($newQty == 0) ? "rupture" : (($newQty < 5) ? "faible" : "en stock");
        $update = $conn->prepare("UPDATE produits SET quantite=?, statut=? WHERE produit_id=?");
        $update->bind_param("isi", $newQty, $statut, $produit_id);
        $update->execute();

        header("Location: liste.php");
        exit();
    }
}
?>

<?php include("../includes/header.php"); ?>
<?php include("../includes/navbar.php"); ?>

<div class="container mt-4">
    <h3>Enregistrer une vente</h3>
    <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="POST">
        <div class="mb-2">
            <select name="produit_id" class="form-control" required>
                <option value="">Sélectionner un produit</option>
                <?php while($prod = $prodResult->fetch_assoc()): ?>
                    <option value="<?= $prod['produit_id'] ?>">
                        <?= $prod['nom'] ?> (Stock: <?= $prod['quantite'] ?>)
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-2">
            <input type="number" name="quantite" class="form-control" placeholder="Quantité vendue" min="1" required>
        </div>
        <button class="btn btn-success" name="ajouter">Enregistrer</button>
        <a href="listes.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<?php include("../includes/footer.php"); ?>