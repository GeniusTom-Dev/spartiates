<?php

namespace controls;

use classe\exception\CannotCreateException;
use classe\exception\NotFoundException;
use classes\data\server\SpartanImage;
use repository\SpartanRepository;
use view\View;

class SpartanController
{
    /**
     * @var mixed
     */
    private mixed $repository;
    private SpartanImage $spartImg;

    public function __construct()
    {
        $this->repository = new SpartanRepository();
    }

    public function showSpartans(): void
    {
        try {
            $path = 'view/adminPages/spartans.php';
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

    public function updateSpartan($id, $lastName, $name, $image = null): void
    {
        try {
            $spartan = $this->repository->getById($id);
            $currentFormattedName = strtolower($spartan->getLastname() . '_' . $spartan->getName());
            $newFormattedName = strtolower(trim($lastName) . '_' . trim($name));

            $this->repository->updateSpartanById($id, trim($lastName), trim($name));

            if (!empty($image['tmp_name'])) {
                SpartanImage::update($currentFormattedName, $newFormattedName, $image['tmp_name']);
            } elseif ($currentFormattedName !== $newFormattedName) {
                SpartanImage::updateName($currentFormattedName, $newFormattedName);
            }
        } catch (NotFoundException $ERROR) {
            file_put_contents('log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        } catch (Exception $e) {
            file_put_contents('log/HockeyGame.log', $e->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $e->getMessage();
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


    public function showUpdateForm($url, $id): void
    {
        $path = 'view/forms/' . $url . '.php';
        View::display('MISE A JOUR', $path, $this->repository->getById($id));
    }

    public function showChooseSpartan(): void
    {
        $path = 'view/chooseSpartan.php';
        View::display('Choix du joueur', $path, $this->repository->getAll());
    }
}