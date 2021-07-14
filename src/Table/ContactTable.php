<?php

namespace App\Table;

use App\App;
use App\Entity\ContactEntity;
use App\Mailer;
use App\Session;

class ContactTable extends Table
{
    /**
     * @return string
     */
    public function getTable(): string
    {
        return 'contact';
    }

    public function getEntity(): string
    {
        return ContactEntity::class;
    }

    public function insert($data)
    {
        if (!empty($data['name']) and !empty($data['email']) and !empty($data['message'])) {
            $req = "INSERT INTO {$this->getTable()} SET name=?, email=?, message=?, created_at=NOW()";
            $query = App::db()->pdo()->prepare($req);

            $query->execute([
                $data['name'],
                $data['email'],
                $data['message']
            ]);

            if ($query == false) {
                var_dump($query->errorInfo());
                exit();
            } else {

                return App::db()->pdo()->lastInsertId();
            }
        } else {
            return false;
        }
    }
}