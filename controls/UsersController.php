<?php

namespace controls;

use class\exception\MoreThanOneException;
use class\exception\NotFoundException;
use repository\UsersRepository;

/**
 * Class UsersController
 *
 * This class is responsible for managing users.
 */
class UsersController
{
    /**
     * @var mixed
     */
    private mixed $repository;

    /**
     * UsersController constructor.
     *
     * Initializes a new instance of the UsersController class.
     */
    public function __construct()
    {
        $this->repository = new UsersRepository();
    }

    /**
     * Log in a user.
     *
     * @param mixed $login The user's login.
     * @param mixed $password The user's password.
     *
     * @return bool True if the user is logged in, false otherwise.
     */
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

    /**
     * Disconnect a user.
     *
     * @return bool True if the user is disconnected, false otherwise.
     */
    public function disconnect(): bool
    {
        $_SESSION['admin'] = false;
        header('refresh:0;url=/');
        return true;
    }

    /**
     * Updates a user's password.
     *
     * @param mixed $login The user's login.
     * @param mixed $password The user's password.
     *
     * @return void
     */
    public function updatePassword($login, $password): void {
        $this->repository->updatePassword($login, $password);
    }

    /**
     * Handles the reset password form.
     *
     * @return void
     */
    public function handleResetPasswordForm(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newPassword = $_POST['newPassword'];
            $confirmPassword = $_POST['confirmPassword'];
            // TODO not used ?
            $token = $_POST['token'];

            // Vérifiez si les mots de passe correspondent
            if ($newPassword === $confirmPassword) {
                $login = "admin";
                // TODO condition tjrs true
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