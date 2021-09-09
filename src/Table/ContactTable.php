<?php

namespace App\Table;

use App\App;
use App\Entity\ContactEntity;

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

            return App::db()->pdo()->lastInsertId();

        }
        return false;

    }
}