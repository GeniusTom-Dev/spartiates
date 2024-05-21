<?php

namespace Repository;

use Exception\MoreThanOneException;
use Exception\NotFoundException;
use Model\User;

class UsersRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function logIn($pseudo, $password): ?User
    {
        //on select tout les Users avec le même pseudo et password
        $query = 'SELECT * FROM USER WHERE PSEUDO = :pseudo and PASSWORD = :password';
        $statement = $this->connexion->prepare($query);
        $statement->execute(['pseudo' => $pseudo, 'password' => $password]);

        if ($statement->rowCount() === 0) {
            return null;
        }

        if ($statement->rowCount() > 1) {
            throw new MoreThanOneException("Problème présent dans la BD");
        }
        $user = $statement->fetch();
        return new User($user);
    }

}
