<?php
require_once 'db/db.php';
try {
    $pdo??die('Erreur de connexion');

    // pour recuperer les donnee a partir db
    if(!empty($_GET))
        $personne=$pdo->query('SELECT * FROM personne WHERE id='.$_GET['id'])->fetch();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
if(!empty($_POST)) {
    $personne = $pdo->prepare('UPDATE personne SET nom=?, prenom=?, depart=?, email=? WHERE id=?')->execute([
        htmlentities($_POST['nom']),
        htmlentities($_POST['prenom']),
        htmlentities($_POST['depart']),
        htmlentities($_POST['email']),
        $personne->id
    ]);
    header('Location: index.php');
}
?>
<!-- header -->
<?php $title='Modifier un ...';require_once 'inc/header.php'; ?>

<!-- content -->
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto my-5">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Modifier un Sportif</h3>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <label for="id">ID</label>
                            <input type="text" name="id" id="id" class="form-control" value="<?= $personne->id ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="nom">Nom</label>
                            <input type="text" name="nom" id="nom" class="form-control" value="<?= $personne->nom ?>" placeholder="Entrer votre nom ..">
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prenom</label>
                            <input type="text" name="prenom" id="prenom" class="form-control" value="<?= $personne->prenom ?>" placeholder="Entrer votre prenom ..">
                        </div>
                        <div class="form-group">
                            <label for="depart">Departement</label>
                            <input type="text" name="depart" id="depart" class="form-control" value="<?= $personne->depart ?>" placeholder="Entrer votre departement ..">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="<?=$personne->email ?>" placeholder="Entrer votre email ..">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Modifier</button>
                            <a href="index.php" class="btn btn-warning">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- footer -->
<?php require_once 'inc/footer.php'; ?>
