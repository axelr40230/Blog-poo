<?php
// lancement de la session
session_start();
if (!isset($_SESSION['id'])) :
    header('Location: index.php?action=login');
else :

// déclaration du fuseau
setlocale(LC_TIME, "fr_FR", "French");

// connexion à la base de données
require_once('models/database.php');
$db = getPdo();

//récupération de tous les articles
$posts = find('articles');
?>

<p><a href="editArticle.php?id=null&action=add">Ajouter un nouvel article</a></p>

<p style="color:red;">Trier les articles</p>
<p style="color:red;">Rechercher dans les articles</p>
<p style="color:red;">Voir la corbeille</p>

<?php //boucle d'affichage des posts ?>
<?php while($post = $posts->fetch()): ?>
<?php

// récupération de l'identifiant de post
$postId = $post['id'];

// récupération de l'auteur de l'article
$author = $db->prepare('SELECT users.first_name, users.last_name FROM users LEFT OUTER JOIN articles ON users.id = articles.author WHERE articles.id = ?');
$author->execute(array($postId));
$result = $author->fetch(PDO::FETCH_ASSOC); ?>


<?php // gestion de l'affichage de la date en français
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
    <p><?= $result['first_name'] ?> <?= $result['last_name'] ?></p>

    <?php //liens ?>
    <p>Nombres de commentaires // <a href="comments-admin-by-post.php?id=<?= $postId ?>">Consulter les commentaires</a></p>
    <p><a href="?action=post&id=<?= $postId ?>">Lire l'article</a></p>
    <p><a href="?action=editArticle&id=<?= $postId ?>">Gérer l'article</a></p>
    <p><a href="delete-article.php?id=<?= $postId ?>">Supprimer l'article</a></p>
<?php
endwhile;
?>

</body>
</html>
<?php endif;