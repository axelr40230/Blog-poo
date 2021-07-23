<?php

namespace App\Controller;

use App\Session;
use App\Table\CommentTable;
use App\Table\PostTable;
use App\Table\UserTable;

class AdminController extends Controller
{
    /**
     * Gère la page du tableau de bord d'administration si l'utilisateur est connecté avec statut administrateur
     */
    public function admin()
    {
        if ($this->isConnected()) {
            if ($this->isAdmin()) {
                $tableComments = new CommentTable();
                $numberComments = $tableComments->howManyWaiting('waiting');

                $tableUsers = new UserTable();
                $numberUsers = $tableUsers->howManyUsers();

                $tablePosts = new PostTable();
                $numberPosts = $tablePosts->howManyPosts();

                $session = new Session();
                $user = $session->get('user');
                $pageTitle = 'Tableau de bord';
                $this->render('admin', ['pageTitle' => $pageTitle, 'numberComments' => $numberComments, 'numberPosts' => $numberPosts, 'numberUsers' => $numberUsers, 'user' => $user], 'backend');
            }
        }
    }

    /**
     * Gère page 404
     */
    public function notFound()
    {
        $pageTitle = 'Page introuvable';
        $this->render('404', ['pageTitle' => $pageTitle], 'backend');
    }

}