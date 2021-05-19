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

    public function comments()
    {

    }
}