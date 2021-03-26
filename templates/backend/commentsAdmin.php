<?php
// lancement de la session
session_start();

// connexion à la base de données
require_once('models/database.php');
$db = getPdo();

if (!isset($_SESSION['id'])) :
    header('Location: index.php?action=login');
else :

// déclaration du fuseau
setlocale(LC_TIME, "fr_FR", "French");

$message = '';

//récupération de tous les commentaires
$comments = find('comments');

?>

<?= $message ?>

<?php //boucle pour récupérer les commentaires ?>
<?php while($comment = $comments->fetch()): ?>
    <?php

if($comment['status'] == 'approuved' OR $comment['status'] == 'waiting') :
    //var_dump($comment['status']);

// récupération de l'identifiant de commentaire
    $commentId = $comment['id'];
    $id_author = $comment['author'];
    //var_dump($id_author);

// récupération de l'auteur du commentaire
    $result = authorComment($id_author);
?>


    <?php // gestion de l'affichage de la date en français
    $date = $comment['created_at'];
    $date = strtotime("$date");
    $date = strftime('%A %d %B %Y',$date); ?>

    <div>
    <p>Posté le <?= $date ?></p>
    <?php //gestion de l'affichage des nom et prénom de l'auteur de l'article ?>
    <p>Par <?= $result['first_name'] ?> <?= $result['last_name'] ?></p>
    <a href="../../index.php?action=post&id=<?= $comment['article_id']?>">Voir l'article lié</a>
    </div>

    <div style="font-weight: bold;"><?= $comment['comment'] ?></div>


    <?php //gestion de l'affichage du statut en français ?>
    <p><?php
        $status = $comment['status'];
        $trad = translate($status);
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
endif;