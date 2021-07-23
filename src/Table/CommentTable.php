<?php

namespace App\Table;

use App\App;
use App\Entity\CommentEntity;
use App\Session;

class CommentTable extends Table
{
    /**
     * @return string
     */
    public function getTable(): string
    {
        return 'comments';
    }

    public function getEntity(): string
    {
        return CommentEntity::class;
    }

    /**
     * Requête de récupération de l'auteur // Author recovery request
     * @param int $id_author
     * @return mixed
     */
    public function author(int $id_author)
    {
        $author = App::db()->pdo()->prepare('SELECT * FROM ' . $this->getTable() . ' WHERE id = ?');
        $author->execute(array($id_author));
        $author->setFetchMode(\PDO::FETCH_CLASS, $this->getEntity());

        return $author->fetch();
    }

    public function elements($id, $status)
    {
        $req = "SELECT * FROM {$this->getTable()} WHERE article_id=:id AND status =:status";
        $query = App::db()->pdo()->prepare($req);

        $query->execute(array(
                'id' => $id,
                'status' => $status)
        );
        return $query->fetchAll(\PDO::FETCH_CLASS, $this->getEntity());

    }

    public function howManyComments($id, $status)
    {
        $req = "SELECT * FROM {$this->getTable()} WHERE article_id=:id AND status =:status";
        $query = App::db()->pdo()->prepare($req);

        $query->execute(array(
                'id' => $id,
                'status' => $status)
        );

        return $count = $query->rowCount();
    }

    public function howManyWaiting($status)
    {
        $req = "SELECT * FROM {$this->getTable()} WHERE status =:status";
        $query = App::db()->pdo()->prepare($req);

        $query->execute(array(
                'status' => $status)
        );

        return $count = $query->rowCount();
    }

    public function insert($id, $data)
    {
        $session = new Session();
        $user = $session->get('user');
        $author = $user->id;
        $status = 'waiting';

        if (!empty($data['comment'])) {
            $req = "INSERT INTO {$this->getTable()} SET author=?, comment=?, article_id=?, status=?, created_at=NOW()";
            $query = App::db()->pdo()->prepare($req);

            $query->execute([
                $author,
                $data['comment'],
                $id,
                $status,
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

    /**
     * Requête de mise à jour d'une instance de table // Request to update a table instance
     * @param $id
     * @param $data
     * @param $slug
     */
    public function update($id, $data)
    {
        $req = "UPDATE {$this->getTable()} SET status=? WHERE id=?";
        $query = App::db()->pdo()->prepare($req);

        $query->execute([
            $data['update'],
            $id
        ]);
    }


    public function findAllWithAuthor()
    {
        $results = App::db()->pdo()->query('SELECT * FROM ' . $this->getTable() . ' INNER JOIN users ON ' . $this->getTable() . '.author = users.id ORDER BY ' . $this->getTable() . '.created_at DESC');

        return $results->fetchAll(\PDO::FETCH_CLASS, $this->getEntity());
    }
}