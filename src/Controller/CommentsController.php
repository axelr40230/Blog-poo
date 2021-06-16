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
        $isAdmin = Auth::isAdmin();
        if ($isAdmin == true) {
            $data = $_POST;
            $table = $this->table('comments');
            $table->update($id, $data);
            header("Refresh:0");
        }
    }

    public function insert($action)
    {
        $isAdmin = Auth::isAdmin();
        if ($isAdmin == true) {
            $data = $_POST;
            $table = $this->table('comments');
            $table->insert($data);
            header("Refresh:0");
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
            $isAdmin = Auth::isAdmin();
            if ($isAdmin == true) {
                $table = $this->table('comments');
                $trad = new App();
                $pageTitle = $trad->translate('comments');
                $table = $table->findAll();
                //var_dump($table);exit();
                $this->render('comments', ['pageTitle' => $pageTitle, 'comments' => $table], 'backend');
            }
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
            $isAdmin = Auth::isAdmin();
            if ($isAdmin == true) {
                $comments = rtrim('comments', 's');
                $name = $comments;
                $table = $this->table($comments);
                $comment = $table->one($id);
                $pageTitle = 'Commentaire n°' . $comment->id;
                $this->render('single-' . $name, ['pageTitle' => $pageTitle, 'id' => $id, $name => $comment], 'backend');
            }

        }
    }
}