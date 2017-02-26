<?php

namespace MorsumMVC\Controllers;

use MorsumMVC\Models\Book;
use MorsumMVC\Models\Vinyl;

class IndexController extends BaseController
{
    public function getIndex()
    {
        $title = $this->config['app_name'];
        $booksHtml = $vinylsHtml = '';

        $books = Book::fetchAll();
        $vinyls = Vinyl::fetchAll();

        $this->render(['title' => $title, 'books' => convertToHtmlItems($books), 'vinyls' => convertToHtmlItems($vinyls)]);
    }
}
