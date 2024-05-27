<?php

namespace model;
/**
 * La classe User permet de gérer les utilisateurs
 */
class Spartan extends Entity
{
    private mixed $id;
    private mixed $lastName;
    private mixed $name;
    private mixed $number;
    private mixed $star;

    /**
     * @return mixed
     */
    public function isStarred(): mixed
    {
        return $this->star;
    }

    /**
     * @param mixed $star
     */
    public function setStar(mixed $star): void
    {
        $this->star = $star;
    }

    /**
     * @return mixed
     */
    public function getId(): mixed
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId(mixed $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getLastname(): mixed
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastname(mixed $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getName(): mixed
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName(mixed $name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getNumber(): mixed
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber(mixed $number): void
    {
        $this->number = $number;
    }


}
