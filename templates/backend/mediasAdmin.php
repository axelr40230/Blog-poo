<?php
// lancement de la session
session_start();
if (!isset($_SESSION['id'])) :
    header('Location: index.php?action=login');
else :

$author = $_SESSION['id'];

// déclaration du fuseau
setlocale(LC_TIME, "fr_FR", "French");

// connexion à la base de données
    require_once('models/database.php');
    $db = getPdo();

//récupération de tous les médias
$medias = find('medias');

?>

<p><a href="?action=editMedia&authorId=<?= $author ?>">Ajouter un nouveau média</a></p>

<?php //boucle pour afficher les medias ?>
<?php while($media = $medias->fetch()): ?>
    <?php

// récupération de l'identifiant de post
    $mediaId = $media['id'];

// récupération de l'auteur du media
    $author = authorMedia($mediaId) ?>


    <?php // gestion de l'affichage de la date en français
    $date = $media['created_at'];
    $date = strtotime("$date");
    $date = strftime('%A %d %B %Y',$date); ?>


    <h2><?= $media['name_media'] ?></h2>
    <img src="public/uploads/<?= $media['link'] ?>">
    <p>Ajouté le <?= $date ?></p>

        <?php //gestion de l'affichage des nom et prénom de l'auteur de l'article ?>
    <p>Par <?= $author['first_name'] ?> <?= $author['last_name'] ?></p>
    <p>Type de média : <?= $media['type_media'] ?></p>
    <p><a href="?action=deleteMedia&mediaId=<?= $mediaId ?>">Supprimer le média</a></p>

<?php
endwhile;
?>



</body>
</html>
<?php endif;