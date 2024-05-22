<?php

namespace Controls;

use Exception\MoreThanOneException;
use Repository\CodesRepository;
use Repository\SessionRepository;

class CodesController
{
    /**
     * @var mixed
     */
    private $repository;

    public function __construct()
    {
        $this->repository = new CodesRepository();
    }

    public function codeIsActive($code)
    {
        try {
            if ($this->repository->isActive($code)) {
                return true;
            } else {
                return false;
            }
        } catch (MoreThanOneException $ERROR) {
            //on fais un retour d'erreur
            file_put_contents('log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        }
    }

    public function checkSessionCode($code)
    {
        try {
            if ($this->repository->checkSessionCode($code)) {
                $_SESSION['code'] = $code;
                return true;
            } else {
                return false;
            }
        } catch (MoreThanOneException $ERROR) {
            //on fais un retour d'erreur
            file_put_contents('log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        }
    }

    public function start()
    {
        $randomCode = rand(10000, 99999);
        if ($this->repository->isSessionCode()) {
            $this->repository->reset();
            $sessionRepo = new SessionRepository();
            $sessionRepo->deleteSession();
        }
        $this->repository->start($randomCode);
        echo $randomCode;
    }

    public function stop()
    {
        $this->repository->stop();
        $sessionRepo = new SessionRepository();
        $data = $sessionRepo->getMailAndPseudoOfHighestScore();
        if (!empty($data)) {
            foreach ($data as $row) {
                if (!empty($row['mail']) && !empty($row['pseudo'])) {
                    $to = $row['mail'];
                    $who = $row['pseudo'];
                    $subject = 'Jeu Spartiate';
                    $headers = 'De: Spartiates <jeuspartiates@alwaysdata.net>' . "\r\n";
                    $message = 'Bonjour ' . $who . ' vous avez fait le meilleur score gardez ce mail pour récupérer votre prix';
                    mail($to, $subject, $message, $headers);
                }
            }
        }

        echo 'Pas de session en cours';
    }

    public function getSessionCode(): void
    {
        echo $this->repository->getSessionCode();
    }

}