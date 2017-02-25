<?php

namespace MorsumMVC\Models;

class Book extends \OurLittleORM
{
    public static $fillable = ['title', 'author'];
    public static $tableName = 'books';

    public $id = null;
    public $title = null;
    public $author = null;
    public $created_at = null;

    public function __construct(array $params = [])
    {
        $this->title = empty($params['title']) ? false : $params['title'];
        $this->author = empty($params['author']) ? false : $params['author'];
    }
}
