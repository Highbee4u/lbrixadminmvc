<?php
class Logger {
    private static $logPath;

    public static function init() {
        self::$logPath = ROOT_DIR . '/storage/logs';
        
        // Create logs directory if it doesn't exist
        if (!is_dir(self::$logPath)) {
            mkdir(self::$logPath, 0755, true);
        }
    }

    public static function log($message, $level = 'INFO') {
        if (!self::$logPath) {
            self::init();
        }

        $date = date('Y-m-d');
        $time = date('Y-m-d H:i:s');
        $logFile = self::$logPath . '/' . $date . '.log';

        $logMessage = "[{$time}] [{$level}] {$message}" . PHP_EOL;

        file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
    }

    public static function info($message) {
        self::log($message, 'INFO');
    }

    public static function error($message) {
        self::log($message, 'ERROR');
    }

    public static function warning($message) {
        self::log($message, 'WARNING');
    }

    public static function debug($message) {
        self::log($message, 'DEBUG');
    }
}
