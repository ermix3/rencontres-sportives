<?php
require_once 'db/db.php';
try {
    $pdo??die('Erreur de connexion');
    if (!empty($_GET)){
        $query= $pdo->prepare('DELETE FROM personne WHERE id = ?')->execute([$_GET['id']]);
        header('Location: index.php');
    }
}catch (PDOException $e){
    echo "Error: ".$e->getMessage();
}

