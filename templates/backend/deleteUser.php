<?php
// lancement de la session
session_start();
if (!isset($_SESSION['id'])) :
    header('Location: index.php?action=login');
else :
require_once('src/database.php');
$userId = $_GET['userId'];
// suppression d'un utilisateur
deleteUsers($userId);
endif;


