<?php

namespace App\Controller;

use App\App;
use App\Auth;

class CommentsController extends Controller
{
    /**
     * @param $comments
     * @return mixed
     */
    public function table($comments)
    {
        $comments = ucfirst($comments);
        $comments = rtrim($comments, 's');
        $table = "App\Table\\" . $comments . "Table";

        return $table = new $table();
    }


    /**
     * @param $slug
     */
    public function addComment($slug)
    {
        $data = $_POST;
        $table = $this->table('comments');
        $tablePost = $this->table('posts');
        $post = $tablePost->oneBySlug($slug);
        $id = $post->id;
        $table->insert($id, $data);
        if ($table == true) {
            header("Refresh:0");
        }
    }

    /**
     *
     */
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

    /**
     * @param $id
     */
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
                $table = $this->table('comments');
                $comment = $table->one($id);
                if ($comment == false) {
                    $url = App::url('admin/404');
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
    }
}