<?php
// Lancement session
session_start();

// déclaration du fuseau
setlocale(LC_TIME, "fr_FR", "French");

// connexion à la bdd
$db = new \PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', '');

$message = '';

//récupération de tous les commentaires
$comments = $db->query('SELECT * FROM comments ORDER BY created_at DESC');

// Gestion des traductions
$trad = array(
    'fr' => array(
        'approuved' => 'Approuvé',
        'intrash' => 'A la corbeille',
        'waiting' => 'En attente de validation'),

    'en' => array(
        'approuved' => 'Approuved',
        'intrash' => 'In trash',
        'waiting' => 'Waiting for validation'));



?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Interface d'administration - tous les commentaires</title>
</head>
<body>

<p><a href="../index.php">Visiter le site</a></p>
<p><a href="posts-admin.php">Gérer les posts</a></p>
<p><a href="medias-admin.php">Gérer les médias</a></p>
<p><a href="comments-admin.php">Gérer commentaires</a></p>
<p><a href="users-admin.php">Gérer les utilisateurs</a></p>
<p><a href="disconnect.php">Se déconnecter</a></p>

<H1>Interface d'administration - tous les commentaires</H1>
<?= $message ?>

<?php //boucle pour récupérer les commentaires ?>
<?php while($comment = $comments->fetch()): ?>
    <?php

if($comment['status'] == 'approuved' OR $comment['status'] == 'waiting') :
    //var_dump($comment['status']);

// récupération de l'identifiant de commentaire
    $commentId = $comment['id'];

// récupération de l'auteur de l'article
    $author = $db->prepare('SELECT users.first_name, users.last_name FROM users LEFT OUTER JOIN comments ON users.id = comments.author WHERE comments.id = ?');
    $author->execute(array($commentId));
    $result = $author->fetch(PDO::FETCH_ASSOC); ?>


    <?php // gestion de l'affichage de la date en français
    $date = $comment['created_at'];
    $date = strtotime("$date");
    $date = strftime('%A %d %B %Y',$date); ?>

    <div>
    <p>Posté le <?= $date ?></p>
    <?php //gestion de l'affichage des nom et prénom de l'auteur de l'article ?>
    <p>Par <?= $result['first_name'] ?> <?= $result['last_name'] ?></p>
    <a href="../post.php?id=<?= $comment['article_id']?>">Voir l'article lié</a>
    </div>

    <div style="font-weight: bold;"><?= $comment['content'] ?></div>


    <?php //gestion de l'affichage du statut en français ?>
    <p><?php
        $status = $comment['status'];
        echo $trad['fr'][$status];
        ?></p>


    <?php //liens ?>

        <?php if($comment['status']!='approuved') :?>
    <p><a href="edit-comment.php?commentId=<?= $commentId ?>&action=approuved">Approuver le commentaire</a></p>
    <?php endif; ?>
    <p><a href="edit-comment.php?commentId=<?= $commentId ?>&action=delete">Supprimer le commentaire</a></p>
<hr>

<?php
endif;
endwhile;
?>

</body>
</html>