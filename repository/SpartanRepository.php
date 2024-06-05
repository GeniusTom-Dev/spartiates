<?php

namespace repository;

use class\exception\MoreThanOneException;
use class\exception\NotFoundException;
use class\entity\Spartan;
use PDO;

/**
 * Class SpartanRepository
 *
 * This class is responsible for managing the Spartans repository.
 */
class SpartanRepository extends AbstractRepository
{
    /**
     * Get a Spartan
     *
     * @param int $id : id of the spartan
     */
    public function getById(int $id): Spartan
    {
        $query = 'SELECT * FROM SPARTAN WHERE ID = :id';
        $statement = $this->connexion->prepare($query);
        $statement->execute(['id' => $id]);

        // Si la requête ne rend rien ça veut dire qu'il n'y a aucun spartiate avec cette id
        if ($statement->rowCount() === 0) {
            throw new NotFoundException('Aucun SPARTIATE trouvé');
        }
        // Exception impossible, mais à prévoir, car on ne peut insérer qu'un spartiate du meme ID
        if ($statement->rowCount() > 1) {
            throw new MoreThanOneException("Duplication du SPARTIATE $id dans la BD");
        }
        $spartan = $statement->fetch();
        return new Spartan($spartan);
    }

    /**
     * Get all Spartans
     *
     * @return array : return an array of Spartans
     */
    public function getAll(): array
    {
        $query = 'SELECT * FROM SPARTAN';
        $statement = $this->connexion->prepare($query);
        $statement->execute();

        // On crée un tableau de Spartiates contenant toutes les données
        $arraySQL = $statement->fetchAll();
        $arrayUser = array();

        // On récupère le résultat de la requête SQL et on le met dans un tableau d'User'
        for ($i = 0; $i < sizeof($arraySQL); $i++) {
            $user = new Spartan($arraySQL[$i]);
            $arrayUser[] = $user;
        }
        return $arrayUser;
    }

    /**
     * Create a Spartan
     *
     * @param string $lastname : lastname of the Spartan
     * @param string $name : name of the Spartan
     */
    public function createSpartan(string $lastname, string $name): void
    {
        $query = "INSERT INTO SPARTAN (LASTNAME, NAME) VALUES (:lastName, :name);";
        $statement = $this->connexion->prepare($query);
        $statement->execute([
            ':lastName' => $lastname,
            ':name' => $name]);
    }

    /**
     * Delete a Spartan by ID
     *
     * @param int $id : id of the Spartan
     */
    public function deleteSpartanById(int $id): void
    {
        // On supprime un spartiate avec son id
        $query = 'DELETE FROM SPARTAN WHERE ID = :id';
        $statement = $this->connexion->prepare($query);
        $statement->execute(['id' => $id]);

        // Si la requête ne rend rien ça veut dire qu'il n'y a aucun spartiates avec cette id
        if ($statement->rowCount() === 0) {
            throw new NotFoundException('Aucun SPARTIATE trouvé');
        }
    }

    /**
     * Update a Spartan by ID
     *
     * @param int $id : id of the Spartan
     * @param string $lastName : lastname of the Spartan
     * @param string $name : name of the Spartan
     */
    public function updateSpartanById(int $id, string $lastName, string $name): void
    {
        $query = "UPDATE SPARTAN SET LASTNAME = :lastName, NAME = :name WHERE ID = :id;";
        $statement = $this->connexion->prepare($query);
        $statement->execute([
            ':lastName' => $lastName,
            ':name' => $name,
            ':id' => $id]);

    }

    /**
     * Search a Spartan by name
     *
     * @param string $searchTerm : name of the Spartan
     * @return array : return an array of Spartans
     */
    public function search(string $searchTerm): array
    {
        $query = "SELECT * FROM SPARTAN WHERE LASTNAME LIKE :searchTerm OR NAME LIKE :searchTerm LIMIT 10";
        $statement = $this->connexion->prepare($query);
        $statement->execute([':searchTerm' => "%$searchTerm%"]);

        $spartiates = [];
        while ($data = $statement->fetch(PDO::FETCH_ASSOC)) {
            $spartiates[] = new Spartan($data);
        }
        return $spartiates;
    }

    /**
     * Increment the selection frequency of a Spartan
     *
     * @param int $id : id of the Spartan
     */
    public function incrementSpartanChoose(int $id): void {
        if($this->getById($id) instanceof Spartan){
            $query = "UPDATE SPARTAN SET SelectionFrequency = SelectionFrequency + 1 WHERE ID = :id";
            $statement = $this->connexion->prepare($query);
            $statement->execute(['id' => $id]);
        }

    }
}
