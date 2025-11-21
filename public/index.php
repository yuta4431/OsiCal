<?php

require_once __DIR__ . '/../vendor/autoload.php';

$route = $_GET['route'] ?? 'calendar/index';
list($controllerName, $method) = explode('/', $route);

$controllerClass = "App\\Controllers\\" . ucfirst($controllerName) . "Controller";
$controller = new $controllerClass();

$controller->$method();
