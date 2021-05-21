<?php

namespace App\Table;

use App\App;
use App\Entity\CommentEntity;

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
        $author = App::db()->pdo()->prepare('SELECT * FROM '.$this->getTable().' WHERE id = ?');
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
}