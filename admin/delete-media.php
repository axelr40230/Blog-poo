<?php
// lancement de la session
session_start();
if (!isset($_SESSION['id'])) :
    header('Location: login.php');
else :

// connexion à la bdd
$db = new \PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', '');

$mediaId = $_GET['mediaId'];

// suppression d'un article
$delete = $db->prepare('DELETE FROM medias WHERE id = ?');
$delete->execute(array($mediaId));
$post = $delete->fetch();
header('location:medias-admin.php');
endif;


