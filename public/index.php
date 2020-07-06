<?php

/**
 * Front controller
 * 
 * PHP version 7.3.11
 */

spl_autoload_register(function($class) {
    $root = dirname(__DIR__);//get the root directory of this site
    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';//use \\ to represent \
    //echo $file;
    if (is_readable($file)) {
        require $file;
    }
});

$router = new Core\Router();

$router ->add('', ['controller' => 'Home', 'action' => 'index']);
$router ->add('{controller}/{action}');
$router ->add('{controller}/{id:\d+}/{action}');
//don't add / before admin
$router ->add('admin/{controller}/{action}', ['namespace' => 'Admin']);

$url = $_SERVER['QUERY_STRING'];

$router->dispatch($url);
/*
echo '<pre>';
var_dump($router->getRoutes());
echo '</pre>';
*/



