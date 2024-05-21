<?php

namespace Model;
/**
 * La classe User permet de gérer les utilisateurs
 *
 * @author BELABBAS-Rayane-2225010aa <Belabbas.rayane[@]etu.univ-amu.fr>
 */
class Spartiate extends Entity
{
    private $spart_id;
    private $lastName;
    private $name;
    private $number;
    private $star;

    /**
     * @return mixed
     */
    public function isStarred()
    {
        return $this->star;
    }

    /**
     * @param mixed $star
     */
    public function setStar($star): void
    {
        $this->star = $star;
    }

    /**
     * @return mixed
     */
    public function getSpart_id()
    {
        return $this->spart_id;
    }

    /**
     * @param mixed $spart_id
     */
    public function setSpart_id($spart_id): void
    {
        $this->spart_id = $spart_id;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastname($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number): void
    {
        $this->number = $number;
    }


}
