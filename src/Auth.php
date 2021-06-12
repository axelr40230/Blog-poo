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

}