<?php

namespace Controls;

use Exception\MoreThanOneException;

class CodesController
{
    /**
     * @var mixed
     */
    private $repository;

    public function __construct()
    {
        $this->repository = new \Repository\CodesRepository();
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
            $sessionRepo = new \Repository\SessionRepository();
            $sessionRepo->deleteSession();
        }
        $this->repository->start($randomCode);
        echo $randomCode;
    }

    public function stop()
    {
        $this->repository->stop();
        echo 'Pas de session en cours';
    }

    public function getSessionCode(): void
    {
        echo $this->repository->getSessionCode();
    }

}