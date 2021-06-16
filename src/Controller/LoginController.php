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
        $posts = rtrim($posts, 's');
        $table = "App\Table\\" . $posts . "Table";

        return $table = new $table();
    }

    public function login()
    {
        $isConnect = Auth::isAuth();
        if ($isConnect == false) {
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
        if ($user == false) {
            $errors = 'Oups, quelque chose a mal fonctionné.. retentez votre chance !';
            //echo $errors;exit();
            $pageTitle = 'Créer un compte';
            $this->render('register', ['pageTitle' => $pageTitle, 'errors' => $errors], 'backend/login');
        } else {
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

    public function changePassword($id)
    {
        $errors = [];
        $pageTitle = 'Réinitialiser mon mot de passe';
        $this->render('new-password', ['pageTitle' => $pageTitle, 'errors' => $errors], 'backend/login');
    }

    public function changedPassword($id)
    {
        $data = $_POST;
        $table = $this->table('users');
        $user = $table->changePass($id);
        if ($user == false) {
            $errors = 'Nous n\'avons pas trouvé de compte pour cet utilisateur';
            $pageTitle = 'Réinitialisation de mot de passe';
            $this->render('new-password', ['pageTitle' => $pageTitle, 'errors' => $errors], 'backend/login');
        } else {
            $errors = 'Le mot de passe à bien été changé';
            $url = App::url('login');
            header("Location: {$url}");
            exit();
        }
    }

    public function retrievepassword()
    {
        $data = $_POST;
        //var_dump($data);exit();
        $table = $this->table('users');
        $user = $table->emailVerif($data);
        if ($user == false) {
            $errors = 'Nous n\'avons pas trouvé cet email';
            //echo $errors;exit();
            $pageTitle = 'Mot de passe oublié';
            $this->render('forgot-password', ['pageTitle' => $pageTitle, 'errors' => $errors], 'backend/login');
        } else {
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
        if ($user == false) {
            $errors = 'Oups, quelque chose a mal fonctionné.. retentez votre chance ou créez un compte !';
            //echo $errors;exit();
            $pageTitle = 'Connexion au back office';
            $this->render('login', ['pageTitle' => $pageTitle, 'errors' => $errors], 'backend/login');
        } else {
            $session = new Session();
            $session->set('user', $user);
            $user = $session->get('user');

            if($user->status == 'admin') {
                $this->goAdmin();
            }else{
                $this->goFront();
            }
        }
    }

    public function goAdmin()
    {
        $url = App::url('admin');
        header("Location: {$url}");
        exit();
    }

    public function goFront()
    {
        $url = App::url('');
        header("Location: {$url}");
        exit();
    }

    public function logout()
    {
        $session = new Session();
        $session->clear();
        $url = App::url('login');
        header("Location: {$url}");
        exit();
    }

    public function confirm(){
        if(isset($_GET['token'])) {
            $token = $_GET['token'];
            $table = $this->table('users');
            $user = $table->validUser($token);
            if($user == true){
                $this->goConfirmed();
            }else{
                echo 'Votre lien ne semble pas fonctionner';
            }
        }else{
            echo 'Votre lien ne semble pas fonctionner';
        }
    }

    public function goConfirmed(){
        $url = App::url('confirmed');
        header("Location: {$url}");
        exit();
    }

    public function confirmed() {
        $errors = 'Merci de votre confirmation, vous pouvez désormais vous connecter à votre compte';
        $pageTitle = 'Bienvenue';
        $this->render('confirmed', ['pageTitle' => $pageTitle, 'errors' => $errors], 'backend/login');
    }

}