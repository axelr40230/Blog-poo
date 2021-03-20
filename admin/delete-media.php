<?php
// lancement de la session
session_start();
if (!isset($_SESSION['id'])) :
    header('Location: login.php');
else :

// connexion à la bdd
$db = new \PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', '');

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
    header('location:medias-admin.php');
    endif;
endif;


