<?php

namespace controls;

use exception\CannotCreateException;
use exception\NotFoundException;
use repository\SpartanRepository;
use view\View;

class SpartanController
{
    /**
     * @var mixed
     */
    private mixed $repository;

    public function __construct()
    {
        $this->repository = new SpartanRepository();
    }

    public function showSpartan(): void
    {
        try {
            $path = 'view/adminPages/spartiates.php';
            View::display('Spartiates', $path, $this->repository->getAll());
        } catch (NotFoundException $ERROR) {
            file_put_contents('log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        }
    }

    public function createSpartan($lastName, $name): void
    {
        try {
            $this->repository->createSpartan(trim($lastName), trim($name));
        } catch (CannotCreateException $ERROR) {
            file_put_contents('log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        }
    }

    public function deleteSpartan($id): void
    {
        try {
            $this->repository->deleteSpartanById($id);
        } catch (NotFoundException $ERROR) {
            file_put_contents('log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        }
    }

    public function updateSpartan($id, $lastName, $name): void
    {
        try {
            $this->repository->updateSpartanById($id, trim($lastName), trim($name));
        } catch (NotFoundException $ERROR) {
            file_put_contents('log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        }
    }

    public function changeStar($id): void
    {
        try {
            if ($this->repository->isStarredById($id) === 1)
                $this->repository->changeSpartanStarById($id, 0);
            else
                $this->repository->changeSpartanStarById($id, 1);

        } catch (NotFoundException $ERROR) {
            file_put_contents('log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        }
    }

    public function searchSpartan($searchTerm): void
    {
        $searchResult = $this->repository->search($searchTerm);
        foreach ($searchResult as $spartan) {
            echo '
                <div class="flex flex-col items-center justify-center w-full p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                    <div class="flex flex-row items-center justify-between w-full mt-2">
                        <p class="text-lg font-medium text-gray-800 mr-5">' . $spartan->getLastname() . ' ' . $spartan->getName() . '</p>
                        <div class="flex flex-row space-x-2">
                            <div class="inline-block w-8 h-8 bg-customBlue hover:bg-blue-700 rounded cursor-pointer">
                                  <img class="p-1 star" data-spartiate-id="' . $spartan->get_id() . '" data-filled="' . $spartan->isStarred() . '" src="' . ($spartan->isStarred() ? "/assets/images/fullStar.svg" : "/assets/images/emptyStar.svg") . '" alt="etoile du match">
                            </div>
                            <a href="/updateSpartan&id=' . $spartan->get_id() . '" class="inline-block w-8 h-8 bg-customBlue hover:bg-blue-700 rounded">
                                <img class="p-1" src="/assets/images/edit.svg" alt="Edit">
                            </a>
                        </div>
                    </div>
                </div>';
        }
    }

    public function showUpdateForm($url, $id): void
    {
        $path = 'view/forms/' . $url . '.php';
        View::display('MISE A JOUR', $path, $this->repository->getById($id));
    }

    public function showChooseSpartan(): void
    {
        $path = 'view/chooseSpartiate.php';
        View::display('Choix du joueur', $path, $this->repository->getAll());
    }
}