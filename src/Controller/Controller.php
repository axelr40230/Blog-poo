<?php

namespace App\Controller;

use App\App;
use App\Auth;

class Controller
{

    /** RENDER FUNCTION
     * @param string $path
     * @param array $variables
     */
    public function render(string $path, array $variables = [], string $folder): void
    {
        extract($variables);
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

}