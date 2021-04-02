<?php
// lancement de la session
session_start();
if (!isset($_SESSION['id'])) :
    header('Location: index.php?action=login');
else :

$author = $_SESSION['id'];

$dossier = 'public/uploads/';
$fichier = basename($_FILES['media']['name']);
$type = $_FILES['media']['type'];
//    var_dump($type);
//    exit();
$taille_maxi = 1024*10*10*10;
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

        if ($type == 'pdf') {
            $type = 'pdf';
        } else {
            $type = 'image';
        }
        // connexion à la base de données
        require_once('src/database.php');

        addMedia($fichier, $author, $type);

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