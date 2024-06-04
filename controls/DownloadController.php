<?php

namespace controls;

use repository\EmailRepository;

class DownloadController{

    private mixed $repository;

    public function __construct(){
        $this->repository = new EmailRepository();
    }

    public function dlData(){
        $fileLocation = realpath(".") . '/assets/data/download/emails.csv';

        $emails = $this->repository->getAllEmails();
        $file = fopen($fileLocation, 'w+');
        foreach ($emails as $email){
            fputcsv($file, [$email['Email']]);
        }
        fclose($file);
    }

}