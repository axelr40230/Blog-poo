<?php


namespace App\Table;


use App\App;

abstract class Table
{


    /**
     * @return string
     */
    abstract public function getTable(): string;

    /**
     * @return string
     */
    abstract public function getEntity(): string;

    /**
     * Requête de récupération de tous les éléments d'une table // Query to retrieve all the elements of a table
     * @return array
     */
    public function findAll(): array
    {
        $results = App::db()->pdo()->query('SELECT * FROM ' . $this->getTable() . ' ORDER BY created_at DESC');

        return $results->fetchAll(\PDO::FETCH_CLASS, $this->getEntity());
    }

    /**
     * Requête de récupération d'une instance de table // Query to retrieve a table instance
     * @param $id
     * @return mixed
     */
    public function one($id)
    {
        $result = App::db()->pdo()->query('SELECT * FROM ' . $this->getTable() . ' WHERE id = ' . $id);
        $result->setFetchMode(\PDO::FETCH_CLASS, $this->getEntity());
        //var_dump($post = $result->fetch());
        return $post = $result->fetch();
    }

    public function findByStatus($status): array
    {
        $req = "SELECT * FROM {$this->getTable()} WHERE status =:status";
        $query = App::db()->pdo()->prepare($req);

        $query->execute(array(
                'status' => $status)
        );
        return $query->fetchAll(\PDO::FETCH_CLASS, $this->getEntity());

    }


}