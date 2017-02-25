<?php

function custom_error_handler()
{
    $lastError = error_get_last();
    if ($lastError && E_ERROR == $lastError['type']) {
        header("HTTP/1.1 500 Internal Server Error");
        echo "<br><i>Ups, sorry, something went wrong...</i><br>";
    }
}

register_shutdown_function('custom_error_handler');