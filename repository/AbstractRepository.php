<?php

namespace Repository;

use PDO;

abstract class AbstractRepository
{
    protected PDO $connexion;

    public function __construct()
    {
//        putenv("DB_DND_DSN=mysql:host=mysql-rbb.alwaysdata.net;dbname=rbb_sitednd");
//        putenv("DB_DND_USER=rbb");
//        putenv("DB_DND_PASSWORD=RayaneBD20");
        $this->connexion = Connexion::getInstance();
    }
}