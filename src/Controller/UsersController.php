<?php

namespace App\Controller;

use App\App;

class UsersController extends Controller
{
    /**
     * fait le lien avec la table users
     * @param $users
     * @return mixed
     */
    public function table($users)
    {
        $users = ucfirst($users);
        $users = rtrim($users, 's');
        $table = "App\Table\\" . $users . "Table";

        return $table = new $table();
    }

    /**
     * permet de mettre à jour un utilisateur
     * @param $id
     */
    public function update($id)
    {
        if ($this->isAdmin()) {
            $data = $_POST;
            $table = $this->table('users');
            $table->update($id, $data);
            header("Refresh:0");
        }
    }

    /**
     * permet d'ajouter un utilisateur
     * @param $action
     */
    public function insert($action)
    {
        if ($this->isAdmin()) {
            $data = $_POST;
            $table = $this->table('users');
            $table->insert($data);
            header("Refresh:0");
        }
    }

    /**
     * liste tous les utilisateurs
     */
    public function list()
    {
        if ($this->isConnected()) {
            if ($this->isAdmin()) {
                $table = $this->table('users');
                $trad = new App();
                $pageTitle = $trad->translate('users');
                $table = $table->findAll();
                $this->render('users', ['pageTitle' => $pageTitle, 'users' => $table], 'backend');
            }
        }
    }

    /**
     * permet d'éditer un utilisateur
     * @param $id
     */
    public function edit($id)
    {
        if ($this->isConnected()) {
            if ($this->isAdmin()) {
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

    /**
     * suppression d'un utilisateur
     * @param $id
     */
    public function delete($id)
    {
        if ($this->isConnected()) {
            if ($this->isAdmin()) {
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