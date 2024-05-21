<?php

namespace Repository;

use PDO;

class Connexion
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if (self::$instance == null) {

            self::$instance = new \PDO(
                $_ENV['DSN'],
                $_ENV['USERNAME'],
                $_ENV['PASSWORD'],
                [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                ]
            );
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        }
        return self::$instance;
    }
}

?>