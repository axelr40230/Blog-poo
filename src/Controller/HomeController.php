<?php

namespace App\Controller;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends Controller
{
    /**
     * manages the display of the front page home page
     * gère l'affichage de la page d'accueil en front
     */
    public function home()
    {
        $pageTitle = 'Accueil';
        $this->render('index', ['pageTitle' => $pageTitle], 'frontend');
    }

}