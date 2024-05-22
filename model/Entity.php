<?php

namespace Model;


abstract class Entity
{
    //Constructeur
    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    //Hydratation
    public function hydrate($data)
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