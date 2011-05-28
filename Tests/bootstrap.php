<?php

if (!class_exists('Zend_Loader_Autoloader')) {
    if (!file_exists(__DIR__ .  '/autoload.php') && file_exists(__DIR__ .  '/autoload.php.dist')) {
        die('For the tests you need to add in the include path framework library, see ' . __DIR__ . '/autoload.php.dist' . PHP_EOL);
    }
    require_once __DIR__ .  '/autoload.php';
}

require_once 'Zend/Loader/Autoloader.php';

$loader = Zend_Loader_Autoloader::getInstance();
$loader->registerNamespace('Ulrika');
