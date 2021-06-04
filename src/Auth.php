<?php


namespace App;


class Auth
{
    public static function isAuth()
    {
        if (is_null(session::getInstance('id'))) {

            return false;
        } else {

            return true;
        }


    }
}