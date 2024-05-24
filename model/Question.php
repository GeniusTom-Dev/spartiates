<?php

namespace model;
/**
 * La classe User permet de gérer les utilisateurs
 *
 * @author BELABBAS-Rayane-2225010aa <Belabbas.rayane[@]etu.univ-amu.fr>
 */
class Question extends Entity
{
    private mixed $question_id;
    private mixed $text;
    private mixed $response;
    private mixed $false1;
    private mixed $false2;

    /**
     * @return mixed
     */
    public function getResponse(): mixed
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     */
    public function setResponse(mixed $response): void
    {
        $this->response = html_entity_decode($response);
    }

    /**
     * @return mixed
     */
    public function getFalse1(): mixed
    {
        return $this->false1;
    }

    /**
     * @param mixed $false1
     */
    public function setFalse1(mixed $false1): void
    {
        $this->false1 = html_entity_decode($false1);
    }

    /**
     * @return mixed
     */
    public function getFalse2(): mixed
    {
        return $this->false2;
    }

    /**
     * @param mixed $false2
     */
    public function setFalse2(mixed $false2): void
    {
        $this->false2 = html_entity_decode($false2);
    }

    /**
     * @return mixed
     */
    public function getQuestion_id(): mixed
    {
        return $this->question_id;
    }

    /**
     * @param mixed $question_id
     */
    public function setQuestion_id(mixed $question_id): void
    {
        $this->question_id = $question_id;
    }

    /**
     * @return mixed
     */
    public function getText(): mixed
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText(mixed $text): void
    {
        $this->text = html_entity_decode($text);
    }

}
