<?php

namespace App\Controller;

use App\App;
use App\Auth;
use App\Env;
use App\Mailer;
use App\Table\PostTable;
use App\Table\UserTable;

/**
 * Class CommentsController
 * @package App\Controller
 */
class CommentsController extends Controller
{
    /**
     * makes the link with the comments table
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
     * allows you to add a comment + send the user notification
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
            $email = Env::get('ADMIN_EMAIL');
            $mailUrl = App::url('admin/comments') . '/' . $commentID;
            $infos = ['content' => $mailUrl];
            $mailer = new Mailer();
            $templateFile = $mailer->file('mail-comment');
            $message = $mailer->extract($templateFile, $infos);
            $mailer->send($email, 'Il y a un commentaire en attente', $message);
            $url = App::url('confirmation');
            header("Location: {$url}");
        }
    }

    /**
     * list all comments
     * liste tous les commentaires
     */
    public function list()
    {
        if ($this->isConnected()) {
            if (Auth::isAdmin()) {
                $table = $this->table('comments');
                $trad = new App();
                $pageTitle = $trad->translate('comments');


                // On détermine sur quelle page on se trouve
                if (isset($_GET['page']) && !empty($_GET['page'])) {
                    $currentPage = (int)strip_tags($_GET['page']);
                } else {
                    $currentPage = 1;
                }

                $totalComments = $table->findAll();

                $nbArticles = count($totalComments);
                // On détermine le nombre d'articles par page
                $parPage = 10;
                // On calcule le nombre de pages total
                $pages = ceil($nbArticles / $parPage);
                // Calcul du 1er article de la page
                $premier = ($currentPage * $parPage) - $parPage;

                $comments = $table->findWithPagination($premier, $parPage);

                foreach ($comments as $comment) {
                    $infos = new UserTable();
                    $comment->author = $infos->author($comment->author);
                }
                $this->render('comments', ['pageTitle' => $pageTitle, 'comments' => $comments, 'currentPage' => $currentPage, 'pages' => $pages], 'backend');
            }
        }
    }

    /**
     * allows you to edit a comment
     * permet d'éditer un commentaire
     * @param $id
     */
    public function edit($id)
    {
        if ($this->isConnected()) {
            if (Auth::isAdmin()) {
                $comment = $this->table('comments')->one($id);
                if ($comment == false) {
                    $this->error();
                }
                $comments = rtrim('comments', 's');
                $authorInfos = new UserTable();
                $comment->author = $authorInfos->author($comment->author);
                $posts = new PostTable();
                $comment->article_id = $posts->get_title($comment->article_id);
                $pageTitle = 'Commentaire n°' . $comment->id;
                $this->render('single-' . $comments, ['pageTitle' => $pageTitle, 'id' => $id, $comments => $comment], 'backend');
            }
        }
    }

    /**
     * confirms sending of the comment for the user
     * confirme l'envoi du commentaire pour l'utilisateur
     */
    public function confirm()
    {
        $pageTitle = 'Commentaire en attente de validation';
        $this->render('confirmation', ['pageTitle' => $pageTitle], 'frontend');
    }


    /**
     * allows you to update a comment
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
        $tableUser = new UserTable();
        $user = $tableUser->one($comment->author);
        $infos = ['content' => $user->first_name];

        if ($status == 'approuved') {
            $mailer = new Mailer();
            $templateFile = $mailer->file('mail-approuved');
            $message = $mailer->extract($templateFile, $infos);
            $mailer->send($user->email, 'Votre message est en ligne', $message);
        }

        header("Refresh:0");
    }
}