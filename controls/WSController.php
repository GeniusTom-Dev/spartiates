<?php

namespace controls;

use repository\UsersRepository;

class WSController
{

    public function connexionWS(): void
    {
        $identificationMessage = array(
            'action' => 'identify',
            'id' => $_SESSION['id'] ?? 1,
            'admin' => $_SESSION['admin'] ?? false,
            'username' => $_SESSION['username'] ?? 'Anonyme',
        );

        // Convertir le tableau associatif en JSON
        $jsonIdentificationMessage = json_encode($identificationMessage);

        echo $jsonIdentificationMessage;
    }

    public function startWS(): void
    {
        echo "start";
    }

    public function stopWS(): void
    {
        echo "stop";
    }

    public function saveScore($scores) {
        $userRepository = new UsersRepository();
        $scores = htmlspecialchars_decode($scores);
        $scores = json_decode($scores, true);
        var_dump($scores);
        foreach ($scores as $score) {
            $userRepository->updateScore($score['id'], $score['score']);
        }

    }
}