<?php

namespace Repository;

use Exception\MoreThanOneException;
use Exception\NotFoundException;
use Model\User;

class UsersRepository extends AbstractRepository
{

    public function logIn($pseudo, $password): ?User
    {
        //on récupère tous les Users avec le même pseudo et le même mot de passe
        $query = 'SELECT * FROM USER WHERE PSEUDO = :pseudo and PASSWORD = :password';
        $result = $this->connexion->prepare($query);
        $result->execute(['pseudo' => $pseudo, 'password' => $password]);

        if ($result->rowCount() === 0) {
            throw new NotFoundException('Aucun USER trouvé');
        }

        if ($result->rowCount() > 1) {
            throw new MoreThanOneException("Utilisateur $pseudo dupliqué");
        }

        $user = $result->fetch();
        return new User($user);
    }

}
