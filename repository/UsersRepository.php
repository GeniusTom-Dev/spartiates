<?php

namespace repository;

use exception\MoreThanOneException;
use exception\NotFoundException;
use model\Admin;

class UsersRepository extends AbstractRepository
{

    public function logIn($pseudo, $password): ?Admin
    {
        // On récupère tous les Users avec le même pseudo et le même mot de passe
        $query = 'SELECT * FROM ADMIN WHERE LOGIN = :pseudo and PASSWORD = :password';
        $result = $this->connexion->prepare($query);
        $result->execute(['pseudo' => $pseudo, 'password' => $password]);

        if ($result->rowCount() === 0) {
            throw new NotFoundException('Aucun ADMIN trouvé');
        }

        if ($result->rowCount() > 1) {
            throw new MoreThanOneException("Duplication de l'ADMIN $pseudo");
        }

        $user = $result->fetch();
        return new Admin($user);
    }

}
