<?php

/** Connexion à la base de données
 * @return PDO
 */
function getPdo() : PDO
{
    try {
        $pdo = new \PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', '');
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        return $pdo;
    }
    catch (PDOException $e) {
        echo 'La base de donnée n\'est pas disponible pour le moment. <br />';
        echo $e->getMessage() . '<br />';
        echo 'Ligne : ' . $e->getLine();
    }

}

/** Requête pour récupérer un listing
 * @param string $table
 * @return false|PDOStatement
 */

function find(string $table) : PDOStatement
{
    $db = getPdo();
    $results = $db->query('SELECT * FROM '.$table.' ORDER BY created_at DESC');

    return $results;
}

/** Requête d'insertion d'un commentaire
 * @param string $author
 * @param string $comment
 * @param int $article_id
 * @param string $status
 * @return false|PDOStatement
 */
function insertComment(string $author, string $comment, int $article_id, string $status) : PDOStatement
{
    $db = getPdo();
    $results = $db->prepare('INSERT INTO comments SET author = :author, comment = :comment, article_id = :article_id, status = :status, created_at = NOW()');
    $results->execute(compact('author','comment','article_id','status'));

    return $results;
}

/**
 * @param string $article_id
 * @return mixed
 */
function authorArticle(string $article_id) : array
{
    $db = getPdo();
    $author = $db->prepare('SELECT users.first_name, users.last_name FROM users LEFT OUTER JOIN articles ON users.id = articles.author WHERE articles.id = ?');
    $author->execute(array($article_id));
    $result = $author->fetch(PDO::FETCH_ASSOC);

    return $result;
}

/** requête pour récupérer les articles approuvés
 * @param string $article_id
 * @return false|PDOStatement
 */
function listComment(string $article_id) : PDOStatement
{
    $db = getPdo();
    $comments = $db->prepare('SELECT * FROM comments WHERE article_id = :id AND status = :status');
    $comments->execute(array(
        'id' =>$article_id,
        'status' => 'approuved'
    ));

    return $comments;
}

/** requête pour retrouver l'auteur d'un commentaire
 * @param string $id_author
 * @return mixed
 */
function authorComment(string $id_author)
{
    $db = getPdo();
    $author = $db->prepare('SELECT * FROM users  WHERE id = ?');
    $author->execute(array($id_author));
    $result = $author->fetch();

    return $result;
}

/** requête de contrôle de l'email / compte existant
 * @param string $email
 * @return false|PDOStatement
 */
function emailControl(string $email) : PDOStatement
{
    $db = getPdo();
    $req_count = $db->prepare('SELECT * FROM users WHERE email = :email');
    $req_count->execute(array(
        'email' => $email
    ));

    return $req_count;
}

/** requête de contrôle du mot de passe / compte existant
 * @param string $email
 * @return false|PDOStatement
 */
function passwordControl(string $email) : PDOStatement
{
    $db = getPdo();
    $req = $db->prepare('SELECT id, password FROM users WHERE email = :email');
    $req->execute(array(
        'email' => $email
    ));

    return $req;
}

/** requete d'insertion d'un nouvel utilisateur
 * @param string $first_name
 * @param string $last_name
 * @param string $email
 * @param string $password
 * @param string $status
 * @return false|PDOStatement
 */
function insertUser(string $first_name, string $last_name, string $email, string $password, string $status) : PDOStatement
{
    $db = getPdo();
    $register = $db->prepare('INSERT INTO users SET first_name = :first_name, last_name = :last_name, email =:email, password = :password, status = :status, created_at = NOW()');
    $register->execute(compact(
            'first_name',
            'last_name',
            'email',
            'password',
            'status',
        )
    );

    return $register;
}

/** requête pour sélectionner un utilisateur précis
 * @param string $userId
 * @return mixed
 */
function selectUser(string $userId)
{
    $db = getPdo();
    $user = $db->prepare('SELECT * FROM users WHERE id = ?');
    $user->execute(array($userId));
    $user = $user->fetch();

    return $user;
}

/** requete pour récupérer les articles d'un utilisateur
 * @param string $userId
 * @return false|PDOStatement
 */
function articlesByUser(string $userId) : PDOStatement
{
    $db = getPdo();
    $listingPosts = $db->prepare('SELECT * FROM articles WHERE author = ?');
    $listingPosts->execute(array($userId));

    return $listingPosts;
}

/** requête pour récupérer les commentaires d'un utilisateur
 * @param string $userId
 * @return false|PDOStatement
 */
function commentsByUser(string $userId) : PDOStatement
{
    $db = getPdo();
    $listingComments = $db->prepare('SELECT * FROM comments WHERE author = ?');
    $listingComments->execute(array($userId));

    return $listingComments;
}

