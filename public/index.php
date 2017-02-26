<?php

require '../vendor/autoload.php';
require '../app/Lib/OurLittleAppHelper.php';

$config = include '../config/config.php';

try {
    $dbConnection = ('GuzzleHttp' == substr($_SERVER['HTTP_USER_AGENT'], 0, 10)) ? new PDO(
        "mysql:host={$config['test_database']['host']};dbname={$config['test_database']['database']}",
        $config['test_database']['username'],
        $config['test_database']['password']
    ) : new PDO(
        "mysql:host={$config['database']['host']};dbname={$config['database']['database']}",
        $config['database']['username'],
        $config['database']['password']
    );
    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo 'There was an error connecting with the DB, check your configuration.';
    exit;
}

$requestUri = $_SERVER['REQUEST_URI'];
$cleanRequestUri = trim($requestUri, '/');
$requestParts = empty($cleanRequestUri) ? [] : explode('/', $cleanRequestUri);

switch (count($requestParts)) {
    case 3:
        $controller = $requestParts[0];
        $action = $requestParts[2];
        $param = $requestParts[1];
        break;
    case 2:
        $controller = $requestParts[0];
        if (is_numeric($requestParts[1])) {
            $param = $requestParts[1];
            if ('GET' == $_SERVER['REQUEST_METHOD']) {
                $action = 'details';
            }
        } else {
            $action = $requestParts[1];
        }
        break;
    case 1:
        $controller = $requestParts[0];
        break;
    default:
        $controller = 'index';
        break;
}

if (empty($action)) {
    $action = 'index';
}

$controllerToCall = 'MorsumMVC\Controllers\\'.ucfirst($controller).'Controller';
$actionToCall = strtolower($_SERVER['REQUEST_METHOD']).ucfirst($action);

$controller = new $controllerToCall();

if (method_exists($controller, $actionToCall)) {
    (new $controllerToCall())->$actionToCall(empty($param) ? false : $param);
} else {
    (new $controllerToCall())->getIndex();
}
