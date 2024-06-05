<?php

namespace repository;

use class\exception\MoreThanOneException;
use class\exception\NotFoundException;
use class\entity\Spartan;
use PDO;

class SpartanRepository extends AbstractRepository
{

    public function getById($id): Spartan
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

    public function createSpartan($lastname, $name): void
    {
        $query = "INSERT INTO SPARTAN (LASTNAME, NAME) VALUES (:lastName, :name);";
        $statement = $this->connexion->prepare($query);
        $statement->execute([
            ':lastName' => $lastname,
            ':name' => $name]);
    }

    public function deleteSpartanById($id): void
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

    public function updateSpartanById($id, $lastName, $name): void
    {
        $query = "UPDATE SPARTAN SET LASTNAME = :lastName, NAME = :name WHERE ID = :id;";
        $statement = $this->connexion->prepare($query);
        $statement->execute([
            ':lastName' => $lastName,
            ':name' => $name,
            ':id' => $id]);

    }

    public function search($searchTerm): array
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

    public function incrementSpartanChoose(int $id): void {
        if($this->getById($id) instanceof Spartan){
            $query = "UPDATE SPARTAN SET SelectionFrequency = SelectionFrequency + 1 WHERE ID = :id";
            $statement = $this->connexion->prepare($query);
            $statement->execute(['id' => $id]);
        }

    }
}
