<?php
// lancement de la session
session_start();
if (!isset($_SESSION['id'])) :
    header('Location: index.php?action=login');
else :

// connexion à la base de données
    require_once('../../models/database.php');
    $db = getPdo();

$userId = $_GET['userId'];

// suppression d'un article
$delete = $db->prepare('DELETE FROM users WHERE id = ?');
$delete->execute(array($userId));
$delete = $delete->fetch();
header('location:usersAdmin.php');
endif;


