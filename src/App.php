<?php


namespace App;

class App
{

    const DB_NAME = 'blogpoo';
    const DB_USER = 'root';
    const DB_PASS = '';
    const DB_HOST = 'localhost';
    const URL_BLOG = 'http://localhost/blog';

    private static $database;

    /**
     * @return Database
     */
    public static function db() : Database
    {
        if(self::$database === null) {
            self::$database = new Database(self::DB_NAME, self::DB_USER, self::DB_PASS, self::DB_HOST);
        }

        return self::$database;
    }

    /**
     * Gestion de l'url dynamique // Dynamic url management
     * @param string $path
     * @return string
     */
    public static function url($path = '') : string
    {
        $origin = self::URL_BLOG;

        return $origin.'/'.$path;
    }


    /**
     * Gestion des traductions de l'application // Managing application translations
     * @param $term
     */
    public function translate($term)
    {
        $trad = array(
            'approuved' => 'Approuvé',
            'intrash' => 'A la corbeille',
            'waiting' => 'En attente de validation',
            'admin' => 'Administrateur du site',
            'author' => 'Auteur',
            'user' => 'Utilisateur',
            'draft' => 'Brouillon',
            'publish' => 'Publié',
            'intrash' => 'A la corbeille',
            'insert post' => 'Ajouter un nouvel article',
            'posts' => 'Articles',
            'users' => 'Utilisateurs',
            'comments' => 'Commentaires',
        );

        if(array_key_exists($term,$trad)){
            return $trad[$term];
        }


    }

}