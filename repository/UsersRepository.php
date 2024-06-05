<?php

namespace repository;

use class\exception\MoreThanOneException;
use class\exception\NotFoundException;
use model\Admin;

/**
 * Class UsersRepository
 *
 * This class is responsible for managing the users repository.
 */
class UsersRepository extends AbstractRepository
{
    /**
     * @param $login
     * @param $password
     * @return Admin|null
     * @throws MoreThanOneException
     * @throws NotFoundException
     */
    public function logIn($login, $password): ?Admin
    {
        // On récupère tous les Users avec le même nom d'utilisateur et le même mot de passe
        $query = 'SELECT * FROM ADMIN WHERE LOGIN = :login';
        $result = $this->connexion->prepare($query);
        $result->execute(['login' => $login]);

        if ($result->rowCount() === 0) {
            throw new NotFoundException('Aucun ADMIN trouvé');
        }

        if ($result->rowCount() > 1) {
            throw new MoreThanOneException("Duplication de l'ADMIN $login");
        }

        $user = $result->fetch();

        if (!password_verify($password, $user['Password'])) {
            var_dump($user);
            var_dump($password);
            throw new NotFoundException('Mot de passe incorrect');
        }
        return new Admin($user);
    }

    /**
     * @param $login
     * @param $password
     * @return void
     */
    public function updatePassword($login, $password): void {
        $securePwd = password_hash($password, PASSWORD_DEFAULT);

        $query = 'UPDATE ADMIN SET PASSWORD = :password WHERE LOGIN = :login';
        $result = $this->connexion->prepare($query);
        $result->execute(['login' => $login, 'password' => $securePwd]);
    }
}
