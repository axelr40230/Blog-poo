<?php

namespace App\Controller;

use App\App;
use App\Table\PostTable;

class PostsController extends Controller
{
    private function table($posts)
    {
        $posts = ucfirst($posts);
        $posts = rtrim($posts,'s');
        $table = "App\Table\\".$posts."Table";

        return $table = new $table();
    }
    
    /**
     * @param $id
     */
    public function show($id)
    {
        $table = new PostTable();
        $post = $table->one($id);
        $pageTitle = $post->title;
        $this->render('single', ['pageTitle' => $pageTitle, 'id'=>$id, 'post' => $post], 'frontend');
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

    public function update($posts, $id)
    {
        $data = $_POST;
        $table = $this->table($posts);
        $table->update($id, $data);
        header("Refresh:0");
    }

    public function insert($posts, $action)
    {
        $data = $_POST;
        $table = $this->table($posts);
        $table->insert($data);
        header("Refresh:0");
    }

    public function list($posts)
    {
        $table = $this->table($posts);
        $trad = new App();
        $pageTitle = $trad->translate($posts);
        $table = $table->findAll();
        //var_dump($table);exit();
        $this->render($posts, ['pageTitle' => $pageTitle, $posts => $table], 'backend');
    }

    public function edit($posts, $id)
    {
        $posts = rtrim($posts,'s');
        $name = $posts;
        $table = $this->table($posts);
        $post = $table->one($id);
        $pageTitle = $post->title;
        $this->render('single-'.$name, ['pageTitle' => $pageTitle, 'id'=>$id, $name => $post ], 'backend');
    }

    public function new($posts, $action)
    {
        $posts = rtrim($posts,'s');
        $name = $posts;
        $pageTitle = $action.' '.$posts;
        $this->render('insert-'.$name, ['pageTitle' => $pageTitle ], 'backend');
    }
}