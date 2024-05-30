<?php

namespace repository;

use exception\MoreThanOneException;
use exception\NotFoundException;
use model\Admin;

class UsersRepository extends AbstractRepository
{

    public function logIn($login, $password): ?Admin
    {
        // On récupère tous les Users avec le même nom d'utilisateur et le même mot de passe
        $query = 'SELECT * FROM ADMIN WHERE LOGIN = :login and PASSWORD = :password';
        $result = $this->connexion->prepare($query);
        $result->execute(['login' => $login, 'password' => $password]);

        if ($result->rowCount() === 0) {
            throw new NotFoundException('Aucun ADMIN trouvé');
        }

        if ($result->rowCount() > 1) {
            throw new MoreThanOneException("Duplication de l'ADMIN $login");
        }

        $user = $result->fetch();
        return new Admin($user);
    }

    public function updatePassword($login, $password){
        $query = 'UPDATE ADMIN SET PASSWORD = :password WHERE LOGIN = :login';
        $result = $this->connexion->prepare($query);
        $result->execute(['login' => $login, 'password' => $password]);

    }
}
