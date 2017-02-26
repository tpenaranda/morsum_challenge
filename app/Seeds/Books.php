#!/usr/bin/php
<?php

$config = include dirname(dirname(__DIR__)).'/config/config.php';

try {
    $conn = new PDO(
        "mysql:host={$config['database']['host']};dbname={$config['database']['database']}",
        $config['database']['username'],
        $config['database']['password']
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn->exec('DROP TABLE IF EXISTS books');

    // sql to create table
    $sql = "CREATE TABLE books (
        `id` int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
        `author` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT NOW(),
        `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
    )";

    $conn->exec($sql);

    echo "Table 'books' created successfully\n";

    $conn->exec('INSERT INTO books (`title`, `author`) VALUES ("The Giving Tree", "Shel Silverstein")');
    $conn->exec('INSERT INTO books (`title`, `author`) VALUES ("On Heroes and Tombs", "Ernesto Sábato")');
    $conn->exec('INSERT INTO books (`title`, `author`) VALUES ("Of Mice and Men", "John Steinbeck")');

    echo "Table 'books' seeded successfully\n";
} catch (PDOException $e) {
    echo "Error creating/seeding 'books' table: {$e->getMessage()}\n";
}
