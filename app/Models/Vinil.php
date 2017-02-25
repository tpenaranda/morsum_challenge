<?php

namespace MorsumMVC\Models;

class Vinil extends \OurLittleORM
{
    public static $fillable = ['title', 'artist', 'genre'];
    public static $tableName = 'vinils';

    public $artist = null;
    public $created_at = null;
    public $genre = null;
    public $id = null;
    public $title = null;

    public function __construct(array $params = [])
    {
        $this->artist = empty($params['artist']) ? false : $params['artist'];
        $this->genre = empty($params['genre']) ? false : $params['genre'];
        $this->title = empty($params['title']) ? false : $params['title'];
    }
}
