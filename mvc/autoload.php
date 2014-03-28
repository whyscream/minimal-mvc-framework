<?php

    /**
     * Autoloader file for all files in mvc/
     */

    spl_autoload_register(function($class_name) {
        $parts = explode('\\', $class_name);
        if (strtolower($parts[0]) !== 'mvc') {
            return;
        }
        $parts[0] = __DIR__;
        $class_path = implode(DIRECTORY_SEPARATOR, $parts) .'.php';
        if (!is_readable($class_path)) {
            return;
        }
        require $class_path;
    });
