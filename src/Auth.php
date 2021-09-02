<?php


namespace App;

/**
 * Class Auth
 * @package App
 */

class Auth
{
    /**
     * Vérifie si l'utilisateur est connecté
     * @return bool
     */
    public static function isAuth(): bool
    {
        $session = new Session();
        if (!is_null($session->get('user'))) {
            return true;
        }
    }

    /**
     * Vérifie si l'utilisateur est un administrateur
     * @return bool
     */
    public static function isAdmin(): bool
    {
        $session = new Session();
        $user = $session->get('user');
        $status = $user->status;
        if (!$status == 'admin') {
            $url = App::url('');
            header("Location: {$url}");
            exit();
        }
        return true;
    }

}