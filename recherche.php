<?php
require_once 'db/db.php';
if(isset($pdo)){
    try {
        $sports=$pdo->query('SELECT DISTINCT designation FROM sport')->fetchAll();
        $niveaus=$pdo->query('SELECT DISTINCT niveau FROM pratique ')->fetchAll();
        $departs=$pdo->query('SELECT DISTINCT depart FROM personne')->fetchAll();
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
try{
    if(isset($_GET['submit'])){
        $query=$pdo->prepare('SELECT * 
                                    FROM `personne` 
                                    WHERE id IN (SELECT personne_id
                                                  FROM `pratique`
                                                  WHERE sport_id IN (SELECT id FROM sport WHERE designation = :sport ) AND niveau = :niveau
                                    ) AND depart = :depart');
        $query->execute([
            'sport'=>htmlentities($_GET['sport']),
            'niveau'=>htmlentities($_GET['niveau']),
            'depart'=>htmlentities($_GET['depart'])
        ]);
        $result=$query->fetchAll();
    }
}catch (PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}
function selected($value,$selected){
    if($value==$selected){
        return 'selected';
    }
}
?>
<!--header-->
<?php $title='Rechercher un ...';require_once 'inc/header.php' ?>

<!--content-->
<div class="container" style="min-height: 76vh;" >
    <div class="row">
        <div class="col-12 mx-auto">
            <h1 class="display-4 my-5 text-center">Rechercher des partenaires</h1>
            <div class="row">
                <div class="col-6">
                    <form action="<?= $_SERVER['PHP_SELF']?>" method="get">
                        <div class="card bg-primary bg-opacity-10 border-0 shadow">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="sport">Sport</label>
                                    <select name="sport" id="sport" class="form-control">
                                        <?php foreach($sports as $sport): ?>
                                            <option value="<?= $sport->designation ?>" <?= selected($sport->designation,$_GET['sport']??'') ?>><?= $sport->designation ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="niveau">Niveau :</label>
                                    <select name="niveau" id="niveau" class="form-control">
                                        <?php foreach($niveaus as $niveau): ?>
                                            <option value="<?= $niveau->niveau ?>" <?= selected($niveau->niveau,$_GET['niveau']??'') ?>><?= $niveau->niveau ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="depart">Departements :</label>
                                    <select name="depart" id="depart" class="form-control">
                                        <?php foreach($departs as $depart): ?>
                                            <option value="<?= $depart->depart ?>" <?= selected($depart->depart,$_GET['depart']??'') ?>><?= $depart->depart ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <button type="submit" name="submit" class="btn btn-primary">Rechercher</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-6">
                    <?php if(isset($result)): ?>
                        <div class="card mt-3 bg-primary bg-opacity-50 border-0">
                            <div class="card-header">
                                <h3 class="card-title">Résultats</h3>
                            </div>
                            <?php if(empty($result)):?>
                                <div class="card-body">
                                    <p class="card-text ">Aucun résultat</p>
                                </div>
                            <?php else: ?>
                                <div class="card-body text-white">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nom</th>
                                            <th>Prenom</th>
                                            <th>Departement</th>
                                            <th>Email</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($result as $personne): ?>
                                            <tr>
                                                <td><?= $personne->id ?></td>
                                                <td><?= $personne->nom ?></td>
                                                <td><?= $personne->prenom ?></td>
                                                <td><?= $personne->depart ?></td>
                                                <td><?= $personne->email ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif ?>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!--footer-->
<?php require_once 'inc/footer.php' ?>