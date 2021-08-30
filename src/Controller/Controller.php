<?php

namespace App\Controller;

use App\App;
use App\Auth;
use App\Table\UserTable;

class Controller
{

    /** RENDER FUNCTION
     * @param string $path
     * @param array $variables
     */
    public function render(string $path, array $variables = [], string $folder): void
    {
        extract($variables);
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
        $isConnect = Auth::isAuth();
        if ($isConnect) {
            return true;
        } else {
            $url = App::url('login');
            header("Location: {$url}");
            exit();
        }
    }

    /**
     * administrateur ?
     * @return bool
     */
    public function isAdmin()
    {
        $isAdmin = Auth::isAdmin();
        if ($isAdmin) {
            return true;
        }
    }

    /**
     * @todo finaliser description
     */
    public function error()
    {
        if ($this->isAdmin()) {
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