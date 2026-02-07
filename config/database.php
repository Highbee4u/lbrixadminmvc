<?php

/**
 * Database Configuration
 * Define constants that are available globally
 */

$isProduction = false;

if ($isProduction) {
    // PRODUCTION SERVER CREDENTIALS
    define('DB_HOST', '');
    define('DB_NAME', '');
    define('DB_USER', '');
    define('DB_PASS', '');
} else {
    // LOCAL DEVELOPMENT
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'lbrixtest');
    define('DB_USER', 'root');
    define('DB_PASS', '');
}
