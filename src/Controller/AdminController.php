<?php
namespace App\Controller;

use App\Table\PostTable;
use App\Table\UserTable;
use App\App;

class AdminController extends Controller
{

    private function table($type)
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

    public function list($type)
    {
        $table = $this->table($type);
        $trad = new App();
        $pageTitle = $trad->translate($type);
        $table = $table->findAll();
        //var_dump($table);exit();
        $this->render($type, ['pageTitle' => $pageTitle, $type => $table], 'backend');
    }

    public function edit($type, $id)
    {
        $type = rtrim($type,'s');
        $name = $type;
        $table = $this->table($type);
        $post = $table->one($id);
        if($type == 'post') :
            $post = $table->one($id);
            $pageTitle = $post->title;
            $this->render('single-'.$name, ['pageTitle' => $pageTitle, 'id'=>$id, $name => $post ], 'backend');
        elseif($type == 'comment') :
            $comment = $table->one($id);
            $pageTitle = 'Commentaire n°'.$comment->id;
            $this->render('single-'.$name, ['pageTitle' => $pageTitle, 'id'=>$id, $name => $post ], 'backend');
            elseif($type == 'user') :
                $pageTitle = 'Editer l\'utilisateur';
        $this->render('single-'.$name, ['pageTitle' => $pageTitle, 'id'=>$id, $name => $post ], 'backend');
            endif;
    }

    public function new($type, $action)
    {
        $type = rtrim($type,'s');
        $name = $type;
        $pageTitle = $action.' '.$type;
        $this->render('insert-'.$name, ['pageTitle' => $pageTitle ], 'backend');
    }

    public function update($type, $id)
    {
        $data = $_POST;
        $table = $this->table($type);
        $table->update($id, $data);
        header("Refresh:0");
    }

    public function insert($type, $action)
    {
        $data = $_POST;
        $table = $this->table($type);
        $table->insert($data);
        header("Refresh:0");
    }

    public function connect()
    {
        $data = $_POST;
        $table = $this->table('users');
        $user = $table->userAuth($data);

        $pageTitle = 'Tableau de bord';
        $this->render('admin', ['pageTitle' => $pageTitle, 'user' => $user], 'backend');
    }

    public function listPosts()
    {
        $table = $this->table('posts');
        //var_dump($table);
        $relation = $table->getRelation();


    }
}