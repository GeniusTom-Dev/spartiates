<?php

namespace repository;

class EmailRepository extends AbstractRepository{
    public function getAllEmails(){
        $query = 'SELECT Email FROM EMAIL';
        $result = $this->connexion->prepare($query);
        $result->execute();
        return $result->fetchAll();

    }
}