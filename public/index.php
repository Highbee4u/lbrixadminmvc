<?php
/**
 * Simple MVC Framework - Universal Entry Point
 * Works on Apache, IIS, Nginx - No URL rewriting required!
 *
 * Usage:
 * - yourdomain.com/index.php?url=dashboard
 * - yourdomain.com/index.php?url=users/create
 * - yourdomain.com/index.php (defaults to home)
 */

// Prevent browser caching for all pages
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Start session
session_start();

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define paths
define('ROOT_DIR', dirname(__DIR__));
define('APP_DIR', ROOT_DIR . '/app');
define('CONFIG_DIR', ROOT_DIR . '/config');
define('PUBLIC_DIR', ROOT_DIR . '/public');
define('STORAGE_DIR', ROOT_DIR . '/storage');
define('VIEWS_DIR', ROOT_DIR . '/resources/views');

// Define URL constants
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
define('BASE_URL', $protocol . '://' . $host . '/');
define('ASSETS_URL', BASE_URL . 'assets/');

// Load configuration
require_once CONFIG_DIR . '/database.php';
require_once CONFIG_DIR . '/app.php';

// Autoload core classes
spl_autoload_register(function ($class) {
    $file = APP_DIR . '/Core/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Load composer autoloader if exists
if (file_exists(ROOT_DIR . '/vendor/autoload.php')) {
    require_once ROOT_DIR . '/vendor/autoload.php';
}

// Manually load essential core files
$coreFiles = [
    'Helpers.php',
    'Database.php',
    'Session.php',
    'Request.php',
    'Response.php',
    'Validator.php',
    'Auth.php',
    'View.php',
    'Model.php',
    'Controller.php',
    'Router.php'
];

foreach ($coreFiles as $file) {
    $filePath = APP_DIR . '/Core/' . $file;
    if (file_exists($filePath)) {
        require_once $filePath;
    }
}

// Load base controller
if (file_exists(APP_DIR . '/Controllers/Controller.php')) {
    require_once APP_DIR . '/Controllers/Controller.php';
}

// Load base model
if (file_exists(APP_DIR . '/Models/BaseModel.php')) {
    require_once APP_DIR . '/Models/BaseModel.php';
}

// Load traits
if (file_exists(APP_DIR . '/Traits/AuditFields.php')) {
    require_once APP_DIR . '/Traits/AuditFields.php';
}

// Initialize the router
$router = new Router();

// Get the URL from query string (works everywhere!)
$url = isset($_GET['action']) ? trim($_GET['action'], '/') : '';

// Route the request
$router->dispatch($url);