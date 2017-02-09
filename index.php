<?php

require_once 'vendor/autoload.php';

$app = new Application();

$app->loadRoutes(__DIR__.'/app/config/routing.yml');
$app->loadParameters(__DIR__.'/app/config/parameter.yml');

$app->handle($_SERVER["REQUEST_URI"]);
