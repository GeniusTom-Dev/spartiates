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
        $file = fopen($fileLocation, 'w+');

        $header = [
            'Nom', 'Email', 'Telephone'
        ];
        fputcsv($file, $header);

        foreach ($this->personalInfoTable->select() as $personalInfo){
            $fields = [
                'name' => $personalInfo->getName(),
                'email' => $personalInfo->getEmail(),
                'phone' => $personalInfo->getPhoneNumber(),
            ];
            fputcsv($file, $fields);
        }
        fclose($file);
    }

}