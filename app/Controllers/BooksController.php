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
            $books .= "{$book->getId()}. {$book->getTitle()} - Author: {$book->getAuthor()}<br>";
        }

        $this->render(['title' => $title, 'books' => $books]);
    }

    public function postCreate()
    {
        $input = $_POST;

        if (!Book::validate($input)) {
            $this->renderJson(['success' => false], '400');
        } else {
            $book = Book::create($input);
            $this->renderJson(['success' => true, 'data' => $book]);
        }
    }

}
