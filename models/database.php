<?php

/** Connexion à la base de données
 * @return PDO
 */
function getPdo() : PDO
{
    try {
        $pdo = new \PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', '');
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        return $pdo;
    }
    catch (PDOException $e) {
        echo 'La base de donnée n\'est pas disponible pour le moment. <br />';
        echo $e->getMessage() . '<br />';
        echo 'Ligne : ' . $e->getLine();
    }

}

/** requête pour récupérer un listing
 * @param string $table
 * @return false|PDOStatement
 */

function find(string $table) : PDOStatement
{
    $db = getPdo();
    $results = $db->query('SELECT * FROM '.$table.' ORDER BY created_at DESC');

    return $results;
}



