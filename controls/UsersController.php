<?php

namespace controls;

use exception\MoreThanOneException;
use exception\NotFoundException;
use repository\UsersRepository;

class UsersController
{
    /**
     * @var mixed
     */
    private $repository;

    public function __construct()
    {
        $this->repository = new UsersRepository();
    }

    public function logIn($pseudo, $password): bool
    {
        //on récupère les informations rentrées dans le formulaire
        try {
            $user = $this->repository->logIn($pseudo, $password);
            if (!empty($user) && $user->getAdmin() == 1) {
                $_SESSION['admin'] = true;
                return true;
            }
        } catch (MoreThanOneException|NotFoundException $ERROR) {
            //on fait un retour d'erreur
            file_put_contents('log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        }
        return false;
    }


}