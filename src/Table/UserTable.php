<?php

namespace App\Table;

use App\App;
use App\Entity\UserEntity;
use App\FormValidator;
use App\Session;

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
        $author = App::db()->pdo()->prepare('SELECT * FROM '.$this->getTable().' WHERE id = ?');
        $author->execute(array($id_author));
        $author->setFetchMode(\PDO::FETCH_CLASS, $this->getEntity());

        return $author->fetch();
    }

    public function update($id, $data)
    {
        $req = "UPDATE {$this->getTable()} SET first_name=?, last_name=?, email=? WHERE id={$id}";
        $query = App::db()->pdo()->prepare($req);

        $query->execute([
            $data['first_name'],
            $data['last_name'],
            $data['email']
        ]);
    }

    public function userAuth($data)
    {
        //var_dump($data);exit();
        if(isset($data) AND !empty($data['email']) AND !empty($data['password'])) {
            $email      = htmlspecialchars($data['email']);
            $password      = htmlspecialchars($data['password']);
            $req = "SELECT * FROM {$this->getTable()} WHERE email =:email";
            $query = App::db()->pdo()->prepare($req);

            $query->execute(array(
                    'email' => $email)
            );

            $count     = $query->rowCount();
            $query->setFetchMode(\PDO::FETCH_CLASS, $this->getEntity());
            $user = $query->fetch();

            //var_dump($user);

            if($count == 0){
                return false;
            } else {
                $pass = $password;
                $hash              = $user->password;
                //var_dump($hash);
                $isPasswordCorrect = password_verify($pass, $hash);

                if(!$isPasswordCorrect) {
                    return false;
                }else{
                    //$session = session::instance();

                    session::setInstance('id', $user->id);
                    session::setInstance('first_name', $user->first_name);
                    session::setInstance('last_name', $user->last_name);
                    session::setInstance('email', $user->email);

                    //var_dump($user);

                    return session::getInstance('id');
                }
            }
            } else {
                return false;
            }


    }

    public function userVerif($data)
    {
        $first_name = htmlspecialchars($data['first_name']);
        $last_name = htmlspecialchars($data['last_name']);
        $email      = htmlspecialchars($data['email']);
        $password      = htmlspecialchars($data['password']);
        $password_confirmed      = htmlspecialchars($data['password_confirmed']);
        $status = 'user';

        $req = "SELECT * FROM {$this->getTable()} WHERE email =:email";
        $query = App::db()->pdo()->prepare($req);

        $query->execute(array(
                'email' => $email)
        );

        $count     = $query->rowCount();
        $query->setFetchMode(\PDO::FETCH_CLASS, $this->getEntity());
        $user = $query->fetch();

        if($count != 0){
            return false;
        }elseif($password != $password_confirmed){
            return false;
        }else{
            $options = [
                'cost' => 10,
            ];
            $pass_hash  = password_hash($password, PASSWORD_DEFAULT, $options);
            // Le message

            $token = uniqid();
            $url = App::url('').'/admin/confirm?token='.$token;
            $message = "Bonjour $first_name \r\nMerci de confirmer votre inscription en suivant ce lien : $url\r\nA très bientôt";

            $message = wordwrap($message, 70, "\r\n");

            mail($email, 'Merci de confirmer votre inscription', $message);

            $register = App::db()->pdo()->prepare('INSERT INTO users(first_name, last_name, email, password, status, created_at) VALUES(:first_name, :last_name, :email, :password, :status, NOW())');
            $register->execute(array(
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'password' => $pass_hash,
                    'status' => $status,
                )
            );

            return true;
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

        $count     = $query->rowCount();
        if($count == 0) {
            return false;
        } else {
            $url = App::url('').'/admin/confirm?email='.$email;
            $message = "Bonjour \r\nMerci d'utiliser ce lien pour réinitialiser votre mot de passe' : $url\r\nA très bientôt";

            $message = wordwrap($message, 70, "\r\n");

            mail($email, 'Réinitialisation de mot de passe', $message);
        }
    }

    public function howManyUsers()
    {
        $req = "SELECT * FROM {$this->getTable()}";
        $query = App::db()->pdo()->query($req);


        return $count = $query->rowCount();
    }
}