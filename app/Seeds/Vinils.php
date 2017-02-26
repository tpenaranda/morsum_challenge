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

    $conn->exec('DROP TABLE IF EXISTS vinils');

    $sql = "CREATE TABLE vinils (
        `id` int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
        `artist` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
        `genre` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT NOW(),
        `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
    )";

    $conn->exec($sql);

    echo "Table 'vinils' created successfully\n";

    $conn->exec('INSERT INTO vinils (`title`, `artist`, `genre`) VALUES ("Back to black", "Amy Winehouse", "Soul")');
    $conn->exec('INSERT INTO vinils (`title`, `artist`, `genre`) VALUES ("Nevermind", "Nirvana", "Grunge")');
    $conn->exec('INSERT INTO vinils (`title`, `artist`, `genre`) VALUES ("Legend", "Bob Marley & The Wailers", "Roots Reggae")');

    echo "Table 'vinils' seeded successfully\n";
} catch (PDOException $e) {
    echo "Error creating/seeding 'vinils' table: {$e->getMessage()}\n";
}
