<?php

namespace App\Controller;

use App\App;
use App\Auth;
use App\Table\CommentTable;

class CommentsController extends Controller
{
    public function table($comments)
    {
        $comments = ucfirst($comments);
        $comments = rtrim($comments, 's');
        $table = "App\Table\\" . $comments . "Table";

        return $table = new $table();
    }

    /**
     * @param $id
     */
    public function show($id)
    {
        $isConnect = Auth::isAuth();
        if ($isConnect == false) {
            $url = App::url('login');
            header("Location: {$url}");
            exit();
        } else {
            $table = new CommentTable();
            $comment = $table->one($id);
            $pageTitle = $comment->title;
            $this->render('single', ['pageTitle' => $pageTitle, 'id' => $id, 'post' => $comment], 'frontend');
        }
    }

    /**
     *
     */
    public function all()
    {
        $table = new CommentTable();
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

    public function update($id)
    {
        $data = $_POST;
        $table = $this->table('comments');
        $table->update($id, $data);
        header("Refresh:0");
    }

    public function insert($action)
    {
        $data = $_POST;
        $table = $this->table('comments');
        $table->insert($data);
        header("Refresh:0");
    }

    public function list()
    {
        $isConnect = Auth::isAuth();
        if ($isConnect == false) {
            $url = App::url('login');
            header("Location: {$url}");
            exit();
        } else {
            $table = $this->table('comments');
            $trad = new App();
            $pageTitle = $trad->translate('comments');
            $table = $table->findAll();
            //var_dump($table);exit();
            $this->render('comments', ['pageTitle' => $pageTitle, 'comments' => $table], 'backend');
        }
    }

    public function edit($id)
    {
        $isConnect = Auth::isAuth();
        if ($isConnect == false) {
            $url = App::url('login');
            header("Location: {$url}");
            exit();
        } else {
            $comments = rtrim('comments', 's');
            $name = $comments;
            $table = $this->table($comments);
            $comment = $table->one($id);
            $pageTitle = 'Commentaire n°' . $comment->id;
            $this->render('single-' . $name, ['pageTitle' => $pageTitle, 'id' => $id, $name => $comment], 'backend');
        }
    }
}