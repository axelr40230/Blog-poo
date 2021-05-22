<?php
namespace App\Controller;

class AdminController extends Controller
{
    public function admin()
    {
        //var_dump($_SESSION);
        $pageTitle = 'Tableau de bord';
        $this->render('admin', ['pageTitle' => $pageTitle], 'backend');
    }

    public function notFound()
    {
        $pageTitle = 'Page introuvable';
        $this->render('404', ['pageTitle' => $pageTitle], 'backend');
    }

}