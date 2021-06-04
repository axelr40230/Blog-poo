<?php
namespace App\Controller;

use App\App;
use App\Auth;
use App\Session;

class LoginController extends Controller
{
    private function table($posts)
    {
        $posts = ucfirst($posts);
        $posts = rtrim($posts,'s');
        $table = "App\Table\\".$posts."Table";

        return $table = new $table();
    }

    public function login()
    {
        $isConnect = Auth::isAuth();
        if($isConnect == false) {
            $errors = [];
            $pageTitle = 'Connexion au back office';
            $this->render('login', ['pageTitle' => $pageTitle, 'errors' => $errors], 'backend/login');
        } else {
            $this->goAdmin();
        }
    }

    public function register()
    {
        $errors = [];
        $pageTitle = 'Créer un compte';
        $this->render('register', ['pageTitle' => $pageTitle, 'errors' => $errors], 'backend/login');
    }

    public function registered()
    {
        $data = $_POST;
        $table = $this->table('users');
        $user = $table->userVerif($data);
        if ($user == false){
            $errors = 'Oups, quelque chose a mal fonctionné.. retentez votre chance !';
            //echo $errors;exit();
            $pageTitle = 'Créer un compte';
            $this->render('register', ['pageTitle' => $pageTitle, 'errors' => $errors], 'backend/login');
        }else{
            $errors = 'Votre compte a bien été créé, vous devez le valider grâce à l\'email que nous venons de vous envoyer';
            $pageTitle = 'Connexion au back office';
            $this->render('login', ['pageTitle' => $pageTitle, 'errors' => $errors], 'backend/login');
        }

    }

    public function forgotpassword()
    {
        $errors = [];
        $pageTitle = 'J\'ai oublié mon mot de passe';
        $this->render('forgot-password', ['pageTitle' => $pageTitle, 'errors' => $errors], 'backend/login');
    }

    public function retrievepassword()
    {
        $data = $_POST;
        $table = $this->table('users');
        $user = $table->emailVerif($data);
        if ($user == false){
            $errors = 'Nous n\'avons pas trouvé cet email';
            //echo $errors;exit();
            $pageTitle = 'Créer un compte';
            $this->render('forgot-password', ['pageTitle' => $pageTitle, 'errors' => $errors], 'backend/login');
        }else{
            $errors = 'Un email vous a été envoyé';
            $pageTitle = 'Demande envoyée';
            $this->render('forgot-password', ['pageTitle' => $pageTitle, 'errors' => $errors], 'backend/login');
        }
    }


    public function connect()
    {
        $data = $_POST;
        $table = $this->table('users');
        $user = $table->userAuth($data);
        if ($user == false){
            $errors = 'Oups, quelque chose a mal fonctionné.. retentez votre chance ou créez un compte !';
            //echo $errors;exit();
            $pageTitle = 'Connexion au back office';
            $this->render('login', ['pageTitle' => $pageTitle, 'errors' => $errors], 'backend/login');
        }else{
            $this->goAdmin();
        }
    }

    public function goAdmin()
    {
        $url = App::url('admin');
        header("Location: {$url}");
        exit();
    }

    public function logout(){
        session::destroy();
        //var_dump(session::getInstance('id'));
        $url = App::url('login');
        header("Location: {$url}");
        exit();
    }

}