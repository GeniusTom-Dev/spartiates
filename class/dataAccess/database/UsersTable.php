<?php

namespace class\dataAccess\database;

use class\entity\Admin;
use class\exception\MoreThanOneException;
use class\exception\NotFoundException;

/**
 * Class UsersTable
 *
 * This class is responsible for managing the users repository.
 */
class UsersTable extends AbstractTable
{
    /**
     * @param string $login
     * @param string $password
     * @return Admin|null
     * @throws MoreThanOneException
     * @throws NotFoundException
     */
    public function logIn(string $login, string $password): ?Admin
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

    /**
     * @param string $login
     * @param string $password
     * @return void
     */
    public function updatePassword(string $login, string $password): void {
        $query = 'UPDATE ADMIN SET PASSWORD = :password WHERE LOGIN = :login';
        $result = $this->connexion->prepare($query);
        $result->execute(['login' => $login, 'password' => $password]);

    }
}
