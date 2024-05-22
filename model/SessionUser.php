<?php

namespace Model;

class SessionUser extends Entity
{
    private $session_user_id;
    private $pseudo;
    private $code;
    private $score;

    /**
     * @return mixed
     */
    public function getSession_user_id()
    {
        return $this->session_user_id;
    }

    /**
     * @param mixed $session_user_id
     */
    public function setSession_user_id($session_user_id): void
    {
        $this->session_user_id = $session_user_id;
    }

    /**
     * @return mixed
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * @param mixed $pseudo
     */
    public function setPseudo($pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code): void
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param mixed $score
     */
    public function setScore($score): void
    {
        $this->score = $score;
    }


}

