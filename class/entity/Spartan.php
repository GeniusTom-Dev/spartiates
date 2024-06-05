<?php

namespace class\entity;

use class\data\server\SpartanImage;

class Spartan extends AbstractEntity
{
    private int $id;
    private string $name;
    private string $lastName;

    // nom img
    private string $formattedName;
    // chemin img
    private string $image;

    private int $selectionFrequency;

    public function getSelectionFrequency(): int {
        return $this->selectionFrequency;
    }

    public function setSelectionFrequency(int $selectionFrequency): void {
        $this->selectionFrequency = $selectionFrequency;
    }

    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->formattedName = $this->name . ' ' . $this->lastName;
        $this->image = SpartanImage::get($this->formattedName);
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

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): Spartan
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getFormattedName(): string
    {
        return $this->formattedName;
    }

    public function setFormattedName(string $formattedName): Spartan
    {
        $this->formattedName = $formattedName;
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

    public function setId(int $id): Spartan
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

}