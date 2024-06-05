<?php

namespace repository;

// TODO unused ?
/**
 * Class EmailRepository
 *
 * This class is responsible for managing the email repository.
 */
class EmailRepository extends AbstractRepository{
    public function getAllEmails(): bool|array {
        $query = 'SELECT Email FROM EMAIL';
        $result = $this->connexion->prepare($query);
        $result->execute();
        return $result->fetchAll();

    }
}