<?php
namespace App\Controller;

use App\Table\PostTable;
use App\Table\UserTable;
use App\App;

class AdminController extends Controller
{

    public function table($type)
    {
        $type = ucfirst($type);
        $type = rtrim($type,'s');
        $table = "App\Table\\".$type."Table";

        return $table = new $table();
    }

    public function login()
    {
        //session_start();
        //var_dump($_SESSION);exit();
        if(isset($_SESSION))
        {
            echo 'connected';
        } else {
            $pageTitle = 'Connexion au back office';
            $this->render('login', ['pageTitle' => $pageTitle], 'backend/login');
        }
    }

    public function register()
    {
        $pageTitle = 'Créer un compte';
        $this->render('register', ['pageTitle' => $pageTitle], 'backend/login');
    }

    public function forgotpassword()
    {
        $pageTitle = 'J\'ai oublié mon mot de passe';
        $this->render('forgot-password', ['pageTitle' => $pageTitle], 'backend/login');
    }

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

    public function connect()
    {
        $data = $_POST;
        $table = $this->table('users');
        $user = $table->userAuth($data);

        $pageTitle = 'Tableau de bord';
        $this->render('admin', ['pageTitle' => $pageTitle, 'user' => $user], 'backend');
    }

}