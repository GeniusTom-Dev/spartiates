<?php

namespace class\model;

use class\data\server\SpartanImage;
use class\entity\AbstractEntity;

/**
 * Class Spartan
 *
 * This class is responsible for managing the spartan entity.
 */
class Spartan extends AbstractEntity
{
    /**
     * @var mixed $id The id of the spartan
     */
    private mixed $id;

    /**
     * @var string $firstName The first name of the spartan
     */
    private string $firstName;

    /**
     * @var string $lastName The last name of the spartan
     */
    private string $lastName;

    /**
     * @var string $name The name of the spartan
     */
    private string $name;

    /**
     * @var string $image The image of the spartan
     */
    private string $image;

    /**
     * Spartan constructor
     *
     * @param array $data An indexed array to hydrate itself
     */
    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->name = $this->firstName . ' ' . $this->lastName;
        $this->image = SpartanImage::get($this->name);
    }

    /**
     * Spartan constructor
     *
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * Spartan constructor
     *
     * @param string $firstName
     * @return Spartan
     */
    public function setFirstName(string $firstName): Spartan
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * Spartan constructor
     *
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * Spartan constructor
     *
     * @param string $lastName
     * @return Spartan
     */
    public function setLastName(string $lastName): Spartan
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * Spartan constructor
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Spartan constructor
     *
     * @param string $name
     * @return Spartan
     */
    public function setName(string $name): Spartan
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Spartan constructor
     *
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * Spartan constructor
     *
     * @param string $image
     * @return Spartan
     */
    public function setImage(string $image): Spartan
    {
        $this->image = $image;
        return $this;
    }

    /**
     * Spartan constructor
     *
     * @param mixed $id
     * @return Spartan
     */
    public function setId(mixed $id): Spartan
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Spartan constructor
     *
     * @return mixed
     */
    public function getId(): mixed
    {
        return $this->id;
    }

}