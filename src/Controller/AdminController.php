<?php
namespace App\Controller;

use App\App;
use App\Auth;

class AdminController extends Controller
{
    public function admin()
    {
        $isConnect = Auth::isAuth();
        if($isConnect == false) {
            $url = App::url('login');
            header("Location: {$url}");
            exit();
        } else {
            $pageTitle = 'Tableau de bord';
            $this->render('admin', ['pageTitle' => $pageTitle], 'backend');
        }

    }

    public function notFound()
    {
        $pageTitle = 'Page introuvable';
        $this->render('404', ['pageTitle' => $pageTitle], 'backend');
    }

}