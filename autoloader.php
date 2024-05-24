<?php

spl_autoload_register(function ($class) {
    $fileName = $class . ".php";
    $fileName = str_replace("\\", "/", $fileName);
    $path = explode("/", realpath("."));
    $fileName = __DIR__ . "/" . $fileName;

    if (file_exists($fileName)) {
        include_once $fileName;
    }
});