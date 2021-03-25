<?php
// lancement de la session
session_start();
if (!isset($_SESSION['id'])) :
    header('Location: login.php');
else :

// déclaration du fuseau
setlocale(LC_TIME, "fr_FR", "French");

// connexion à la base de données
    require_once('../models/database.php');
    $db = getPdo();

//récupération de tous les utilisateurs
$users = find('users');

// Gestion des traductions
require_once ('../models/functions.php');


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Interface d'administration - tous les utilisateurs</title>
</head>
<body>

<p><a href="../index.php">Visiter le site</a></p>
<p><a href="dashboard.php">Mon profil</a></p>
<p><a href="posts-admin.php">Gérer les posts</a></p>
<p><a href="medias-admin.php">Gérer les médias</a></p>
<p><a href="comments-admin.php">Gérer commentaires</a></p>
<p><a href="users-admin.php">Gérer les utilisateurs</a></p>
<p><a href="logout.php">Se déconnecter</a></p>

<H1>Interface d'administration - tous les utilisateurs</H1>

<?php //boucle pour récupérer les posts ?>
<?php while($user = $users->fetch()): ?>
    <?php

// récupération de l'identifiant de l'utilisateur
    $userId = $user['id'];

    ?>


    <?php // gestion de l'affichage de la date en français
    $date = $user['created_at'];
    $date = strtotime("$date");
    $date = strftime('%A %d %B %Y',$date); ?>


    <h2><?= $user['first_name'] ?> <?= $user['last_name'] ?></h2>
    <p>Enregistré le : <?= $date ?></p>

    <?php //gestion de l'affichage du statut en français ?>
    <p>Rôle : <?php
        $status = $user['status'];
        $trad = translate($status);
        echo $trad['fr'][$status];
        ?></p>

    <?php //liens ?>
    <p><a href="edit-user.php?userId=<?= $userId ?>">Modifier l'utilisateur</a></p>
    <p><a href="delete-user.php?userId=<?= $userId ?>">Supprimer l'utilisateur</a></p>

<?php
endwhile;
?>

</body>
</html>

<?php endif;