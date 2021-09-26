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
     * makes the link with the users table
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
     * allows you to update a user
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
     * allows you to add a user
     * permet d'ajouter un utilisateur
     */
    public function insert()
    {
        if (Auth::isAdmin()) {
            $data = $_POST;
            $table = $this->table('users');
            $table->insert($data);
            header("Refresh:0");
        }
    }

    /**
     * list all users
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
                    $user->created_at = $user->date_fr('exact', 'created_at');
                }
                $this->render('users', ['pageTitle' => $pageTitle, 'users' => $users], 'backend');
            }
        }
    }

    /**
     * allows you to edit a user
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
                $date = $user->date_fr('exact', 'created_at');
                $trad = new App();
                $status = $trad->translate($user->status);
                $pageTitle = 'Editer l\'utilisateur';
                $this->render('single-' . $users, ['pageTitle' => $pageTitle, 'id' => $id, 'user' => $user, 'status' => $status, 'date' => $date], 'backend');

            }
        }
    }

    /**
     * deleting a user
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
                }
                header("Refresh:0");

            }
        }
    }
}