<?php

namespace controls;

use class\exception\CannotCreateException;
use class\exception\NotFoundException;
use class\data\server\SpartanImage;
use Exception;
use repository\SpartanRepository;
use view\View;

/**
 * Class SpartanController
 *
 * This class is responsible for managing Spartans.
 */
class SpartanController
{
    /**
     * @var mixed
     */
    private mixed $repository;

    /**
     * @var SpartanImage
     */
    private SpartanImage $spartImg;

    /**
     * SpartanController constructor.
     *
     * Initializes a new instance of the SpartanController class.
     */
    public function __construct()
    {
        $this->repository = new SpartanRepository();
    }

    /**
     * Displays Spartans.
     *
     * @return void
     */
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

    /**
     * Create a new Spartan.
     *
     * @param string $lastName The Spartan's last name.
     * @param string $name The Spartan's name.
     *
     * @return void
     */
    public function createSpartan($lastName, $name): void
    {
        try {
            $this->repository->createSpartan(trim($lastName), trim($name));
        } catch (CannotCreateException $ERROR) {
            file_put_contents('log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        }
    }

    /**
     * Delete a Spartan.
     *
     * @param mixed $id The Spartan's ID.
     *
     * @return void
     */
    public function deleteSpartan($id): void
    {
        try {
            $this->repository->deleteSpartanById($id);
        } catch (NotFoundException $ERROR) {
            file_put_contents('log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        }
    }

    /**
     * Update a Spartan.
     *
     * @param mixed $id The Spartan's ID.
     * @param string $lastName The Spartan's last name.
     * @param string $name The Spartan's name.
     * @param mixed $image The Spartan's image.
     *
     * @return void
     */
    public function updateSpartan($id, $lastName, $name, $image = null): void
    {
        try {
            $spartan = $this->repository->getById($id);
            $currentFormattedName = strtolower($spartan->getLastname() . '_' . $spartan->getFormattedName());
            $newFormattedName = strtolower(trim($lastName) . '_' . trim($name));

            $this->repository->updateSpartanById($id, trim($lastName), trim($name));

            if (empty($image['tmp_name']) === false && is_null($image) === false) {
                SpartanImage::update($currentFormattedName, $newFormattedName, $image['tmp_name']);
            } elseif ($currentFormattedName !== $newFormattedName) {
                SpartanImage::update($currentFormattedName, $newFormattedName);
            }
        } catch (NotFoundException $ERROR) {
            file_put_contents('log/HockeyGame.log', $ERROR->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $ERROR->getMessage();
        } catch (Exception $e) {
            file_put_contents('log/HockeyGame.log', $e->getMessage() . "\n", FILE_APPEND | LOCK_EX);
            echo $e->getMessage();
        }
    }

    /**
     * Show the form to create a new Spartan.
     *
     * @param $url
     * @param $id
     * @return void
     */
    public function showUpdateForm($url, $id): void
    {
        $path = 'view/forms/' . $url . '.php';
        View::display('MISE A JOUR', $path, $this->repository->getById($id));
    }

    /**
     * Show the form to create a new Spartan.
     *
     * @return void
     */
    public function showChooseSpartan(): void
    {
        $path = 'view/chooseSpartan.php';
        View::display('Choix du joueur', $path, $this->repository->getAll());
    }
}