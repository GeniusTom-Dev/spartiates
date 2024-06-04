<?php

namespace model;
/**
 * La classe User permet de gérer les utilisateurs
 */
class Spartan extends Entity
{
    private mixed $id;
    private mixed $lastName;
    private mixed $name;
    private mixed $num;

    /**
     * @return mixed
     */
    public function getId(): mixed
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId(mixed $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getLastname(): mixed
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastname(mixed $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getName(): mixed
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName(mixed $name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getNum(): mixed
    {
        return $this->num;
    }

    /**
     * @param mixed $number
     */
    public function setNum(mixed $number): void
    {
        $this->num = $number;
    }

    public function getFormattedName(){
        $formattedName = $this->formatName($this->getLastname()) . "_" . $this->formatName($this->getName());
        return strtolower($formattedName);
    }

    private function formatName($name){
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
