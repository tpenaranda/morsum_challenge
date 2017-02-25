<?php

class BaseController
{
    public function __construct()
    {
        global $config;
        $this->config = $config;
    }

    protected function render(Array $opts)
    {
        $folderName = preg_replace('/controller$/', '', strtolower(get_class($this)));
        $viewName = strtolower(preg_replace('/^get/', '', debug_backtrace()[1]['function']));

        $view = file_get_contents(dirname(dirname(__FILE__))."/views/{$folderName}/{$viewName}.view");

        $function = function ($item) { return "/\{\{ $item \}\}/"; };
        $filledView = preg_replace(array_map($function, array_keys($opts)), array_values($opts), $view);

        echo $filledView;
    }
}
