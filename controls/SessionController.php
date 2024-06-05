<?php

namespace controls;

use class\dataAccess\database\PersonalInfoTable;
use class\dataAccess\database\PlayerTable;
use class\entity\PersonalInfo;
use class\entity\Player;
use class\exception\NotFoundException;
use repository\SpartanRepository;

/**
 * Class SessionController
 *
 * This class is responsible for managing sessions.
 */
class SessionController
{
    /**
     * @var SpartanRepository An instance of the SpartanRepository class.
     */
    private SpartanRepository $spartanRepository;

    /**
     * @var PlayerTable An instance of the PlayerTable class.
     */
    private PlayerTable $playerTable;
    /**
     * @var PersonalInfoTable An instance of the PersonalInfoTable class.
     */
    private PersonalInfoTable $personalInfoTable;


    /**
     * SessionController constructor.
     *
     * Initializes a new instance of the SessionController class.
     */
    public function __construct()
    {
        $this->playerTable = new PlayerTable();
        $this->personalInfoTable = new PersonalInfoTable();
        $this->spartanRepository = new SpartanRepository();
    }

    /**
     * Create a new player and initiate its session
     *
     * @param string $name The player's name
     * @param string $email The player's email address
     * @param string $phone The player's phone number
     * @return void
     */
    public function addSessionPlayer(string $name, string $email, string $phone): void
    {
        $personalInfo = new PersonalInfo();
        $personalInfo
            ->setName($name)
            ->setEmail($email)
            ->setPhoneNumber($phone);
        $id = $this->personalInfoTable->insert($personalInfo);

        $player = new Player();
        $player
            ->setScore(0)
            ->setPersonalInfo($id);
        $this->playerTable->insert($player);

        $_SESSION['id'] = $player->getId();
        $_SESSION['username'] = $name;
    }

    /**
     * Show the ranking of players
     *
     * @return void
     */
    public function showRanking(): void
    {
        $players = $this->playerTable->getRanking();
        $i = 1;
        foreach ($players as $player) {
            $name = $this->personalInfoTable->select($player->getPersonalInfo())->getName();
            $score = $player->getScore();
            $id = $player->getId();

            echo <<<HTML
            <tr class="bg-white">
                <td class="px-4 py-2 border-t border-b text-center font-bold">$i</td>
                <td class="px-4 py-2 border-t border-b text-center">$name</td>
                <td class="px-4 py-2 border-t border-b text-center">$score</td>
                <td class="p-2 border bg-[var(--color-bg)] text-center">
                    <button data-id="'$id'" data-action="deleteUser" class="deleteButton actionButton inline-block w-8 h-8 bg-red-500 hover:bg-red-700 rounded" type="button">
                        <img class="p-1" src="/assets/images/icon/trashcan.svg" alt="Delete">
                    </button>
                </td>
            </tr>
            HTML;
            $i++;
        }
    }

    /**
     * Delete a user by their ID
     *
     * @param mixed $id The ID of the user
     * @return void
     */
    public function deleteUser(mixed $id): void
    {
        try {
            $this->playerTable->delete($id);
        } catch (NotFoundException $ERROR) {
            file_put_contents('log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        }
    }

    /**
     * Check if the player is in an active session
     *
     * @return void
     */
    public function isInActiveSession(): void
    {
        $codesController = new CodesController();
        if (!empty($_SESSION['code'] && $codesController->codeIsActive($_SESSION['code'])) && $this->playerTable->exists($_SESSION['id'])) {
            echo 'true';
        } elseif (!empty($_SESSION['code'] && isset($_SESSION['id']) && $this->playerTable->exists($_SESSION['id']))) {
            echo 'notActive';

        } else {
            $_SESSION['code'] = null;
            $_SESSION['randomQuestion'] = null;
            echo 'false';
        }
    }

    /**
     * Show the end game screen
     *
     * @param int $score The player's score
     * @return void
     */
    public function showEndGame(int $score): void
    {
        try {
            if ($score == 0)
                $score = $this->playerTable->select($_SESSION['id']);
            if (isset($_SESSION['id']) && $this->playerTable->exists($_SESSION['id'])) {
                $player = $this->playerTable->select($_SESSION['id']);
                $player->setScore($score);
                $this->playerTable->update($_SESSION['id'], $player);
                echo json_encode($player);
            }
        } catch (NotFoundException $ERROR) {
            echo $ERROR->getMessage();
            echo $_SESSION['id'];
        }
    }

    /**
     * Set the session spartan
     *
     * @param int $spartanId The ID of the spartan
     * @return void
     */
    public function setSessionSpart(int $spartanId): void
    {
        if (isset($_SESSION['id']) && $this->playerTable->exists($_SESSION['id'])) {
            $_SESSION['spartanId'] = $spartanId;
            $this->spartanRepository->incrementSpartanChoose($spartanId);
        }
    }

}