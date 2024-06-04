<?php

namespace controls;

use class\data\database\PersonalInfoTable;

class DownloadController{

    private PersonalInfoTable $personalInfoTable;

    public function __construct(){
        $this->personalInfoTable = new PersonalInfoTable();
    }

    public function dlData(){
        $fileLocation = realpath(".") . '/assets/data/download/emails.csv';
        $file = fopen($fileLocation, 'w');

        $header = ['Nom', 'Email', 'Telephone'];
        fputcsv($file, $header);

        foreach ($this->personalInfoTable->select() as $personalInfo){
            $fields = [
                $personalInfo->getName(),
                $personalInfo->getEmail(),
                $personalInfo->getPhoneNumber(),
            ];
            fputcsv($file, $fields);
        }
        fclose($file);
    }

}