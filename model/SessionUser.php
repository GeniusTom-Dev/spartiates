<?php

namespace model;

class SessionUser extends Entity
{
    private mixed $session_user_id;
    private mixed $pseudo;
    private mixed $code;
    private mixed $score;

    /**
     * @return mixed
     */
    public function getSession_user_id(): mixed
    {
        return $this->session_user_id;
    }

    /**
     * @param mixed $session_user_id
     */
    public function setSession_user_id(mixed $session_user_id): void
    {
        $this->session_user_id = $session_user_id;
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
    public function getCode(): mixed
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode(mixed $code): void
    {
        $this->code = $code;
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

