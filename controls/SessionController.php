<?php

namespace Controls;

use Exception\NotFoundException;
use Repository\CodesRepository;

class SessionController
{
    /**
     * @var mixed
     */
    private $repository;

    public function __construct()
    {
        $this->repository = new \Repository\SessionRepository();
    }

    public function addSessionPlayer($pseudo)
    {
        $_SESSION['id'] = $this->repository->addSessionPlayer($pseudo, $_SESSION['code']);
        $_SESSION['pseudo'] = $pseudo;
    }

    public function showRanking(): void
    {
        $data = $this->repository->getRanking();
        $i = 1;
        foreach ($data as $sessionUser) {
            echo '
            <tr class="bg-white">
                <td class="px-4 py-2 border-t border-b text-center font-bold">' . $i . '</td>
                <td class="px-4 py-2 border-t border-b text-center">' . $sessionUser->getPseudo() . '</td>
                <td class="px-4 py-2 border-t border-b text-center">' . $sessionUser->getScore() . '</td>
                <td class="p-2 border bg-[var(--color-bg)] text-center">
                    <button id="actionButton" data-id="' . $sessionUser->getSession_user_id() . '"data-action="deleteUser" class="inline-block w-8 h-8 bg-red-500 hover:bg-red-700 rounded" type="button">
                        <img class="p-1" src="/assets/images/trashcan.svg" alt="Delete">
                    </button>
                </td>
            </tr>';
            $i++;
        }
    }

    public function deleteUser($id): void
    {
        try {
            $this->repository->deleteUserById($id);
        } catch (NotFoundException $ERROR) {
            file_put_contents('log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        }
    }

    public function addScore($score)
    {
        try {
            $codesRepo = new CodesRepository();
            if (isset($_SESSION['id']) && $this->repository->isInSession($_SESSION['id']) && isset($_SESSION['code']) && $codesRepo->isActive($_SESSION['code'])) {
                $this->repository->addScore($_SESSION['id'], $score);
                echo $this->repository->getScore($_SESSION['id']);
            }
        } catch (NotFoundException $ERROR) {
            file_put_contents('log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        }
    }

    public function isInActiveSession(): void
    {
        $codesRepo = new CodesRepository();
        if (isset($_SESSION['id']) && $this->repository->isInSession($_SESSION['id']) && isset($_SESSION['code']) && $codesRepo->isActive($_SESSION['code'])) {
            echo 'true';
        } elseif (isset($_SESSION['id']) && $this->repository->isInSession($_SESSION['id'])) {
            echo 'notActive';
        } else {
            $_SESSION['code'] = null;
            $_SESSION['randomQuestion'] = null;
            echo 'false';
        }
    }

    public function showEndGame(): void
    {
        try {
            if (isset($_SESSION['id']) && $this->repository->isInSession($_SESSION['id'])) {
                $sessionUser = $this->repository->getSessionUser($_SESSION['id']);
                echo json_encode($sessionUser);
            }
        } catch (NotFoundException $ERROR) {
            file_put_contents('log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        }
    }

    public function showScore(): void
    {
        try {
            if (isset($_SESSION['id']) && $this->repository->isInSession($_SESSION['id'])) {
                echo $this->repository->getScore($_SESSION['id']);
            }
        } catch (NotFoundException $ERROR) {
            file_put_contents('log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        }
    }

    public function setSessionSpart($spartiateId): void
    {
        if (isset($_SESSION['id']) && $this->repository->isInSession($_SESSION['id'])) {
            $_SESSION['spartiateId'] = $spartiateId;
        }
    }
}