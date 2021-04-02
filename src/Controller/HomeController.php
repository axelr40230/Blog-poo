<?php
namespace App\Controller;

class HomeController
{
    public function home()
    {
        echo 'Je suis la home';
    }

    public function hello($name)
    {
        echo $name;
    }
}