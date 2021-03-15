<?php
session_start();
$author = $_SESSION['id'];


// connexion à la bdd
$db = new \PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', '');

$postId = $_GET['id'];
$action = $_GET['action'];

// récupération des infos
$post = $db->prepare('SELECT title, introduction, chapo, content, created_at, modify_at  FROM articles WHERE id = ?');
$post->execute(array($postId));
$post = $post->fetch();

// gestion du fuseau
setlocale(LC_TIME, "fr_FR", "French");

// gestion affichage date en français
$date = $post['created_at'];
$date = strtotime("$date");
$date = strftime('%A %d %B %Y',$date);

// ajout d'un nouvel article
if($action == 'add') :
    $message = 'yo';

    // article directement publié
    if(isset($_POST['publier'])) :
        if(!empty($_POST['title-article']) AND !empty($_POST['chapo-article']) AND !empty($_POST['contenu-article'])):
        //validation des données
        $title = htmlspecialchars($_POST['title-article']);
        $slug1 = htmlspecialchars($_POST['title-article']);
        // mettre en minuscule
        $slug2 = strtolower($slug1);
        // effectuer un remplacement de caractère
        $slug = strtr($slug2, ' ','-');
        $introduction = htmlspecialchars($_POST['chapo-article']);
        $content = htmlspecialchars($_POST['contenu-article']);
        $status = 'publish';

        $add = $db->prepare('INSERT INTO articles(title, slug, introduction, content, author, status, created_at, modify_at) VALUES (:title, :slug, :introduction, :content, :author, :status,NOW(),NOW())');
            $add->execute(array(
                'title' => $title,
                'slug' => $slug,
                'introduction' => $introduction,
                'content' => $content,
                'author' => $author,
                'status' => $status
            ));
        else :
        $message = 'Tous les champs ne sont pas remplis';
        endif;

    // article en brouillon
    elseif(isset($_POST['brouillon'])) :
        if(!empty($_POST['title-article']) AND !empty($_POST['chapo-article']) AND !empty($_POST['contenu-article'])):
            //validation des données
            $title = htmlspecialchars($_POST['title-article']);
            $slug1 = htmlspecialchars($_POST['title-article']);
            // mettre en minuscule
            $slug2 = strtolower($slug1);
            // effectuer un remplacement de caractère
            $slug = strtr($slug2, ' ','-');
            $introduction = htmlspecialchars($_POST['chapo-article']);
            $content = htmlspecialchars($_POST['contenu-article']);
            $status = 'draft';

            $add = $db->prepare('INSERT INTO articles(title, slug, introduction, content, author, status, created_at, modify_at) VALUES (:title, :slug, :introduction, :content, :author, :status,NOW(),NOW())');
            $add->execute(array(
                'title' => $title,
                'slug' => $slug,
                'introduction' => $introduction,
                'content' => $content,
                'author' => $author,
                'status' => $status
            ));
        else :
            $message = 'Tous les champs ne sont pas remplis';
        endif;
    else :
    $message = 'Non publié';
    endif;


endif;

// mise à jour d'un article
//$update = $db->prepare('UPDATE articles SET articles = ?, modify_at = NOW() WHERE id = ?');
//$newPost = $update->execute(array($comment, $id));
//$newPost = $update->fetch();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <?php // cas 1 : mise à jour d'un article ?>

    <?php if($action == 'add' AND $postId == 'null') : ?>
    <title>Interface d'administration - Création d'un article</title>

    <?php //cas 2 : ajout d'un article ?>
    
    <?php elseif($action == '') : ?>
    <title>Interface d'administration - Gestion d'un article</title>

    <?php endif; ?>

</head>
<body>

<p><a href="../index.php">Visiter le site</a></p>
<p><a href="posts-admin.php">Gérer les posts</a></p>
<p><a href="medias-admin.php">Gérer les médias</a></p>
<p><a href="comments-admin.php">Gérer commentaires</a></p>
<p><a href="users-admin.php">Gérer les utilisateurs</a></p>
<p><a href="disconnect.php">Se déconnecter</a></p>

<?php // cas 1 : mise à jour d'un article ?>

<?php if($action == 'edit' AND isset($_GET['id'])) : ?>
    <h1>Interface d'administration - Gestion d'un article</h1>

    <form action="" method="post">
        <p>editeur wysiwig</p>

        </script>
        <label for="title-article">Ancien titre de l'article</label>
        <input type="text" name="title-article" id="title-article">
        <label for="chapo-article">Chapô de l'article</label>
        <input type="text" name="chapo-article" id="chapo-article">
        <label for="contenu-article">Contenu de l'article</label>
        <textarea id="contenu-article"></textarea>
        <input type="submit" name="publier" value="Publier">
        <input type="submit" name="mettre à jour" value="Mettre à jour">
        <input type="submit" name="brouillon" value="Enregistrer en tant que brouillon">
    </form>

    <?php //cas 2 : ajout d'un article ?>

<?php elseif($action == 'add' AND $postId == 'null') : ?>
    <h1>Interface d'administration - Création d'un article</h1>

    <form action="" method="post">
        <p>editeur wysiwig</p>
        <p><?= $message ?></p>
        <label for="title-article">Titre de l'article</label>
        <input type="text" name="title-article" id="title-article">
        <label for="chapo-article">Chapô de l'article</label>
        <input type="text" name="chapo-article" id="chapo-article">
        <label for="contenu-article">Contenu de l'article</label>
        <textarea id="contenu-article" name="contenu-article"></textarea>
        <input type="submit" name="publier" value="publier">
        <input type="submit" name="brouillon" value="brouillon">

    </form>

<?php endif; ?>


</body>
</html>