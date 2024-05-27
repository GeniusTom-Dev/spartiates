<?php

namespace model;

class SessionPlayer extends Entity
{
    private mixed $id;
    private mixed $login;
    private mixed $score;
    private mixed $email;

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
    public function setId(mixed $id): void
    {
        $this->id = $id;
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

    /**
     * @return mixed
     */

    /**
     * @return mixed
     */
    public function getScore(): mixed
    {
        return $this->score;
    }

    /**
     * @param mixed $score
     */
    public function setScore(mixed $score): void
    {
        $this->score = $score;
    }

    /**
     * @return mixed
     */
    public function getEmail(): mixed
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail(mixed $email): void
    {
        $this->email = $email;
    }


}

