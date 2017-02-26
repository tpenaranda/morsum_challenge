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

    $conn->exec('DROP TABLE IF EXISTS vinyls');

    $sql = "CREATE TABLE vinyls (
        `id` int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
        `artist` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
        `genre` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT NOW(),
        `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
    )";

    $conn->exec($sql);

    echo "Table 'vinyls' created successfully\n";

    $conn->exec('INSERT INTO vinyls (`title`, `artist`, `genre`) VALUES ("Back to black", "Amy Winehouse", "Soul")');
    $conn->exec('INSERT INTO vinyls (`title`, `artist`, `genre`) VALUES ("Nevermind", "Nirvana", "Grunge")');
    $conn->exec('INSERT INTO vinyls (`title`, `artist`, `genre`) VALUES ("Legend", "Bob Marley & The Wailers", "Roots Reggae")');

    echo "Table 'vinyls' seeded successfully\n";
} catch (PDOException $e) {
    echo "Error creating/seeding 'vinyls' table: {$e->getMessage()}\n";
}
