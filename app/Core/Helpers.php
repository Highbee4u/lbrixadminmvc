<?php
/**
 * Universal Helper Functions
 * These work on any server without URL rewriting
 */

/**
 * Helpers class for static methods
 */
class Helpers {
    /**
     * Generate base URL
     */
    public static function baseUrl($path = '') {
        $path = ltrim($path, '/');
        if (empty($path)) {
            return BASE_URL;
        }
        return BASE_URL . $path;
    }

    /**
     * Generate asset URL
     */
    public static function asset($path) {
        return self::baseUrl('/assets/' . ltrim($path, '/'));
    }

    /**
     * Generate redirect
     */
    public static function redirect($url, $statusCode = 302) {
        header('Location: ' . $url, true, $statusCode);
        exit;
    }

    /**
     * Sanitize data
     */
    public static function sanitize($data) {
        if (is_array($data)) {
            return array_map([self::class, 'sanitize'], $data);
        }
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Generate CSRF token
     */
    public static function generateToken() {
        return bin2hex(random_bytes(32));
    }

    /**
     * Validate CSRF token
     */
    public static function validateToken($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    /**
     * Check if POST request
     */
    public static function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * Check if GET request
     */
    public static function isGet() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    /**
     * Get POST data
     */
    public static function getPostData() {
        return $_POST;
    }

    /**
     * Get GET data
     */
    public static function getGetData() {
        return $_GET;
    }

    /**
     * Flash message helper
     */
    public static function flash($key, $value = null) {
        if ($value !== null) {
            $_SESSION['flash'][$key] = $value;
        } else {
            $flash = $_SESSION['flash'][$key] ?? null;
            unset($_SESSION['flash'][$key]);
            return $flash;
        }
    }

    /**
     * Get old input value
     */
    public static function old($key, $default = '') {
        return $_SESSION['old'][$key] ?? $default;
    }

    /**
     * Set old input data
     */
    public static function setOld($data) {
        $_SESSION['old'] = $data;
    }

    /**
     * Clear old input data
     */
    public static function clearOld() {
        unset($_SESSION['old']);
    }

    /**
     * Debug dump and die
     */
    public static function dd($data) {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        die;
    }

    /**
     * Debug dump
     */
    public static function dump($data) {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }

    /**
     * Get image URL - handles multiple upload folders for backward compatibility
     * Supports: images/, pictures/, documents/ from database
     * @param string $imagePath - Path from database (e.g., "images/0001234567890.jpg", "pictures/file.jpg", "documents/doc.pdf")
     * @param string $default - Default image if not found
     * @return string - Full URL to image/document
     */
    public static function imageUrl($imagePath, $default = 'images/home-decor-1.jpg') {
        if (empty($imagePath)) {
            return self::asset($default);
        }

        // If it's already a full URL (http:// or https://), return as is
        if (preg_match('/^https?:\/\//', $imagePath)) {
            return $imagePath;
        }

        // If it's already a full path starting with /, add base URL
        if (strpos($imagePath, '/') === 0) {
            return self::baseUrl($imagePath);
        }

        // Handle database paths: "images/file.jpg", "pictures/file.jpg", "documents/file.pdf"
        // These are stored without leading slash in database
        return self::baseUrl('/assets/' . ltrim($imagePath, '/'));
    }
}

    // Global helper functions for easy access in views (wrappers for Helpers class methods)
    if (!function_exists('url')) {
        function url($path = '') {
            $path = ltrim($path, '/');
            if (empty($path)) {
                return BASE_URL . 'index.php';
            }
            return BASE_URL . 'index.php?action=' . $path;
        }
    }

    if (!function_exists('asset')) {
        function asset($path = '') {
            $path = ltrim($path, '/');
            return '/assets/' . $path;
        }
    }

    if (!function_exists('redirect')) {
        function redirect($path = '') {
            header('Location: ' . url($path));
            exit;
        }
    }

    if (!function_exists('old')) {
        function old($key, $default = '') {
            return Helpers::old($key, $default);
        }
    }

    if (!function_exists('error')) {
        function error($key) {
            return isset($_SESSION['errors'][$key]) ? $_SESSION['errors'][$key] : '';
        }
    }

    if (!function_exists('isAuth')) {
        function isAuth() {
            return isset($_SESSION['user_id']);
        }
    }

    if (!function_exists('auth')) {
        function auth() {
            return isset($_SESSION['user']) ? $_SESSION['user'] : null;
        }
    }

    if (!function_exists('e')) {
        function e($string) {
            return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
        }
    }

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

    if (!function_exists('dump')) {
        function dump(...$vars) {
            echo '<pre>';
            foreach ($vars as $var) {
                var_dump($var);
            }
            echo '</pre>';
        }
    }

    if (!function_exists('flash')) {
        function flash($key, $message = null) {
            return Helpers::flash($key, $message);
        }
    }

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

    if (!function_exists('view')) {
        function view($viewPath, $data = []) {
            $view = new View();
            return $view->render($viewPath, $data);
        }
    }
