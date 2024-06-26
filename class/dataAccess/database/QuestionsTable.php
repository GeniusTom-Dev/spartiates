<?php

namespace class\dataAccess\database;

use class\entity\Question;
use class\exception\MoreThanOneException;
use class\exception\NotFoundException;
use PDO;

/**
 * Class QuestionsTable
 *
 * This class is responsible for managing the question repository.
 */
class QuestionsTable extends AbstractTable
{

    /**
     * Get a Questions
     *
     * @param int $id : id of the question
     */
    public function getById(int $id): Question
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

    /**
     * Get all the questions in a random order
     *
     * @return array : return an array of questions
     */
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

    /**
     * Get all questions
     *
     * @return array : return an array of questions
     */
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

    /**
     * Create a question
     *
     * @param string $text : text of the question
     * @param string $true : true answer
     * @param string $false1 : false answer
     * @param string $false2 : false answer
     */
    public function createQuestion(string $text, string $true, string $false1, string $false2): void
    {
        $query = "INSERT INTO QUESTION (ID, TEXT, ANSWER, FALSE1, FALSE2) VALUES (NULL, :text, :true, :false1, :false2);";
        $statement = $this->connexion->prepare($query);
        $statement->execute([
            ':text' => $text,
            ':true' => $true,
            ':false1' => $false1,
            ':false2' => $false2]);

    }

    /**
     * Delete a question
     *
     * @param int $id : id of the question
     */
    public function deleteQuestionById(int $id): void
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

    /**
     * Update a question
     *
     * @param int $id : id of the question
     * @param string $text : text of the question
     * @param string $answer : true answer
     * @param string $false1 : false answer
     * @param string $false2 : false answer
     */
    public function updateQuestionById(int $id, string $text, string $answer, string $false1, string $false2): void
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

    /**
     * Search a question
     *
     * @param string $searchTerm : term to search
     * @return array : return an array of questions
     */
    public function search(string $searchTerm): array
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
