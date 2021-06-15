<?php

namespace App\Controller;

use App\App;
use App\Auth;
use App\Table\PostTable;

class PostsController extends Controller
{
    public function table($posts)
    {
        $posts = ucfirst($posts);
        $posts = rtrim($posts, 's');
        $table = "App\Table\\" . $posts . "Table";

        return $table = new $table();
    }

    /**
     * @param $id
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
     *
     */
    public function all()
    {
        $table = new PostTable();
        $pageTitle = 'Mes articles';
        $this->render('posts', ['pageTitle' => $pageTitle, 'posts' => $table->findByStatus('publish')], 'frontend');
    }

    /**
     * @param $id
     * @todo A finaliser
     */
    public function addComment($id)
    {
        $data = $_POST;
        var_dump($data);
        var_dump($id);
    }

    public function update($slug)
    {
        $data = $_POST;
        $table = $this->table('posts');
        $post = $table->oneBySlug($slug);
        $id = $post->id;
        $table->update($id,$slug, $data);
        header("Refresh:0");
    }

    public function insert()
    {
        //echo 'yes';exit();
        $errors = [];
        $data = $_POST;
        //var_dump($data);exit();
        $table = $this->table('posts');
        $postId = $table->insert($data);
        //$postId = intval($postId);
        //var_dump($postId);exit();
        if ($postId == false) {
            $errors = 'Oups ! Quelque chose s\'est mal passé. Recommencez...';
            $posts = rtrim('posts', 's');
            $name = $posts;
            $pageTitle = 'insert' . $posts;
            $this->render('insert-' . $name, ['pageTitle' => $pageTitle, 'errors' => $errors], 'backend');
        } else {
            $post = new PostTable();
            $post = $post->one($postId);
            //var_dump($post);exit;
            $url = App::url("admin/posts/edit/{$post->slug}");
            header("Location: {$url}");
            exit();
        }
    }

    public function list()
    {
        $isConnect = Auth::isAuth();
        if ($isConnect == false) {
            $url = App::url('login');
            header("Location: {$url}");
            exit();
        } else {
            $table = $this->table('posts');
            $trad = new App();
            $pageTitle = $trad->translate('posts');
            $table = $table->findNotTrash();
            //var_dump($table);exit();
            $this->render('posts', ['pageTitle' => $pageTitle, 'posts' => $table], 'backend');
        }
    }

    public function trash()
    {
        $isConnect = Auth::isAuth();
        if ($isConnect == false) {
            $url = App::url('login');
            header("Location: {$url}");
            exit();
        } else {
            $table = $this->table('posts');
            $trad = new App();
            $pageTitle = $trad->translate('posts');
            $table = $table->findInTrash();
            //var_dump($table);exit();
            $this->render('posts', ['pageTitle' => $pageTitle, 'posts' => $table], 'backend');
        }
    }

    public function draft()
    {
        $isConnect = Auth::isAuth();
        if ($isConnect == false) {
            $url = App::url('login');
            header("Location: {$url}");
            exit();
        } else {
            $table = $this->table('posts');
            $trad = new App();
            $pageTitle = $trad->translate('posts');
            $table = $table->findDraft();
            //var_dump($table);exit();
            $this->render('posts', ['pageTitle' => $pageTitle, 'posts' => $table], 'backend');
        }
    }

    public function publish()
    {
        $isConnect = Auth::isAuth();
        if ($isConnect == false) {
            $url = App::url('login');
            header("Location: {$url}");
            exit();
        } else {
            $table = $this->table('posts');
            $trad = new App();
            $pageTitle = $trad->translate('posts');
            $table = $table->findPublish();
            //var_dump($table);exit();
            $this->render('posts', ['pageTitle' => $pageTitle, 'posts' => $table], 'backend');
        }
    }


    public function edit($slug)
    {
        $errors = [];
        //var_dump($slug);
        $isConnect = Auth::isAuth();
        if ($isConnect == false) {
            $url = App::url('login');
            header("Location: {$url}");
            exit();
        } else {
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

    public function new()
    {
        $errors = [];
        $isConnect = Auth::isAuth();
        if ($isConnect == false) {
            $url = App::url('login');
            header("Location: {$url}");
            exit();
        } else {
            $posts = rtrim('posts', 's');
            $name = $posts;
            $pageTitle = 'insert' . $posts;
            $this->render('insert-' . $name, ['pageTitle' => $pageTitle, 'errors' => $errors], 'backend');
        }
    }
}