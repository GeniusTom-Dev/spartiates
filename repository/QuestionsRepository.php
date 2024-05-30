<?php

namespace repository;

use exception\MoreThanOneException;
use exception\NotFoundException;
use model\Question;
use PDO;

class QuestionsRepository extends AbstractRepository
{

    public function getById($id): Question
    {
        $query = 'SELECT * FROM QUESTION WHERE ID = :id';
        $statement = $this->connexion->prepare($query);
        $statement->execute(['id' => $id]);

        // Si la requête ne rend rien ça veut dire qu'il n'y a aucune question avec cette id
        if ($statement->rowCount() === 0) {
            throw new NotFoundException('Aucune QUESTION trouvée');
        }
        //exception imposible mais a prévoire car on ne peut insérer qu'une question du meme ID
        if ($statement->rowCount() > 1) {
            throw new MoreThanOneException("Duplication de la QUESTION $id");
        }
        $question = $statement->fetch();
        return new Question($question);
    }

    public function getQuestion(): array
    {
        $query = 'SELECT * FROM QUESTION ORDER BY RAND();';
        $statement = $this->connexion->prepare($query);
        $statement->execute();

        //on récupère le résultat de la requête SQL
        $arraySQL = $statement->fetchAll();
        //on crée un tableau de questions
        $arrayQuestions = array();

        //on transforme le tableau de données SQL en tableau de questions
        for ($i = 0; $i < sizeof($arraySQL); $i++) {
            $question = new Question($arraySQL[$i]);
            $arrayQuestions[] = $question;
        }
        return $arrayQuestions;
    }

    public function getAll(): array
    {
        $query = 'SELECT * FROM QUESTION';
        $statement = $this->connexion->prepare($query);
        $statement->execute();

        //on crée un tableau de questions contenant toutes les données
        $arraySQL = $statement->fetchAll();
        $arrayQuestions = array();

        /* on récupère le résultat de la requête SQL et on le met dans un tableau d'User'*/
        for ($i = 0; $i < sizeof($arraySQL); $i++) {
            $question = new Question($arraySQL[$i]);
            $arrayQuestions[] = $question;
        }
        return $arrayQuestions;
    }

    public function createQuestion($text, $true, $false1, $false2): void
    {
        $query = "INSERT INTO QUESTION (ID, TEXT, ANSWER, FALSE1, FALSE2) VALUES (NULL, :text, :true, :false1, :false2);";
        $statement = $this->connexion->prepare($query);
        $statement->execute([
            ':text' => $text,
            ':true' => $true,
            ':false1' => $false1,
            ':false2' => $false2]);

    }

    public function deleteQuestionById($id): void
    {
        //On supprime une question avec son id
        $query = 'DELETE FROM QUESTION WHERE ID = :id';
        $statement = $this->connexion->prepare($query);
        $statement->execute(['id' => $id]);

        //Si la requête ne rend rien ça veut dire qu'il n'y a aucune question avec cette id
        if ($statement->rowCount() === 0) {
            throw new NotFoundException('Aucun QUESTION trouvé');
        }
    }

    public function updateQuestionById($id, $text, $answer, $false1, $false2): void
    {
        $query = "UPDATE QUESTION SET TEXT = :text, ANSWER= :answer, FALSE1= :false1, FALSE2= :false2  WHERE ID = :id;";
        $statement = $this->connexion->prepare($query);
        $statement->execute([
            ':text' => $text,
            ':id' => $id,
            ':answer' => $answer,
            ':false1' => $false1,
            ':false2' => $false2]);
    }

    public function search($searchTerm): array
    {
        $query = "SELECT * FROM QUESTION WHERE TEXT LIKE :searchTerm LIMIT 10";
        $statement = $this->connexion->prepare($query);
        $statement->execute([':searchTerm' => "%$searchTerm%"]);

        $questions = [];
        while ($data = $statement->fetch(PDO::FETCH_ASSOC)) {
            $questions[] = new Question($data);
        }
        return $questions;
    }

}
