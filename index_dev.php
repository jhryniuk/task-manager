<?php

require_once 'vendor/autoload.php';

$app = new Application('dev');

$app->loadParameters(__DIR__.'/app/config/parameter_dev.yml');
$app->loadServices(__DIR__.'/app/config/service.yml');
$app->loadRoutes(__DIR__.'/app/config/routing.yml');

try {
    $app->handle($_SERVER["REQUEST_URI"]);
} catch (Exception $e) {
    echo sprintf('<h2>Application Broken! %s</h2>', $e->getMessage());
}
