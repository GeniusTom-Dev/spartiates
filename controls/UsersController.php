<?php

namespace Controls;

use Exception\MoreThanOneException;
use Exception\NotFoundException;

class UsersController
{
    /**
     * @var mixed
     */
    private $repository;

    public function __construct()
    {
        $this->repository = new \Repository\UsersRepository();
    }

    public function logIn($pseudo, $password)
    {
        //on recupère les information rentrées dans le formulaire
        try {
            $user = $this->repository->logIn($pseudo, $password);
            if (!empty($user) && $user->getAdmin() == 1) {
                $_SESSION['admin'] = true;
                return true;
            } else {
                return false;
            }
        } catch (MoreThanOneException|NotFoundException $ERROR) {
            //on fais un retour d'erreur
            echo $ERROR->getMessage();
        }
    }


}