<?php


namespace App;

/**
 * Class App
 * @package App
 */
class App
{
    private static $database;
    private static $validator = null;
    private static $session = null;

    /**
     * @return Database
     */
    public static function db(): Database
    {
        if (self::$database === null) {
            $db_name = Env::get('DB_NAME');
            $db_user = Env::get('DB_USER');
            $db_pass = Env::get('DB_PASS');
            $db_host = Env::get('DB_HOST');
            self::$database = new Database($db_name, $db_user, $db_pass, $db_host);
        }

        return self::$database;
    }

    /**
     * Gestion de l'url dynamique
     * Dynamic url management
     * @param string $path
     * @return string
     */
    public static function url($path = ''): string
    {
        $origin = Env::get('URL_BLOG');;

        return $origin . '/' . $path;
    }


    /**
     * Gestion des traductions de l'application
     * Managing application translations
     * @param $term
     */
    public static function translate($term)
    {
        $trad = array(
            'approuved' => 'Approuvé',
            'intrash' => 'A la corbeille',
            'waiting' => 'En attente de validation',
            'admin' => 'Administrateur du site',
            'not confirmed' => 'Non confirmé',
            'user' => 'Utilisateur',
            'draft' => 'Brouillon',
            'publish' => 'Publié',
            'insert post' => 'Ajouter un nouvel article',
            'posts' => 'Articles',
            'users' => 'Utilisateurs',
            'comments' => 'Commentaires',
        );

        if (array_key_exists($term, $trad)) {
            return $trad[$term];
        }
    }

    /** singleton validator
     * @return Validator
     */
    public static function validator(): Validator
    {
        if (empty(self::$validator)) {
            self::$validator = new Validator();
        }

        return self::$validator;
    }

    /**
     * singleton session
     * @return Session
     */
    public static function session(): Session
    {
        if (empty(self::$session)) {
            self::$session = new Session();
        }

        return self::$session;
    }

}