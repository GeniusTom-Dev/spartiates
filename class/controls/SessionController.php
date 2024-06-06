<?php

namespace class\controls;

use class\dataAccess\database\PersonalInfoTable;
use class\dataAccess\database\PlayerTable;
use class\dataAccess\database\SpartanTable;
use class\dataAccess\database\UsersTable;
use class\entity\PersonalInfo;
use class\entity\Player;
use class\exception\NotFoundException;

/**
 * Class SessionController
 *
 * This class is responsible for managing sessions.
 */
class SessionController
{
    /**
     * @var SpartanTable An instance of the SpartanTable class.
     */
    private SpartanTable $spartanTable;

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
        $this->spartanTable = new SpartanTable();
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
        $this->playerTable->delete($id);
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

    private function checkRank($allRanks, $playerId) {
        foreach ($allRanks as $rank) {
            if ($rank['Id'] == $playerId) {
                return $rank['Rank'];
            }
        }
        return null;
    }

    /**
     * Show the end game screen
     *
     * @param int $score The player's score
     * @return void
     */
    public function showEndGame($score): void
    {
        try {
            $userTable = new UsersTable();
            $allRanks = $userTable->getRanking();
            if ($score == 0)
                $score = $this->playerTable->select($_SESSION['id'])->getScore();
            if (isset($_SESSION['id']) && $this->playerTable->exists($_SESSION['id'])) {
                $player = $this->playerTable->select($_SESSION['id']);
                $player->setScore($score);
                $this->playerTable->update($_SESSION['id'], $player);
                $rank = $this->checkRank($allRanks, $_SESSION['id']);
                if(is_null($rank) === false){
                    $player->setRank("#" . $rank);
                }else{
                    $lastPlayerRank = end($allRanks)['score'];
                    $rank = "Vous êtes à " . ($lastPlayerRank - $player->getScore()) . " points du classement.";
                    $player->setRank($rank);
                }
                echo $player->jsonPlayer();
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
            $this->spartanTable->incrementSpartanChoose($spartanId);
        }
    }

}