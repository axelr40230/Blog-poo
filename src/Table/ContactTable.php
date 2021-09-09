<?php

namespace App\Table;

use App\App;
use App\Entity\ContactEntity;

class ContactTable extends Table
{
    /**
     * permet de travailler sur la table contact
     * @return string
     */
    public function getTable(): string
    {
        return 'contact';
    }

    /** permet de faire le lien avec la bonne entity
     * @return string
     */
    public function getEntity(): string
    {
        return ContactEntity::class;
    }

    /** permet d'insérer une prise de contact en base de données
     * @param $data
     * @return false|string
     */
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