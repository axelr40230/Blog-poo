<?php


namespace App;


class Auth
{
    public static function isAuth()
    {
        $session = new Session();
        if (is_null($session->get('user'))) {

            return false;

        } else {

            return true;
        }
    }

    public static function isAdmin()
    {
        $session = new Session();
        $user = $session->get('user');
        $status = $user->status;
        if ($status == 'admin') {

            return true;

        } else {
            $url = App::url('');
            header("Location: {$url}");
            exit();
        }
    }

}