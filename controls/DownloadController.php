<?php

namespace controls;

use class\data\database\PersonalInfoTable;

class DownloadController{

    private PersonalInfoTable $personalInfoTable;

    public function __construct(){
        $this->personalInfoTable = new PersonalInfoTable();
    }

    public function dlData(string $separator = ';'){
        $filePath = realpath(".") . '/assets/data/download/emails.csv';

        if(file_exists($filePath)){
            unlink($filePath);
        }

        $file = fopen($filePath, 'w');


        $header = ['Nom', 'Email', 'Telephone'];
        fputcsv($file, $header, $separator);

        foreach ($this->personalInfoTable->select() as $personalInfo){
            $fields = [
                $personalInfo->getName(),
                $personalInfo->getEmail(),
                $personalInfo->getPhoneNumber(),
            ];
            fputcsv($file, $fields, $separator);
        }
        fclose($file);
    }

}