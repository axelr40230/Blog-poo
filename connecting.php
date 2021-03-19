<?php

//vérifie si l'utilisateur est connecté
if (isset($_SESSION['id'])) {
    header('location:admin/login.php');
    //si oui, envoie directement à la page des partenaires


} else {
    //si non, reste sur la page de connexion
    header('location:admin/login.php');
}