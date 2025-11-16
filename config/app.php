<?php
/**
 * Application Configuration
 */

$config = [
    'app' => [
        'name' => 'Simple MVC Framework',
        'env' => 'development', // development, production
        'debug' => true,
        'timezone' => 'UTC',
    ],
    
    'url' => [
        'base_url' => BASE_URL,
        'assets_url' => ASSETS_URL,
    ],
    
    'session' => [
        'lifetime' => 120, // minutes
        'name' => 'simple_mvc_session',
    ],
];

// Set timezone
date_default_timezone_set($config['app']['timezone']);

// Error reporting based on environment
if ($config['app']['env'] === 'production') {
    error_reporting(0);
    ini_set('display_errors', 0);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}
