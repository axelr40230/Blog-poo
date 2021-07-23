<?php

namespace App\Table;

use App\App;
use App\Entity\UserEntity;
use App\FormValidator;

class UserTable extends Table
{
    /**
     * @return string
     */
    public function getTable(): string
    {
        return 'users';
    }

    public function getEntity(): string
    {
        return UserEntity::class;
    }

    /**
     * Requête de récupération de l'auteur // Author recovery request
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

    public function update($id, $data)
    {
        //var_dump($data);
        $req = "UPDATE {$this->getTable()} SET first_name=?, last_name=?, email=?, status=?, modify_at=NOW() WHERE id={$id}";
        $query = App::db()->pdo()->prepare($req);

        $query->execute([
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['status']
        ]);
    }

    public function userAuth($data)
    {
        //var_dump($data);exit();
        if (isset($data) and !empty($data['email']) and !empty($data['password'])) {
            $email = htmlspecialchars($data['email']);
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
        } else {
            return false;
        }


    }

    public function userVerif($data)
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
        } else {

            return false;
        }


    }

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
        //var_dump($user);exit();


        if ($count == 0) {
            return false;
        } else {
            $user = $user->token;
            $url = App::url('') . 'change?token=' . $user;

            return $infos = ['email' => $email, 'url' => $url];

        }
    }

    public function howManyUsers()
    {
        $req = "SELECT * FROM {$this->getTable()}";
        $query = App::db()->pdo()->query($req);


        return $count = $query->rowCount();
    }

    public function validUser($token)
    {
        $status = 'user';
        $req = "UPDATE {$this->getTable()} SET status=:status, modify_at=NOW() WHERE token=:token";
        //var_dump($req);
        $query = App::db()->pdo()->prepare($req);

        $query->execute([
            'status' => $status,
            'token' => $token
        ]);

        return true;
    }

    public function showColumn($for)
    {
        $req = "SHOW COLUMNS FROM {$this->getTable()} LIKE '{$for}'";
        $query = App::db()->pdo()->query($req);
        $query->setFetchMode(\PDO::FETCH_ASSOC);
        $options = $query->fetch();

        return $options;
    }

    public function delete($id)
    {
        $req = "DELETE FROM {$this->getTable()} WHERE id = :id";
        $result = App::db()->pdo()->prepare($req);
        $result->execute([
            'id' => $id
        ]);

        return true;
    }

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

        if ($count == 0) {
            return false;
        } elseif ($password != $password_confirmed) {
            return false;
        } else {
            $options = [
                'cost' => 10,
            ];
            $pass_hash = password_hash($password, PASSWORD_DEFAULT, $options);

            $req = "UPDATE {$this->getTable()} SET password=:password, modify_at=NOW() WHERE id=:id";
            //var_dump($req);
            $query = App::db()->pdo()->prepare($req);

            $query->execute([
                'password' => $pass_hash,
                'id' => $id
            ]);

            return true;
        }
    }
}