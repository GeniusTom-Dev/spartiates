<?php

namespace controls;

use class\data\database\PersonalInfoTable;

/**
 * Class DownloadController
 *
 * This class is responsible for handling data downloads.
 */
class DownloadController{

    /**
     * @var PersonalInfoTable The table for personal information.
     */
    private PersonalInfoTable $personalInfoTable;

    /**
     * DownloadController constructor.
     *
     * Initializes a new instance of the DownloadController class.
     */
    public function __construct(){
        $this->personalInfoTable = new PersonalInfoTable();
    }

    /**
     * Downloads data.
     *
     * @param string $separator The separator to use in the CSV file.
     *
     * @return void
     */
    public function dlData(string $separator = ';'): void {
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