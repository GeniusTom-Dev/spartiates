<?php

namespace Model;
/**
 * La classe User permet de gérer les utilisateurs
 *
 * @author BELABBAS-Rayane-2225010aa <Belabbas.rayane[@]etu.univ-amu.fr>
 */
class Question extends Entity
{
    private $question_id;
    private $text;
    private $difficulty;
    private $response;
    private $false1;
    private $false2;

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     */
    public function setResponse($response): void
    {
        $this->response = html_entity_decode($response);
    }

    /**
     * @return mixed
     */
    public function getFalse1()
    {
        return $this->false1;
    }

    /**
     * @param mixed $false1
     */
    public function setFalse1($false1): void
    {
        $this->false1 = html_entity_decode($false1);
    }

    /**
     * @return mixed
     */
    public function getFalse2()
    {
        return $this->false2;
    }

    /**
     * @param mixed $false2
     */
    public function setFalse2($false2): void
    {
        $this->false2 = html_entity_decode($false2);
    }

    /**
     * @return mixed
     */
    public function getQuestion_id()
    {
        return $this->question_id;
    }

    /**
     * @param mixed $question_id
     */
    public function setQuestion_id($question_id): void
    {
        $this->question_id = $question_id;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text): void
    {
        $this->text = html_entity_decode($text);
    }

    /**
     * @return mixed
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * @param mixed $difficulty
     */
    public function setDifficulty($difficulty): void
    {
        $this->difficulty = $difficulty;
    }


}
