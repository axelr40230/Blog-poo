<?php

require_once ('models/database.php');

class Post
{
    /**
     * @param string $article_id
     * @return mixed
     */
    public function author(string $article_id) : array
    {
        $db = getPdo();
        $author = $db->prepare('SELECT users.first_name, users.last_name FROM users LEFT OUTER JOIN articles ON users.id = articles.author WHERE articles.id = ?');
        $author->execute(array($article_id));
        $result = $author->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    /** requete pour récupérer les articles d'un utilisateur
     * @param string $userId
     * @return false|PDOStatement
     */
    public function articlesByUser(string $userId) : PDOStatement
    {
        $db = getPdo();
        $listingPosts = $db->prepare('SELECT * FROM articles WHERE author = ?');
        $listingPosts->execute(array($userId));

        return $listingPosts;
    }

    /**
     * @param string $article_id
     * @return mixed
     */
    public function find(string $article_id)
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
    public function insert(string $title, string $slug, string $introduction, string $content, int $author, string $status) : void
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
    public function update(string $attribut, string $state, string $id) : void
    {
        $db = getPdo();
        $db->query('UPDATE articles SET '.$attribut.' = "'.$state.'", modify_at = NOW() WHERE id = '.$id);
        header("Refresh:0");
    }

    /** requête pour supprimer un article
     * @param string $article_id
     */
    function delete(string $article_id) : void
    {
        $db = getPdo();
        $delete = $db->prepare('DELETE FROM articles WHERE id = ?');
        $delete->execute(array($article_id));
        $post = $delete->fetch();
        header('location:?action=postsAdmin');
    }
}