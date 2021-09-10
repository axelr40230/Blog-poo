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
     * Checks if the user is logged in
     * @return bool
     */
    public static function isAuth(): bool
    {
        $session = new Session();

        return !is_null($session->get('user'));
    }

    /**
     * Vérifie si l'utilisateur est un administrateur
     * Checks if the user is an administrator
     * @return bool
     */
    public static function isAdmin(): bool
    {
        $session = new Session();
        $user = $session->get('user');
        if ($user->status == 'user') {

            return false;
        }

        return true;
    }

}