<?php

$loader = require __DIR__.'/vendor/autoload.php';
$routes = require 'app/routing.php';

$uri = $_SERVER["REQUEST_URI"];

if (array_key_exists($uri, $routes)) {
    $route = $routes[$uri];
    $class = sprintf('\%s\Controller\%sController', $route['module'], $route['controller']);
    $action = sprintf('%sAction', $route['action']);
    $controller = new $class();
    $controller->$action();
} else {
    header("HTTP/1.0 404 Not Found");
}
