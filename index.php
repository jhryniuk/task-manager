<?php

$loader = require __DIR__.'/vendor/autoload.php';
$routes = require 'app/routing.php';

$uri = $_SERVER["REQUEST_URI"];

foreach ($routes as $pattern => $route) {

    $pattern = str_replace('/', '\/', $pattern);
    $pattern = sprintf('/%s$/', $pattern);

    if (preg_match($pattern, $uri, $output_array)) {
        $params = array_slice($output_array,1);
        $class = sprintf('\%s\Controller\%sController', $route['module'], $route['controller']);
        $action = sprintf('%sAction', $route['action']);
        $controller = new $class();
        $controller->$action($params);
    }
}
