<?php

namespace repository;

use classe\exception\MoreThanOneException;


class CodesRepository extends AbstractRepository
{

    /**
     * Check whether a code matches the session code stored in the database
     *
     * @param $code : of the session
     * @return bool : true if the code is in the database and false if it is not
     */
    public function checkSessionCode($code): bool
    {
        $query = 'SELECT * FROM SESSION WHERE CODE = :code and ACTIVE = true';
        $result = $this->connexion->prepare($query);
        $result->execute([
            'code' => $code,
        ]);

        if ($result->rowCount() > 1) {
            throw new MoreThanOneException("Duplication de la SESSION $code dans la BD");
        }

        return $result->rowCount() !== 0;
    }

    /**
     * Check if a session exists in the database
     *
     * @return bool : return true if a result is found and false if there is no session
     */
    public function isSessionCode(): bool
    {
        $query = 'SELECT * FROM SESSION';
        $result = $this->connexion->prepare($query);
        $result->execute();

        return $result->rowCount() !== 0;
    }

    public function start($code): void
    {
        $query = 'INSERT INTO SESSION (CODE, ACTIVE)
                    VALUES (:code, 1)';
        $result = $this->connexion->prepare($query);
        $result->execute([
            ':code' => $code,
        ]);
    }

    public function reset(): void
    {
        $query = 'DELETE FROM SESSION';
        $result = $this->connexion->prepare($query);
        $result->execute();
    }

    public function stop(): void
    {
        $query = 'UPDATE SESSION SET ACTIVE = 0;';
        $result = $this->connexion->prepare($query);
        $result->execute();
    }

    public function getSessionCode(): string
    {
        $query = 'SELECT CODE FROM SESSION WHERE ACTIVE = 1';
        $result = $this->connexion->prepare($query);
        $result->execute();
        $data = $result->fetch();

        if ($result->rowCount() === 0) {
            return 'Aucune session en cours';
        }
        return $data['CODE'];
    }

    public function isActive($code): bool
    {
        $query = 'SELECT * FROM SESSION WHERE CODE = :code and ACTIVE = 1';
        $result = $this->connexion->prepare($query);
        $result->execute([
            ':code' => $code,
        ]);
        $result->fetch();

        return $result->rowCount() !== 0;
    }
}