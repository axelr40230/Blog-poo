<?php
// lancement de la session
session_start();
if (!isset($_SESSION['id'])) :
    header('Location: index.php?action=login');
else :
$userId = $_SESSION['id'];

// déclaration du fuseau
setlocale(LC_TIME, "fr_FR", "French");

// connexion à la base de données
    require_once('models/database.php');
    $db = getPdo();

//récupération de l'utilisateur
$user = selectUser($userId);

?>


<?php //récupération des données sur l'utilisateur?>


    <?php // gestion de l'affichage de la date en français
    $date = $user['created_at'];
    $date = strtotime("$date");
    $date = strftime('%A %d %B %Y',$date); ?>


    <h2><?= $user['first_name'] ?> <?= $user['last_name'] ?></h2>
    <p>Enregistré le : <?= $date ?></p>
    <p><a href="">Editer mon profil</a></p>


    <?php //gestion de l'affichage du statut en français ?>
    <p>Rôle : <?php
        $status = $user['status'];
        $trad = translate($status);
        echo $trad['fr'][$status];
        ?></p>

    <h2>Articles publiés</h2>
        <?php // requete SQL pour récupérer la liste des articles publiés par l'utilisateur
        $listingPosts = articlesByUser($userId);
        $count     = $listingPosts->rowCount();

        if($count == 0) : ?>
            <h2>Aucun article rédigé</h2>
        <?php elseif ($count == 1) : ?>
            <h2><?= $count ?> article rédigé</h2>
        <?php else : ?>
            <h2><?= $count ?> articles rédigés</h2>
        <?php endif;
        while($post = $listingPosts->fetch()): ?>
            <p><a href="../../index.php?action=listPosts&id=<?= $post['id'] ?>"><?= $post['title'] ?></a> -
                <?php
                $status = $post['status'];
                $trad = translate($status);
                echo $trad['fr'][$status];
                ?>
            </p>
        <?php
            endwhile;
            ?>

    <h2>Commentaires publiés</h2>
    <?php // requete SQL pour récupérer la liste des commentaires publiés par l'utilisateur
    $listingComments = commentsByUser($userId);
    $count     = $listingComments->rowCount();

        if($count == 0) : ?>
    <h2>Aucun commentaire</h2>
    <?php elseif ($count == 1) : ?>
    <h2><?= $count ?> commentaire</h2>
    <?php else : ?>
    <h2><?= $count ?> commentaires</h2>
    <?php endif;

    while($comment = $listingComments->fetch()): ?>
        <p><?= $comment['comment'] ?></a></p>
    <hr>
    <?php
      endwhile;
        ?>

    <?php //liens ?>
    <p><a href="edit-user.php?userId=<?= $userId ?>">Modifier l'utilisateur</a></p>
    <p><a href="delete-user.php?userId=<?= $userId ?>">Supprimer l'utilisateur</a></p>



</body>
</html>
<?php endif;