<?php

spl_autoload_register(function ($class) {
    $fileName = $class . ".php";
    $fileName = str_replace("\\", "/", $fileName);
    $path = explode("/", realpath("."));
    if(end($path) !== "www"){
        $fileName = "../" . $fileName;
    }
    if (file_exists($fileName)) {
        include_once $fileName;
    }
});