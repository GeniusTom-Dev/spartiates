<?php

namespace controls;

use class\exception\CannotCreateException;
use class\exception\NotFoundException;
use repository\QuestionsRepository;
use view\View;

class QuestionsController
{
    /**
     * @var QuestionsRepository
     */
    private QuestionsRepository $repository;

    /**
     * QuestionsController constructor.
     *
     * Initializes a new instance of the QuestionsController class.
     */
    public function __construct()
    {
        $this->repository = new QuestionsRepository();
    }


    /**
     * Displays all questions.
     *
     * @return void
     */
    public function showQuestions(): void
    {
        try {
            $path = 'view/adminPages/questions.php';
            View::display('Questions', $path, $this->repository->getAll());
        } catch (NotFoundException $ERROR) {
            file_put_contents('log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        }
    }

    /**
     * Send an Ajax response with the question corresponding to the $index of a random list of questions stocker in $_SESSION
     * The list of questions is $_SESSION is randomized so that the "index/id" of the questions changed every time.
     * The $index of the question that we are going to get is randomized, to prevent players to have the same questions in the same order
     *
     * @param int $index
     * @return void
     */
    public function getQuestion(int $index): void
    {
        if (empty($_SESSION['randomQuestion'])) {
            $question = $this->repository->getQuestion();
            $_SESSION['randomQuestion'] = $question;
        }
        if (!empty($_SESSION['randomQuestion'])) {
            $temp = array('text' => $_SESSION['randomQuestion'][$index]->getText(),
                'answer' => $_SESSION['randomQuestion'][$index]->getAnswer(),
                'false1' => $_SESSION['randomQuestion'][$index]->getFalse1(),
                'false2' => $_SESSION['randomQuestion'][$index]->getFalse2(),);
            echo json_encode($temp);
        }
    }

    /**
     * Send an Ajax response with the total number of questions (with a maximum of 200)
     *
     * @return void
     */
    public function getQuestionsNumber(): void
    {
        if (empty($_SESSION['randomQuestion'])) {
            $question = $this->repository->getQuestion();
            $_SESSION['randomQuestion'] = $question;
        }
        if (sizeof($_SESSION['randomQuestion']) > 200) {
            echo json_encode(200);
        } else {
            echo json_encode(sizeof($_SESSION['randomQuestion']));
        }
    }

    /**
     * Check if the player answer is the correct answer
     * TODO : gérer si l'index est mauvais
     * @param $index
     * renvoie un json avec l'attribut, "isAnswerCorrect": true, if the user find the good answer and , "isAnswerCorrect": false, otherwise.
     */
    public function getAnswer(int $index) : void
    {
        if (!empty($_SESSION['randomQuestion'])) {
            echo json_encode($_SESSION['randomQuestion'][$index]->getAnswer());
        }
    }

    /**
     * Creates a new question.
     *
     * @param string $text The text of the question.
     * @param string $true The correct answer.
     * @param string $false1 The first incorrect answer.
     * @param string $false2 The second incorrect answer.
     *
     * @return void
     */
    public function createQuestion($text, $true, $false1, $false2): void
    {
        try {
            $this->repository->createQuestion(trim($text), trim($true), trim($false1), trim($false2));
        } catch (CannotCreateException $ERROR) {
            file_put_contents('log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        }
    }


    /**
     * Deletes a question by its ID.
     *
     * @param int $id The ID of the question.
     *
     * @return void
     */
    public function deleteQuestion($id): void
    {
        try {
            $this->repository->deleteQuestionById($id);
        } catch (NotFoundException $ERROR) {
            file_put_contents('log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        }
    }

    /**
     * Updates a question by its ID.
     *
     * @param int $id The ID of the question.
     * @param string $text The new text of the question.
     * @param string $true The new correct answer.
     * @param string $false1 The new first incorrect answer.
     * @param string $false2 The new second incorrect answer.
     *
     * @return void
     */
    public function updateQuestion($id, $text, $true, $false1, $false2): void
    {
        try {
            $this->repository->updateQuestionById($id, trim($text), trim($true), trim($false1), trim($false2));
        } catch (NotFoundException $ERROR) {
            file_put_contents('log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        }
    }

    /**
     * Searches for questions that match a search term.
     *
     * @param string $searchTerm The term to search for.
     *
     * @return void
     */
    public function searchQuestion($searchTerm): void
    {
        $questions = $this->repository->search($searchTerm);
        foreach ($questions as $question) {
            echo '
            <div class="flex flex-col items-center justify-center w-full p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                <div class="flex flex-row items-center justify-between w-full mt-2">
                    <p class="text-lg font-medium text-gray-800 mr-5"> ' . $question->getText() . ' </p>
                    <div class="flex flex-row space-x-2">
                        <a href="/updateQuestion&id=' . $question->getId() . '" class="inline-block w-8 h-8 bg-customBlue hover:bg-blue-700 rounded cursor-pointer">
                            <img class="p-1" src="/assets/images/edit.svg" alt="Delete">
                        </a>
                        <button data-id="<?= $question->getId() ?>" data-modal-target="deleteModalQuestion" data-modal-toggle="deleteModalQuestion" class="callActionButton inline-block w-8 h-8 bg-red-500 hover:bg-red-700 rounded" type="button">
                                <img class="p-1" src="/assets/images/trashcan.svg" alt="Delete">
                        </button>
                    </div>
                </div>
            </div>';
        }
    }

    /**
     * Displays the form to update a question.
     *
     * @param string $url The URL of the form.
     * @param int $id The ID of the question.
     *
     * @return void
     */
    public function showUpdateForm($url, $id): void
    {
        $path = 'view/forms/' . $url . '.php';
        View::display('MISE A JOUR', $path, $this->repository->getById($id));
    }

}