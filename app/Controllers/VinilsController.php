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
        $VinilDetails = '';
        $Vinil = Vinil::getById($param);

        if (!empty($Vinil)) {
            foreach ($Vinil as $key => $value) {
                $key =  str_replace('_', ' ', ucfirst($key));
                $value = ucwords($value);

                $VinilDetails .= "<br> <b>{$key}:</b> {$value}";
            }
        } else {
            $VinilDetails = 'Vinil ID not found';
        }

        $this->render(['title' => $title, 'vinil' => $VinilDetails]);
    }

    public function postCreate()
    {
        $input = $_POST;

        if (!Vinil::validate($input)) {
            $this->renderJson(['success' => false], '400');
        } else {
            $Vinil = Vinil::create($input);
            $this->renderJson(['success' => true, 'data' => $Vinil]);
        }
    }

}
