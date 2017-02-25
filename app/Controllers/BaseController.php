<?php

namespace MorsumMVC\Controllers;

class BaseController
{
    public function __construct()
    {
        global $config;
        $this->config = $config;
    }

    protected function render(array $opts = [])
    {
        $folderName = preg_replace(['/^morsummvc.controllers./', '/controller$/'], '', strtolower(get_class($this)));

        $viewName = strtolower(preg_replace('/^get/', '', debug_backtrace()[1]['function']));
        $viewFile = dirname(dirname(__FILE__))."/Views/{$folderName}/{$viewName}.view";

        $view = @file_get_contents($viewFile);

        if ($view) {
            $mapFunction = function ($item) { return "/\{\{ $item \}\}/"; };
            $filledView = preg_replace(array_map($mapFunction, array_keys($opts)), array_values($opts), $view);

            echo $filledView;
        } else {
            echo "Can't read {$viewFile} file.";
        }
    }

    protected function renderJson(array $output = [], $httpCode = 0)
    {
        header('Content-Type: application/json');

        if ((int) $httpCode) {
            http_response_code($httpCode);
        }

        echo json_encode($output);
    }
}
