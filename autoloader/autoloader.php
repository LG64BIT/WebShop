<?php

spl_autoload_register(function ($class) {
    $class = lcfirst($class);
    $filename = __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    $filename = str_replace("autoloader" . DIRECTORY_SEPARATOR, "", $filename);
    if (file_exists($filename))
        require $filename;
});