<?php

namespace App\Controller;

use App\App;
use App\Mailer;
use App\Table\UserTable;

class CommentsController extends Controller
{
    /**
     * fait le lien avec la table commentaires
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
     * permet d'ajouter un commentaire + envoi de la notification utilisateur
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
            $infos = ['content' => $mailUrl];
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
     * liste tous les commentaires
     */
    public function list()
    {
        if ($this->isConnected()) {
            if ($this->isAdmin()) {
                $table = $this->table('comments');
                $trad = new App();
                $pageTitle = $trad->translate('comments');
                $comments = $table->findAll();
                $statusTranslate = function () {
                    echo 'patate';
                };
                foreach ($comments as $comment) {
                    $infos = new UserTable();
                    $id_author = $comment->author;
                    $author = $infos->author($id_author);
                    $first_name = $author->first_name;
                    $last_name = $author->last_name;
                }
                $this->render('comments', ['pageTitle' => $pageTitle, 'comments' => $comments, 'status' => $statusTranslate, 'first_name' => $first_name, 'last_name' => $last_name], 'backend');
            }
        }
    }

    /**
     * permet d'éditer un commentaire
     * @param $id
     */
    public function edit($id)
    {
        if ($this->isConnected()) {
            if ($this->isAdmin()) {
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
     * confirme l'envoi du commentaire pour l'utilisateur
     */
    public function confirm()
    {
        $pageTitle = 'Commentaire en attente de validation';
        $this->render('confirmation', ['pageTitle' => $pageTitle], 'frontend');
    }


    /**
     * permet de mettre à jour un commentaire
     * @param $id
     */
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
        $infos = ['content' => $prenom];

        if($status == 'approuved') {
            $mailer = new Mailer();
            $templateFile = $mailer->file('mail-approuved');
            $message = $mailer->extract($templateFile, $infos);
            $mailer->send($email, 'Votre message est en ligne', $message);
        }

        header("Refresh:0");
    }
}