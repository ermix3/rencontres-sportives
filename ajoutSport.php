<?php
require_once 'db/db.php';
try {
    $pdo??die('Erreur de connexion');
    print_r($_GET);
    if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET['new_sport'])) {
        $query = $pdo->prepare('INSERT INTO `sport` (`designation`) VALUES (?)');
        $query->execute([htmlentities($_GET['new_sport'])]);
    }
//    header('Location: ajout.php');
}catch (PDOException $e){
    echo "Error: ".$e->getMessage();
}

