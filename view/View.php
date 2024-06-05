<?php

namespace view;

/**
 * Class View
 *
 * This class is responsible for managing the view.
 */
abstract class View
{
    /**
     * Display the view
     *
     * @param string $title The title of the view
     * @param string|null $path The path of the view
     * @param mixed|null $data The data of the view
     * @param bool $showLayout The layout of the view
     * @return void
     */
    public static function display(string $title, string $path = null, $data = null, $showLayout = true) : void {
        if (empty($title) && empty($path)){
            header('refresh:0;url=/error');
            exit;
        }

        if($showLayout === false){
            require $path;
        } else {
            extract(array('data' => $data));
            ob_start();
            require $path;
            $content = ob_get_clean();
            echo str_replace(['%title%', '%content%'], [$title, $content], file_get_contents('view/layout.php'));
        }

    }
}

