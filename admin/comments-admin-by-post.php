<?php // lancement de la session
session_start();
if (!isset($_SESSION['id'])) :
header('Location: login.php');
else :
    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Interface d'administration - commentaires de l'article XX</title>
</head>
<body>

<p><a href="../index.php">Visiter le site</a></p>
<p><a href="dashboard.php">Mon profil</a></p>
<p><a href="posts-admin.php">Gérer les posts</a></p>
<p><a href="medias-admin.php">Gérer les médias</a></p>
<p><a href="comments-admin.php">Gérer commentaires</a></p>
<p><a href="users-admin.php">Gérer les utilisateurs</a></p>
<p><a href="logout.php">Se déconnecter</a></p>

<H1>Interface d'administration - commentaires de l'article XX</H1>

<h2>Auteur du commentaire</h2>
<p>Date de publication</p>
<p>Contenu du commentaire</p>
<p><a href="edit-comment.html">Approuver le commentaire</a></p>
<p><a href="edit-comment.html">Modifier le commentaire</a></p>
<p><a href="delete-comment.html">Supprimer le commentaire</a></p>

</body>
</html>
<?php endif;