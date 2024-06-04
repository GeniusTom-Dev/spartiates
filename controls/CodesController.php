<?php

namespace controls;

use class\data\database\PersonalInfoTable;
use class\data\database\PlayerTable;
use class\exception\MoreThanOneException;
use repository\CodesRepository;

class CodesController
{
    /**
     * @var mixed
     */
    private CodesRepository $repository;
    private PlayerTable $playerTable;

    public function __construct()
    {
        $this->repository = new CodesRepository();
        $this->playerTable = new PlayerTable();
    }

    public function codeIsActive($code): bool
    {
        try {
            if ($this->repository->isActive($code)) {
                return true;
            }
        } catch (MoreThanOneException $ERROR) {
            //on fait un retour d'erreur
            file_put_contents('log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        }
        return false;
    }

    public function checkSessionCode($code): bool
    {
        try {
            if ($this->repository->checkSessionCode($code)) {
                $_SESSION['code'] = $code;
                return true;
            }
        } catch (MoreThanOneException $ERROR) {
            //on fait un retour d'erreur
            file_put_contents('log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        }
        return false;
    }

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

    public function getSessionCode(): void
    {
        echo $this->repository->getSessionCode();
    }

}