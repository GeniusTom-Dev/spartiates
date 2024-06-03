<?php

namespace classes\data\server;

use Exception;
use InvalidArgumentException;
use exception\NotFoundException;

/**
 * Contains static methods and constants used to get, add, update and delete spartan images from the server.
 *
 * The $name and $image are usually like this :
 * ```php
 * $name = $firstName . '_' . $lastName;
 * $image = $_FILES['filesToUpload']['tmp_name']
 * ```
 *
 */

class SpartanImage
{
    /**
     * Directory where the spartan images are put.
     */
    const SPARTAN_IMAGES_DIRECTORY = __DIR__ . '/assets/spartImage/';
    /**
     * The allowed files extension for the spartan images.
     */
    const ALLOWED_EXTENSIONS = ['jpg', 'png', 'gif', 'jpeg'];
    /**
     * Max image size (5 Mo)
     */
    const MAX_IMAGE_SIZE = 5000000;

    /**
     * Find a directory matching the given spartan name.
     *
     * @param string $name The name of the spartan.
     * @return string The directory where he can be found.
     * @throws NotFoundException When no files match the name.
     */

    public static function getSpartan(string $name) : string
    {
        foreach (self::ALLOWED_EXTENSIONS as $extension) {
            $file = self::SPARTAN_IMAGES_DIRECTORY . $name . $extension;
            if (file_exists($file)) {
                return $file;
            }
        }
        throw new NotFoundException("Aucun spartiate ne correspond à $name");
    }

    /**
     * Create a new spartan.
     *
     * @param string $name The spartan name.
     * @param string $image The image of the spartan.
     * @return bool True on success, False on failure.
     * @throws Exception If the file is too big or the extension is invalid
     */

    public static function addSpartan(string $name, string $image) : bool
    {
        self::checkImage($image);
        $name = self::formatName($name);
        try {
            self::getSpartan($name);
            self::updateImage($name, $image);
        } catch(NotFoundException) {
            $extension = self::getExtension(basename($image));
            $file = self::SPARTAN_IMAGES_DIRECTORY . $name . $extension;
            return move_uploaded_file($image, $file) ?? TRUE;
        }
        return TRUE;
    }

    /**
     * Update a spartan.
     *
     * Check if he needs an update before processing it.
     *
     * @param string $currentName The spartan's current name.
     * @param string $newName The spartan's new name.
     * @param string|null $image [OPTIONAL] The spartan's image.
     * @return bool TRUE on success OR if nothing matches, FALSE on failure.
     * @throws Exception if the extension is not okay.
     */

    public static function update(string $currentName, string $newName, ?string $image = null) : bool
    {
        if($currentName != $newName) {
            self::updateName($currentName, $newName);
        }
        if(isset($image)) {
            self::updateImage($currentName, $image);
        }
        return TRUE;
    }

    /**
     * Change a spartan name.
     *
     * @param string $currentName The spartan's current name.
     * @param string $newName The spartan's new name.
     * @return bool TRUE on success OR if nothing matches, FALSE on failure.
     * @throws Exception if the extension is not okay.
     */

    public static function updateName(string $currentName, string $newName) : bool
    {
        $currentName = self::formatName($currentName);
        $newName = self::formatName($newName);
        $file = self::getSpartan($currentName);
        $extension = self::getExtension($file);
        $newName = self::SPARTAN_IMAGES_DIRECTORY . $newName . $extension;
        return rename($file, $newName);
    }

    /**
     * Change a spartan image.
     *
     * @param string $name The spartan's name.
     * @param string $image The spartan's new image.
     * @return bool TRUE on success OR if nothing matches, FALSE on failure.
     */

    public static function updateImage(string $name, string $image) : bool
    {
        $name = self::formatName($name);
        $file = self::getSpartan($name);
        return rename($file, $image) ?? TRUE;
    }

    /**
     * Delete a Spartan.
     *
     * @param string $name The spartan name.
     * @return bool TRUE on success OR if nothing matches, FALSE on failure.
     */

    public static function deleteSpartan(string $name) : bool
    {
        $name = self::formatName($name);
        $file = self::getSpartan($name);
        return unlink($file);
    }

    /**
     * Get a file's extension.
     *
     * Checks also if the extension is allowed.
     *
     * @param string $directory The file to extract the extension from.
     * @return string The file's extension.
     * @throws Exception If the extension is not allowed.
     */

    private static function getExtension(string $directory) : string
    {
        $extension = strtolower(pathinfo($directory, PATHINFO_EXTENSION));
        if(!in_array($extension, self::ALLOWED_EXTENSIONS)) {
            throw new Exception("L'extension $extension ne convient pas, essayer plutôt : .png .jpg .gif .jpeg ");
        }
        return $extension;
    }

    /**
     * Checks and format a given spartan name.
     *
     * Trims it, replaces whitespaces and special characters.
     *
     * @param string $name The name to format.
     * @return string The formatted name.
     * @throws InvalidArgumentException If the name contains invalid characters.
     */

    private static function formatName(string $name) : string
    {
        $name = trim($name);
        $name = str_replace(' ', '_', $name);

        // TODO Move the replacement of special characters into its own global function because it could be usefull elsewhere

        $specialChars =
            array('à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý');
        $replacements =
            array('a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y');
        $name = str_replace($specialChars, $replacements, $name);

        // Check if the name contains only alphanumeric characters and underscores
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $name)) {
            throw new InvalidArgumentException('Invalid characters in the name.');
        }

        return $name;
    }

    /**
     * Checks a given image.
     *
     * @param string $image The name to format.
     * @return void
     * @throws Exception If the file is not okay (too big, extension not allowed, extension not allowed).
     */

    private static function checkImage(string $image) : void
    {
        self::getExtension($image);
        if(getimagesize($image) > self::MAX_IMAGE_SIZE) {
            throw new Exception("La taille de l'image est trop grande");
        }
    }
}