<?php


namespace App\Router;


use App\App;
use App\Auth;

/**
 * Class RouterException
 * @package App\Router
 */
class RouterException extends \Exception
{
    /**
     * RouterException constructor.
     * permet d'afficher la bonne 404
     * display the correct 404
     */
    public function __construct()
    {
        $isAdmin = Auth::isAdmin();
        if ($isAdmin == true) {
            $url = App::url('admin/404');
            header("Location: {$url}");
        } else {
            $url = App::url('404');
            header("Location: {$url}");
        }
    }
}