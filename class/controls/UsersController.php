<?php

namespace class\controls;

use class\dataAccess\database\UsersTable;
use class\dataAccess\server\TokenRepository;
use class\exception\MoreThanOneException;
use class\exception\NotFoundException;

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
    private UsersTable $repository;

    /**
     * UsersController constructor.
     *
     * Initializes a new instance of the UsersController class.
     */
    public function __construct()
    {
        $this->repository = new UsersTable();
    }

    /**
     * Log in a user.
     *
     * @param string $login The user's login.
     * @param string $password The user's password.
     *
     * @return bool True if the user is logged in, false otherwise.
     */
    public function logIn(string $login, string $password): bool
    {
        session_regenerate_id(true);
        //on récupère les informations rentrées dans le formulaire
        try {
            $user = $this->repository->logIn($login, $password);
            if (!empty($user) && $user->isAdminActive() == 1) {
                $_SESSION['admin'] = true;
                return true;
            }

        } catch (MoreThanOneException|NotFoundException $ERROR) {
            return false;
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
     * @param string $login The user's login.
     * @param string $password The user's password.
     *
     * @return void
     */
    public function updatePassword(string $login, string $password): void {
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


    public function sendResetEmail(): void {
        $email = $_ENV['USER_EMAIL'];

        if ($email) {
            $tokenRepository = new TokenRepository();
            $token = $tokenRepository->generateToken($email);

            $resetLink = "https://newspartitatesgames.alwaysdata.net/reset&token=$token";

            // Assuming you have a mail function setup
            $to = $email;
            $subject = "Password Reset Request";
            $message = "Cliquez sur ce lien pour réinitialiser le mot de passe: $resetLink";
            $headers = "From: no-reply@spartiates.com";
            if (mail($to, $subject, $message, $headers)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        } else {
            echo json_encode(['success' => false]);
        }
    }

}