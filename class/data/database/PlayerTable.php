<?php

namespace class\data\database;

use class\entity\Player;
use repository\AbstractRepository;

class PlayerTable extends AbstractRepository
{
    /**
     * Select a tuple from the Player table
     *
     * @param null|int|Player $id Either the Id or null if you wish to select them all, or the whole Player.
     * @return Player|Player[]|FALSE One or more Player
     */
    public function select(null|int|Player $id): Player|array|FALSE
    {
        $query = 'SELECT * FROM PLAYER';
        $values = array();

        if($id instanceof Player) {
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
        $existingPlayer = $this->select($player);

        if ($existingPlayer !== FALSE) {
            return $existingPlayer->getId();
        }

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

    private function newId() : int
    {
        $query = 'SELECT MAX(Id) FROM PLAYER';
        $statement = $this->connexion->prepare($query);
        $statement->execute();

        return $statement->fetch() + 1;
    }

    /**
     * Update an existing tuple
     *
     * @param int|Player $key Either the existing tuple's id or its data
     * @param Player $player The new data
     * @return void
     */
    public function update(int|Player $key, Player $player) : void
    {
        $existingPlayer = $this->select($key);

        if($existingPlayer === FALSE || $player->equals($existingPlayer)) {
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

        if($existingPlayer === FALSE) {
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
}