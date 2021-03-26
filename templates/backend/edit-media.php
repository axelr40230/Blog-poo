<?php

// lancement de la session
session_start();
if (!isset($_SESSION['id'])) :
header('Location: index.php?action=login');
else :
    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Interface d'administration - Ajouter un média</title>
</head>
<body>

<p><a href="../../index.php">Visiter le site</a></p>
<p><a href="dashboard.php">Mon profil</a></p>
<p><a href="postsAdmin.php">Gérer les posts</a></p>
<p><a href="mediasAdmin.php">Gérer les médias</a></p>
<p><a href="commentsAdmin.php">Gérer commentaires</a></p>
<p><a href="usersAdmin.php">Gérer les utilisateurs</a></p>
<p><a href="logout.php">Se déconnecter</a></p>

<H1>Interface d'administration - Ajouter un média</H1>

<h2>Envoyer une image depuis votre ordinateur</h2>

<form method="POST" action="upload.php" enctype="multipart/form-data">

    Fichier : <input type="file" name="media">
    <input type="submit" name="envoyer" value="Envoyer le fichier">
</form>





</body>
</html>
<?php endif;