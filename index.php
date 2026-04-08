<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: auth/login.php");
}
?>

<?php include("includes/header.php"); ?>
<?php include("includes/navbar.php"); ?>

<div class="container mt-4">
    <div class="alert alert-success">
        Bienvenue <?php echo $_SESSION['user']['nom']; ?> 👋
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card p-3 shadow">
                <h5>Produits</h5>
                <a href="produits/listes.php" class="btn btn-primary">Voir</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 shadow">
                <h5>Catégories</h5>
                <a href="categorie/listes.php" class="btn btn-warning">Voir</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 shadow">
                <h5>Ventes</h5>
                <a href="ventes/listes.php" class="btn btn-success">Voir</a>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>