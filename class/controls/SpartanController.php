<?php

namespace class\controls;

use class\dataAccess\database\SpartanTable;
use class\dataAccess\server\SpartanImage;
use class\exception\CannotCreateException;
use class\exception\NotFoundException;
use Exception;
use view\View;

/**
 * Class SpartanController
 *
 * This class is responsible for managing Spartans.
 */
class SpartanController
{
    /**
     * @var SpartanTable
     */
    private SpartanTable $repository;

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
        $this->repository = new SpartanTable();
    }

    /**
     * Displays Spartans.
     *
     * @return void
     */
    public function showSpartans(): void
    {
        $path = 'view/adminPages/spartans.php';
        View::display('Spartiates', $path, $this->repository->getAll());
    }

    /**
     * Create a new Spartan.
     *
     * @param string $lastName The Spartan's last name.
     * @param string $name The Spartan's name.
     *
     * @return void
     */
    public function createSpartan(string $lastName, string $name): void
    {
        $this->repository->createSpartan(trim($lastName), trim($name));
    }

    /**
     * Delete a Spartan.
     *
     * @param int $id The Spartan's ID.
     *
     * @return void
     */
    public function deleteSpartan(int $id): void
    {
        $spartan = $this->repository->getById($id);
        $spartanName = strtolower($spartan->getLastName() . '_' . $spartan->getName());
        SpartanImage::delete($spartanName);
        $this->repository->deleteSpartanById($id);
    }

    /**
     * Update a Spartan.
     *
     * @param int $id The Spartan's ID.
     * @param string $lastName The Spartan's last name.
     * @param string $name The Spartan's name.
     * @param string|null $image The Spartan's path image.
     *
     * @return void
     * @throws Exception
     */
    public function updateSpartan(int $id, string $lastName, string $name, string $image = null): void
    {
        $spartan = $this->repository->getById($id);
        $currentFormattedName = strtolower($spartan->getLastName() . '_' . $spartan->getName());
        $newFormattedName = strtolower(trim($lastName) . '_' . trim($name));
        $this->repository->updateSpartanById($id, trim($lastName), trim($name));

        if (!empty($image['tmp_name'])) {
            SpartanImage::update($currentFormattedName, $newFormattedName, $image['tmp_name']);
        } elseif ($currentFormattedName !== $newFormattedName) {
            SpartanImage::updateName($currentFormattedName, $newFormattedName);
        }
    }

    /**
     * Show the form to create a new Spartan.
     *
     * @param string $url
     * @param int $id
     * @return void
     */
    public function showUpdateForm(string $url, int $id): void
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