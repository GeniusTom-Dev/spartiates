<?php

namespace class\data\database;

use class\entity\PersonalInfo;
use repository\AbstractRepository;

class PersonalInfoTable extends AbstractRepository
{
    /**
     * Select a tuple from the PersonalInfo table
     *
     * @param null|int|PersonalInfo $key Either the Id, the personal info, or null if you wish to select all.
     * @return PersonalInfo|PersonalInfo[]|FALSE One or more PersonalInfo
     */
    public function select(null|int|PersonalInfo $key = null): PersonalInfo|array|FALSE
    {
        $query = 'SELECT * FROM PERSONAL_INFO';
        $values = array();

        if (is_int($key)) {
            $query .= ' WHERE Id = :id';
            $values = ['id' => $key];
        } else if ($key instanceof PersonalInfo) {
            $query .= ' WHERE Name = :name AND PhoneNumber = :phoneNumber AND Email = :email';
            $values = [
                'name' => $key->getName(),
                'phoneNumber' => $key->getPhoneNumber(),
                'email' => $key->getEmail()
            ];
        }

        $result = $this->connexion->prepare($query);
        $result->execute($values);

        if ($result->rowCount() === 0) {
            return FALSE;
        }

        $tupleArray = $result->fetchAll();
        $personalInfoArray = array();

        foreach ($tupleArray as $tuple) {
            $personalInfoArray[] = new PersonalInfo($tuple);
        }

        return $result->rowCount() === 1 ? $personalInfoArray[0] : $personalInfoArray;
    }

    /**
     * Insert a personal info and returns its Id
     *
     * If the tuple already exists, prevent the insertion and return the existing Id
     *
     * Also set the Id attribute of the given PersonalInfo
     *
     * @param PersonalInfo $personalInfo The personal info to insert
     * @return int The Id of the given PersonalInfo
     */
    public function insert(PersonalInfo &$personalInfo): int
    {
        $existingPersonalInfo = $this->select($personalInfo);

        if ($existingPersonalInfo !== FALSE) {
            return $existingPersonalInfo->getId();
        }

        $query = <<<SQL
                INSERT INTO PERSONAL_INFO (Name, PhoneNumber, Email)
                VALUES (:name, :phoneNumber, :email)
        SQL;
        $values = [
            'name' => $personalInfo->getName(),
            'phoneNumber' => $personalInfo->getPhoneNumber(),
            'email' => $personalInfo->getEmail(),
        ];
        $this->connexion->prepare($query)->execute($values);

        $id = $this->select($personalInfo)->getId();

        $personalInfo->setId($id);
        return $id;
    }

    /**
     * Update an existing tuple
     *
     * @param int|PersonalInfo $key Either the existing tuple's i or its data
     * @param PersonalInfo $personalInfo The new data
     * @return void
     */
    public function update(int|PersonalInfo $key, PersonalInfo $personalInfo) : void
    {
        $existingPersonalInfo = $this->select($key);

        if($existingPersonalInfo === FALSE || $personalInfo->equals($existingPersonalInfo)) {
            return;
        }

        $query = <<<SQL
            UPDATE PERSONAL_INFO
            SET FirstName = :name, PhoneNumber :phoneNumber, Email = :email
            WHERE Id = :id
        SQL;

        $values = [
            'name' => $personalInfo->getName(),
            'phoneNumber' => $personalInfo->getPhoneNumber(),
            'email' => $personalInfo->getEmail(),
            'id' => $existingPersonalInfo->getId(),
        ];

        $this->connexion->prepare($query)->execute($values);
    }

    /**
     * Delete a persona info
     *
     * @param int|PersonalInfo $key Either its key or its data
     * @return void
     */

    public function delete(int|PersonalInfo $key): void
    {
        $existingPersonalInfo = $this->select($key);

        if($existingPersonalInfo === FALSE) {
            return;
        }

        $query = <<<SQL
            DELETE FROM PERSONAL_INFO
            WHERE Id = :id
        SQL;

        $values = [
            'id' => $existingPersonalInfo->getId(),
        ];

        $this->connexion->prepare($query)->execute($values);
    }

}