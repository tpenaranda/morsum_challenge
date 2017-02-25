<?php

require '../vendor/autoload.php';
require '../app/Lib/OurLittleAppHelper.php';

$config = include '../config/config.php';

try {
    $dbConnection = empty($dbConnection) ? new PDO(
        "mysql:host={$config['database']['host']};dbname={$config['database']['database']}",
        $config['database']['username'],
        $config['database']['password']
    ) : $dbConnection;
    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo 'There was an error connecting with the DB, check your configuration.';
    exit;
}

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

$controller = new $controllerToCall();

if (method_exists($controller, $actionToCall)) {
    (new $controllerToCall())->$actionToCall();
} else {
    (new $controllerToCall())->getIndex();
}
