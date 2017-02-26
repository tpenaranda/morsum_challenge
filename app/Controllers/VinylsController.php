<?php

namespace MorsumMVC\Controllers;

use MorsumMVC\Models\Vinyl;

class VinylsController extends BaseController
{
    public function getIndex()
    {
        $title = "Vinyls - {$this->config['app_name']}";

        $this->render(['title' => $title, 'vinyls' => convertToHtmlItems(Vinyl::fetchAll())]);
    }

    public function getDetails($param = false)
    {
        $title = "Vinyl details - {$this->config['app_name']}";
        $vinylDetails = '';
        $vinyl = Vinyl::getById($param);

        if (!empty($vinyl)) {
            foreach ($vinyl as $key => $value) {
                $key = str_replace('_', ' ', ucfirst($key));
                $value = ucwords($value);

                $vinylDetails .= "<br> <b>{$key}:</b> {$value}";
            }
        } else {
            $vinylDetails = 'Vinyl ID not found';
        }

        $this->render(['title' => $title, 'vinyl' => $vinylDetails]);
    }

    public function postIndex()
    {
        $input = $_POST;

        if (!Vinyl::validate($input)) {
            $this->renderJson(['success' => false], 400);
        } else {
            $vinyl = Vinyl::create($input);
            $this->renderJson(['success' => true, 'data' => $vinyl]);
        }
    }

    public function deleteIndex($param = false)
    {
        $vinyl = Vinyl::getById($param);

        if (empty($vinyl) || !$vinyl->delete()) {
            $this->renderJson(['success' => false], 400);
        } else {
            $this->renderJson(['success' => true]);
        }
    }
}
