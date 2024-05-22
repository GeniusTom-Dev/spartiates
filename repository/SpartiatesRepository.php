<?php

namespace Repository;

use Exception\MoreThanOneException;
use Exception\NotFoundException;
use Model\Spartiate;
use PDO;

class SpartiatesRepository extends AbstractRepository
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getById($id): Spartiate
    {
        $query = 'SELECT * FROM SPARTIATE WHERE SPART_ID = :id';
        $statement = $this->connexion->prepare($query);
        $statement->execute(['id' => $id]);

        //Si la requête ne rend rien ça veut dire qu'il n'y a aucun spartiate avec cette id
        if ($statement->rowCount() === 0) {
            throw new NotFoundException('Aucun SPARTIATE trouvé');
        }
        //exception imposible mais a prévoire car on ne peut insérer qu'un spartiate du meme ID
        if ($statement->rowCount() > 1) {
            throw new MoreThanOneException("Problème présent dans la BD");
        }
        $spartiate = $statement->fetch();
        return new Spartiate($spartiate);
    }

    public function getAll(): array
    {
        $query = 'SELECT * FROM SPARTIATE';
        $statement = $this->connexion->prepare($query);
        $statement->execute();

//        if ($statement->rowCount() === 0) {
//            throw new NotFoundException('Aucun untilisateur n\'a été trouvé ');
//        }

        //on créer un tableau de Spartiates contenant toutes les données
        $arraySQL = $statement->fetchAll();
        $arrayUser = array();

        /* on récupére le résultat de la requête SQL et on le met dans un tableau d'User'*/
        for ($i = 0; $i < sizeof($arraySQL); $i++) {
            $user = new Spartiate($arraySQL[$i]);
            $arrayUser[] = $user;
        }
        return $arrayUser;
    }

    public function createSpartiate($lastname, $name): void
    {
        $query = "INSERT INTO SPARTIATE (SPART_ID, LASTNAME, NAME) VALUES (NULL, :lastName, :name);";
        $statement = $this->connexion->prepare($query);
        $statement->execute([
            ':lastName' => $lastname,
            ':name' => $name]);
    }

    public function deleteSpartiateById($id): void
    {
        //On supprime un spartiate avec son id
        $query = 'DELETE FROM SPARTIATE WHERE SPART_ID = :id';
        $statement = $this->connexion->prepare($query);
        $statement->execute(['id' => $id]);

        //Si la requête ne rend rien ça veut dire qu'il n'y a aucun spartiates avec cette id
        if ($statement->rowCount() === 0) {
            throw new NotFoundException('Aucun SPARTIATE trouvé');
        }
    }

    public function isStarredById($id): int
    {
        //On select le score d'un utilisateur par rapport a son id
        $query = 'SELECT STAR FROM SPARTIATE WHERE SPART_ID = :id';
        $statement = $this->connexion->prepare($query);
        $statement->execute(['id' => $id]);

        //Si la requête ne rend rien ça veut dire qu'il n'y a aucun utilisateurs avec cette id
        if ($statement->rowCount() === 0) {
            throw new NotFoundException('Aucun USER trouvé');
        }
        //exception imposible mais a prévoire car on ne peut insérer qu'un User
        if ($statement->rowCount() > 1) {
            throw new MoreThanOneException("Problème présent dans la BD");
        }
        $user = $statement->fetch();
        return $user["STAR"];
    }

    public function changeSpartiateStarById($id, $starred)
    {
        $query = "UPDATE SPARTIATE SET STAR = :starred WHERE SPART_ID = :id;";
        $statement = $this->connexion->prepare($query);
        $statement->execute([
            ':starred' => $starred,
            ':id' => $id]);
    }

    public function updateSpartiateById($id, $lastName, $name)
    {
        $query = "UPDATE SPARTIATE SET LASTNAME = :lastName, NAME = :name WHERE SPART_ID = :id;";
        $statement = $this->connexion->prepare($query);
        $statement->execute([
            ':lastName' => $lastName,
            ':name' => $name,
            ':id' => $id]);

    }

    public function search($searchTerm)
    {
        $query = "SELECT * FROM SPARTIATE WHERE LASTNAME LIKE :searchTerm OR NAME LIKE :searchTerm LIMIT 10";
        $statement = $this->connexion->prepare($query);
        $statement->execute([':searchTerm' => "%$searchTerm%"]);

        $spartiates = [];
        while ($data = $statement->fetch(PDO::FETCH_ASSOC)) {
            $spartiates[] = new Spartiate($data);
        }
        return $spartiates;
    }
}
