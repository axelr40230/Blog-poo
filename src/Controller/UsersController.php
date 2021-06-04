<?php

namespace App\Controller;

use App\App;
use App\Auth;
use App\Table\UserTable;

class UsersController extends Controller
{
    private function table($users)
    {
        $users = ucfirst($users);
        $users = rtrim($users, 's');
        $table = "App\Table\\" . $users . "Table";

        return $table = new $table();
    }

    /**
     * @param $id
     */
    public function show($id)
    {
        $isConnect = Auth::isAuth();
        if ($isConnect == false) {
            $url = App::url('login');
            header("Location: {$url}");
            exit();
        } else {
            $table = new UserTable();
            $user = $table->one($id);
            $pageTitle = $user->title;
            $this->render('single', ['pageTitle' => $pageTitle, 'id' => $id, 'post' => $user], 'frontend');
        }
    }

    /**
     *
     */
    public function all()
    {
        $table = new UserTable();
        $pageTitle = 'Mes articles';
        $this->render('posts', ['pageTitle' => $pageTitle, 'posts' => $table->findByStatus('publish')], 'frontend');
    }

    /**
     * @param $id
     * @todo A finaliser
     */
    public function addComment($id)
    {
        $data = $_POST;
        var_dump($data);
        var_dump($id);
    }

    public function update($id)
    {
        $data = $_POST;
        $table = $this->table('users');
        $table->update($id, $data);
        header("Refresh:0");
    }

    public function insert($action)
    {
        $data = $_POST;
        $table = $this->table('users');
        $table->insert($data);
        header("Refresh:0");
    }

    public function list()
    {
        $isConnect = Auth::isAuth();
        if ($isConnect == false) {
            $url = App::url('login');
            header("Location: {$url}");
            exit();
        } else {
            $table = $this->table('users');
            $trad = new App();
            $pageTitle = $trad->translate('users');
            $table = $table->findAll();
            //var_dump($table);exit();
            $this->render('users', ['pageTitle' => $pageTitle, 'users' => $table], 'backend');
        }
    }

    public function edit($id)
    {
        $isConnect = Auth::isAuth();
        if ($isConnect == false) {
            $url = App::url('login');
            header("Location: {$url}");
            exit();
        } else {
            $users = rtrim('users', 's');
            $name = $users;
            $table = $this->table($users);
            $user = $table->one($id);
            $pageTitle = 'Editer l\'utilisateur';
            $this->render('single-' . $name, ['pageTitle' => $pageTitle, 'id' => $id, $name => $user], 'backend');
        }
    }
}