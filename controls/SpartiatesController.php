<?php

namespace Controls;

use Exception\CannotCreateException;
use Exception\NotFoundException;
use Repository\SpartiatesRepository;
use View\View;

class SpartiatesController
{
    /**
     * @var mixed
     */
    private $repository;

    public function __construct()
    {
        $this->repository = new SpartiatesRepository();
    }

    public function showSpartiates(): void
    {
        try {
            $path = 'view/adminPages/spartiates.php';
            View::display('Spartiates', $path, $this->repository->getAll());
        } catch (NotFoundException $ERROR) {
            file_put_contents('log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        }
    }

    public function createSpartiate($lastName, $name): void
    {
        try {
            $this->repository->createSpartiate($lastName, $name);
        } catch (CannotCreateException $ERROR) {
            file_put_contents('log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        }
    }

    public function deleteSpartiate($id): void
    {
        try {
            $this->repository->deleteSpartiateById($id);
        } catch (NotFoundException $ERROR) {
            file_put_contents('log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        }
    }

    public function updateSpartiate($id, $lastName, $name)
    {
        try {
            $this->repository->updateSpartiateById($id, $lastName, $name);
        } catch (NotFoundException $ERROR) {
            file_put_contents('log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        }
    }

    public function changeStar($id)
    {
        try {
            if ($this->repository->isStarredById($id) === 1)
                $this->repository->changeSpartiateStarById($id, 0);
            else
                $this->repository->changeSpartiateStarById($id, 1);

        } catch (NotFoundException $ERROR) {
            file_put_contents('log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        }
    }

    public function searchSpartiate($searchTerm)
    {
        $questions = $this->repository->search($searchTerm);
        foreach ($questions as $spartiate) {
            echo '
                <div class="flex flex-col items-center justify-center w-full p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                    <div class="flex flex-row items-center justify-between w-full mt-2">
                        <p class="text-lg font-medium text-gray-800 mr-5">' . $spartiate->getLastname() . ' ' . $spartiate->getName() . '</p>
                        <div class="flex flex-row space-x-2">
                            <div class="inline-block w-8 h-8 bg-customBlue hover:bg-blue-700 rounded cursor-pointer">
                                  <img class="p-1 star" data-spartiate-id="' . $spartiate->getSpart_id() . '" data-filled="' . $spartiate->isStarred() . '" src="' . ($spartiate->isStarred() ? "/assets/images/fullStar.svg" : "/assets/images/emptyStar.svg") . '" alt="etoile du match">
                            </div>
                            <a href="/updateSpartiate&id=' . $spartiate->getSpart_id() . '" class="inline-block w-8 h-8 bg-customBlue hover:bg-blue-700 rounded">
                                <img class="p-1" src="/assets/images/edit.svg" alt="Edit">
                            </a>
                        </div>
                    </div>
                </div>';
        }
    }

    public function showUpdateForm($url, $id)
    {
        $path = 'view/forms/' . $url . '.php';
        View::display('MISE A JOUR', $path, $this->repository->getById($id));
    }

    public function showChooseSpartiate()
    {
        $path = 'view/chooseSpartiate.php';
        View::display('Choix du joueur', $path, $this->repository->getAll());
    }
}