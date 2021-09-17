<?php

namespace App\Table;

use App\App;
use App\Entity\UserEntity;

/**
 * Class UserTable
 * @package App\Table
 */
class UserTable extends Table
{
    /**
     * permet de travailler sur la table des utilisateurs
     * allows you to work on the users table
     * @return string
     */
    public function getTable(): string
    {
        return 'users';
    }

    /**
     * permet de faire le lien avec la bonne entity
     * allows you to make the link with the right entity
     * @return string
     */
    public function getEntity(): string
    {
        return UserEntity::class;
    }

    /**
     * Requête de récupération de l'auteur
     * Author recovery request
     * @param string $id_author
     * @return mixed
     */
    public function author(string $id_author)
    {
        $author = App::db()->pdo()->prepare('SELECT * FROM ' . $this->getTable() . ' WHERE id = ?');
        $author->execute(array($id_author));
        $author->setFetchMode(\PDO::FETCH_CLASS, $this->getEntity());

        return $author->fetch();
    }

    /**
     * mise à jour d'un utilisateur
     * updating a user
     * @param $id
     * @param $data
     */
    public function update($id, $data)
    {
        $req = "UPDATE {$this->getTable()} SET first_name=?, last_name=?, email=?, status=?, modify_at=NOW() WHERE id={$id}";
        $query = App::db()->pdo()->prepare($req);

        $query->execute([
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['status']
        ]);
    }

    /**
     * permet de vérfier l'existance d'un utilisateur pour l'authentifier
     * allows you to check the existence of a user to authenticate
     * @param $data
     * @return false|mixed
     */
    public function userAuth($data)
    {
        if (isset($data) and !empty($data['email']) and !empty($data['password'])) {
            $email = $data['email'];
            $password = htmlspecialchars($data['password']);
            $req = "SELECT * FROM {$this->getTable()} WHERE email =:email";
            $query = App::db()->pdo()->prepare($req);

            $query->execute(array(
                    'email' => $email)
            );

            $count = $query->rowCount();
            $query->setFetchMode(\PDO::FETCH_CLASS, $this->getEntity());
            $user = $query->fetch();

            if ($count == 0) {
                return false;
            } else {
                $pass = $password;
                $hash = $user->password;
                $isPasswordCorrect = password_verify($pass, $hash);

                if (!$isPasswordCorrect) {
                    return false;
                } else {
                    if ($user->status == 'not confirmed') {
                        return false;
                    } else {
                        return $user;
                    }

                }
            }

        }

        return false;

    }

    /**
     * vérifie l'email utilisateur
     * verify user email
     * @param $email
     * @return bool
     */
    public function emailCheck($email)
    {
        $req = "SELECT * FROM {$this->getTable()} WHERE email =:email";
        $query = App::db()->pdo()->prepare($req);
        $query->execute(array(
                'email' => $email)
        );
        $count = $query->rowCount();
        $query->setFetchMode(\PDO::FETCH_CLASS, $this->getEntity());
        $query->fetch();

        if ($count == 0) {
            return false;
        }
        return true;
    }

    /**
     * insertion d'un utilisateur
     * inserting a user
     * @param $data
     * @return array|false
     */
    public function insert($data)
    {
        if (!empty($data['first_name']) and !empty($data['last_name']) and !empty($data['email']) and !empty($data['password']) and !empty($data['password_confirmed'])) {
            $first_name = htmlspecialchars($data['first_name']);
            $last_name = htmlspecialchars($data['last_name']);
            $email = htmlspecialchars($data['email']);
            $password = htmlspecialchars($data['password']);
            $password_confirmed = htmlspecialchars($data['password_confirmed']);
            $status = 'not confirmed';

            $req = "SELECT * FROM {$this->getTable()} WHERE email =:email";
            $query = App::db()->pdo()->prepare($req);

            $query->execute(array(
                    'email' => $email)
            );

            $count = $query->rowCount();
            $query->setFetchMode(\PDO::FETCH_CLASS, $this->getEntity());
            $user = $query->fetch();

            if ($count != 0) {
                return false;
            } elseif ($password != $password_confirmed) {
                return false;
            } else {
                $options = [
                    'cost' => 10,
                ];
                $pass_hash = password_hash($password, PASSWORD_DEFAULT, $options);
                // Le message

                $token = uniqid();

                $url = App::url('') . 'confirm?token=' . $token;

                $infos = ['email' => $email, 'url' => $url];


                $register = App::db()->pdo()->prepare('INSERT INTO users(first_name, last_name, email, password, status, created_at, modify_at, token) VALUES(:first_name, :last_name, :email, :password, :status, NOW(), NOW(), :token)');
                $register->execute(array(
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'email' => $email,
                        'password' => $pass_hash,
                        'status' => $status,
                        'token' => $token
                    )
                );

                return $infos;
            }
        }

        return false;


    }

