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
    <title>Interface d'administration - Editer un utilisateur</title>
</head>
<body>

<p><a href="../../index.php">Visiter le site</a></p>
<p><a href="dashboard.php">Mon profil</a></p>
<p><a href="postsAdmin.php">Gérer les posts</a></p>
<p><a href="mediasAdmin.php">Gérer les médias</a></p>
<p><a href="commentsAdmin.php">Gérer commentaires</a></p>
<p><a href="usersAdmin.php">Gérer les utilisateurs</a></p>
<p><a href="logout.php">Se déconnecter</a></p>

<H1>Interface d'administration - Editer un utilisateur</H1>

<form action="" method="post">
    <label for="title-article">Titre de l'article</label>
    <input type="text" name="title-article" id="title-article" value="Saisissez un titre">
    <label for="chapo-article">Chapô de l'article</label>
    <input type="text" name="chapo-article" id="chapo-article" value="Saisissez un chapô">
    <label for="contenu-article">Contenu de l'article</label>
    <textarea id="contenu-article"></textarea>
    <input type="submit" name="publier" value="Publier">
    <input type="submit" name="mettre à jour" value="Mettre à jour">
    <input type="submit" name="brouillon" value="Enregistrer en tant que brouillon">
</form>

</body>
</html>
<?php endif;