<?php

namespace repository;

use PDO;

/**
 * Class Connexion
 *
 * This class is responsible for managing the connexion.
 */
class Connexion
{
    /**
     * @var PDO|null An instance of the PDO class.
     */
    private static ?PDO $instance = null;

    /**
     * Connexion constructor.
     *
     * Initializes a new instance of the Connexion class.
     */
    public static function getInstance(): PDO
    {
        if (self::$instance == null) {
            self::$instance = new PDO(
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