/** requête pour supprimer un article
 * @param string $article_id
 */
function deletePost(string $article_id) : void
{
    $db = getPdo();
    $delete = $db->prepare('DELETE FROM articles WHERE id = ?');
    $delete->execute(array($article_id));
    $post = $delete->fetch();
    header('location:?action=postsAdmin');
}

/** requête pour supprimer un utilisateur
 * @param string $userId
 */
function deleteUsers(string $userId) : void
{
    $db = getPdo();
    $delete = $db->prepare('DELETE FROM users WHERE id = ?');
    $delete->execute(array($userId));
    $delete = $delete->fetch();
    header('location:?action=usersAdmin');
}

/** requête pour approuver un commentaire
 * @param string $status
 * @param string $commentId
 */
function updateComment(string $status, string $commentId) : void
{
    $db = getPdo();
    $publish = $db->prepare('UPDATE comments SET status = :status WHERE id = :id');
    $publish->execute(array(
        'status'=> $status,
        'id'=> $commentId
    ));

    header('location:?action=commentsAdmin');
}

/** requête de suppression d'un commentaire
 * @param string $status
 * @param string $commentId
 */
function deleteComment(string $status, string $commentId) : void
{
    $db = getPdo();
    $publish = $db->prepare('UPDATE comments SET status = :status WHERE id = :id');
    $publish->execute(array(
        'status'=> $status,
        'id'=> $commentId
    ));

    header('location:?action=commentsAdmin');
}

/** requête de sélection du média à supprimer
 * @param string $mediaId
 * @return false|PDOStatement
 */
function selectMedia(string $mediaId) : PDOStatement
{
    $db = getPdo();
    $media = $db->prepare('SELECT * FROM medias WHERE id = :media_id');
    $media->execute(array(
        'media_id' => $mediaId
    ));

    return $media;
}

/** requête de suppression d'un media
 * @param string $mediaId
 */
function mediaDelete (string $mediaId) : void
{
    $db = getPdo();
    $delete = $db->prepare('DELETE FROM medias WHERE id = ?');
    $delete->execute(array($mediaId));
    $post = $delete->fetch();
    header('location:?action=mediasAdmin');
}

/** requête d'ajout d'un nouveau média
 * @param string $fichier
 * @param string $author
 * @param string $type
 */
function addMedia(string $fichier, string $author, string $type) : void
{
    $db = getPdo();
    $add = $db->prepare('INSERT INTO medias(name_media, user_id, type_media, link, created_at) VALUES (:name_media, :user_id, :type_media, :link, NOW())');
    $add->execute(array(
        'name_media' => $fichier,
        'user_id' => $author,
        'type_media' => $type,
        'link' => $fichier
    ));
    header('Location: index.php?action=mediasAdmin');
}

/**
 * @param string $article_id
 * @return mixed
 */
function findArticle(string $article_id)
{
    $db = getPdo();
    $post = $db->prepare('SELECT title, introduction, content, status, created_at, modify_at FROM articles WHERE id = ?');
    $post->execute(array($article_id));
    $post = $post->fetch();

    return $post;
}

/** requête d'insertion d'un article
 * @param string $title
 * @param string $slug
 * @param string $introduction
 * @param string $content
 * @param int $author
 * @param string $status
 */
function insertArticle(string $title, string $slug, string $introduction, string $content, int $author, string $status) : void
{
    $db = getPdo();
    $add = $db->prepare('INSERT INTO articles(title, slug, introduction, content, author, status, created_at, modify_at) VALUES (:title, :slug, :introduction, :content, :author, :status,NOW(),NOW())');
    $add->execute(array(
        'title' => $title,
        'slug' => $slug,
        'introduction' => $introduction,
        'content' => $content,
        'author' => $author,
        'status' => $status
    ));
    header('Location: index.php?action=postsAdmin');
}

/** requête de mise à jour d'un article
 * @param string $attribut
 * @param string $state
 * @param string $id
 */
function updateArticle(string $attribut, string $state, string $id) : void
{
    $db = getPdo();
    $db->query('UPDATE articles SET '.$attribut.' = "'.$state.'", modify_at = NOW() WHERE id = '.$id);
    header("Refresh:0");
}

/** requête pour récupérer l'auteur d'un média
 * @param string $mediaId
 * @return mixed
 */
function authorMedia(string $mediaId)
{
    $db = getPdo();
    $author = $db->prepare('SELECT users.first_name, users.last_name FROM users LEFT OUTER JOIN medias ON users.id = medias.user_id WHERE medias.id = ?');
    $author->execute(array($mediaId));
    $result = $author->fetch(PDO::FETCH_ASSOC);

    return $result;
}
