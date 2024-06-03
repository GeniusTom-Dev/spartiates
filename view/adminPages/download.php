<?php
$fileLocation = realpath(".") . '/assets/data/download/emails.csv';
$cptSecurity = 10;

while($cptSecurity > 0){
    if(file_exists($fileLocation)){
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $fileLocation . '"');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fileLocation));

        ob_clean();
        flush();

        readfile($fileLocation);
        unlink($fileLocation);

        break;
    }

    sleep(1);
    $cptSecurity--;
}