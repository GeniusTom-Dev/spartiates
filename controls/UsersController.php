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
    private mixed $repository;

    public function __construct()
    {
        $this->repository = new UsersRepository();
    }

    public function logIn($login, $password): bool
    {
        //on récupère les informations rentrées dans le formulaire
        try {
            $user = $this->repository->logIn($login, $password);
            if (!empty($user) && $user->isAdminActive() == 1) {
                $_SESSION['admin'] = true;
                return true;
            }

        } catch (MoreThanOneException|NotFoundException $ERROR) {
            //on fait un retour d'erreur
            file_put_contents('../log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        }
        return false;
    }
    public function disconnect(): bool
    {
        $_SESSION['admin'] = false;
        header('refresh:0;url=/');
        return true;
    }

    public function updatePassword($login, $password){
        $this->repository->updatePassword($login, $password);
    }

    public function handleResetPasswordForm() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newPassword = $_POST['newPassword'];
            $confirmPassword = $_POST['confirmPassword'];
            $token = $_POST['token'];

            // Vérifiez si les mots de passe correspondent
            if ($newPassword === $confirmPassword) {
                $login = "admin";
                if ($login) {
                    $this->updatePassword($login, $newPassword);
                    header('Location: /success');
                    exit();
                } else {
                    echo "Token invalide.";
                }
            } else {
                echo "Les mots de passe ne correspondent pas.";
            }
        }
    }

}