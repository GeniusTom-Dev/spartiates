<?php

namespace class\entity;

/**
 * La classe User permet de gérer les utilisateurs
 *
 * @author BELABBAS-Rayane-2225010aa <Belabbas.rayane[@]etu.univ-amu.fr>
 */
class Question extends AbstractEntity {
    private int $id;
    private string $text;
    private string $answer;
    private string $false1;
    private string $false2;

    /**
     * @return string
     */
    public function getAnswer(): string {
        return $this->answer;
    }

    /**
     * @param string $answer
     */
    public function setAnswer(string $answer): void {
        $this->answer = html_entity_decode($answer);
    }

    /**
     * @return string
     */
    public function getFalse1(): string {
        return $this->false1;
    }

    /**
     * @param string $false1
     */
    public function setFalse1(string $false1): void {
        $this->false1 = html_entity_decode($false1);
    }

    /**
     * @return string
     */
    public function getFalse2(): string {
        return $this->false2;
    }

    /**
     * @param string $false2
     */
    public function setFalse2(string $false2): void {
        $this->false2 = html_entity_decode($false2);
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getText(): string {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void {
        $this->text = html_entity_decode($text);
    }

}
