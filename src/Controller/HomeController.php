<?php

namespace App\Controller;


class HomeController extends Controller
{
    /**
     * gère l'affichage de la page d'accueil en front
     */
    public function home()
    {
        $pageTitle = 'Accueil';
        $this->render('index', ['pageTitle' => $pageTitle], 'frontend');
    }

}