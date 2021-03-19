<?php
// lancement de la session
session_start();
if (!isset($_SESSION['id'])) :
    header('Location: login.php');
else :

$author = $_SESSION['id'];

// déclaration du fuseau
setlocale(LC_TIME, "fr_FR", "French");

// connexion à la bdd
$db = new \PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', '');

//récupération de tous les médias
$medias = $db->query('SELECT * FROM medias ORDER BY created_at DESC');

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Interface d'administration - tous les médias</title>
</head>
<body>

<p><a href="../index.php">Visiter le site</a></p>
<p><a href="dashboard.php">Mon profil</a></p>
<p><a href="posts-admin.php">Gérer les posts</a></p>
<p><a href="medias-admin.php">Gérer les médias</a></p>
<p><a href="comments-admin.php">Gérer commentaires</a></p>
<p><a href="users-admin.php">Gérer les utilisateurs</a></p>
<p><a href="logout.php">Se déconnecter</a></p>

<H1>Interface d'administration - tous les médias</H1>

<p><a href="edit-media.php?authorId=<?= $author ?>&action=add">Ajouter un nouveau média</a></p>

<?php //boucle pour récupérer les medias ?>
<?php while($media = $medias->fetch()): ?>
    <?php

// récupération de l'identifiant de post
    $mediaId = $media['id'];

// récupération de l'auteur du media
    $author = $db->prepare('SELECT users.first_name, users.last_name FROM users LEFT OUTER JOIN medias ON users.id = medias.user_id WHERE medias.id = ?');
    $author->execute(array($mediaId));
    $result = $author->fetch(PDO::FETCH_ASSOC); ?>


    <?php // gestion de l'affichage de la date en français
    $date = $media['created_at'];
    $date = strtotime("$date");
    $date = strftime('%A %d %B %Y',$date); ?>


    <h2><?= $media['name_media'] ?></h2>
    <img src="<?= $media['link'] ?>">
    <p>Ajouté le <?= $date ?></p>

        <?php //gestion de l'affichage des nom et prénom de l'auteur de l'article ?>
    <p>Par <?= $result['first_name'] ?> <?= $result['last_name'] ?></p>
    <p>Type de média : <?= $media['type_media'] ?></p>
    <p><a href="delete-media.php?mediaId=<?= $mediaId ?>">Supprimer le média</a></p>

<?php
endwhile;
?>



</body>
</html>
<?php endif;