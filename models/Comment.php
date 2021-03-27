<?php

require_once ('models/database.php');

class Comment
{
    /** Requête d'insertion d'un commentaire
     * @param string $author
     * @param string $comment
     * @param int $article_id
     * @param string $status
     * @return false|PDOStatement
     */
    public function insert(string $author, string $comment, int $article_id, string $status) : PDOStatement
    {
        $db = getPdo();
        $results = $db->prepare('INSERT INTO comments SET author = :author, comment = :comment, article_id = :article_id, status = :status, created_at = NOW()');
        $results->execute(compact('author','comment','article_id','status'));

        return $results;
    }

    /** requête pour récupérer les articles approuvés
     * @param string $article_id
     * @return false|PDOStatement
     */
    public function list(string $article_id) : PDOStatement
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
    public function author(string $id_author)
    {
        $db = getPdo();
        $author = $db->prepare('SELECT * FROM users  WHERE id = ?');
        $author->execute(array($id_author));
        $result = $author->fetch();

        return $result;
    }

    /** requête pour récupérer les commentaires d'un utilisateur
     * @param string $userId
     * @return false|PDOStatement
     */
    public function commentsByUser(string $userId) : PDOStatement
    {
        $db = getPdo();
        $listingComments = $db->prepare('SELECT * FROM comments WHERE author = ?');
        $listingComments->execute(array($userId));

        return $listingComments;
    }

    /** requête pour approuver un commentaire
     * @param string $status
     * @param string $commentId
     */
    public function update(string $status, string $commentId) : void
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
    public function delete(string $status, string $commentId) : void
    {
        $db = getPdo();
        $publish = $db->prepare('UPDATE comments SET status = :status WHERE id = :id');
        $publish->execute(array(
            'status'=> $status,
            'id'=> $commentId
        ));

        header('location:?action=commentsAdmin');
    }
}
