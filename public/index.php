<?php

/**
 * Front controller
 * 
 * PHP version 7.3.11
 */
require('../Core/Router.php');

$router = new Router();

$router ->add('', ['controller' => 'Home', 'action' => 'index']);
$router ->add('posts', ['controller' => 'Posts', 'action' => 'index']);
$router ->add('{controller}/{action}');
$router ->add('{controller}/{id:\d+}/{action}');
$router ->add('admin/{action}/{controller}');

echo '<pre>';
echo htmlspecialchars(print_r($router ->getRoutes(), true));
echo '</pre>';

$url = $_SERVER['QUERY_STRING'];

if ($router->match($url)) {
    echo '<pre>';
    var_dump($router->getParams());
    echo '</pre>';
} else {
    echo "No route found for URL '$url'";
}



