<?php
// connexion à la bdd
$db = new \PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', '');

$postId = $_GET['id'];

// suppression d'un article
$delete = $db->prepare('DELETE FROM articles WHERE id = ?');
$delete->execute(array($postId));
$post = $delete->fetch();
header('location:posts-admin.php');


