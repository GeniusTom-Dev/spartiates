<?php

namespace model;


abstract class Entity
{
    // Constructor
    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    // Hydratation
    public function hydrate($data): void
    {
        foreach ($data as $key => $value) {
            $key = strtolower($key);
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
}