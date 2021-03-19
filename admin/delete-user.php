<?php
// lancement de la session
session_start();
if (!isset($_SESSION['id'])) :
    header('Location: login.php');
else :

// connexion à la bdd
$db = new \PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', '');

$userId = $_GET['userId'];

// suppression d'un article
$delete = $db->prepare('DELETE FROM users WHERE id = ?');
$delete->execute(array($userId));
$delete = $delete->fetch();
header('location:users-admin.php');
endif;


