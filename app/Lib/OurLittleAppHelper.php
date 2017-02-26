<?php

function customErrorHandler()
{
    $lastError = error_get_last();
    if ($lastError && E_ERROR == $lastError['type']) {
        header('HTTP/1.1 500 Internal Server Error');
        echo '<br><i>Ups, sorry, something went wrong...</i><br>';
    }
}

register_shutdown_function('customErrorHandler');

function d($thing = false)
{
    echo '<pre>';
    var_dump($thing);
    echo '</pre>';
}

function dd($thing = false)
{
    d($thing);
    die;
}

function convertToHtmlItems(array $inputArray = [])
{
    $output = '';

    foreach ($inputArray as $item) {
        $model = strtolower(preg_replace('/MorsumMVC\\\Models\\\/', '', get_class($item)));

        $itemDataArray = [];
        foreach ($item::$fillable as $column) {
            $columnMethod = 'get'.ucfirst($column);
            $itemDataArray[] = $item->$columnMethod();
        }

        if (!empty($itemDataArray[0])) {
            $itemDataArray[0] = "<i>{$itemDataArray[0]}</i>";
        }

        if (count($itemDataArray) > 2) {
            $itemDataArray[2] = "[{$itemDataArray[2]}]";
        }

        $itemData = implode(' - ', $itemDataArray);

        $output .= "<a href='/{$model}s/{$item->getId()}' class='list-group-item'>";
        $output .= $itemData;
        $output .= '</a>';
    }

    return $output;
}
