<?php

namespace model;
/**
 * La classe User permet de gérer les utilisateurs
 */
class User extends Entity
{
    private mixed $user_id;
    private mixed $password;
    private mixed $pseudo;
    private mixed $mail;
    private mixed $score;
    private mixed $admin;

    /**
     * @return mixed
     */
    public function getAdmin(): mixed
    {
        return $this->admin;
    }

    /**
     * @param mixed $admin
     */
    public function setAdmin(mixed $admin): void
    {
        $this->admin = $admin;
    }

    /**
     * @return mixed
     */
    public function getUser_id(): mixed
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUser_id(mixed $user_id): void
    {
        $this->user_id = $user_id;
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
    public function getPseudo(): mixed
    {
        return $this->pseudo;
    }

    /**
     * @param mixed $pseudo
     */
    public function setPseudo(mixed $pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    /**
     * @return mixed
     */
    public function getMail(): mixed
    {
        return $this->mail;
    }

    /**
     * @param mixed $mail
     */
    public function setMail(mixed $mail): void
    {
        $this->mail = $mail;
    }

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


}
