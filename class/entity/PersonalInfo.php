<?php

namespace class\entity;

/**
 * Class PersonalInfo
 *
 * This class is responsible for managing the personal info entity.
 */
class PersonalInfo extends AbstractEntity
{
    /**
     * @var int|null $id The Id of the personal info
     */
    private ?int $id;

    /**
     * @var string $name The name of the player
     */
    private string $name;

    /**
     * @var string $phoneNumber The phone number of the player
     */
    private string $phoneNumber;

    /**
     * @var string $email The email of the player
     */
    private string $email;

    /***
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id ?? null;
    }

    /***
     * @param int $id
     * @return PersonalInfo
     */
    public function setId(int $id): PersonalInfo
    {
        $this->id = $id;
        return $this;
    }

    /***
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /***
     * @param string $phoneNumber The phone number of the player
     * @return PersonalInfo
     */
    public function setPhoneNumber(string $phoneNumber): PersonalInfo
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /***
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /***
     * @param string $email The email of the player
     * @return PersonalInfo
     */
    public function setEmail(string $email): PersonalInfo
    {
        $this->email = $email;
        return $this;
    }

    /***
     * @param PersonalInfo $personalInfo The personal info to compare
     * @return bool
     */
    public function equals(PersonalInfo $personalInfo): bool
    {
        if($personalInfo->getName() !== $this->getName()
            || $personalInfo->getPhoneNumber() !== $this->getPhoneNumber()
            || $personalInfo->getEmail() !== $this->getEmail()) {
            return FALSE;
        }
        return TRUE;
    }

    /***
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /***
     * @param string $name The name of the player
     * @return PersonalInfo
     */
    public function setName(string $name): PersonalInfo
    {
        $this->name = $name;
        return $this;
    }
}