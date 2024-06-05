<?php

namespace class\entity;

class Player extends AbstractEntity
{
    private int $id;
    private int $score;
    private int $personalInfo;
    private string $name;

    public function getId(): int|null
    {
        return $this->id ?? null;
    }

    public function setId(int $id): Player
    {
        $this->id = $id;
        return $this;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $score): Player
    {
        $this->score = $score;
        return $this;
    }

    public function getPersonalInfo(): int
    {
        return $this->personalInfo;
    }

    public function setPersonalInfo(int $personalInfo): Player
    {
        $this->personalInfo = $personalInfo;
        return $this;
    }

    public function equals(Player $player): bool
    {
        if ($player->getScore() !== $this->getScore()
            || $player->getPersonalInfo() == $this->getPersonalInfo()) {
            return FALSE;
        }
        return TRUE;
    }

    public function getName(): ?string
    {
        return $this->name ?? null;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

}