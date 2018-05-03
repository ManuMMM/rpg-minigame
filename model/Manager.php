<?php

/*
 * Description of Manager
 * ----------------------------------------------------------------------------------------
 * Class to connect to the database where:
 *      - $dsn is the Data Source Name which contains the informations to connect to the db
 *      - $user is the user for the DNS string (to log in to the db)
 *      - $password is the password for the DNS string (to connect to the db)
 * ----------------------------------------------------------------------------------------
 * @author Manu
 */

class Manager {
    protected function dbConnect()
    {
        $dsn = 'mysql:host=localhost;dbname=mini_jeu_de_combat;charset=utf8';
        $user = 'root';
        $password = '';
        $db = new PDO($dsn, $user, $password);
        return $db;
    }
}
