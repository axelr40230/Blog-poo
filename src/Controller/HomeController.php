<?php

namespace App\Controller;


class HomeController extends Controller
{
    public function home()
    {
        $pageTitle = 'Accueil';
        $this->render('index', ['pageTitle' => $pageTitle], 'frontend');
    }

}