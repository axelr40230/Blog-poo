<?php
session_start();
$db = new \PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', '');
$posts = $db->query('SELECT * FROM articles ORDER BY created_at DESC');

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des posts</title>
</head>
<body>
<p><a href="index.php">Retour à l'accueil</a></p>
<?php
while($post = $posts->fetch()): ?>
    <?php $status = $post['status'];
    if ($status == 'publish') : ?>
        <h2><?= $post['title'] ?></h2>
        <p><?= $post['introduction'] ?></p>
        <p><a href="post.php?id=<?= $post['id'] ?>">Lire l'article</a></p>
    <?php endif; ?>
<?php endwhile; ?>

</body>
</html>