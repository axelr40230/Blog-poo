<?php

namespace App\Controller;

use App\App;
use App\Auth;
use App\Session;
use App\Table\CommentTable;
use App\Table\PostTable;
use App\Table\UserTable;

/**
 * Class AdminController
 * @package App\Controller
 */
class AdminController extends Controller
{
    /**
     * Manages access and display of the administration dashboard page if the user is logged in with administrator status
     * Gère l'accès et l'affichage de la page du tableau de bord d'administration si l'utilisateur est connecté avec statut administrateur
     */
    public function admin()
    {
        if ($this->isConnected()) {
            if (Auth::isAdmin()) {
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
     * Manage page 404
     * Gère page 404
     */
    public function notFound()
    {
        $pageTitle = 'Page introuvable';
        $this->render('404', ['pageTitle' => $pageTitle], 'backend');
    }

    /**
     * Manage the display of the search results page
     * Gère l'affichage de la page des résultats de recherche
     */
    public function search()
    {
        $pageTitle = 'Résultats de recherche';
        $this->render('search', ['pageTitle' => $pageTitle], 'backend');
    }

    /**
     * Manages the display of search results
     * Gère l'affichage des résultats d'une recherche
     */
    public function results()
    {
        $results = [
            'users' => (new UserTable())->search($_POST['search'], ['first_name', 'last_name', 'email']),
            'posts' => (new PostTable())->search($_POST['search'], ['title', 'slug', 'introduction', 'content']),
            'comments' => (new CommentTable())->search($_POST['search'], ['comment'])
        ];
        $users = $results['users'];
        $posts = $results['posts'];
        $comments = $results['comments'];

        $countUsers = count($users);
        $countPosts = count($posts);
        $countComments = count($comments);

        $count = $countUsers + $countPosts + $countComments;

        foreach ($users as $user) {
            $user->status = App::translate($user->status);
        }

        foreach ($posts as $post) {
            $infos = new UserTable();
            $post->author = $infos->author($post->author);
        }

        foreach ($comments as $comment) {
            $infos = new UserTable();
            $comment->author = $infos->author($comment->author);
        }

        if ($count === 0) {
            $pageTitle = "Aucun résultat de recherche, essayez autre chose !";
        } elseif ($count === 1) {
            $pageTitle = "Il n'y qu'un seul résultat !";
        }

        $pageTitle = 'Il y a ' . $count . ' résultats de recherche';
        $this->render('search', ['pageTitle' => $pageTitle, 'count' => $count, 'countUsers' => $countUsers, 'countPosts' => $countPosts, 'countComments' => $countComments, 'users' => $users, 'posts' => $posts, 'comments' => $comments], 'backend');
    }

}