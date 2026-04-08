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

// Récupérer catégories
$sql = "SELECT * FROM categories WHERE nom LIKE ? OR description LIKE ?";
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
        <h3>Liste des catégories</h3>
        <a href="ajoute.php" class="btn btn-success">Ajouter une catégorie</a>
    </div>

    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control" placeholder="Rechercher une catégorie">
            <button class="btn btn-primary">Rechercher</button>
        </div>
    </form>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while($cat = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $cat['categorie_id'] ?></td>
                <td><?= $cat['nom'] ?></td>
                <td><?= $cat['description'] ?></td>
                <td>
                    <a href="modifie.php?id=<?= $cat['categorie_id'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                    <a href="supprimer.php?id=<?= $cat['categorie_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer ?')">Supprimer</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include("../includes/footer.php"); ?>