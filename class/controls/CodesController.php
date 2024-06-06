<?php

namespace class\controls;

use class\dataAccess\database\CodesTable;
use class\dataAccess\database\PersonalInfoTable;
use class\dataAccess\database\PlayerTable;
use class\exception\MoreThanOneException;

/**
 * Class CodesController
 *
 * This class is responsible for managing codes.
 */
class CodesController
{
    /**
     * @var mixed
     */
    private CodesTable $repository;
    private PlayerTable $playerTable;

    public function __construct()
    {
        $this->repository = new CodesTable();
        $this->playerTable = new PlayerTable();
    }

    /**
     * Checks if a code is active.
     *
     * @param mixed $code The code to check.
     *
     * @return bool True if the code is active, false otherwise.
     */
    public function codeIsActive(mixed $code): bool
    {
        if ($this->repository->isActive($code)) {
            return true;
        }
        return false;
    }

    /**
     * Checks if a session code is valid.
     *
     * @param mixed $code The code to check.
     *
     * @return bool True if the session code is valid, false otherwise.
     */
    public function checkSessionCode(mixed $code): bool
    {

                if ($this->repository->checkSessionCode($code)) {
                    $_SESSION['code'] = $code;
                    return true;
                }

        return false;
    }

    /**
     * Starts a new session with a random code.
     *
     * @return void
     */
    public function start(): void
    {
        $randomCode = rand(10000, 99999);
        if ($this->repository->isSessionCode()) {
            $this->repository->reset();
            $this->playerTable->clear();
        }
        $this->repository->start($randomCode);
        echo $randomCode;
    }

    // TODO
    /**
     * Stops the current session and sends an email to the winners.
     *
     * @return void
     */
    public function stop(): void
    {
        $this->repository->stop();
        $winners = $this->playerTable->getWinners();

        $personalInfoTable = new PersonalInfoTable();
        foreach ($winners as $winner) {
            $personalInfo = $personalInfoTable->select($winner->getPersonalInfo());

            $to = $personalInfo->getEmail();
            $who = $personalInfo->getName();
            $subject = 'Jeu Spartan';
            $headers = 'De: Spartiates <jeuspartiates@alwaysdata.net>' . "\r\n";
            $message = 'Bonjour ' . $who . ' vous avez fait le meilleur score gardez ce mail pour récupérer votre prix';

            mail($to, $subject, $message, $headers);
        }

        echo 'Pas de session en cours';
    }

    /**
     * Gets the current session code.
     *
     * @return void
     */
    public function getSessionCode(): void
    {
        echo $this->repository->getSessionCode();
    }

}