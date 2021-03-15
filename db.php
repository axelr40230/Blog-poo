<?php
// Connexion à la base de donnée

try {
    $db = new \PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch (PDOException $e) {
    echo 'La base de donnée n\'est pas disponible pour le moment. <br />';
    echo $e->getMessage() . '<br />';
    echo 'Ligne : ' . $e->getLine();
}

// Fin de la connexion à la base de donnée

