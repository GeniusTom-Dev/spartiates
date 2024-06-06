<?php

namespace class\dataAccess\database;

use PDO;

/**
 * Class AbstractTable
 *
 * This class is responsible for managing the abstract repository.
 */
abstract class AbstractTable
{
    /**
     * @var PDO An instance of the PDO class.
     */
    protected PDO $connexion;

    /**
     * AbstractTable constructor.
     *
     * Initializes a new instance of the AbstractTable class.
     */
    public function __construct()
    {
        $this->connexion = Connexion::getInstance();
    }
}