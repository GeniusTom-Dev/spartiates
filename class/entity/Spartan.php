<?php

namespace class\model;

use class\AbstractEntity;
use class\data\server\SpartanImage;

class Spartan extends AbstractEntity
{
    private mixed $id;
    private string $firstName;
    private string $lastName;
    private string $name;
    private string $image;

    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->name = $this->firstName . ' ' . $this->lastName;
        $this->image = SpartanImage::getSpartan($this->name);
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): Spartan
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): Spartan
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Spartan
    {
        $this->name = $name;
        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): Spartan
    {
        $this->image = $image;
        return $this;
    }

    public function setId(mixed $id): Spartan
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): mixed
    {
        return $this->id;
    }

}