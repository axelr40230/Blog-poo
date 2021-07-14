<?php

namespace App\Controller;

use App\App;
use App\Auth;

class AdminController extends Controller
{
    /**
     * Gère la page du tableau de bord d'administration si l'utilisateur est connecté avec statut administrateur
     */
    public function admin()
    {
        if ($this->isConnected()) {
            if ($this->isAdmin()) {
                $pageTitle = 'Tableau de bord';
                $this->render('admin', ['pageTitle' => $pageTitle], 'backend');
            }
        }
    }

    /**
     * Gère page 404
     */
    public function notFound()
    {
        $pageTitle = 'Page introuvable';
        $this->render('404', ['pageTitle' => $pageTitle], 'backend');
    }

}