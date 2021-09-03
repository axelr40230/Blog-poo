<?php

namespace App\Controller;

use App\App;
use App\Auth;
use App\Table\PostTable;

/**
 * Class UsersController
 * @package App\Controller
 */
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
        if (Auth::isAdmin()) {
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
        if (Auth::isAdmin()) {
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
            if (Auth::isAdmin()) {
                $table = $this->table('users');
                $trad = new App();
                $pageTitle = $trad->translate('users');
                $users = $table->findAll();
                foreach ($users as $user) {
                    $user->status = $trad->translate($user->status);
                }
                $this->render('users', ['pageTitle' => $pageTitle, 'users' => $users], 'backend');
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
            if (Auth::isAdmin()) {
                $users = rtrim('users', 's');
                $table = $this->table($users);
                $user = $table->one($id);
                if ($user == false) {
                    $this->error();
                }
                $trad = new App();
                $status = $trad->translate($user->status);
                $postsTable = new PostTable();

                $pageTitle = 'Editer l\'utilisateur';
                $this->render('single-' . $users, ['pageTitle' => $pageTitle, 'id' => $id, $users => $user, 'status' => $status], 'backend');

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
            if (Auth::isAdmin()) {
                $table = $this->table('users');
                $delete = $table->delete($id);
                if ($delete == true) {
                    $url = App::url('admin/users');
                    header("Location: {$url}");
                    exit();
                }
                header("Refresh:0");

            }
        }
    }
}