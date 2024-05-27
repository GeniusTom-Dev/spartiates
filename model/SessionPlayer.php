<?php

namespace model;

class SessionPlayer extends Entity
{
    private mixed $id;
    private mixed $username;
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
    public function getUsername(): mixed
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername(mixed $username): void
    {
        $this->username = $username;
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

