<?php

namespace Model;
/**
 * La classe User permet de gérer les utilisateurs
 */
class Spartiate extends Entity
{
    private mixed $spart_id;
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
    public function getSpart_id(): mixed
    {
        return $this->spart_id;
    }

    /**
     * @param mixed $spart_id
     */
    public function setSpart_id(mixed $spart_id): void
    {
        $this->spart_id = $spart_id;
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
