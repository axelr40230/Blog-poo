<?php
// lancement de la session
session_start();
if (!isset($_SESSION['id'])) :
    header('Location: index.php?action=login');
else :

// déclaration du fuseau
setlocale(LC_TIME, "fr_FR", "French");

// connexion à la base de données
require_once('src/database.php');
require_once('src/Post.php');
require_once('src/Comment.php');

$postModel = new Post();
$commentModel = new Comment();


//récupération de tous les articles
$posts = find('articles');
?>

<p><a href="?action=editArticle&id=null&do=add">Ajouter un nouvel article</a></p>

<p style="color:red;">Trier les articles</p>
<p style="color:red;">Rechercher dans les articles</p>
<p style="color:red;">Voir la corbeille</p>

<?php //boucle d'affichage des posts ?>
<?php while($post = $posts->fetch()): ?>
<?php

// récupération de l'identifiant de post
$article_id = $post['id'];

// récupération de l'auteur de l'article
$author = $postModel->author($article_id);


 // gestion de l'affichage de la date en français
    $date = $post['created_at'];
    $date = strtotime("$date");
    $date = strftime('%A %d %B %Y',$date); ?>


    <h2><?= $post['title'] ?></h2>
    <p><?= $date ?></p>

    <?php //gestion de l'affichage du statut en français ?>
    <p><?php
        $status = $post['status'];
        $trad = translate($status);
        echo $trad['fr'][$status];
        ?></p>

    <?php //gestion de l'affichage des nom et prénom de l'auteur de l'article ?>
    <p><?= $author['first_name'] ?> <?= $author['last_name'] ?></p>

    <?php //liens ?>
    <?php
    $comments = $commentModel->list($article_id);
    $count     = $comments->rowCount();
    ?>
    <p>Nombre de commentaires : <?= $count ?> // <a href="?action=commentByArticle&id=<?= $article_id ?>">Consulter les commentaires</a></p>
    <p><a href="?action=post&id=<?= $article_id ?>">Lire l'article</a></p>
    <p><a href="?action=editArticle&id=<?= $article_id ?>&do=editArticle">Gérer l'article</a></p>
    <p><a href="?action=deleteArticle&id=<?= $article_id ?>">Supprimer définitivement l'article</a></p>
<?php
endwhile;
?>

</body>
</html>
<?php endif;