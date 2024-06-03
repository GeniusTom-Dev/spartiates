<?php

namespace repository;

use classe\exception\NotFoundException;
use model\SessionPlayer;
use PDO;

class SessionRepository extends AbstractRepository
{
    public function addSessionPlayer($firstName, $lastName, $email, $phoneNumber): false|string
    {
        $queryDoesEmailExist = 'SELECT id FROM EMAIL WHERE email = :email';
        $statement = $this->connexion->prepare($queryDoesEmailExist);
        $statement->execute([
            'email' => $email
        ]);

        if ($statement->rowCount() === 1) {
            $emailId = $statement->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $query1 = 'INSERT INTO EMAIL (EMAIL ) VALUES (:email )';
            $statement = $this->connexion->prepare($query1);
            $statement->execute([
                'email' => $email
            ]);
        }

        $query = 'INSERT INTO PLAYER (username, score, email) VALUES (:username, 0, (SELECT id FROM EMAIL WHERE email = :email))';
        $statement = $this->connexion->prepare($query);
        $statement->execute([
            'username' => $username,
            'email' => $email
        ]);
        return $this->connexion->lastInsertId();
    }

    public function deleteSession(): void
    {
        $query = 'DELETE FROM PLAYER';
        $statement = $this->connexion->prepare($query);
        $statement->execute();
    }

    public function getRanking(): array
    {
        $query = 'SELECT * FROM PLAYER ORDER BY SCORE DESC limit 10';
        $statement = $this->connexion->prepare($query);
        $statement->execute();
        $sessionUsers = [];
        while ($data = $statement->fetch(PDO::FETCH_ASSOC)) {
            $sessionUsers[] = new SessionPlayer($data);
        }
        return $sessionUsers;
    }

    public function deleteUserById($id): void
    {
        //On supprime un user avec son id
        $query = 'DELETE FROM PLAYER WHERE ID = :id';
        $statement = $this->connexion->prepare($query);
        $statement->execute(['id' => $id]);

        //Si la requête ne rend rien ça veut dire qu'il n'y a aucun utilisateurs avec cette id
        if ($statement->rowCount() === 0) {
            throw new NotFoundException('Aucun USER trouvé');
        }
    }

    public function addScore($id, $scoreToAdd): void
    {
        //On ajoute le score à l'utilisateur
        $query = 'UPDATE PLAYER SET SCORE = SCORE + :scoreToAdd WHERE ID = :id';
        $statement = $this->connexion->prepare($query);
        $statement->execute([
            'id' => $id,
            'scoreToAdd' => $scoreToAdd
        ]);
    }

    public function setScore($id, $score): void
    {
        $query = 'UPDATE PLAYER SET SCORE = :score WHERE ID = :id';
        $statement = $this->connexion->prepare($query);
        $statement->execute([
            'id' => $id,
            'score' => $score
        ]);
    }


    public function getScore($id): int
    {
        //On ajoute le score à l'utilisateur
        $query = 'SELECT * FROM PLAYER WHERE ID = :id';
        $statement = $this->connexion->prepare($query);
        $statement->execute([
            'id' => $id,
        ]);

        //Si la requête ne rend rien ça veut dire qu'il n'y a aucun utilisateurs avec cette id
        if ($statement->rowCount() === 0) {
            throw new NotFoundException('Aucun USER trouvé');
        }

        $data = $statement->fetch();
        return $data['SCORE'];
    }

    public function isInSession($id): bool
    {
        $query = 'SELECT * FROM PLAYER WHERE ID = :id';
        $statement = $this->connexion->prepare($query);
        $statement->execute([
            'id' => $id,
        ]);

        //Si la requête ne rend rien ça veut dire qu'il n'y a aucun utilisateurs avec cette id
        if ($statement->rowCount() === 0) {
            return false;
        }
        return true;
    }

    public function getSessionUser($id): bool|array
    {
        $query = 'SELECT username, score,
       (SELECT COUNT(DISTINCT score) + 1 FROM PLAYER WHERE score > t1.score) AS rank
        FROM PLAYER t1 WHERE ID = :id;';
        $statement = $this->connexion->prepare($query);
        $statement->execute([
            ':id' => $id,
        ]);
        //Si la requête ne rend rien ça veut dire qu'il n'y a aucun utilisateurs avec cette id
        if ($statement->rowCount() === 0) {
            throw new NotFoundException('Aucun USER trouvé');
        }
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMailAndUsernameOfHighestScore(): bool|array
    {
        $query = 'SELECT username, email FROM PLAYER WHERE SCORE = (SELECT MAX(SCORE) FROM PLAYER)';
        $statement = $this->connexion->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


}