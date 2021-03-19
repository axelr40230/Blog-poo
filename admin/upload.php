<?php
// lancement de la session
session_start();
if (!isset($_SESSION['id'])) :
    header('Location: login.php');
else :

$author = $_SESSION['id'];

$dossier = '../uploads/';
$fichier = basename($_FILES['media']['name']);
$taille_maxi = 100000;
$taille = filesize($_FILES['media']['tmp_name']);
$extensions = array('.png', '.gif', '.jpg', '.jpeg', '.pdf');
$extension = strrchr($_FILES['media']['name'], '.');
//Début des vérifications de sécurité...
if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
{
    $erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, ou pdf...';
}
if($taille>$taille_maxi)
{
    $erreur = 'Le fichier est trop gros...';
}
if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
{
    //On formate le nom du fichier ici...
    $fichier = strtr($fichier,
        'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
        'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
    $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
    if(move_uploaded_file($_FILES['media']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
    {

        if ($extension == 'pdf') {
            $type = 'pdf';
        }
        else {
            $type = 'image';
        }
        $db = new \PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', '');
        $add = $db->prepare('INSERT INTO medias(name_media, user_id, type_media, link, created_at) VALUES (:name_media, :user_id, :type_media, :link, NOW())');
        $add->execute(array(
            'name_media' => $fichier,
            'user_id' => $author,
            'type_media' => $type,
            'link' => 'http://localhost/BLOG-POO-AR/projet%20blog%20alexandra%20OC/uploads/'.$fichier
        ));
        echo 'Upload effectué avec succès !';
    }
    else //Sinon (la fonction renvoie FALSE).
    {
        echo 'Echec de l\'upload !';
    }
}
else
{
    echo $erreur;
}
 endif;