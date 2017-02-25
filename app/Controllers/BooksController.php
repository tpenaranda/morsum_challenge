<?php

namespace MorsumMVC\Controllers;

use MorsumMVC\Models\Book;

class BooksController extends BaseController
{
    public function getIndex()
    {
        $title = "Books - {$this->config['app_name']}";

        $this->render(['title' => $title, 'books' => convertToHtmlItems(Book::fetchAll())]);
    }

    public function getDetails($param = false)
    {
        $title = "Book details - {$this->config['app_name']}";
        $bookDetails = '';
        $book = Book::getById($param);

        if (!empty($book)) {
            foreach ($book as $key => $value) {
                $key =  str_replace('_', ' ', ucfirst($key));
                $value = ucwords($value);

                $bookDetails .= "<br> <b>{$key}:</b> {$value}";
            }
        } else {
            $bookDetails = 'Book ID not found';
        }

        $this->render(['title' => $title, 'book' => $bookDetails]);
    }

    public function postIndex()
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
