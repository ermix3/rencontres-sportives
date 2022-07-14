<?php
require_once 'db/db.php';
$error=null;
try {
    if(isset($pdo)){
        $personnes=$pdo->query('SELECT * FROM personne')->fetchAll();
    }
}catch(PDOException $e){
    $error=$e->getMessage();
}
?>
<!--header-->
<?php $title='Home';$root='./';require_once 'inc/header.php' ?>

<!--content-->
<div class="container">
    <?php if($error):?>
        <div class="alert alert-danger">
            <?=$error?>
        </div>
    <?php else: ?>
        <h1 class="mt-4">Liste des Sportifs</h1>
        <div class="card ">
            <div class="card-header d-flex justify-content-between ">
                <h2>Liste</h2>
                <a href="#">
                    <a href="ajout.php" role="button" class="btn btn-outline-success btn-lg shadow  ">Ajouter</a>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive-md">
                    <table class="table table-bordered table-hover">
                        <thead class="table-group-divider ">
                        <tr class=" bg-info bg-opacity-25 text-opacity-100">
                            <th scope="col">#</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Prenom</th>
                            <th scope="col">Depart</th>
                            <th scope="col">Email</th>
                            <th scope="col" class="d-flex justify-content-center">action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($personnes as $personne):?>
                            <tr>
                                <th scope="row"><?=$personne->id?></th>
                                <td><?=$personne->nom?></td>
                                <td><?=$personne->prenom?></td>
                                <td><?=$personne->depart?></td>
                                <td><?=$personne->email?></td>
                                <td class="d-flex justify-content-center">
                                    <a href="modifier.php?id=<?=$personne->id?>" class="btn btn-outline-warning shadow me-3">Modifier</a>
                                    <a href="supprimer.php?id=<?=$personne->id?>" class="btn btn-outline-danger shadow" onclick="return confirm('Delete this?');">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <nav aria-label="Page navigation example">
                    <ul class="pagination  bg-gradient justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link">Previous</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    <?php endif ?>
</div>

<!--footer-->
<?php require_once 'inc/footer.php' ?>