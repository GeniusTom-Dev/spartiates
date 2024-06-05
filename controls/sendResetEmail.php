<?php
include_once "../autoloader.php";
use repository\TokenRepository;

/**
 * This script is responsible for sending a password reset email.
 */
$email = $_ENV['USER_EMAIL'];

if ($email) {
    $tokenRepository = new TokenRepository();
    $token = $tokenRepository->generateToken($email);

    // TODO mettre le bon lien
    $resetLink = "https://spartiatesdev.alwaysdata.net/reset?token=$token";

    // Assuming you have a mail function setup
    $to = "mathieu.leroux130304@gmail.com";
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