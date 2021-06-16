<?php


namespace App\Router;


use App\App;
use App\Auth;

class RouterException extends \Exception
{
    public function __construct()
    {
        $isAdmin = Auth::isAdmin();
        if ($isAdmin == true) {
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