<?php

$config = include('../config/config.php');

$directory = new RecursiveDirectoryIterator(__DIR__.'/../app', FilesystemIterator::SKIP_DOTS);
$projectFiles = new RecursiveIteratorIterator($directory);

function __autoload($className) {
    global $projectFiles;
    foreach ($projectFiles as $item) {
        if ("{$className}.php" == $item->getFilename()) {
            include_once($item->getPathname());
            echo "Included file for instantiating {$className} class<br>";
            break;
        }
    }
}


echo 'Hello World! - '.$config['app_name']."<br>";


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

$controllerToCall = ucfirst($controller).'Controller';
$actionToCall = strtolower($_SERVER['REQUEST_METHOD']).ucfirst($action);

echo "Controller we should call: {$controllerToCall}, Action: {$actionToCall}<br>";

new $controllerToCall;



