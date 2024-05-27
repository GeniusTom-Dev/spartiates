<?php

namespace model;
/**
 * La classe User permet de gérer les utilisateurs
 *
 * @author BELABBAS-Rayane-2225010aa <Belabbas.rayane[@]etu.univ-amu.fr>
 */
class Question extends Entity
{
    private mixed $id;
    private mixed $text;
    private mixed $answer;
    private mixed $false1;
    private mixed $false2;

    /**
     * @return mixed
     */
    public function getAnswer(): mixed
    {
        return $this->answer;
    }

    /**
     * @param mixed $answer
     */
    public function setAnswer(mixed $answer): void
    {
        $this->answer = html_entity_decode($answer);
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
