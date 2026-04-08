<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: ../auth/login.php");
}

require_once("../config/connexion.php");

// Récupérer ventes
$sql = "SELECT ventes.*, produits.nom AS produit_nom 
        FROM ventes 
        LEFT JOIN produits ON ventes.produit_id = produits.produit_id
        ORDER BY ventes.date_vente DESC";
$result = $conn->query($sql);
?>

<?php include("../includes/header.php"); ?>
<?php include("../includes/navbar.php"); ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h3>Liste des ventes</h3>
        <a href="ajoute.php" class="btn btn-success">Nouvelle vente</a>
    </div>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Produit</th>
                <th>Date</th>
                <th>Quantité</th>
                <th>Montant total</th>
            </tr>
        </thead>
        <tbody>
        <?php while($vente = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $vente['vente_id'] ?></td>
                <td><?= $vente['produit_nom'] ?></td>
                <td><?= $vente['date_vente'] ?></td>
                <td><?= $vente['quantite'] ?></td>
                <td><?= number_format($vente['montant_total'], 0, ',', ' ') ?> FCFA</td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include("../includes/footer.php"); ?>