<?php
// lancement de la session
session_start();
if (!isset($_SESSION['id'])) :
    header('Location: index.php?action=login');
else :

// connexion à la base de données
    require_once('src/database.php');
    $db = getPdo();

$mediaId = $_GET['mediaId'];
//var_dump($mediaId);

    $media = selectMedia($mediaId);
    $count     = $media->rowCount();
    //dans le cas où aucun media est trouvé
    if ($count == 0) :
        $message = 'Aucun média ne correspond';
        $media->closeCursor();
    else :
        $result = $media->fetch();
        $filename = $result['name_media'];
        //var_dump($filename);
    $filename = 'public/uploads/'.$filename;
   //var_dump($filename);

    unlink($filename);
       // exit();
    // suppression d'un media
    mediaDelete($mediaId);
    endif;
endif;


