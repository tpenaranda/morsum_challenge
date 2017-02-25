<?php

namespace MorsumMVC\Controllers;

use MorsumMVC\Models\Book;

class BooksController extends BaseController
{
    public function getIndex()
    {
        $title = "Books - {$this->config['app_name']}";
        $books = '';

        foreach (Book::fetchAll() as $book) {
            $books .= "Title: {$book->getTitle()} - Author: {$book->getAuthor()}<br>";
        }

        $this->render(['title' => $title, 'books' => $books]);
    }
}
