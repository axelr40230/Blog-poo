<?php

namespace App\Controller;

use App\App;
use App\Auth;
use App\Table\PostTable;
use App\Table\UserTable;

class PostsController extends Controller
{
    /**
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
     * gère l'affichage d'un post en front
     * @param $slug
     */
    public function show($slug)
    {

        $table = new PostTable();
        $post = $table->oneBySlug($slug);
        $pageTitle = $post->title;
        $slug = $post->slug;
        $id = $post->id;
        $this->render('single', ['pageTitle' => $pageTitle, 'id' => $id, 'slug' => $slug, 'post' => $post], 'frontend');

    }

    /**
     * gère l'affichage du listing des posts en front
     */
    public function all()
    {
        $table = new PostTable();
        $pageTitle = 'Mes articles';
        $this->render('posts', ['pageTitle' => $pageTitle, 'posts' => $table->findByStatus('publish')], 'frontend');
    }


    /**
     * permet de mettre à jour un post
     * @param $slug
     */
    public function update($slug)
    {
        $data = $_POST;
        $table = $this->table('posts');
        $post = $table->oneBySlug($slug);
        $id = $post->id;
        $table->update($id, $slug, $data);
        header("Refresh:0");
    }

    /**
     * gère l'insertion d'un nouveau post
     */
    public function insert()
    {
        if ($this->isAdmin()) {
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
                exit();
            }
        }
    }

    /**
     * liste de tous les posts sauf corbeille dans le BO
     */
    public function list()
    {
        if ($this->isConnected()) {
            if ($this->isAdmin()) {
                $table = $this->table('posts');
                $trad = new App();
                $pageTitle = $trad->translate('posts');
                $posts = $table->findNotTrash();
                foreach ($posts as $post) {
                    $infos = new UserTable();
                    $id_author = $post->author;
                    $author = $infos->author($id_author);
                    $first_name = $author->first_name;
                    $last_name = $author->last_name;
                }
                $this->render('posts', ['pageTitle' => $pageTitle, 'posts' => $posts, 'first_name' => $first_name, 'last_name' => $last_name], 'backend');
            }
        }
    }

    /**
     * listing des posts à la corbeille
     */
    public function trash()
    {
        if ($this->isConnected()) {
            if ($this->isAdmin()) {
                $posts = $this->table('posts');
                $trad = new App();
                $pageTitle = $trad->translate('posts');
                $posts = $posts->findInTrash();
                foreach ($posts as $post) {
                    $infos = new UserTable();
                    $id_author = $post->author;
                    $author = $infos->author($id_author);
                    $first_name = $author->first_name;
                    $last_name = $author->last_name;
                }
                $this->render('posts', ['pageTitle' => $pageTitle, 'posts' => $posts, 'first_name' => $first_name, 'last_name' => $last_name], 'backend');
            }
        }
    }

    /**
     * suppression définitive d'un post
     * @param $slug
     */
    public function delete($slug)
    {
        if ($this->isConnected()) {
            if ($this->isAdmin()) {
                $table = $this->table('posts');
                $delete = $table->delete($slug);
                if ($delete == true) {
                    $url = App::url('admin/posts');
                    header("Location: {$url}");
                    exit();
                } else {
                    header("Refresh:0");
                }
            }
        }
    }

    /**
     * liste posts en brouillon
     */
    public function draft()
    {
        if ($this->isConnected()) {
            if ($this->isAdmin()) {
                $posts = $this->table('posts');
                $trad = new App();
                $pageTitle = $trad->translate('posts');
                $posts = $posts->findDraft();
                foreach ($posts as $post) {
                    $infos = new UserTable();
                    $id_author = $post->author;
                    $author = $infos->author($id_author);
                    $first_name = $author->first_name;
                    $last_name = $author->last_name;
                }
                $this->render('posts', ['pageTitle' => $pageTitle, 'posts' => $posts, 'first_name' => $first_name, 'last_name' => $last_name], 'backend');
            }
        }
    }

    /**
     * liste les posts publiés
     */
    public function publish()
    {
        if ($this->isConnected()) {
            if ($this->isAdmin()) {
                $posts = $this->table('posts');
                $trad = new App();
                $pageTitle = $trad->translate('posts');
                $posts = $posts->findPublish();
                foreach ($posts as $post) {
                    $infos = new UserTable();
                    $id_author = $post->author;
                    $author = $infos->author($id_author);
                    $first_name = $author->first_name;
                    $last_name = $author->last_name;
                }
                $this->render('posts', ['pageTitle' => $pageTitle, 'posts' => $posts, 'first_name' => $first_name, 'last_name' => $last_name], 'backend');
            }
        }
    }


    /**
     * permet d'éditer un post
     * @param $slug
     */
    public function edit($slug)
    {
        $errors = [];
        if ($this->isConnected()) {
            if ($this->isAdmin()) {
                $post = rtrim('posts', 's');
                $name = $post;
                $posts = 'posts';
                $table = $this->table($posts);
                $post = $table->oneBySlug($slug);
                $pageTitle = $post->title;
                $id = $post->id;
                $this->render('single-' . $name, ['pageTitle' => $pageTitle, 'id' => $id, $name => $post, 'errors' => $errors], 'backend');
            }
        }
    }

    /**
     * gère l'affichage de la page de création d'un post
     */
    public function new()
    {
        $errors = [];
        if ($this->isConnected()) {
            if ($this->isAdmin()) {
                $posts = rtrim('posts', 's');
                $name = $posts;
                $pageTitle = 'insert' . $posts;
                $this->render('insert-' . $name, ['pageTitle' => $pageTitle, 'errors' => $errors], 'backend');
            }
        }
    }

}