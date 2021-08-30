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
     * Requête de récupération de tous les éléments d'une table // Query to retrieve all the elements of a table
     * @return array
     */
    public function findWithPagination($premier, $parPage): array
    {
        $results = App::db()->pdo()->query('SELECT * FROM ' . $this->getTable() . ' ORDER BY created_at DESC LIMIT '.$premier.', '.$parPage);

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
        $count = $result->rowCount();
        if ($count != 0) {
            return $post = $result->fetch();
        } else {
            return false;
        }
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

    /** @todo  créer une fonction search avec le terme à rechercher en variable et faire une recherche dans chaque table puis afficher les résultats
     *
     */

    public function search($term, $columns)
    {
        $elements = [];
        foreach ($columns as $column) {
            $elements[] = sprintf('%s LIKE "%%%s%%"', $column, $term);
        }
        $query = 'SELECT * FROM ' . $this->getTable() . ' WHERE '. implode($elements, ' OR ');
        $result = App::db()->pdo()->query($query);
        $result->setFetchMode(\PDO::FETCH_CLASS, $this->getEntity());
        $count = $result->rowCount();

        if ($count != 0) {
            return $result->fetchAll();
        }

        return [];
    }

}
