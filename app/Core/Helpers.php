<?php
/**
 * Universal Helper Functions
 * These work on any server without URL rewriting
 */

/**
 * Generate URL for routing
 * Usage: url('dashboard') or url('users/create')
 */
if (!function_exists('url')) {
    function url($path = '') {
        $path = ltrim($path, '/');
        if (empty($path)) {
            return BASE_URL . 'index.php';
        }
        return BASE_URL . 'index.php?action=' . $path;
    }
}

/**
 * Generate asset URL (CSS, JS, images)
 * Usage: asset('css/style.css')
 */
if (!function_exists('asset')) {
    function asset($path = '') {
        $path = ltrim($path, '/');
        return '/assets/' . $path;
    }
}

/**
 * Redirect to another page
 * Usage: redirect('dashboard')
 */
if (!function_exists('redirect')) {
    function redirect($path = '') {
        header('Location: ' . url($path));
        exit;
    }
}

/**
 * Get old input value (for form repopulation after validation error)
 */
if (!function_exists('old')) {
    function old($key, $default = '') {
        return isset($_SESSION['old'][$key]) ? $_SESSION['old'][$key] : $default;
    }
}

/**
 * Display validation error
 */
if (!function_exists('error')) {
    function error($key) {
        return isset($_SESSION['errors'][$key]) ? $_SESSION['errors'][$key] : '';
    }
}

/**
 * Check if user is authenticated
 */
if (!function_exists('isAuth')) {
    function isAuth() {
        return isset($_SESSION['user_id']);
    }
}

/**
 * Get authenticated user data
 */
if (!function_exists('auth')) {
    function auth() {
        return isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }
}

/**
 * Escape output for XSS protection
 */
if (!function_exists('e')) {
    function e($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}

/**
 * Debug helper - dump and die
 */
if (!function_exists('dd')) {
    function dd(...$vars) {
        echo '<pre>';
        foreach ($vars as $var) {
            var_dump($var);
        }
        echo '</pre>';
        die();
    }
}

/**
 * Simple dump without dying
 */
if (!function_exists('dump')) {
    function dump(...$vars) {
        echo '<pre>';
        foreach ($vars as $var) {
            var_dump($var);
        }
        echo '</pre>';
    }
}

/**
 * Flash message helper
 */
if (!function_exists('flash')) {
    function flash($key, $message = null) {
        if ($message === null) {
            // Get flash message
            if (isset($_SESSION['flash'][$key])) {
                $msg = $_SESSION['flash'][$key];
                unset($_SESSION['flash'][$key]);
                return $msg;
            }
            return null;
        } else {
            // Set flash message
            $_SESSION['flash'][$key] = $message;
        }
    }
}

/**
 * Config helper
 */
if (!function_exists('config')) {
    function config($key, $default = null) {
        global $config;
        
        $keys = explode('.', $key);
        $value = $config;
        
        foreach ($keys as $k) {
            if (isset($value[$k])) {
                $value = $value[$k];
            } else {
                return $default;
            }
        }
        
        return $value;
    }
}

/**
 * View helper function
 */
if (!function_exists('view')) {
    function view($viewPath, $data = []) {
        $view = new View();
        return $view->render($viewPath, $data);
    }
}
