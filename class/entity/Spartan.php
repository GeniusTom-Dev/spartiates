<?php

namespace class\entity;

use class\data\server\SpartanImage;

/**
 * Class Spartan
 *
 * This class is responsible for managing the spartan entity.
 */
class Spartan extends AbstractEntity
{

    /**
     * @var int $id The id of the spartan
     */
    private int $id;

    /**
     * @var string $name The first name of the spartan
     */
    private string $name;

    /**
     * @var string $lastName The last name of the spartan
     */
    private string $lastName;

    /**
     * @var string $formattedName The concatenation of the lastname and name, used for the image's name
     */
    private string $formattedName;

    /**
     * @var string $image The path of the image
     */
    private string $image;

    /**
     * @var int $selectionFrequency The number of time a spartan has been chosen
     */
    private int $selectionFrequency;

    /***
     * @param array $data An indexed array to hydrate itself
     */

    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->formattedName = $this->name . ' ' . $this->lastName;
        $this->image = SpartanImage::get($this->formattedName);
    }

    /***
     * @return int
     */
    public function getSelectionFrequency(): int {
        return $this->selectionFrequency;
    }

    /***
     * @param int $selectionFrequency
     * @return Spartan
     */
    public function setSelectionFrequency(int $selectionFrequency): Spartan {
        $this->selectionFrequency = $selectionFrequency;
        return $this;
    }

    /***
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /***
     * @param string $name
     * @return Spartan
     */
    public function setName(string $name): Spartan
    {
        $this->name = $name;
        return $this;
    }

    /***
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return Spartan
     */
    public function setLastName(string $lastName): Spartan
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getFormattedName(): string
    {
        return $this->formattedName;
    }

    /**
     * @param string $formattedName
     * @return Spartan
     */
    public function setFormattedName(string $formattedName): Spartan
    {
        $this->formattedName = $formattedName;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @return Spartan
     */
    public function setImage(string $image): Spartan
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @param int $id
     * @return Spartan
     */
    public function setId(int $id): Spartan
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

}