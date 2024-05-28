<?php

namespace view;

abstract class View
{
    private const PATH = [
        'Home' => 'view/home.php',
        'Erreur' => 'view/error.php',
        'Admin' => 'view/adminPages/users.php',
        'Regles' => 'view/rules.php',
        'entrer le code' => 'view/forms/sessionCode.php',
        'entrer un nom d\'utilisateur' => 'view/forms/username.php',
        'Connexion' => 'view/forms/connect.php',
        'Nouvelle Question' => 'view/forms/newQuestion.php',
        'Nouveau Spartiate' => 'view/forms/newSpartan.php',
        'Jeu de hockey' => 'view/game.php',
    ];

    public static function display(string $title, ?string $path = null, $data = null) : void
    {
        if($title == 'none') {
            return;
        }
        if(empty($path)) {
            $path = self::PATH[$title] ?? self::PATH['Erreur'];
        }
        if(empty($path)) {
            return;
        }
        if (!file_exists($path))
            header('refresh:0;url=/404');

        extract(array('data' => $data));
        ob_start();
        require $path;
        $content = ob_get_clean();
//        $content = str_replace(['%username%'], ['alex'], $content);//todo $_GET['username']
        echo str_replace(['%title%', '%content%'], [$title, $content], file_get_contents('view/layout.php'));

    }
}

