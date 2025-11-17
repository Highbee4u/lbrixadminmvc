<?php
/**
 * Application Configuration
 */

$config = [
    'app' => [
        'name' => 'Lbrix Admin',
        'env' => 'production', // development, production
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

    // Upload Configuration
    'uploads' => [
        // Base URL for this application (new uploads will use this)
        'base_url' => 'http://lbrix_mvc.test',
        // 'base_url' => 'https://devadmin.lbrix.com',
        
        // Legacy base URL (for fallback when files don't exist locally)
        'legacy_url' => 'https://app.lbrix.com',
        
        // Upload folders (relative to public directory)
        'folders' => [
            'pictures' => 'pictures',      // User profile pictures
            'images' => 'images',          // Property images
            'documents' => 'documents',    // PDF, Word files, etc.
        ],
        
        // Allowed file types for each folder
        'allowed_types' => [
            'pictures' => ['jpg', 'jpeg', 'png', 'gif'],
            'images' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
            'documents' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt'],
        ],
        
        // Maximum file sizes in bytes
        'max_sizes' => [
            'pictures' => 5242880,  // 5MB
            'images' => 10485760,   // 10MB
            'documents' => 20971520, // 20MB
        ],
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

return $config;