    /** vérifie l'email et génération d'un token unique pour préparer la confirmation d'inscription
     * verifies the email and generates a unique token to prepare the registration confirmation
     * @param $data
     * @return array|false
     */
    public function emailVerif($data)
    {
        $email = $data['email'];
        $req = "SELECT * FROM {$this->getTable()} WHERE email =:email";
        $query = App::db()->pdo()->prepare($req);
        $query->execute(array(
                'email' => $email)
        );
        $count = $query->rowCount();
        $query->setFetchMode(\PDO::FETCH_CLASS, $this->getEntity());
        $user = $query->fetch();

        if ($count == 0) {
            return false;
        } else {
            $user = $user->token;
            $url = App::url('') . 'change?token=' . $user;

            return $infos = ['email' => $email, 'url' => $url];

        }
    }

    /**
     * retourne le nombre d'utilisateurs enregistrés
     * returns the number of registered users
     * @return int
     */
    public function howManyUsers()
    {
        $req = "SELECT * FROM {$this->getTable()}";
        $query = App::db()->pdo()->query($req);


        return $count = $query->rowCount();
    }

    /**
     * Requête de récupération d'une instance de table
     * Query to retrieve a table instance
     * @param $id
     * @return mixed
     */
    public function oneWithToken($token)
    {
        $req = "SELECT * FROM {$this->getTable()} WHERE token=:token";
        $query = App::db()->pdo()->prepare($req);

        $query->execute([
            'token' => $token
        ]);
        $query->setFetchMode(\PDO::FETCH_CLASS, $this->getEntity());
        $count = $query->rowCount();
        if ($count === 0) {
            return false;
        }
        return $user = $query->fetch();
    }

    /**
     * vérifie le token pour confirmer l'utilisateur
     * check the token to confirm the user
     * @param $token
     * @return bool
     */
    public function validUser($token)
    {
        $status = 'user';
        $req = "UPDATE {$this->getTable()} SET status=:status, modify_at=NOW() WHERE token=:token";
        $query = App::db()->pdo()->prepare($req);

        $query->execute([
            'status' => $status,
            'token' => $token
        ]);

        return true;
    }

    /**
     * suppression d'un utilisateur
     * deleting a user
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $req = "DELETE FROM {$this->getTable()} WHERE id = :id";
        $result = App::db()->pdo()->prepare($req);
        $result->execute([
            'id' => $id
        ]);

        return true;
    }

    /** modification de mot de passe
     * change password
     * @param $token
     * @return bool
     */
    public function changePass($token)
    {
        $data = $_POST;
        $password = htmlspecialchars($data['password']);
        $password_confirmed = htmlspecialchars($data['password_confirmed']);
        $req = "SELECT * FROM {$this->getTable()} WHERE token =:token";
        $query = App::db()->pdo()->prepare($req);

        $query->execute(array(
                'token' => $token)
        );
        $count = $query->rowCount();
        $query->setFetchMode(\PDO::FETCH_CLASS, $this->getEntity());
        $user = $query->fetch();
        $id = $user->id;
        $status = $user->status;
        if ($count == 0) {
            return false;
        } elseif ($password != $password_confirmed) {
            return false;
        }
        $options = [
            'cost' => 10,
        ];
        $pass_hash = password_hash($password, PASSWORD_DEFAULT, $options);

        $req = "UPDATE {$this->getTable()} SET password=:password, status=:status, modify_at=NOW() WHERE id=:id";
        $query = App::db()->pdo()->prepare($req);

        $query->execute([
            'password' => $pass_hash,
            'status' => $status,
            'id' => $id
        ]);

        return true;
    }
}