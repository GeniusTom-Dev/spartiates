<?php

namespace model;
/**
 * La classe User permet de gérer les utilisateurs
 */
class Spartan extends Entity
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $lastName;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var int
     */
    private int $selectionFrequency;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastname(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getSelectionFrequency(): int
    {
        return $this->selectionFrequency;
    }

    /**
     * @param int $selectionFrequency
     */
    public function setSelectionFrequency(int $selectionFrequency): void
    {
        $this->selectionFrequency = $selectionFrequency;
    }

    /**
     * Get the formatted name of a Spartan
     *
     * @return string The formatted name
     */
    public function getFormattedName(): string {
        $formattedName = $this->formatName($this->getLastname()) . "_" . $this->formatName($this->getName());
        return strtolower($formattedName);
    }

    /**
     * Format the name of a Spartan
     *
     * @param string $name The name to format
     * @return string The formatted name
     */
    private function formatName($name): array|string {
        $name = trim($name);
        $name = str_replace(' ', '_', $name);

        // TODO Move the replacement of special characters into its own global function because it could be usefull elsewhere

        $specialChars =
            array('à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý');
        $replacements =
            array('a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y');
        $name = str_replace($specialChars, $replacements, $name);

        // Check if the name contains only alphanumeric characters and underscores
        if (preg_match('/^[a-zA-Z0-9_]+$/', $name)) {
            return $name;
        }

        return "";

    }


}
