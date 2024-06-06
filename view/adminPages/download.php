<?php
$fileLocation = realpath(".") . '/assets/data/download/emails.csv';
$cptSecurity = 30;

while($cptSecurity > 0){
    if(file_exists($fileLocation)){
        //$fileHandle = fopen($fileLocation, 'r');
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $fileLocation . '"');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fileLocation));

        ob_clean();
        flush();

        readfile($fileLocation);
        //unlink($fileLocation);

        //fclose($fileHandle);

        // Redirection vers l'URL /accueil
        //header('Location: /users');
        exit;
    }

    sleep(1);
    header('refresh:0;url=/' . "download");
    $cptSecurity--;
}
