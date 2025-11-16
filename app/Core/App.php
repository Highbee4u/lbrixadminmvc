<?php
class App {
    private static $instance;
    private $router;

    public function __construct() {
        $this->initialize();
    }

    private function initialize() {
        // Configure session settings before starting
        if (session_status() == PHP_SESSION_NONE) {
            // Session timeout: 30 minutes of inactivity
            ini_set('session.gc_maxlifetime', 1800);
            ini_set('session.cookie_lifetime', 1800);

            // Session security settings
            ini_set('session.cookie_httponly', 1);
            ini_set('session.use_strict_mode', 1);
            // PHP 7.3+ supports samesite via ini; fallback handled by framework if needed
            ini_set('session.cookie_samesite', 'Lax');

            session_start();

            // Enforce inactivity timeout (server-side). If last activity older than gc_maxlifetime, destroy session.
            $timeout = 1800; // seconds
            if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
                // Clear session and redirect to login
                Session::destroy();
                // Redirect to login page immediately
                Response::redirect('/login');
            }

            // Update last activity timestamp for the current session
            $_SESSION['last_activity'] = time();
        }

        // Load configuration
        Config::load('app');
        Config::load('database');

        // Set timezone
        date_default_timezone_set(Config::get('app.timezone'));

        // Generate CSRF token if not exists
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = Helpers::generateToken();
        }

        // Initialize router
        $this->router = new Router();
    }

    public function run() {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        try {
            $this->router->dispatch($requestUri, $requestMethod);
        } catch (Exception $e) {
            $this->handleError($e);
        }
    }

    private function handleError($exception) {
        http_response_code(500);

        if (Config::get('app.debug')) {
            echo '<h1>Error</h1>';
            echo '<p>' . $exception->getMessage() . '</p>';
            echo '<pre>' . $exception->getTraceAsString() . '</pre>';
        } else {
            View::make('errors/500');
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __destruct() {
        // Cleanup if needed
    }
}