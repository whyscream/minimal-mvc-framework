<?php

    // show all PHP errors
    ini_set('error_reporting', -1);
    ini_set('display_errors', 1);

    // autoload mvc framework components
    require '../mvc/autoload.php';

    // create path to directory that contains our application
    $app_dir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'example-app';

    $app = new Mvc\Application($app_dir);
    $app->run();
?>
