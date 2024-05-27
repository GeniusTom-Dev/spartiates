<?php

namespace controls;

use exception\MoreThanOneException;
use repository\CodesRepository;
use repository\SessionRepository;

class CodesController
{
    /**
     * @var mixed
     */
    private mixed $repository;

    public function __construct()
    {
        $this->repository = new CodesRepository();
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
            $sessionRepo = new SessionRepository();
            $sessionRepo->deleteSession();
        }
        $this->repository->start($randomCode);
        echo $randomCode;
    }

    // TODO
    public function stop(): void
    {
        $this->repository->stop();
        $sessionRepo = new SessionRepository();
        $data = $sessionRepo->getMailAndPseudoOfHighestScore();
        if (!empty($data)) {
            foreach ($data as $row) {
                if (!empty($row['email']) && !empty($row['login'])) {
                    $to = $row['email'];
                    $who = $row['login'];
                    $subject = 'Jeu Spartan';
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