<?php

require '../vendor/autoload.php';
$config = include '../config/config.php';

$requestUri = $_SERVER['REQUEST_URI'];
$cleanRequestUri = trim($requestUri, '/');
$requestParts = empty($cleanRequestUri) ? [] : explode('/', $cleanRequestUri);

switch (count($requestParts)) {
    case 2:
        $controller = $requestParts[0];
        $action = $requestParts[1];
        break;
    case 1:
        $controller = $requestParts[0];
        $action = 'index';
        break;
    default:
        $controller = $action = 'index';
        break;
}

$controllerToCall = 'MorsumMVC\Controllers\\'.ucfirst($controller).'Controller';
$actionToCall = strtolower($_SERVER['REQUEST_METHOD']).ucfirst($action);

(new $controllerToCall())->$actionToCall();
