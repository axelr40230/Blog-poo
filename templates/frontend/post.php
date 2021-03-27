<?php
session_start();

// connexion à la base de données
require_once('models/database.php');
require_once('models/Comment.php');
require_once('models/Post.php');

$postModel = new Post();
$commentModel = new Comment();


if (isset($_SESSION['id'])) :
    $idconnect = $_SESSION['id'];
endif;

$postModel = new Post();
$commentModel = new Comment();

$article_id = $_GET['id'];
$post = find('articles');
$post = $post->fetch();
setlocale(LC_TIME, "fr_FR", "French");
$date = $post['created_at'];
$date = strtotime("$date");
$date = strftime('%A %d %B %Y',$date);

// traitement des formulaires

$information='';

if(isset($_POST['commenter'])):

    if(!empty($_POST['comment'])) :
        $author = $idconnect;
        $status = 'waiting';
        $comment = htmlspecialchars($_POST['comment']);
        $newComment = insertComment($author, $comment, $article_id, $status);
        // debug
/*        if($success == false):
            var_dump($newComment->errorInfo());
            exit();
        endif;
        // Plusieurs destinataires
        $to  = 'johny@example.com, sally@example.com'; // notez la virgule

        // Sujet
        $subject = 'Commentaire en attente de validation';

        // message
        $message = '
     <html>
      <head>
       <title>Un nouveau commentaire est arrivé sur le site</title>
      </head>
      <body>
       <p>Voici un nouveau commentaire sur le site</p>
       <table>
        <tr>
            <th>
                <a href="http://localhost/BLOG-POO-AR/projet%20blog%20alexandra%20OC/templates/backend/commentsAdmin.php">Lien</a>
            </th>
        </tr>
       </table>
      </body>
     </html>
     ';

        // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';

        // En-têtes additionnels
        $headers[] = 'To: Mary <mary@example.com>, Kelly <kelly@example.com>';
        $headers[] = 'From: Anniversaire <anniversaire@example.com>';
        $headers[] = 'Cc: anniversaire_archive@example.com';
        $headers[] = 'Bcc: anniversaire_verif@example.com';

        // Envoi
        mail($to, $subject, $message, implode("\r\n", $headers));
        $information = 'Merci pour votre commentaire. Nous allons l\'examiner et le publier';*/

    elseif (isset($_POST['repondre'])):
        if(!empty($_POST['comment-reply'])) :
            $status = 'waiting';
            $author = $idconnect;
            $comment = htmlspecialchars($_POST['comment']);
            $newComment = insertComment($author, $comment, $article_id, $status);
        endif;
    else :
        $information = 'Merci de remplir tous les champs';
    endif;
endif;

?>


<p><a href="index.php?action=homePage">Retour à l'accueil</a></p>
<p><a href="index.php?action=listPosts">Page des posts</a></p>

<?php //Affichage de l'article ?>

<?php if($article_id) :

    $result = $postModel->author($article_id);

    ?>
    <h2><?= $post['title'] ?></h2>
    <p>Ecrit par <?= $result['first_name'] ?> <?= $result['last_name'] ?>, le <?= $date ?> - date de dernière mise à jour</p>
    <p style="font-weight: bold;"><?= $post['introduction'] ?></p>
    <p><?= $post['content'] ?></p>

    <?php //Affichage de des commentaires ?>

    <?php
    $comments = $commentModel->list($article_id);
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
            $author = $commentModel->author($id_author);
            //var_dump($result);
            ?>
            <p>Le <?= $date ?>, <?= $result['first_name'] ?> <?= $result['last_name'] ?> a écrit :</p>
            <p><?= $comment['comment'] ?></p>
            <hr>

            <?php if(isset($_SESSION['id'])) : ?>

            <p><a href="report-comment.php?comment=<?= $comment['id'] ?>">Signaler le commentaire</a></p>
            <p><a href="post.php?id=<?= $article_id ?>&comment=<?= $comment['id'] ?>&replyto=<?= $id_author ?>">Répondre à ce commentaire</a></p>
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
            <?php if(!$information) : ?>
                <p><?= $information ?></p>
            <?php endif; ?>
            <label for="comment-reply">Votre commentaire</label><br>
            <textarea name="comment-reply" id="comment-reply" cols="30" rows="10"></textarea><br>
            <input type="submit" name="repondre">
        </form>


        <?php //Formulaire d'ajout ?>

    <?php else : ?>

        <h2>Ajouter un commentaire</h2>


        <form action="" method="post">
            <?php if(!$information) : ?>
                <p><?= $information ?></p>
            <?php endif; ?>
            <label for="comment">Votre commentaire</label><br>
            <textarea name="comment" id="comment" cols="30" rows="10"></textarea><br>
            <input type="submit" name="commenter">
        </form>


    <?php endif; ?>

<?php else : ?>

    <h2>Vous devez être connecté pour commenter</h2>
    <p><a href="templates/backend/login.php">Se connecter</a></p>

<?php endif; ?>
