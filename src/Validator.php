<?php


namespace App;


class Validator
{
    public static function isEmail($value)
    {
       if(filter_var($value, FILTER_VALIDATE_EMAIL)) return true;
    }
}