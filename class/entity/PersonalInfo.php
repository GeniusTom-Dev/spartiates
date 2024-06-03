<?php

namespace classe\entity;

use class\AbstractEntity;

class PersonalInfo extends AbstractEntity
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private string $phoneNumber;
    private string $email;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): PersonalInfo
    {
        $this->id = $id;
        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): PersonalInfo
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): PersonalInfo
    {
        $this->lastName = $lastName;
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
        if($personalInfo->getFirstName() !== $this->getFirstName()
            && $personalInfo->getLastName() !== $this->getLastName()
            && $personalInfo->getPhoneNumber() !== $this->getPhoneNumber()
            && $personalInfo->getEmail() !== $this->getEmail()) {
            return FALSE;
        }
        return TRUE;
    }
}