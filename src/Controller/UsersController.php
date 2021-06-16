<?php

namespace App\Controller;

use App\App;
use App\Auth;
use App\Table\UserTable;

class UsersController extends Controller
{
    public function table($users)
    {
        $users = ucfirst($users);
        $users = rtrim($users, 's');
        $table = "App\Table\\" . $users . "Table";

        return $table = new $table();
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
        $isAdmin = Auth::isAdmin();
        if ($isAdmin == true) {
            $data = $_POST;
            $table = $this->table('users');
            $table->update($id, $data);
            header("Refresh:0");
        }
    }

    public function insert($action)
    {
        $isAdmin = Auth::isAdmin();
        if ($isAdmin == true) {
            $data = $_POST;
            $table = $this->table('users');
            $table->insert($data);
            header("Refresh:0");
        }
    }

    public function list()
    {
        $isConnect = Auth::isAuth();
        if ($isConnect == false) {
            $url = App::url('login');
            header("Location: {$url}");
            exit();
        } else {
            $isAdmin = Auth::isAdmin();
            if ($isAdmin == true) {
                $table = $this->table('users');
                $trad = new App();
                $pageTitle = $trad->translate('users');
                $table = $table->findAll();
                $this->render('users', ['pageTitle' => $pageTitle, 'users' => $table], 'backend');
            }
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
            $isAdmin = Auth::isAdmin();
            if ($isAdmin == true) {
                $users = rtrim('users', 's');
                $name = $users;
                $table = $this->table($users);
                $user = $table->one($id);
                if ($user == false) {
                    $url = App::url('admin/404');
                    header("Location: {$url}");
                    exit();
                } else {
                    $pageTitle = 'Editer l\'utilisateur';
                    $this->render('single-' . $name, ['pageTitle' => $pageTitle, 'id' => $id, $name => $user], 'backend');
                }
            }
        }
    }

    public function delete($id)
    {
        $isConnect = Auth::isAuth();
        if ($isConnect == false) {
            $url = App::url('login');
            header("Location: {$url}");
            exit();
        } else {
            $isAdmin = Auth::isAdmin();
            if ($isAdmin == true) {
                $table = $this->table('users');
                $delete = $table->delete($id);
                if ($delete == true) {
                    $url = App::url('admin/users');
                    header("Location: {$url}");
                    exit();
                } else {
                    header("Refresh:0");
                }
            }
        }
    }
}