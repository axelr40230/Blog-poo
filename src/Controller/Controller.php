<?php

namespace App\Controller;

use App\App;
use App\Auth;
use App\Form;
use App\Session;

/**
 * Class Controller
 * @package App\Controller
 */
class Controller
{

    /** RENDER FUNCTION
     * @param string $path
     * @param array $variables
     */
    public function render(string $path, array $variables = [], string $folder): void
    {
        extract($variables);
        $session = new Session();
        $identity = $session->get('user');
        $isConnect = Auth::isAuth();
        $form = new Form();
        $validator = App::validator();
        $translator = function ($term) {
            return App::translate($term);
        };
        ob_start();
        require('pages/templates/' . $folder . '/' . $path . '.php');
        $content = ob_get_clean();
        require('pages/templates/' . $folder . '/layout.php');
    }

    /**
     * user logged in?
     * utilisateur connecté ?
     * @return bool
     */
    public function isConnected()
    {
        if (!Auth::isAuth()) {
            $url = App::url('login');
            header("Location: {$url}");
        }
        return true;
    }


    /**
     * Navigates to the correct 404 page according to user status
     * Oriente vers la bonne page 404 selon le statut utilisateur
     */
    public function error()
    {
        if (Auth::isAdmin()) {
            $url = App::url('admin/404');
            header("Location: {$url}");
        }
        $url = App::url('404');
        header("Location: {$url}");

    }

    /**
     * allows you to go to the administration dashboard page
     * permet de se rendre à la page tableau de bord d'administration
     */
    public function goAdmin()
    {
        $url = App::url('admin');
        header("Location: {$url}");
    }

    /**
     * allows you to go to the home page of the site
     * permet de se rendre sur la page d'accueil du site
     */
    public function goFront()
    {
        $url = App::url('');
        header("Location: {$url}");
    }

}