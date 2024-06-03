<?php

namespace view;

abstract class View
{
    public static function display(string $title, string $path = null, $data = null, $showLayout = true) : void {


        if (empty($title) && empty($path)){
            header('refresh:0;url=/error');
            exit;
        }

        if($showLayout === false){
            require $path;
        }else{
            extract(array('data' => $data));
            ob_start();
            require $path;
            $content = ob_get_clean();
            echo str_replace(['%title%', '%content%'], [$title, $content], file_get_contents('view/layout.php'));
        }

    }
}

