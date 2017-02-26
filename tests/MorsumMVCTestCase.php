<?php

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class MorsumMVCTestCase extends TestCase
{
    protected $config;

    protected function setUpSchemas()
    {
        global $dbConnection;

        $dbConnection = new PDO(
            "mysql:host={$this->config['test_database']['host']};dbname={$this->config['test_database']['database']}",
            $this->config['test_database']['username'],
            $this->config['test_database']['password']
        );

        $sql = "CREATE TABLE books (
            `id` int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
            `author` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT NOW(),
            `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
        )";
        $dbConnection->exec($sql);

        $sql = "CREATE TABLE vinyls (
            `id` int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
            `artist` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
            `genre` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT NOW(),
            `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
        )";
        $dbConnection->exec($sql);
    }

    public function setUp()
    {
        $this->config = include __DIR__.'/../config/config.php';
        putenv('environment=testing');

        $this->guzzle = new Client(['base_uri' => $this->config['local_url'], 'timeout' => 1, 'exceptions' => false]);

        $this->setUpSchemas();

        return parent::setUp();
    }

    public function tearDown()
    {
        global $dbConnection;

        $dbConnection->exec('DROP TABLE books');
        $dbConnection->exec('DROP TABLE vinyls');
    }
}
