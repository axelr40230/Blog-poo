<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Interface d'administration - Ajouter un média</title>
</head>
<body>

<p><a href="../index.php">Visiter le site</a></p>
<p><a href="posts-admin.php">Gérer les posts</a></p>
<p><a href="medias-admin.php">Gérer les médias</a></p>
<p><a href="comments-admin.php">Gérer commentaires</a></p>
<p><a href="users-admin.php">Gérer les utilisateurs</a></p>
<p><a href="disconnect.php">Se déconnecter</a></p>

<H1>Interface d'administration - Ajouter un média</H1>

<h2>Envoyer une image depuis votre ordinateur</h2>

<form method="POST" action="upload.php" enctype="multipart/form-data">
    <!-- On limite le fichier à 100Ko -->
    <input type="hidden" name="MAX_FILE_SIZE" value="100000">
    Fichier : <input type="file" name="media">
    <input type="submit" name="envoyer" value="Envoyer le fichier">
</form>





</body>
</html>