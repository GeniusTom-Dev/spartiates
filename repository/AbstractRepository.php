<?php

namespace Repository;

use PDO;

abstract class AbstractRepository
{
    protected PDO $connexion;

    public function __construct()
    {

        $this->connexion = Connexion::getInstance();
    }
}