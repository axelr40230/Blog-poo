<?php

namespace App\Controller;

use App\App;
use App\Auth;
use App\Mailer;
use App\Session;

/**
 * Class LoginController
 * @package App\Controller
 */
class LoginController extends Controller
{
    /**
     * fait le lien avec la table
     * @param $posts
     * @return mixed
     */
    private function table($posts)
    {
        $posts = ucfirst($posts);
        $posts = rtrim($posts, 's');
        $table = "App\Table\\" . $posts . "Table";

        return $table = new $table();
    }

    /**
     * gère l'affichage de la page de connexion au BO
     */
    public function login()
    {
        $isConnect = Auth::isAuth();
        if ($isConnect == false) {
            $errors = [];
            $pageTitle = 'Bon retour parmi nous !';
            $this->render('login', ['pageTitle' => $pageTitle, 'errors' => $errors], 'backend/login');
        } else {
            $this->goAdmin();
        }
    }

    /**
     * gère l'affichage de la page de création de compte utilisateur
     */
    public function register()
    {
        $errors = [];
        $pageTitle = 'Créer un compte';
        $this->render('register', ['pageTitle' => $pageTitle, 'errors' => $errors], 'backend/login');
    }

    /**
     * gère la création d'un nouveau compte utilisateur
     */
    public function registered()
    {
        $validator = App::validator();
        $validator->validate($_POST, [
            'first_name' => [
                'required',
                'min:2',
                'max:20'
            ],
            'last_name' => [
                'required',
                'min:2',
                'max:20'
            ],
            'password' => [
                'required',
                'min:2',
                'max:8'
            ],
            'email' => [
                'required',
                'email',
            ],
        ]);

        if ($validator->fails() === false) {
            $this->render('register', ['pageTitle' => 'Créer un compte'], 'backend/login');
        }
        $data = $_POST;
        $table = $this->table('users');
        $infos = $table->insert($data);
        if ($infos == false) {
            $errors = 'Oups, quelque chose a mal fonctionné.. retentez votre chance !';
            //echo $errors;exit();
            $pageTitle = 'Créer un compte';
            $this->render('register', ['pageTitle' => $pageTitle, 'errors' => $errors], 'backend/login');
        } else {
            $email = $data['email'];
            $url = $infos['url'];
            $contenu = [
                'content' => $url
            ];
            $mailer = new Mailer();
            $templateFile = $mailer->file('mail-register');
            $message = $mailer->extract($templateFile, $contenu);
            $mailer->send($email, 'Confirmation', $message);
            $pageTitle = 'Votre compte a bien été créé, vous devez le valider grâce à l\'email que nous venons de vous envoyer';
            $this->render('register', ['pageTitle' => $pageTitle], 'backend/login');
        }
    }

    /**
     * gère l'affichage de la page d'oubli du mot de passe
     */
    public function forgotpassword()
    {
        $pageTitle = 'J\'ai oublié mon mot de passe';
        $text = 'Aucun problème, pas facile de se souvenir de tous ces mots de passe. Entrez simplement votre adresse e-mail ci-dessous et nous vous enverrons un lien pour réinitialiser votre mot de passe !';
        $this->render('forgot-password', ['pageTitle' => $pageTitle, 'text' => $text], 'backend/login');
    }

    /**
     * gère l'affichage de la page de demande de réinitialisation du mot de passe
     */
    public function changePassword()
    {
        $text = 'Vous pouvez choisir un nouveau mot de passe';
        $pageTitle = 'Réinitialiser mon mot de passe';
        $this->render('new-password', ['pageTitle' => $pageTitle, 'text' => $text], 'backend/login');
    }

    /**
     * gestion du formulaire de changement de mot de passe
     */
    public function changedPassword()
    {
        $validator = App::validator();
        $validator->validate($_POST, [
            'password' => [
                'required',
                'min:2',
                'max:8'
            ]
        ]);

        if ($validator->fails() === false) {
            $pageTitle = 'Oups, il y a eu un souci.';
            $text = 'Veuillez recommencer !';
            $this->render('new-password', ['pageTitle' => $pageTitle, 'text' => $text], 'backend/login');
        }
        if (isset($_GET['token'])) {
            $token = $_GET['token'];
            $table = $this->table('users');
            $user = $table->oneWithToken($token);
            if ($user == true) {
                $user = $table->changePass($token);
                if ($user == false) {
                    $text = 'Nous n\'avons pas trouvé de compte pour cet utilisateur';
                    $pageTitle = 'Réinitialisation de mot de passe';
                    $this->render('new-password', ['pageTitle' => $pageTitle, 'text' => $text], 'backend/login');
                } else {
                    $text = 'Le mot de passe à bien été changé';
                    $url = App::url('login');
                    header("Location: {$url}");
                }
            } else {
                return 'Votre lien ne semble pas fonctionner';
            }
        } else {
            return 'Votre lien ne semble pas fonctionner';
        }
    }

