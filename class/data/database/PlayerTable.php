<?php

namespace class\data\database;

use class\entity\Player;
use class\exception\NotFoundException;
use PDO;
use repository\AbstractRepository;

class PlayerTable extends AbstractRepository
{
    /**
     * Select a tuple from the Player table
     *
     * @param null|int|Player $id Either the Id or null if you wish to select them all, or the whole Player.
     * @return Player|Player[]|FALSE One or more Player
     */
    public function select(null|int|Player $id): Player|array|false
    {
        $query = 'SELECT * FROM PLAYER';
        $values = array();

        if ($id instanceof Player) {
            $id = $id->getId();
        }

        if (is_int($id)) {
            $query .= ' WHERE Id = :id';
            $values = ['id' => $id];
        }

        $statement = $this->connexion->prepare($query);
        $statement->execute($values);

        if ($statement->rowCount() === 0) {
            return FALSE;
        }

        $tupleArray = $statement->fetchAll();
        $playerArray = array();

        foreach ($tupleArray as $tuple) {
            $playerArray[] = new Player($tuple);
        }

        return $statement->rowCount() === 1 ? $playerArray[0] : $playerArray;
    }

    /**
     * Insert a player and returns its Id
     *
     * If the tuple already exists, prevent the insertion and return the existing Id
     *
     * Also set the Id attribute of the given Player
     *
     * @param Player $player The player to insert
     * @return int The Id of the given Player
     */
    public function insert(Player &$player): int
    {
        $query = <<<SQL
                INSERT INTO PLAYER (Id, PersonalInfo)
                VALUES (:id, :personalInfo)
        SQL;

        $id = $this->newId();

        $values = [
            'id' => $id,
            'personalInfo' => $player->getPersonalInfo(),
        ];

        $this->connexion->prepare($query)->execute($values);

        $player->setId($id);
        return $id;
    }

    /**
     * Find a new and free ID for the Player table
     *
     * @return int
     */

    private function newId(): int
    {
        $query = 'SELECT MAX(Id) FROM PLAYER';
        $statement = $this->connexion->prepare($query);
        $statement->execute();

        return $statement->fetch()[0] + 1;
    }

    /**
     * Update an existing tuple
     *
     * @param int|Player $key Either the existing tuple's id or its data
     * @param Player $player The new data
     * @return void
     */
    public function update(int|Player $key, Player $player): void
    {
        $existingPlayer = $this->select($key);

        if ($existingPlayer === FALSE || $player->equals($existingPlayer)) {
            return;
        }

        $query = <<<SQL
            UPDATE PLAYER
            SET Score = :score, PersonalInfo = :personalInfo
            WHERE Id = :id
        SQL;

        $values = [
            'score' => $player->getScore(),
            'personalInfo' => $player->getPersonalInfo(),
            'id' => $existingPlayer->getId(),
        ];

        $this->connexion->prepare($query)->execute($values);
    }

    /**
     * Delete a player
     *
     * @param int|Player $key Either its key or the Player
     * @return void
     */

    public function delete(int|Player $key): void
    {
        $existingPlayer = $this->select($key);

        if ($existingPlayer === FALSE) {
            return;
        }

        $query = <<<SQL
            DELETE FROM PLAYER
            WHERE Id = :id
        SQL;

        $values = [
            'id' => $existingPlayer->getId(),
        ];

        $this->connexion->prepare($query)->execute($values);
    }

    /**
     * Clears the PLAYER table
     *
     * @return bool TRUE on success, FALSE en failure
     */

    public function clear(): bool
    {
        $query = 'DELETE FROM PLAYER';
        $statement = $this->connexion->prepare($query);
        return $statement->execute();
    }

    /**
     * Get an array of winners
     *
     * @return Player[]
     */

    public function getWinners(): array
    {
        $query = 'SELECT * FROM PLAYER WHERE SCORE = (SELECT MAX(SCORE) FROM PLAYER)';
        $statement = $this->connexion->prepare($query);
        $statement->execute();
        $winners = [];
        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $player) {
            $winners[] = new Player($player);
        }
        return $winners;
    }

    /**
     * Select the top 10 players
     *
     * @return Player[]
     */

    public function getRanking(): array
    {
        $query = 'SELECT * FROM PLAYER ORDER BY SCORE DESC limit 10';
        $statement = $this->connexion->prepare($query);
        $statement->execute();
        $sessionUsers = [];
        while ($data = $statement->fetch(PDO::FETCH_ASSOC)) {
            $sessionUsers[] = new Player($data);
        }
        return $sessionUsers;
    }

    /**
     * Check if the given id exists or not
     *
     * @param int $id An ID to check
     * @return bool TRUE if it exists, FALSE if not
     */

    public function exists(int $id): bool
    {
        $query = 'SELECT * FROM PLAYER WHERE ID = :id';
        $statement = $this->connexion->prepare($query);
        $statement->execute([
            'id' => $id,
        ]);

        return $statement->rowCount() !== 0;
    }
}