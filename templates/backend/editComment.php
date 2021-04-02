<?php
// lancement de la session
session_start();
if (!isset($_SESSION['id'])) :
    header('Location: index.php?action=login');
else :
    // connexion à la base de données
    require_once('src/database.php');
    $db = getPdo();

    // mise à jour statut >> approuvé
    if(isset($_GET['commentId']) and isset($_GET['do'])) :
        if($_GET['do'] == 'approuved') :
        $status = 'approuved';
        $commentId = $_GET['commentId'];
        updateComment($status, $commentId);

        elseif ($_GET['do'] == 'delete') :
            $status = 'intrash';
            $commentId = $_GET['commentId'];
            deleteComment($status, $commentId);
        endif;
    endif;
endif;