    /**
     * formulaire de demande de changement de mot de passe
     */
    public function retrievepassword()
    {
        $validator = App::validator();
        $validator->validate($_POST, [
            'email' => [
                'required',
                'email',
                'exist:users'
            ]
        ]);

        if ($validator->fails() === false) {
            $pageTitle = 'Oups, il y a eu un souci.';
            $text = 'Veuillez recommencer !';
            $this->render('forgot-password', ['pageTitle' => $pageTitle, 'text' => $text], 'backend/login');
        }
        $data = $_POST;
        $table = $this->table('users');
        $infos = $table->emailVerif($data);
        $email = $infos['email'];
        $url = $infos['url'];
        $contenu = [
            'content' => $url
        ];
        if ($infos == false) {
            $text = 'Nous n\'avons pas trouvé cet email';
            $pageTitle = 'Mot de passe oublié';
            $this->render('forgot-password', ['pageTitle' => $pageTitle, 'text' => $text], 'backend/login');
        } else {
            $mailer = new Mailer();
            $templateFile = $mailer->file('mail-password');
            $message = $mailer->extract($templateFile, $contenu);
            $mailer->send($email, 'Modifier votre mot de passe', $message);
            $text = 'Un email vous a été envoyé';
            $pageTitle = 'Demande envoyée';
            $this->render('forgot-password', ['pageTitle' => $pageTitle, 'text' => $text], 'backend/login');
        }
    }


    /**
     * gestion du formulaire de connexion au BO
     */
    public function connect()
    {
        $validator = App::validator();
        $validator->validate($_POST, [
            'password' => [
                'required',
                'min:2',
                'max:8'
            ],
            'email' => [
                'required',
                'email',
                'exist:users'
            ]
        ]);

        if ($validator->fails() === false) {
            $pageTitle = 'Oups, il y a eu un souci.<br/>Veuillez recommencer !';
            $this->render('login', ['pageTitle' => $pageTitle], 'backend/login');
        }
        $data = $_POST;
        $table = $this->table('users');
        $user = $table->userAuth($data);
        if ($user == false) {
            $pageTitle = 'Bon retour parmi nous !';
            $this->render('login', ['pageTitle' => $pageTitle], 'backend/login');
        } else {
            $session = new Session();
            $session->set('user', $user);
            $user = $session->get('user');

            if ($user->status == 'admin') {
                $this->goAdmin();
            } else {
                $this->goFront();
            }
        }
    }

    /**
     * permet de se rendre à la page tableau de bord d'administration
     */
    public function goAdmin()
    {
        $url = App::url('admin');
        header("Location: {$url}");
    }

    /**
     * permet de se rendre sur la page d'accueil du site
     */
    public function goFront()
    {
        $url = App::url('');
        header("Location: {$url}");
    }

    /**
     * déconnexion du BO
     */
    public function logout()
    {
        $session = new Session();
        $session->clear();
        $url = App::url('login');
        header("Location: {$url}");
    }

    /**
     * confirmation de compte utilisateur
     */
    public function confirm()
    {
        if (isset($_GET['token'])) {
            $token = $_GET['token'];
            $table = $this->table('users');
            $user = $table->validUser($token);
            if ($user == true) {
                $this->goConfirmed();
            } else {
                echo 'Votre lien ne semble pas fonctionner';
            }
        } else {
            echo 'Votre lien ne semble pas fonctionner';
        }
    }

    /**
     * permet d'afficher la page de confirmation de compte utilisateur validé
     */
    public function goConfirmed()
    {
        $url = App::url('confirmed');
        header("Location: {$url}");
    }

    /**
     * gère l'affichage de la page de confirmation de compte utilisateur validé
     */
    public function confirmed()
    {
        $text = 'Merci de votre confirmation, vous pouvez désormais vous connecter à votre compte';
        $pageTitle = 'Bienvenue parmi nous !';
        $this->render('confirmed', ['pageTitle' => $pageTitle, 'text' => $text], 'backend/login');
    }

}