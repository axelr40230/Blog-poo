<?php
// lancement de la session
session_start();
if (!isset($_SESSION['id'])) :
    header('Location: index.php?action=login');
else :

$author = $_SESSION['id'];

// connexion à la base de données
    require_once('models/database.php');
    $db = getPdo();


$postId = $_GET['id'];
$action = $_GET['action'];

$post = $db->prepare('SELECT title, introduction, content, status, created_at, modify_at FROM articles WHERE id = ?');
$post->execute(array($postId));
$post = $post->fetch();
setlocale(LC_TIME, "fr_FR", "French");
$date = $post['created_at'];
$date = strtotime("$date");
$date = strftime('%A %d %B %Y',$date);
$oldTitle = $post['title'];
$oldIntroduction = $post['introduction'];
$oldContent = $post['content'];
$status = $post['status'];
$modifyDate = $post['modify_at'];
$modifyDate = strtotime("$modifyDate");
$modifyDate = strftime('%A %d %B %Y',$modifyDate);

$message = '';


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

// gestion d'un article existant
if($action == 'edit') :

    $message = 'yeah';

    // mise à jour statut >> publié
    if(isset($_POST['publier'])) :
        $status = 'publish';
        $publish = $db->prepare('UPDATE articles SET status = :status, modify_at = NOW() WHERE id = :id');
        $publish->execute(array(
                'status'=> $status,
                'id'=> $postId
        ));
        $message = 'L\'article a bien été publié';
    endif;

    // mise à jour statut >> brouillon
    if(isset($_POST['brouillon'])) :
        $status = 'draft';
        $publish = $db->prepare('UPDATE articles SET status = :status, modify_at = NOW() WHERE id = :id');
        $publish->execute(array(
            'status'=> $status,
            'id'=> $postId
        ));
        $message = 'L\'article a bien été enregistré en tant que brouillon';
    endif;

    // mise à jour statut >> corbeille
    if(isset($_POST['delete'])) :
        $status = 'intrash';
        $publish = $db->prepare('UPDATE articles SET status = :status, modify_at = NOW() WHERE id = :id');
        $publish->execute(array(
            'status'=> $status,
            'id'=> $postId
        ));
        $message = 'L\'article a bien été placé dans la corbeille';
    endif;

    // mise à jour >> titre
    if(isset($_POST['update'])) :
        //var_dump($_POST['new-title-article']);
        if(!empty($_POST['new-title-article'])) :
        $newTitle = htmlspecialchars($_POST['new-title-article']);
        $updateTitle = $db->prepare('UPDATE articles SET title = :title, modify_at = NOW() WHERE id = :id');
            $updateTitle->execute(array(
            'title'=> $newTitle,
            'id'=> $postId
        ));
        $message = 'Le titre de l\'article a bien été modifié';
            header('location:editArticle.php?id='.$postId .'&action=edit');
        else :
            $message = 'Petit souci';
        endif;
    endif;

    // mise à jour >> chapo
    if(isset($_POST['update'])) :
        //var_dump($_POST['new-chapo-article']);
        if(!empty($_POST['new-chapo-article'])) :
            $newIntroduction = htmlspecialchars($_POST['new-chapo-article']);
        //var_dump($newIntroduction);
        //var_dump($postId);
            $updateChapo = $db->prepare('UPDATE articles SET introduction = :introduction, modify_at = NOW() WHERE id = :id');
            $updateChapo->execute(array(
                'introduction'=> $newIntroduction,
                'id'=> $postId
            ));
            $message = 'Le chapo de l\'article a bien été modifié';
            header('location:editArticle.php?id='.$postId .'&action=edit');
        else :
            $message = 'Petit souci';
        endif;
    endif;

    // mise à jour >> contenu
    if(isset($_POST['update'])) :
            //var_dump($_POST['new-contenu-article']);
        if(!empty($_POST['new-contenu-article'])) :
            $newContent = htmlspecialchars($_POST['new-contenu-article']);
            $updateContent = $db->prepare('UPDATE articles SET content = :content, modify_at = NOW() WHERE id = :id');
            $updateContent->execute(array(
                'content'=> $newContent,
                'id'=> $postId
            ));
            $message = 'Le contenu de l\'article a bien été modifié';
            header('location:editArticle.php?id='.$postId .'&action=edit');
        else :
            $message = 'Petit souci';
        endif;
    endif;
endif;
?>


<?php // cas 1 : mise à jour d'un article ?>

<?php if($action == 'editArticle' AND isset($_GET['id'])) : ?>
    <?php

    // récupération des infos
    $oldTitle = $post['title'];
    ?>

    <h1>Interface d'administration - Gestion d'un article</h1>

    <form action="" method="post">

        <h2>Infos sur l'article</h2>
        <?php $trad = translate($status) ?>
        <p>Statut : <?= $trad['fr'][$status]; ?></p>
        <p>Date de création : <?= $date ?></p>
        <p>Date de dernière mise à jour : <?= $modifyDate ?></p>
        <p>Gérer la visibilité de l'article</p>
        <input type="submit" name="publier" value="publier"><br><br>
        <input type="submit" name="brouillon" value="brouillon"><br><br>
        <input type="submit" name="delete" value="Supprimer"><br>
        <p><?= $message ?></p>
        <label for="new-title-article">Titre actuel de l'article : <?= $oldTitle ?></label><br><br>
        <input type="text" name="new-title-article" id="title-article"><br><br>
        <label for="chapo-article">Chapô actuel de l'article : <?= $oldIntroduction ?></label><br><br>
        <input type="text" name="new-chapo-article" id="chapo-article"><br><br>
        <label for="contenu-article">Contenu actuel de l'article : <?= $oldContent ?></label><br><br>
        <textarea id="contenu-article" name="new-contenu-article"></textarea><br><br>

        <input type="submit" name="update" value="Mettre à jour">
    </form>

    <?php //cas 2 : ajout d'un article ?>

<?php elseif($action == 'addArticle' AND $postId == 'null') : ?>
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
<?php endif;