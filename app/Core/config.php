<?php
class Config {
    private static $config = [];

    public static function load($file) {
        $path = __DIR__ . '/../../config/' . $file . '.php';
        if (file_exists($path)) {
            self::$config[$file] = include $path;
        }
    }

    public static function get($key, $default = null) {
        $keys = explode('.', $key);
        $config = self::$config;

        foreach ($keys as $key) {
            if (!isset($config[$key])) {
                return $default;
            }
            $config = $config[$key];
        }

        return $config;
    }

    public static function all($file = null) {
        if ($file) {
            return self::$config[$file] ?? [];
        }
        return self::$config;
    }
}