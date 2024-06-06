<?php

namespace class\controls;

use class\dataAccess\database\UsersTable;

/**
 * Class WSController
 *
 * This class is responsible for handling WebSocket connections.
 */
class WSController
{
    /**
     * WSController constructor.
     *
     * Initializes a new instance of the WSController class.
     */
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

    /**
     * Start the WebSocket connection.
     *
     * @return void
     */
    public function startWS(): void
    {
        echo "start";
    }

    /**
     * Stop the WebSocket connection.
     *
     * @return void
     */
    public function stopWS(): void
    {
        echo "stop";
    }

    public function saveScore($scores) {
        $usersTable = new UsersTable();
        $scores = htmlspecialchars_decode($scores);
        $scores = json_decode($scores, true);
        foreach ($scores as $score) {
            $usersTable->updateScore($score['id'], $score['score']);
        }

    }
}