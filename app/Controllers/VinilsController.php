<?php

namespace MorsumMVC\Controllers;

use MorsumMVC\Models\Vinil;

class VinilsController extends BaseController
{
    public function getIndex()
    {
        $title = "Vinils - {$this->config['app_name']}";

        $this->render(['title' => $title, 'vinils' => convertToHtmlItems(Vinil::fetchAll())]);
    }

    public function getDetails($param = false)
    {
        $title = "Vinil details - {$this->config['app_name']}";
        $vinilDetails = '';
        $vinil = Vinil::getById($param);

        if (!empty($vinil)) {
            foreach ($vinil as $key => $value) {
                $key = str_replace('_', ' ', ucfirst($key));
                $value = ucwords($value);

                $vinilDetails .= "<br> <b>{$key}:</b> {$value}";
            }
        } else {
            $vinilDetails = 'Vinil ID not found';
        }

        $this->render(['title' => $title, 'vinil' => $vinilDetails]);
    }

    public function postIndex()
    {
        $input = $_POST;

        if (!Vinil::validate($input)) {
            $this->renderJson(['success' => false], '400');
        } else {
            $vinil = Vinil::create($input);
            $this->renderJson(['success' => true, 'data' => $vinil]);
        }
    }
}
