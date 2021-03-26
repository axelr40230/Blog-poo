<?php

//vérifie si l'utilisateur est connecté
if (isset($_SESSION['id'])) {
    header('location:templates/backend/login.php');
    //si oui, envoie directement à la page des partenaires


} else {
    //si non, reste sur la page de connexion
    header('location:templates/backend/login.php');
}