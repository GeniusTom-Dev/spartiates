<?php

namespace class\entity;

/**
 * Class Player
 *
 * This class is responsible for managing the player entity.
 */
class Player extends AbstractEntity
{
    /**
     * @var int|null $id The Id of the player
     */
    private ?int $id;

    /**
     * @var int $score The score of the player
     */
    private int $score;

    /**
     * @var int $personalInfo The personal info of the player
     */
    private int $personalInfo;

    /**
     * @var string $name The name of the player
     */
    private string $name;

    /**
     * Player constructor
     *
     * @return int|null
     */
    public function getId(): int|null
    {
        return $this->id ?? null;
    }

    /**
     * Player constructor
     *
     * @param int $id
     * @return Player
     */
    public function setId(int $id): Player
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Player constructor
     *
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * Player constructor
     *
     * @param int $score
     * @return Player
     */
    public function setScore(int $score): Player
    {
        $this->score = $score;
        return $this;
    }

    /**
     * Player constructor
     *
     * @return int
     */
    public function getPersonalInfo(): int
    {
        return $this->personalInfo;
    }

    /**
     * Player constructor
     *
     * @param int $personalInfo
     * @return Player
     */
    public function setPersonalInfo(int $personalInfo): Player
    {
        $this->personalInfo = $personalInfo;
        return $this;
    }

    /**
     * Player constructor
     *
     * @param Player $player The player to compare
     * @return bool
     */
    public function equals(Player $player): bool
    {
        if ($player->getScore() !== $this->getScore()
            || $player->getPersonalInfo() == $this->getPersonalInfo()) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Player constructor
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name ?? null;
    }

    /**
     * Player constructor
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

}