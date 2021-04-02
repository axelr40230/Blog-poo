<p><a href="index.php?action=homePage">Retour à l'accueil</a></p>

<?php
// boucle d'affichage des articles
foreach ($posts as $post): ?>
    <?php $status = $post['status'];
    if ($status == 'publish') : ?>
        <h2><?= $post['title'] ?></h2>
        <p><?= $post['introduction'] ?></p>
        <p><a href="index.php?action=post&id=<?= $post['id'] ?>">Lire l'article</a></p>
    <?php endif; ?>
<?php endforeach; ?>