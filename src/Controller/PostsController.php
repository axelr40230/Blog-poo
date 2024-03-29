<?php

namespace App\Controller;

use App\App;
use App\Auth;
use App\Table\CommentTable;
use App\Table\PostTable;
use App\Table\UserTable;

/**
 * Class PostsController
 * @package App\Controller
 */
class PostsController extends Controller
{
    /**
     * makes the link with the posts table
     * fait le lien avec la table des posts
     * @param $posts
     * @return mixed
     */
    public function table($posts)
    {
        $posts = ucfirst($posts);
        $posts = rtrim($posts, 's');
        $table = "App\Table\\" . $posts . "Table";

        return $table = new $table();
    }

    /**
     * manages the display of a post in front
     * gère l'affichage d'un post en front
     * @param $slug
     */
    public function show($slug)
    {

        $table = new PostTable();
        $post = $table->oneBySlug($slug);
        $usersTable = new UserTable();
        $post->author = $usersTable->author($post->author);
        $tableComments = new CommentTable();
        $comments = $tableComments->elements($post->id, 'approuved');
        $number = $tableComments->howManyComments($post->id, 'approuved');
        foreach ($comments as $comment) {
            $comment->author = $usersTable->author($comment->author);
        }

        $this->render('single', ['pageTitle' => $post->title, 'id' => $post->id, 'slug' => $post->slug, 'post' => $post, 'comments' => $comments, 'number' => $number], 'frontend');

    }

    /**
     * manages the display of the listing of posts in front
     * gère l'affichage du listing des posts en front
     */
    public function all()
    {
        $table = new PostTable();
        $pageTitle = 'Mes articles';
        $this->render('posts', ['pageTitle' => $pageTitle, 'posts' => $table->findByStatus('publish', 'modify_at', 'DESC')], 'frontend');
    }


    /**
     * allows you to update a post
     * permet de mettre à jour un post
     * @param $slug
     */
    public function update($slug)
    {
        $data = $_POST;
        $table = $this->table('posts');
        $post = $table->oneBySlug($slug);
        $id = $post->id;
        $new = $table->update($id, $slug, $data);
        $url = App::url("admin/posts/edit/{$new}");
        header("Location: {$url}");
    }

    /**
     * manages the insertion of a new post
     * gère l'insertion d'un nouveau post
     */
    public function insert()
    {
        if (Auth::isAdmin()) {
            $errors = [];
            $data = $_POST;
            $table = $this->table('posts');
            $postId = $table->insert($data);
            if ($postId == false) {
                $errors = 'Oups ! Quelque chose s\'est mal passé. Recommencez...';
                $posts = rtrim('posts', 's');
                $name = $posts;
                $pageTitle = 'insert' . $posts;
                $this->render('insert-' . $name, ['pageTitle' => $pageTitle, 'errors' => $errors], 'backend');
            } else {
                $post = new PostTable();
                $post = $post->one($postId);
                $url = App::url("admin/posts/edit/{$post->slug}");
                header("Location: {$url}");
            }
        }
    }

    /**
     * list of all posts except trash in the BO
     * liste de tous les posts sauf corbeille dans le BO
     */
    public function list()
    {
        if ($this->isConnected()) {
            if (Auth::isAdmin()) {
                $table = $this->table('posts');
                $trad = new App();
                $pageTitle = $trad->translate('posts');
                $posts = $table->findNotTrash();
                foreach ($posts as $post) {
                    $infos = new UserTable();
                    $post->author = $infos->author($post->author);
                }
                $this->render('posts', ['pageTitle' => $pageTitle, 'posts' => $posts], 'backend');
            }
        }
    }

    /**
     * listing of posts in the trash
     * listing des posts à la corbeille
     */
    public function trash()
    {
        if ($this->isConnected()) {
            if (Auth::isAdmin()) {
                $posts = $this->table('posts');
                $trad = new App();
                $pageTitle = $trad->translate('posts');
                $posts = $posts->findInTrash();
                foreach ($posts as $post) {
                    $infos = new UserTable();
                    $post->author = $infos->author($post->author);
                }
                $this->render('posts', ['pageTitle' => $pageTitle, 'posts' => $posts], 'backend');
            }
        }
    }

    /**
     * permanent deletion of a post
     * suppression définitive d'un post
     * @param $slug
     */
    public function delete($slug)
    {
        if ($this->isConnected()) {
            if (Auth::isAdmin()) {
                $table = $this->table('posts');
                $delete = $table->delete($slug);
                if ($delete == true) {
                    $url = App::url('admin/posts');
                    header("Location: {$url}");
                } else {
                    header("Refresh:0");
                }
            }
        }
    }

    /**
     * list of draft posts
     * liste posts en brouillon
     */
    public function draft()
    {
        if ($this->isConnected()) {
            if (Auth::isAdmin()) {
                $posts = $this->table('posts');
                $trad = new App();
                $pageTitle = $trad->translate('posts');
                $posts = $posts->findDraft();
                foreach ($posts as $post) {
                    $infos = new UserTable();
                    $post->author = $infos->author($post->author);
                }
                $this->render('posts', ['pageTitle' => $pageTitle, 'posts' => $posts], 'backend');
            }
        }
    }

    /**
     * list the published posts
     * liste les posts publiés
     */
    public function publish()
    {
        if ($this->isConnected()) {
            if (Auth::isAdmin()) {
                $posts = $this->table('posts');
                $trad = new App();
                $pageTitle = $trad->translate('posts');
                $posts = $posts->findPublish();
                foreach ($posts as $post) {
                    $infos = new UserTable();
                    $post->author = $infos->author($post->author);
                }
                $this->render('posts', ['pageTitle' => $pageTitle, 'posts' => $posts], 'backend');
            }
        }
    }


    /**
     * allows you to edit a post
     * permet d'éditer un post
     * @param $slug
     */
    public function edit($slug)
    {
        $errors = [];
        if ($this->isConnected()) {
            if (Auth::isAdmin()) {
                $post = rtrim('posts', 's');
                $name = $post;
                $posts = 'posts';
                $table = $this->table($posts);
                $post = $table->oneBySlug($slug);
                $id = $post->id;
                $infos = new UserTable();
                $author = $infos->author($post->author);
                $status = new App();
                $status = $status->translate($post->status);
                $this->render('single-' . $name, ['pageTitle' => $post->title, 'id' => $id, $name => $post, 'errors' => $errors, 'author' => $author, 'status' => $status], 'backend');
            }
        }
    }

    /**
     * manages the display of the post creation page
     * gère l'affichage de la page de création d'un post
     */
    public function new()
    {
        $errors = [];
        if ($this->isConnected()) {
            if (Auth::isAdmin()) {
                $posts = rtrim('posts', 's');
                $pageTitle = 'insert ' . $posts;
                $trad = new App();
                $pageTitle = $trad->translate($pageTitle);
                $this->render('insert-' . $posts, ['pageTitle' => $pageTitle, 'errors' => $errors], 'backend');
            }
        }
    }

}