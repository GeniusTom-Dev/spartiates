<?php

namespace class\entity;

use class\entity\AbstractEntity;

class PersonalInfo extends AbstractEntity
{
    private int $id;
    private string $name;
    private string $phoneNumber;
    private string $email;

    public function getId(): ?int
    {
        return $this->id ?? null;
    }

    public function setId(int $id): PersonalInfo
    {
        $this->id = $id;
        return $this;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): PersonalInfo
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): PersonalInfo
    {
        $this->email = $email;
        return $this;
    }
    public function equals(PersonalInfo $personalInfo): bool
    {
        if($personalInfo->getName() !== $this->getName()
            || $personalInfo->getPhoneNumber() !== $this->getPhoneNumber()
            || $personalInfo->getEmail() !== $this->getEmail()) {
            return FALSE;
        }
        return TRUE;
    }
    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): PersonalInfo
    {
        $this->name = $name;
        return $this;
    }
}