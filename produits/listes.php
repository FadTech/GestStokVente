<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: ../auth/login.php");
}

require_once("../config/connexion.php");

// Recherche
$search = "";
if(isset($_GET['search'])){
    $search = $_GET['search'];
}

// Récupérer produits
$sql = "SELECT produits.*, categories.nom AS categorie_nom 
        FROM produits 
        LEFT JOIN categories ON produits.categorie_id = categories.categorie_id
        WHERE produits.nom LIKE ? OR categories.nom LIKE ?";
$stmt = $conn->prepare($sql);
$likeSearch = "%".$search."%";
$stmt->bind_param("ss", $likeSearch, $likeSearch);
$stmt->execute();
$result = $stmt->get_result();
?>

<?php include("../includes/header.php"); ?>
<?php include("../includes/navbar.php"); ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h3>Liste des produits</h3>
        <a href="ajoute.php" class="btn btn-success">Ajouter un produit</a>
    </div>

    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control" placeholder="Rechercher un produit ou catégorie">
            <button class="btn btn-primary">Rechercher</button>
        </div>
    </form>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>Prix Achat</th>
                <th>Prix Vente</th>
                <th>Quantité</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while($prod = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $prod['produit_id'] ?></td>
                <td><?= $prod['nom'] ?></td>
                <td><?= $prod['categorie_nom'] ?></td>
                <td><?= $prod['prix_achat'] ?> FCFA</td>
                <td><?= $prod['prix_vente'] ?> FCFA</td>
                <td><?= $prod['quantite'] ?></td>
                <td>
                    <?php
                        if($prod['quantite'] == 0) echo "<span class='badge bg-danger'>Rupture</span>";
                        elseif($prod['quantite'] < 5) echo "<span class='badge bg-warning'>Faible</span>";
                        else echo "<span class='badge bg-success'>En stock</span>";
                    ?>
                </td>
                <td>
                    <a href="modifie.php?id=<?= $prod['produit_id'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                    <a href="supprimer.php?id=<?= $prod['produit_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer ?')">Supprimer</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include("../includes/footer.php"); ?>