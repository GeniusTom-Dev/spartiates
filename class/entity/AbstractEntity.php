<?php

namespace class\entity;

abstract class AbstractEntity
{
    /**
     * Abstract construct
     *
     * @param array $data An indexed array to hydrate itself
     */
    public function __construct(?array $data = null)
    {
        if(is_array($data)) {
            $this->hydrate($data);
        }
    }

    /**
     * Instantiates attributes which has setter depending on the input
     *
     * @param array $data An indexed array with key => value format
     * @return void
     */
    public function hydrate(array $data): void
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