<?php

namespace App\Controller;

use App\App;
use App\Auth;
use App\Mailer;
use App\Session;
use App\Table\UserTable;

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
        $commentID = $table->insert($id, $data);
        if ($table == true) {
            $email = 'axelr.apl@gmail.com';
            $mailUrl = App::url('admin/comments'). '/' . $commentID;
            $infos = ['{{content}}' => $mailUrl];
            $mailer = new Mailer();
            $templateFile = $mailer->file('mail-comment');
            $message = $mailer->extract($templateFile, $infos);
            $mailer->send($email, 'Il y a un commentaire en attente', $message);
            $url = App::url('confirmation');
            header("Location: {$url}");
            exit();
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

    /**
     *
     */
    public function confirm()
    {
        $pageTitle = 'Commentaire en attente de validation';
        $this->render('confirmation', ['pageTitle' => $pageTitle], 'frontend');
    }

    public function update($id)
    {
        $data = $_POST;
        $status = $data['update'];
        $table = $this->table('comments');
        $comment = $table->one($id);
        $id = $comment->id;
        $table->update($id, $data);
        $author = $comment->author;
        $tableUser = new UserTable();
        $user = $tableUser->one($author);
        $email = $user->email;
        $prenom = $user->first_name;
        $infos = ['{{content}}' => $prenom];

        if($status == 'approuved') {
            $mailer = new Mailer();
            $templateFile = $mailer->file('mail-approuved');
            $message = $mailer->extract($templateFile, $infos);
            $mailer->send($email, 'Votre message est en ligne', $message);
        }

        header("Refresh:0");
    }
}