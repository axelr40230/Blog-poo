<?php

namespace App\Controller;

use App\App;
use App\Auth;

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
     * utilisateur connecté ?
     * @return bool
     */
    public function isConnected()
    {
        if (!Auth::isAuth()) {
            $url = App::url('login');
            header("Location: {$url}");
            exit();
        }
        return true;
    }


    /**
     * Oriente vers la bonne page 404 selon le statut utilisateur
     */
    public function error()
    {
        if (Auth::isAdmin()) {
            $url = App::url('admin/404');
            header("Location: {$url}");
            exit();
        } else {
            $url = App::url('404');
            header("Location: {$url}");
            exit();
        }

    }

}