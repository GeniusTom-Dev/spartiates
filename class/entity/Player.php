<?php

namespace class\entity;

use class\entity\AbstractEntity;

class Player extends AbstractEntity
{
    private int $id;
    private int $score;
    private int $personalInfo;
    private string $name;

    private string $rank;

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

    public function setRank(string $rank) {
        $this->rank = $rank;
    }

    public function getRank(): string {
        return $this->rank;
    }

    public function jsonPlayer() {
        return json_encode([
            'id' => $this->getId(),
            'score' => $this->getScore(),
            'personalInfo' => $this->getPersonalInfo(),
            'name' => $this->getName(),
            'rank' => $this->getRank()
        ]);
    }

}