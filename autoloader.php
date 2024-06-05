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


/*spl_autoload_register(function ($class) {
    // Répertoires où chercher les classes
    $directories = [
        __DIR__ . "/class",
        __DIR__ . "/controls",
        __DIR__ . "/repository",
        __DIR__ . "/view",
    ];

    // Convertit le namespace de la classe en chemin relatif au système de fichiers
    $classPath = str_replace("\\", "/", $class) . ".php";

    // Parcourt les répertoires pour trouver le fichier de classe
    foreach ($directories as $directory) {
        // Recherche tous les fichiers PHP dans le répertoire et ses sous-répertoires
        $files = glob($directory . "/**/
/**.php", GLOB_BRACE);
        foreach ($files as $file) {
            // Vérifie si le fichier correspond à la classe recherchée
            if (basename($file) === basename($classPath)) {
                include_once $file;
                return;
            }
        }
    }
});*//*spl_autoload_register(function ($class) {
    // Répertoires où chercher les classes
    $directories = [
        __DIR__ . "/class",
        __DIR__ . "/controls",
        __DIR__ . "/repository",
        __DIR__ . "/view",
    ];

    // Convertit le namespace de la classe en chemin relatif au système de fichiers
    $classPath = str_replace("\\", "/", $class) . ".php";

    // Parcourt les répertoires pour trouver le fichier de classe
    foreach ($directories as $directory) {
        // Recherche tous les fichiers PHP dans le répertoire et ses sous-répertoires
        $files = glob($directory . "/**/
/**.php", GLOB_BRACE);
        foreach ($files as $file) {
            // Vérifie si le fichier correspond à la classe recherchée
            if (basename($file) === basename($classPath)) {
                include_once $file;
                return;
            }
        }
    }
});*/