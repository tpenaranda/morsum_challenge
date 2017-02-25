<?php

class IndexController extends BaseController
{
    public function getIndex()
    {
        $title = $this->config['app_name'];
        $body = "Hello World!";

        $this->render(['title' => $title, 'body' => $body]);
    }
}
