<?php

namespace App\Table;

use App\App;
use App\Entity\PostEntity;
use App\Session;

/**
 * Class PostTable
 * @package App\Table
 */
class PostTable extends Table
{

    /** permet de travailler sur la table posts
     * allows you to work on the posts table
     * @return string
     */
    public function getTable(): string
    {
        return 'posts';
    }

    /** permet de faire le lien avec la bonne entity
     * allows you to make the link with the right entity
     * @return string
     */
    public function getEntity(): string
    {
        return PostEntity::class;
    }

    /**
     * génère le slug
     * generate the slug
     * @param $string
     * @return string
     */
    public function dSlug($string)
    {
        $slug = strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities(preg_replace('/[&]/', ' et ', $string), ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
        $first = $this->oneBySlug($slug);
        if (!$first) {
            return $slug;
        } else {
            return $slug . '-2';
        }
    }

    /**
     * Requête d'insertion d'une instance dans une table
     * Request to insert an instance in a table
     * @param $data
     */
    public function insert($data)
    {
        $session = new Session();
        $user = $session->get('user');
        $author = $user->id;
        $string = $data['title'];
        $slug = $this->dSlug($string);
        if (!empty($data['title']) and !empty($data['introduction']) and !empty($data['content'])) {
            $req = "INSERT INTO {$this->getTable()} SET title=?, slug=?, introduction=?, content=?, author=?, status=?, created_at=NOW(), modify_at=NOW()";
            $query = App::db()->pdo()->prepare($req);

            $query->execute([
                $data['title'],
                $slug,
                $data['introduction'],
                $data['content'],
                $author,
                $data['insert']
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
    public function update($id, $slug, $data)
    {
        //var_dump($data);exit();
        if (isset($data['checkSlug'])) {
            if($data['checkSlug']=== 'checkSlug')
          {
              $slug = $this->dSlug($data['slug']);
              $req = "UPDATE {$this->getTable()} SET title=?, slug=?, introduction=?, content=?, status=?, author=?, modify_at=NOW() WHERE id=?";
              $query = App::db()->pdo()->prepare($req);

              $query->execute([
                  $data['title'],
                  $slug,
                  $data['introduction'],
                  $data['content'],
                  $data['update'],
                  $data['author'],
                  $id
              ]);

              return $slug;
          }

        } else {
            $req = "UPDATE {$this->getTable()} SET title=?, slug=?, introduction=?, content=?, status=?, author=?, modify_at=NOW() WHERE id=?";
            $query = App::db()->pdo()->prepare($req);

            $query->execute([
                $data['title'],
                $slug,
                $data['introduction'],
                $data['content'],
                $data['update'],
                $data['author'],
                $id
            ]);

            return $slug;
        }

    }

    /**
     * retourne le nombre de posts
     * returns the number of posts
     * @return int
     */
    public function howManyPosts()
    {
        $req = "SELECT * FROM {$this->getTable()}";
        $query = App::db()->pdo()->query($req);


        return $count = $query->rowCount();
    }

    /**
     * Requête de récupération d'une instance de table
     * Query to retrieve a table instance
     * @param $id
     * @return mixed
     */
    public function oneBySlug($slug)
    {
        $req = "SELECT * FROM {$this->getTable()} WHERE slug = :slug";
        $result = App::db()->pdo()->prepare($req);
        $result->execute([
            'slug' => $slug
        ]);
        $result->setFetchMode(\PDO::FETCH_CLASS, $this->getEntity());

        return $post = $result->fetch();
    }

    /**
     * Requête de récupération de tous les éléments d'une table
     * Query to retrieve all the elements of a table
     * @return array
     */
    public function findNotTrash(): array
    {
        $results = App::db()->pdo()->query('SELECT * FROM ' . $this->getTable() . ' WHERE status NOT LIKE "%n%" ORDER BY created_at DESC ');

        return $results->fetchAll(\PDO::FETCH_CLASS, $this->getEntity());
    }

    /**
     * Requête de récupération de tous les éléments d'une table
     * Query to retrieve all the elements of a table
     * @return array
     */
    public function findInTrash(): array
    {
        $results = App::db()->pdo()->query('SELECT * FROM ' . $this->getTable() . ' WHERE status = "intrash" ORDER BY created_at DESC ');

        return $results->fetchAll(\PDO::FETCH_CLASS, $this->getEntity());
    }

    /**
     * Requête de récupération de tous les éléments d'une table
     * Query to retrieve all the elements of a table
     * @return array
     */
    public function findDraft(): array
    {
        $results = App::db()->pdo()->query('SELECT * FROM ' . $this->getTable() . ' WHERE status = "draft" ORDER BY created_at DESC ');

        return $results->fetchAll(\PDO::FETCH_CLASS, $this->getEntity());
    }

    /**
     * Requête de récupération de tous les éléments d'une table
     * Query to retrieve all the elements of a table
     * @return array
     */
    public function findPublish(): array
    {
        $results = App::db()->pdo()->query('SELECT * FROM ' . $this->getTable() . ' WHERE status = "publish" ORDER BY created_at DESC ');

        return $results->fetchAll(\PDO::FETCH_CLASS, $this->getEntity());
    }

    public function delete($slug)
    {
        $req = "DELETE FROM {$this->getTable()} WHERE slug = :slug";
        $result = App::db()->pdo()->prepare($req);
        $result->execute([
            'slug' => $slug
        ]);

        return true;
    }

    /** permet de récupérer le titre d'un article
     * allows you to retrieve the title of an article
     * @param $id
     * @return mixed
     */
    public function get_title($id)
    {
        $req = "SELECT * FROM {$this->getTable()} WHERE id = :id";
        $result = App::db()->pdo()->prepare($req);
        $result->execute([
            'id' => $id
        ]);
        $result->setFetchMode(\PDO::FETCH_CLASS, $this->getEntity());

        return $post = $result->fetch();
    }

}