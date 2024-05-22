<?php

namespace Repository;

use Exception\MoreThanOneException;


class CodesRepository extends AbstractRepository
{

    public function checkSessionCode($code): bool
    {
        // On récupère tous les Users avec le même pseudo et password
        $query = 'SELECT * FROM CODES WHERE CODE_TYPE = "SESSION" and CODE = :code ';
        $result = $this->connexion->prepare($query);
        $result->execute([
            'code' => $code,
        ]);

        if ($result->rowCount() > 1) {
            throw new MoreThanOneException("Duplication de la SESSION $code dans la BD");
        }

        return $result->rowCount() !== 0;
    }

    // TODO what is this ???
    public function isSessionCode(): bool
    {
        $query = 'SELECT * FROM CODES WHERE CODE_TYPE = "SESSION"';
        $result = $this->connexion->prepare($query);
        $result->execute();

        return $result->rowCount() !== 0;
    }

    public function start($code): void
    {
        $query = 'INSERT INTO CODES (CODE_TYPE, CODE)
                    VALUES ("SESSION", :code)';
        $result = $this->connexion->prepare($query);
        $result->execute([
            ':code' => $code,
        ]);
    }

    public function reset(): void
    {
        $query = 'DELETE FROM CODES WHERE CODE_TYPE = "SESSION"';
        $result = $this->connexion->prepare($query);
        $result->execute();
    }

    public function stop(): void
    {
        $query = 'UPDATE CODES SET ACTIVE = 0 WHERE CODE_TYPE = "SESSION";';
        $result = $this->connexion->prepare($query);
        $result->execute();
    }

    public function getSessionCode(): string
    {
        $query = 'SELECT CODE FROM CODES WHERE CODE_TYPE = "SESSION" and ACTIVE = 1';
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
        $query = 'SELECT * FROM CODES WHERE CODE_TYPE = "SESSION" and CODE = :code and ACTIVE = 1';
        $result = $this->connexion->prepare($query);
        $result->execute([
            ':code' => $code,
        ]);
        $result->fetch();

        return $result->rowCount() !== 0;
    }
}