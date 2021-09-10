<?php


namespace App;

use \PDO;

/**
 * Class Database
 * @package App
 */
class Database
{
    private $pdo;

    /**
     * Database constructor.
     * @param $db_name
     * @param string $db_user
     * @param string $db_pass
     * @param string $db_host
     */
    public function __construct($db_name, $db_user = 'root', $db_pass = '', $db_host = 'localhost')
    {
        $db_name = Env::get('DB_NAME');
        $db_user = Env::get('DB_USER');
        $db_pass = Env::get('DB_PASS');
        $db_host = Env::get('DB_HOST');

        $pdo = new \PDO('mysql:host=' . $db_host . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo = $pdo;
    }

    /**
     * @return PDO
     */
    public function pdo(): \PDO
    {
        return $this->pdo;
    }

}