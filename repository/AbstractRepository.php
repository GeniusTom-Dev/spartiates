<?php

namespace repository;

use PDO;

/**
 * Class AbstractRepository
 *
 * This class is responsible for managing the abstract repository.
 */
abstract class AbstractRepository
{
    /**
     * @var PDO An instance of the PDO class.
     */
    protected PDO $connexion;

    /**
     * AbstractRepository constructor.
     *
     * Initializes a new instance of the AbstractRepository class.
     */
    public function __construct()
    {
        $this->connexion = Connexion::getInstance();
    }
}