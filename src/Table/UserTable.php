<?php

namespace App\Table;

use App\App;
use App\Entity\UserEntity;

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
            header("Refresh:0");
        } else {
            $pass = $password;
            $hash              = $user->password;
            //var_dump($hash);
            $isPasswordCorrect = password_verify($pass, $hash);

            if($isPasswordCorrect)
            {
                //echo 'yo';exit();
                session_start();
                $_SESSION['id']   = $user->id;
                $_SESSION['first_name']   = $user->first_name;
                $_SESSION['last_name']   = $user->last_name;
                $_SESSION['email'] = $user->email;

                header('Location: http://localhost/blog/admin');
            }
        }

    }

    public function howManyUsers()
    {
        $req = "SELECT * FROM {$this->getTable()}";
        $query = App::db()->pdo()->query($req);


        return $count = $query->rowCount();
    }
}