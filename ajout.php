<?php
require_once 'db/db.php';
try {
    $pdo??die('Erreur de connexion');
    // pour recuperer les donnee a partir db
    $sports=$pdo->query('SELECT DISTINCT designation FROM sport')->fetchAll();
    $niveaus=$pdo->query('SELECT DISTINCT niveau FROM pratique')->fetchAll();
    // pour inserer les donnee dans sport
    if (isset($_GET['ajouter'])) {
        $query1 = $pdo->prepare('INSERT INTO `sport` (`designation`) VALUES (?)');
        $query1->execute([$_GET['new_sport']]);
    }
    if (isset($_POST['submit'])) {
        // pour inserer des donnee
        $query2 = $pdo->prepare('INSERT INTO `personne` (`nom`, `prenom`, `depart`, `email`) VALUES (?,?,?,?)');
        $query2->execute([
            htmlentities($_POST['nom']),
            htmlentities($_POST['prenom']),
            htmlentities($_POST['depart']),
            htmlentities($_POST['email'])
        ]);
        $query3 = $pdo->prepare('INSERT INTO `pratique` (`personne_id`, `sport_id`, `niveau`) VALUES (?,?,?)');
        $query3->execute([
            $pdo->lastInsertId(),
            $_POST['sport'],
            $_POST['niveau']
        ]);
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
// functions
function divForm(string $type, string $name, string $contenu, string $placeholder = ''): string
{
    $placeholder = !empty($placeholder) ? $placeholder : "Entrer votre $name ..";
    $value = !empty($_POST[$name]) ? htmlentities($_POST[$name]) : '';
    return <<<HTML
    <div class="form-group mt-3">
        <label for="$name">$contenu</label>
        <input type="$type" name="$name" id="$name" class="form-control" value="$value" placeholder="$placeholder">
    </div>
HTML;
}

function selected($value, $selected)
{
    if ($value == $selected) {
        return 'selected';
    }
    return '';
}

?>

<!--header-->
<?php $title='Ajouter un ...';$root = './';require_once 'inc/header.php' ?>

<!--content-->
<div class="container " style="min-height: 75vh;">
    <div class="row">
        <div class="col-12">
            <h1 class="display-1 my-3">Inscrivez-vous:</h1>
            <form  method="post">
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="my-2">Vos coordonnees</h4>
                            </div>
                            <div class="card-body">
                                <?php
                                foreach (['nom', 'prenom', 'depart'] as $key) {
                                    if ($key !== 'depart')
                                        echo divForm('text', $key, ucfirst($key));
                                    else
                                        echo divForm('text', $key, "Departement");

                                }
                                echo divForm('email', 'email', "Email ");
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="my-2">Vos sports pratiques</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="sport">Sport</label>
                                    <select name="sport" id="sport" class="form-control">
                                        <?php foreach ($sports as $sport): ?>
                                            <option value="<?= $sport->designation ?>" <?= selected($sport->designation, $_POST['sport'] ?? '') ?>><?= $sport->designation ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <?= divForm('text', 'new_sport', 'Ajouter nouveau sport') ?>
                                <a href="ajoutSport.php?new_sport=<?= $id??'';//TODO  ?>" class="btn btn-warning mt-2">Ajouter
                                </a>
                                <div class="form-group mb-3">
                                    <label for="niveau">Niveau :</label>
                                    <select name="niveau" id="niveau" class="form-control">
                                        <?php foreach ($niveaus as $niveau): ?>
                                            <option value="<?= $niveau->niveau ?>" <?= selected($niveau->niveau, $_POST['niveau'] ?? '') ?>><?= $niveau->niveau ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" name="submit" class="btn btn-outline-primary">Envoyer</button>
                        <button type="reset" class="btn btn-outline-warning mx-2">Effacer</button>
                        <button type="button" class="btn btn-outline-danger"
                                onclick="window.location.href='./index.php'">Annuler
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!--footer-->
<?php require_once 'inc/footer.php' ?>