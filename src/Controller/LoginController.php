<?php
namespace App\Controller;

class LoginController extends Controller
{
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


    public function connect()
    {
        $data = $_POST;
        $table = $this->table('users');
        $user = $table->userAuth($data);

        $pageTitle = 'Tableau de bord';
        $this->render('admin', ['pageTitle' => $pageTitle, 'user' => $user], 'backend');
    }

}