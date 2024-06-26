<?php

namespace class\entity;
/**
 * Class Admin
 *
 * This class is responsible for managing the admin.
 */
class Admin extends AbstractEntity
{
    private mixed $id;
    private mixed $password;
    private mixed $login;
    private mixed $active;

    /**
     * Admin constructor.
     *
     * Initializes a new instance of the Admin class.
     */
    public function isAdminActive(): mixed
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive(mixed $active): void
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getId(): mixed
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId(mixed $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getPassword(): mixed
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword(mixed $password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getLogin(): mixed
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin(mixed $login): void
    {
        $this->login = $login;
    }

}
