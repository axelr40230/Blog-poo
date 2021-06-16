<?php

namespace App\Controller;

use App\App;
use App\Auth;
use App\Session;

class AdminController extends Controller
{
    public function admin()
    {
        $isConnect = Auth::isAuth();
        if ($isConnect == false) {
            $url = App::url('login');
            header("Location: {$url}");
            exit();
        } else {
            $isAdmin = Auth::isAdmin();
            if ($isAdmin == true) {
                $pageTitle = 'Tableau de bord';
                $this->render('admin', ['pageTitle' => $pageTitle], 'backend');
            }
        }

    }

    public function notFound()
    {
        $pageTitle = 'Page introuvable';
        $this->render('404', ['pageTitle' => $pageTitle], 'backend');
    }

}