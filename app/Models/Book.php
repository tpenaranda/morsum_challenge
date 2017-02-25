<?php

namespace MorsumMVC\Models;

class Book extends \OurLittleORM
{
    public static $fillable = ['title', 'author'];
    public static $tableName = 'books';

    public $author = null;
    public $created_at = null;
    public $id = null;
    public $title = null;

    public function __construct(array $params = [])
    {
        $this->author = empty($params['author']) ? false : $params['author'];
        $this->title = empty($params['title']) ? false : $params['title'];
    }
}
