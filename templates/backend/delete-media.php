<?php
// lancement de la session
session_start();
if (!isset($_SESSION['id'])) :
    header('Location: index.php?action=login');
else :

// connexion à la base de données
    require_once('../../models/database.php');
    $db = getPdo();

$mediaId = $_GET['mediaId'];

$req_count = $db->prepare('SELECT * FROM medias WHERE id = :media_id');
    $req_count->execute(array(
        'media_id' => $mediaId
    ));
    $count     = $req_count->rowCount();
    //dans le cas où aucun media est trouvé
    if ($count == 0) :
        $message = 'Aucun média ne correspond';
        $req_count->closeCursor();
    else :
        $result = $req_count->fetch();
        $filename = $result['name_media'];
        //var_dump($filename);
    $filename = '../uploads/'.$filename;
   // var_dump($filename);

    unlink($filename);
        //exit();
    // suppression d'un media
    $delete = $db->prepare('DELETE FROM medias WHERE id = ?');
    $delete->execute(array($mediaId));
    $post = $delete->fetch();
    header('location:mediasAdmin.php');
    endif;
endif;


