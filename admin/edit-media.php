<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Interface d'administration - Ajouter un article</title>
</head>
<body>

<p><a href="../index.php">Visiter le site</a></p>
<p><a href="posts-admin.php">Gérer les posts</a></p>
<p><a href="medias-admin.php">Gérer les médias</a></p>
<p><a href="comments-admin.php">Gérer commentaires</a></p>
<p><a href="users-admin.php">Gérer les utilisateurs</a></p>
<p><a href="disconnect.php">Se déconnecter</a></p>

<H1>Interface d'administration - Ajouter un article</H1>

<form action="" method="post">

    <label for="title-media">Nom du média</label>
    <input type="text" name="title-media" id="title-media" value="Saisissez un titre">
    <label for="type-media">Type de média</label>
    <input type="text" name="type-media" id="type-media" value="PDF/Image ?">
    <label for="link-video">Lien vidéo</label>
    <p><input type="text" name="link-video" id="link-video" value="lien youtube"></p>
    <p>ou</p>
    <input type="submit" name="publier" value="Télécharger un média">
    <p>
        <input type="submit" name="publier" value="Publier">
        <input type="submit" name="mettre à jour" value="Mettre à jour">
        <input type="submit" name="brouillon" value="Enregistrer en tant que brouillon">
    </p>

</form>

</body>
</html>