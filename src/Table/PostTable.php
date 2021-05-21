<?php

namespace App\Table;

use App\App;
use App\Entity\PostEntity;

class PostTable extends Table
{

    /**
     * @return string
     */
    public function getTable(): string
    {
        return 'posts';
    }

    /**
     * @return string
     */
    public function getEntity(): string
    {
        return PostEntity::class;
    }

    /**
     * Requête d'insertion d'une instance dans une table // Request to insert an instance in a table
     * @param $data
     */
    public function insert($data)
    {
        $req = "INSERT INTO {$this->getTable()} SET title=?, introduction=?, content=?, author=?, created_at=NOW()";
        $query = App::db()->pdo()->prepare($req);

        $query->execute([
            $data['title'],
            $data['introduction'],
            $data['content'],
            1
        ]);

        if($query == false) {
            var_dump($query->errorInfo());
            exit();
        }

        return App::db()->pdo()->lastInsertId();

    }

    /**
     * Requête de mise à jour d'une instance de table // Request to update a table instance
     * @param $id
     * @param $data
     */
    public function update($id, $data)
    {
        $req = "UPDATE {$this->getTable()} SET title=?, introduction=?, content=?, status=?, author=?, modify_at=NOW() WHERE id={$id}";
        $query = App::db()->pdo()->prepare($req);

        $query->execute([
            $data['title'],
            $data['introduction'],
            $data['content'],
            $data['status'],
            1
        ]);
    }

    public function getRelation()
    {
        echo 'all';
    }

    public function howManyPosts()
    {
        $req = "SELECT * FROM {$this->getTable()}";
        $query = App::db()->pdo()->query($req);


        return $count = $query->rowCount();
    }

}