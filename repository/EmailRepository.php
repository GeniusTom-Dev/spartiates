<?php

namespace repository;

// TODO unused ?
class EmailRepository extends AbstractRepository{
    public function getAllEmails(): bool|array {
        $query = 'SELECT Email FROM EMAIL';
        $result = $this->connexion->prepare($query);
        $result->execute();
        return $result->fetchAll();

    }
}