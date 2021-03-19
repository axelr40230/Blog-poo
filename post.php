<?php
session_start();

if (isset($_SESSION['id'])) :
$idconnect = $_SESSION['id'];
endif;

$db = new \PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', '');
$postId = $_GET['id'];
$post = $db->prepare('SELECT title, introduction, content, created_at  FROM articles WHERE id = ?');
$post->execute(array($postId));
$post = $post->fetch();
setlocale(LC_TIME, "fr_FR", "French");
$date = $post['created_at'];
$date = strtotime("$date");
$date = strftime('%A %d %B %Y',$date);

// traitement des formulaires

$message='';

if(isset($_POST['commenter'])):

    if(!empty($_POST['comment'])) :
        $author = $idconnect;
        $comment = htmlspecialchars($_POST['comment']);
        $newComment = $db->prepare('INSERT INTO comments (author, content, article_id, status, created_at) VALUES(:author, :content, :article_id, :status, NOW())');
        $newComment->execute(array(
            'author' => $author,
            'content'=> $comment,
            'article_id' => $postId,
            'status' => 'waiting'
        ));
        $to      = 'axelr.apl@gmail.com';
        $subject = 'Un nouveau commentaire attend une validaiton'; ?>
        <?php ob_start(); ?>

   Bonjour Alexandra
    Tu as un com à valider
    www.test.fr

<?php $message = ob_get_clean(); ?>
<?php
        $headers = 'From: webmaster@blog.com' . "\r\n" .
            'Reply-To: axelr.apl@gmail.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);

        elseif (isset($_POST['repondre'])):
            if(!empty($_POST['comment-reply'])) :
                $author = $idconnect;
                $comment = htmlspecialchars($_POST['comment']);
                $newComment = $db->prepare('INSERT INTO comments (author, content, article_id, created_at) VALUES(:author, :content, :article_id, NOW())');
                $newComment->execute(array(
                    'author' => $author,
                    'content'=> $comment,
                    'article_id' => $postId));
            endif;
        else :
        $message = 'Merci de remplir tous les champs';
    endif;
endif;

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Lire un post</title>
</head>
<body>

<p><a href="index.php">Retour à l"accueil</a></p>
<p><a href="posts.php">Page des posts</a></p>

<?php //Affichage de l'article ?>

<?php if($postId) :

    $author = $db->prepare('SELECT users.first_name, users.last_name FROM users LEFT OUTER JOIN articles ON users.id = articles.author WHERE articles.id = ?');
    $author->execute(array($postId));
    $result = $author->fetch(PDO::FETCH_ASSOC);

    ?>
    <h2><?= $post['title'] ?></h2>
    <p>Ecrit par <?= $result['first_name'] ?> <?= $result['last_name'] ?>, le <?= $date ?> - date de dernière mise à jour</p>
    <p style="font-weight: bold;"><?= $post['introduction'] ?></p>
    <p><?= $post['content'] ?></p>

    <?php //Affichage de des commentaires ?>

    <?php
    $comments = $db->prepare('SELECT * FROM comments WHERE article_id = :id AND status = :status');
    $comments->execute(array(
            'id' =>$postId,
        'status' => 'approuved'
        ));
    $count     = $comments->rowCount();

    if($count == 0) : ?>
        <h2>Aucun commentaire</h2>
        <?php elseif ($count == 1) : ?>
        <h2><?= $count ?> commentaire</h2>
        <?php else : ?>
        <h2><?= $count ?> commentaires</h2>
        <?php endif;
    ?>

    <?php
    while($comment = $comments->fetch()):
        if($comment['status'] == 'approuved') :
        $date = $comment['created_at'];
        $date = strtotime("$date");
        $date = strftime('%A %d %B %Y',$date);
        $id_author = $comment['author'];
        //var_dump($id_author);
        $author = $db->prepare('SELECT * FROM users  WHERE id = ?');
        $author->execute(array($id_author));
        $result = $author->fetch();
        //var_dump($result);
        ?>
        <p>Le <?= $date ?>, <?= $result['first_name'] ?> <?= $result['last_name'] ?> a écrit :</p>
        <p><?= $comment['content'] ?></p>
        <hr>

        <?php if(isset($_SESSION['id'])) : ?>

        <p><a href="report-comment.php?comment=<?= $comment['id'] ?>">Signaler le commentaire</a></p>
        <p><a href="post.php?id=<?= $postId ?>&comment=<?= $comment['id'] ?>&replyto=<?= $id_author ?>">Répondre à ce commentaire</a></p>
        <hr>
        <?php endif; ?>


    <?php
        endif;
    endwhile;
    ?>



<?php else :
    echo 'Aucun id de billet saisi';
endif;

?>

<?php //Gestion des formulaires ?>

<?php if(isset($_SESSION['id'])) : ?>


    <?php //Formulaire de réponse ?>

    <?php if (isset($_GET['replyto'])) : ?>

        <h2>Répondre au commentaire</h2>


        <form action="" method="post">
            <?php if(!$message) : ?>
                <p><?= $message ?></p>
            <?php endif; ?>
            <label for="comment-reply">Votre commentaire</label><br>
            <textarea name="comment-reply" id="comment-reply" cols="30" rows="10"></textarea><br>
            <input type="submit" name="repondre">
        </form>


            <?php //Formulaire d'ajout ?>

    <?php else : ?>

        <h2>Ajouter un commentaire</h2>


        <form action="" method="post">
            <?php if(!$message) : ?>
                <p><?= $message ?></p>
            <?php endif; ?>
            <label for="comment">Votre commentaire</label><br>
            <textarea name="comment" id="comment" cols="30" rows="10"></textarea><br>
            <input type="submit" name="commenter">
        </form>


    <?php endif; ?>

<?php else : ?>

    <h2>Vous devez être connecté pour commenter</h2>
    <p><a href="admin/login.php">Se connecter</a></p>

<?php endif; ?>

</body>
</html>