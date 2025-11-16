<?php
/**
 * Database Configuration
 */

// $dbConfig = [
//     'host' => 'localhost',
//     'database' => 'oyesoft_lbrixdata',
//     'username' => 'lbrixuser',
//     'password' => 'Liquid@Br1x_3HHi',
//     'charset' => 'utf8mb4',
//     'options' => [
//         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//         PDO::ATTR_EMULATE_PREPARES => false,
//     ]
// ];

$dbConfig = [
    'host' => 'localhost',
    'database' => 'lbrixtest',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
];

