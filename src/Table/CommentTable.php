<?php

namespace App\Table;

use App\App;
use App\Entity\CommentEntity;
use App\Session;

/**
 * Class CommentTable
 * @package App\Table
 */
class CommentTable extends Table
{
    /** permet de sélectionner la table comments
     * allows you to select the comments table
     * @return string
     */
    public function getTable(): string
    {
        return 'comments';
    }

    /** permet de faire le lien avec la bonne entity
     * allows you to make the link with the right entity
     * @return string
     */
    public function getEntity(): string
    {
        return CommentEntity::class;
    }

    /**
     * Requête de récupération de l'auteur
     * Author recovery request
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

    /**
     * permet de sélectionner des commentaires en fonction de leur statut
     * allows you to select comments according to their status
     * @param $id
     * @param $status
     * @return array
     */
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

    /**
     * permet de connaître le nombre de commentaires
     * allows you to know the number of comments
     * @param $id
     * @param $status
     * @return int
     */
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

    /**
     * permet de connaitre le nombre de commentaires en attente de validation
     * allows you to know the number of comments awaiting validation
     * @param $status
     * @return int
     */
    public function howManyWaiting($status)
    {
        $req = "SELECT * FROM {$this->getTable()} WHERE status =:status";
        $query = App::db()->pdo()->prepare($req);

        $query->execute(array(
                'status' => $status)
        );

        return $count = $query->rowCount();
    }

    /**
     * permet d'insérer un commentaire
     * allows you to insert a comment
     * @param $id
     * @param $data
     * @return false|string
     */
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

            return App::db()->pdo()->lastInsertId();

        }
        return false;

    }

    /**
     * Requête de mise à jour d'une instance de table
     * Request to update a table instance
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
}