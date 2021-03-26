<?php
session_start();

// connexion à la base de données
require_once('models/database.php');
$db = getPdo();

// récupération des articles
$posts = find('articles');

?>

<p><a href="index.php?action=homePage">Retour à l'accueil</a></p>

<?php
// boucle d'affichage des articles
while($post = $posts->fetch()): ?>
    <?php $status = $post['status'];
    if ($status == 'publish') : ?>
        <h2><?= $post['title'] ?></h2>
        <p><?= $post['introduction'] ?></p>
        <p><a href="index.php?action=post&id=<?= $post['id'] ?>">Lire l'article</a></p>
    <?php endif; ?>
<?php endwhile; ?>