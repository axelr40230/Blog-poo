<?php
// lancement de la session
session_start();
if (!isset($_SESSION['id'])) :
    header('Location: index.php?action=login');
else :
require_once('src/database.php');
$article_id = $_GET['id'];
// suppression d'un article
deletePost($article_id);
endif;


