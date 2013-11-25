<?php

//change the current working directory to the application directory
chdir(dirname(__DIR__));

//let the php cli-server serve static files directly
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

//include autoloader
include 'vendor/autoload.php';

//run the application
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
