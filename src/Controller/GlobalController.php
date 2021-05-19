<?php
namespace App\Controller;

class GlobalController extends Controller
{
    public function contact()
    {
        $pageTitle = 'Me contacter';
        $this->render('contact', ['pageTitle' => $pageTitle], 'frontend');
    }

    public function notFound()
    {
        $pageTitle = 'Page introuvable';
        $this->render('404', ['pageTitle' => $pageTitle], 'frontend');
    }

}