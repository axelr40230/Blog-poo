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

//récupération de tous les utilisateurs
$users = find('users');



?>

<?php //boucle pour récupérer les posts ?>
<?php while($user = $users->fetch()): ?>
    <?php

// récupération de l'identifiant de l'utilisateur
    $userId = $user['id'];

    ?>


    <?php // gestion de l'affichage de la date en français
    $date = $user['created_at'];
    $date = strtotime("$date");
    $date = strftime('%A %d %B %Y',$date); ?>


    <h2><?= $user['first_name'] ?> <?= $user['last_name'] ?></h2>
    <p>Enregistré le : <?= $date ?></p>

    <?php //gestion de l'affichage du statut en français ?>
    <p>Rôle : <?php
        $status = $user['status'];
        $trad = translate($status);
        echo $trad['fr'][$status];
        ?></p>

    <?php //liens ?>
    <p><a href="edit-user.php?userId=<?= $userId ?>">Modifier l'utilisateur</a></p>
    <p><a href="delete-user.php?userId=<?= $userId ?>">Supprimer l'utilisateur</a></p>

<?php
endwhile;
?>

</body>
</html>

<?php endif;