<?php
// lancement de la session
session_start();
if (!isset($_SESSION['id'])) :
    header('Location: login.php');
else :
// connexion à la bdd
$db = new \PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', '');

$postId = $_GET['id'];

// suppression d'un article
$delete = $db->prepare('DELETE FROM articles WHERE id = ?');
$delete->execute(array($postId));
$post = $delete->fetch();
header('location:posts-admin.php');
endif;


