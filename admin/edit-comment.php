<?php
// lancement de la session
session_start();
if (!isset($_SESSION['id'])) :
    header('Location: login.php');
else :
    // connexion à la base de données
    require_once('../models/database.php');
    $db = getPdo();

    // mise à jour statut >> approuvé
    if(isset($_GET['commentId']) and isset($_GET['action'])) :
        if($_GET['action'] == 'approuved') :
        $status = 'approuved';
        $commentId = $_GET['commentId'];
        $publish = $db->prepare('UPDATE comments SET status = :status WHERE id = :id');
        $publish->execute(array(
            'status'=> $status,
            'id'=> $commentId
        ));

        header('location:comments-admin.php');

        elseif ($_GET['action'] == 'delete') :
            $status = 'intrash';
            $commentId = $_GET['commentId'];
            $publish = $db->prepare('UPDATE comments SET status = :status WHERE id = :id');
            $publish->execute(array(
                'status'=> $status,
                'id'=> $commentId
            ));

            header('location:comments-admin.php');
        endif;
    endif;
endif;