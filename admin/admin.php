<?php
// lancement de la session
session_start();
if (!isset($_SESSION['id'])) :
    header('Location: login.php');
else :

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
</head>
<body>

<h1>Administration</h1>

<?php //menu ?>
<p><a href="../index.php">Visiter le site</a></p>
<p><a href="dashboard.php">Mon profil</a></p>
<p><a href="posts-admin.php">Gérer les posts</a></p>
<p><a href="medias-admin.php">Gérer les médias</a></p>
<p><a href="comments-admin.php">Gérer commentaires</a></p>
<p><a href="users-admin.php">Gérer les utilisateurs</a></p>
<p><a href="logout.php">Se déconnecter</a></p>

</body>
</html>
<?php endif; ?>