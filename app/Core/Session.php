<?php
class Session {
    
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set($key, $value) {
        self::start();
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null) {
        self::start();
        return $_SESSION[$key] ?? $default;
    }

    public static function has($key) {
        self::start();
        return isset($_SESSION[$key]);
    }

    public static function remove($key) {
        self::start();
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public static function all() {
        self::start();
        return $_SESSION;
    }

    public static function flash($key, $value = null) {
        self::start();
        
        if ($value !== null) {
            $_SESSION['flash'][$key] = $value;
        } else {
            $flash = $_SESSION['flash'][$key] ?? null;
            unset($_SESSION['flash'][$key]);
            return $flash;
        }
    }

    public static function hasFlash($key) {
        self::start();
        return isset($_SESSION['flash'][$key]);
    }

    public static function getFlash($key, $default = null) {
        $value = self::flash($key);
        return $value !== null ? $value : $default;
    }

    public static function reflash() {
        self::start();
        if (isset($_SESSION['flash'])) {
            $_SESSION['flash_old'] = $_SESSION['flash'];
        }
    }

    public static function keep($keys = null) {
        self::start();
        
        if ($keys === null) {
            $_SESSION['flash'] = $_SESSION['flash_old'] ?? [];
        } else {
            $keys = is_array($keys) ? $keys : func_get_args();
            foreach ($keys as $key) {
                if (isset($_SESSION['flash_old'][$key])) {
                    $_SESSION['flash'][$key] = $_SESSION['flash_old'][$key];
                }
            }
        }
    }

    public static function old($key = null, $default = null) {
        self::start();
        
        if ($key === null) {
            return $_SESSION['old'] ?? [];
        }
        
        return $_SESSION['old'][$key] ?? $default;
    }

    public static function setOld($data) {
        self::start();
        $_SESSION['old'] = $data;
    }

    public static function clearOld() {
        self::start();
        unset($_SESSION['old']);
    }

    public static function destroy() {
        self::start();
        $_SESSION = [];
        
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }
        
        session_destroy();
    }

    public static function regenerate($deleteOld = true) {
        self::start();
        session_regenerate_id($deleteOld);
    }

    public static function put($key, $value) {
        self::set($key, $value);
    }

    public static function pull($key, $default = null) {
        self::start();
        $value = $_SESSION[$key] ?? $default;
        unset($_SESSION[$key]);
        return $value;
    }

    public static function forget($key) {
        self::remove($key);
    }

    public static function flush() {
        self::start();
        $_SESSION = [];
    }

    public static function getId() {
        self::start();
        return session_id();
    }

    public static function setId($id) {
        session_id($id);
    }

    public static function getName() {
        return session_name();
    }

    public static function setName($name) {
        session_name($name);
    }

    public static function token() {
        self::start();
        
        if (!isset($_SESSION['_token'])) {
            $_SESSION['_token'] = bin2hex(random_bytes(32));
        }
        
        return $_SESSION['_token'];
    }

    public static function regenerateToken() {
        self::start();
        $_SESSION['_token'] = bin2hex(random_bytes(32));
        return $_SESSION['_token'];
    }

    public static function previousUrl() {
        self::start();
        return $_SESSION['_previous']['url'] ?? null;
    }

    public static function setPreviousUrl($url) {
        self::start();
        $_SESSION['_previous']['url'] = $url;
    }
}
