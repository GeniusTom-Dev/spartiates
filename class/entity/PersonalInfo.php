<?php

namespace class\entity;

use class\entity\AbstractEntity;

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
    private int $id;

    /**
     * @var string $name The name of the personal info
     */
    private string $name;

    /**
     * @var string $phoneNumber The phone number of the personal info
     */
    private string $phoneNumber;

    /**
     * @var string $email The email of the personal info
     */
    private string $email;

    /**
     * PersonalInfo constructor
     *
     * @param array|null $data An indexed array to hydrate itself
     */
    public function getId(): ?int
    {
        return $this->id ?? null;
    }

    /**
     * PersonalInfo constructor
     *
     * @param array|null $data An indexed array to hydrate itself
     */
    public function setId(int $id): PersonalInfo
    {
        $this->id = $id;
        return $this;
    }

    /**
     * PersonalInfo constructor
     *
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * PersonalInfo constructor
     *
     * @param string $phoneNumber The phone number of the personal info
     * @return PersonalInfo
     */
    public function setPhoneNumber(string $phoneNumber): PersonalInfo
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * PersonalInfo constructor
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * PersonalInfo constructor
     *
     * @param string $email The email of the personal info
     * @return PersonalInfo
     */
    public function setEmail(string $email): PersonalInfo
    {
        $this->email = $email;
        return $this;
    }

    /**
     * PersonalInfo constructor
     *
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

    /**
     * PersonalInfo constructor
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * PersonalInfo constructor
     *
     * @param string $name The name of the personal info
     * @return PersonalInfo
     */
    public function setName(string $name): PersonalInfo
    {
        $this->name = $name;
        return $this;
    }
}