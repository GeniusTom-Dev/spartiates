<?php

namespace model;

/**
 * Class Entity
 *
 * This class is responsible for managing entities.
 */
abstract class Entity
{
    /**
     * Entity constructor.
     *
     * Initializes a new instance of the Entity class.
     *
     * @param array $data The data.
     */
    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    /**
     * Hydrates the entity.
     *
     * @param array $data The data.
     *
     * @return void
     */
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