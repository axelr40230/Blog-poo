<?php
// Lancement session
session_start();

// déclaration du fuseau
setlocale(LC_TIME, "fr_FR", "French");

// connexion à la bdd
$db = new \PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', '');

//récupération de tous les articles
$posts = $db->query('SELECT * FROM articles ORDER BY created_at DESC');

// Gestion des traductions
$trad = array(
    'fr' => array(
        'draft' => 'Brouillon',
        'publish' => 'Publié',
        'intrash' => 'A la corbeille'),

    'en' => array(
        'draft' => 'draft',
        'publish' => 'publish',
        'intrash' => 'in trash'));


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Interface d'administration - tous les articles</title>
</head>
<body>


<?php //menu ?>
<p><a href="../index.php">Visiter le site</a></p>
<p><a href="posts-admin.php">Gérer les posts</a></p>
<p><a href="medias-admin.php">Gérer les médias</a></p>
<p><a href="comments-admin.php">Gérer commentaires</a></p>
<p><a href="users-admin.php">Gérer les utilisateurs</a></p>
<p><a href="disconnect.php">Se déconnecter</a></p>

<?php //contenu ?>
<H1>Interface d'administration - tous les articles</H1>

<p><a href="edit-article.php?id=null&action=add">Ajouter un nouvel article</a></p>

<p style="color:red;">Trier les articles</p>
<p style="color:red;">Rechercher dans les articles</p>
<p style="color:red;">Voir la corbeille</p>

<?php //boucle pour récupérer les posts ?>
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
        echo $trad['fr'][$status];
        ?></p>

    <?php //gestion de l'affichage des nom et prénom de l'auteur de l'article ?>
    <p><?= $result['first_name'] ?> <?= $result['last_name'] ?></p>

    <?php //liens ?>
    <p>Nombres de commentaires // <a href="comments-admin-by-post.php?id=<?= $postId ?>">Consulter les commentaires</a></p>
    <p><a href="../post.php?id=<?= $postId ?>">Lire l'article</a></p>
    <p><a href="edit-article.php?id=<?= $postId ?>&action=edit">Gérer l'article</a></p>
    <p><a href="delete-article.php?id=<?= $postId ?>">Supprimer l'article</a></p>
<?php
endwhile;
?>

</body>
</html>