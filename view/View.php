<?php

namespace view;

abstract class View
{
    private const PATH = [
        'Home' => 'view/home.php',
        'Erreur' => 'view/error.php',
        'Admin' => 'view/adminPages/users.php',
    ];

    public static function display(string $title, ?string $path = null, $data = null) : void
    {
        if($title == 'none') {
            return;
        }
        if(empty($path)) {
            $path = self::PATH[$title] ?? self::PATH['Erreur'];
        }
        if (!file_exists($path))
            header('refresh:0;url=/404');
        if ($path == 'view/play.php') {
            echo str_replace(['%title%'], [$title], file_get_contents($path));
        } else {
            extract(array('data' => $data));
            ob_start();
            require $path;
            $content = ob_get_clean();
//        $content = str_replace(['%username%'], ['alex'], $content);//todo $_GET['username']
            echo str_replace(['%title%', '%content%'], [$title, $content], file_get_contents('view/layout.php'));
        }
    }
}

