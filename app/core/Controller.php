<?php

namespace App\Core;

class Controller
{
    protected function render($view, $data = [])
    {
        // Extract data to variables
        extract($data);

        // Include the view file
        //include __DIR__ . "/../views/{$view}.php";
        $path = str_replace("\\", DIRECTORY_SEPARATOR, $view);
        $path = str_replace(".", DIRECTORY_SEPARATOR, $path);
        $file = APP_ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . $path . '.php';
        //echo $file;
        if (file_exists($file)) {
            extract($data);
            require_once $file;
        } else {
            echo "Page not found";
        }
    }

    protected function redirect($url)
    {
        header("Location: $url");
        exit;
    }
}
