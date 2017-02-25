<?php

namespace MorsumMVC\Controllers;

use MorsumMVC\Models\Book;
use MorsumMVC\Models\Vinil;

class IndexController extends BaseController
{
    public function getIndex()
    {
        $title = $this->config['app_name'];
        $booksHtml = $vinilsHtml = '';

        $books = Book::fetchAll();
        $vinils = Vinil::fetchAll();

        $this->render(['title' => $title, 'books' => convertToHtmlItems($books), 'vinils' => convertToHtmlItems($vinils)]);
    }
}
