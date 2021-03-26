<?php
// lancement de la session
session_start();
if (!isset($_SESSION['id'])) :
    header('Location: index.php?action=login');
else :
// connexion à la base de données
    require_once('../../models/database.php');
    $db = getPdo();

$postId = $_GET['id'];

// suppression d'un article
$delete = $db->prepare('DELETE FROM articles WHERE id = ?');
$delete->execute(array($postId));
$post = $delete->fetch();
header('location:postsAdmin.php');
endif;


