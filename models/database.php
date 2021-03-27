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
