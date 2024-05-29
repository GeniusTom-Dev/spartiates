<?php
require_once "../repository/TokenRepository.php";

use {repository\TokenRepository};

$email = $_ENV['USER_EMAIL'];

if ($email) {
    $tokenRepository = new TokenRepository();
    $token = $tokenRepository->generateToken($email);

    $resetLink = "http://spartiatesdev.alwaysdata.net/reset?token=$token";

    // Assuming you have a mail function setup
    $to = "sokhna.diop.1@etu.univ-amu.fr";
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
?>