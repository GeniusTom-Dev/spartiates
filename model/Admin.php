<?php

namespace model;
/**
 * La classe User permet de gérer les utilisateurs
 */
class Admin extends Entity
{
    private mixed $id;
    private mixed $password;
    private mixed $login;
    private mixed $active;

    /**
     * @return mixed
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
    public function get_id(): mixed
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function set_id(mixed $id): void
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
