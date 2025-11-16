<?php
/**
 * Enhanced Router with Routes File Support
 * Supports both:
 * 1. Explicit routes from config/routes.php
 * 2. Fallback to simple routing
 */

class Router
{
    private $routes = [];
    private $defaultController = 'Home';
    private $defaultMethod = 'index';
    
    public function __construct()
    {
        $this->loadRoutes();
    }

    /**
     * Load routes from config/routes.php
     */
    private function loadRoutes()
    {
        $routesFile = CONFIG_DIR . '/routes.php';

        if (file_exists($routesFile)) {
            $this->routes = require $routesFile;
        }
    }

    /**
     * Dispatch the request
     */
    public function dispatch($url)
    {
        // Get the HTTP method
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        // Clean the URL
        $url = '/' . trim($url, '/');

        // Try to match explicit routes first
        $route = $this->matchRoute($method, $url);

        if ($route) {
            $this->executeRoute($route);
        } else {
            // Fallback to simple routing
            $this->simpleRouting($url);
        }
    }

    /**
     * Match a route from routes.php
     */
    private function matchRoute($method, $url)
    {
        $routeKey = $method . ' ' . $url;
        
        // Try exact match first
        if (isset($this->routes[$routeKey])) {
            return [
                'handler' => $this->routes[$routeKey],
                'params' => []
            ];
        }
        
        // Try pattern matching for dynamic routes (with :id, :countryid, etc.)
        foreach ($this->routes as $pattern => $handler) {
            list($routeMethod, $routePath) = explode(' ', $pattern, 2);
            
            // Skip if HTTP method doesn't match
            if ($routeMethod !== $method) {
                continue;
            }
            
            // Convert route pattern to regex
            // Replace :param with named capture groups
            $regex = preg_replace('/\/\:([a-zA-Z0-9_]+)/', '/(?P<$1>[^/]+)', $routePath);
            $regex = '#^' . $regex . '$#';
            
            if (preg_match($regex, $url, $matches)) {
                // Extract named parameters
                $params = array_filter($matches, function($key) {
                    return !is_numeric($key);
                }, ARRAY_FILTER_USE_KEY);
                
                return [
                    'handler' => $handler,
                    'params' => $params
                ];
            }
        }
        
        return null;
    }

    /**
     * Execute a matched route
     */
    private function executeRoute($route)
    {
        $handler = $route['handler'];
        $params = $route['params'];

        // Parse handler: "ControllerName@methodName" or "Namespace/ControllerName@methodName"
        list($controllerPath, $method) = explode('@', $handler);

        // Handle namespaced controllers (e.g., Auth/AdminLoginController)
        // Split by '/' and take the last part as class name
        $pathParts = explode('/', $controllerPath);
        $controllerName = end($pathParts); // Get the last part (the actual class name)

        // Build the full file path
        $filePath = APP_DIR . '/Controllers/' . str_replace('\\', '/', $controllerPath) . '.php';

        // Load the controller
        if (file_exists($filePath)) {
            require_once $filePath;

            if (class_exists($controllerName)) {
                $controller = new $controllerName();

                if (method_exists($controller, $method)) {
                    // Call the method with parameters
                    call_user_func_array([$controller, $method], array_values($params));
                } else {
                    $this->show404("Method '{$method}' not found in {$controllerName}");
                }
            } else {
                $this->show404("Controller class '{$controllerName}' not found");
            }
        } else {
            $this->show404("Controller file not found: {$filePath}");
        }
    }

    /**
     * Fallback simple routing (for backwards compatibility)
     */
    private function simpleRouting($url)
    {
        $url = trim($url, '/');
        
        if (empty($url)) {
            $controller = $this->defaultController;
            $method = $this->defaultMethod;
            $params = [];
        } else {
            $urlParts = explode('/', $url);
            $controller = !empty($urlParts[0]) ? ucfirst($urlParts[0]) : $this->defaultController;
            $method = !empty($urlParts[1]) ? $urlParts[1] : $this->defaultMethod;
            $params = array_slice($urlParts, 2);
        }
        
        $controllerFile = APP_DIR . '/Controllers/' . $controller . 'Controller.php';
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controllerClass = $controller . 'Controller';
            
            if (class_exists($controllerClass)) {
                $controllerInstance = new $controllerClass();
                
                if (method_exists($controllerInstance, $method)) {
                    call_user_func_array([$controllerInstance, $method], $params);
                } else {
                    $this->show404("Method '{$method}' not found");
                }
            } else {
                $this->show404("Controller class not found");
            }
        } else {
            $this->show404("Controller file not found");
        }
    }

    /**
     * Show 404 error page
     */
    private function show404($message = 'Page not found')
    {
        http_response_code(404);
        
        $errorView = VIEWS_DIR . '/errors/404.php';
        
        if (file_exists($errorView)) {
            require_once $errorView;
        } else {
            echo "<h1>404 - Not Found</h1>";
            echo "<p>{$message}</p>";
        }
        
        exit;
    }

    /**
     * Generate URL helper function
     */
    public static function url($path = '')
    {
        $path = ltrim($path, '/');

        if (empty($path)) {
            return BASE_URL . 'index.php';
        }

        return BASE_URL . 'index.php?action=' . $path;
    }
    
    /**
     * Get the current URL path
     */
    public static function currentUrl()
    {
        return $_GET['action'] ?? '';
    }
    
    /**
     * Check if current route matches a pattern
     */
    public static function isRoute($pattern)
    {
        $currentUrl = '/' . trim(self::currentUrl(), '/');
        $pattern = '/' . trim($pattern, '/');
        
        return $currentUrl === $pattern || strpos($currentUrl, $pattern) === 0;
    }
}

/**
 * Global URL helper function
 */
if (!function_exists('url')) {
    function url($path = '') {
        return Router::url($path);
    }
}

/**
 * Check if current route matches
 */
if (!function_exists('isRoute')) {
    function isRoute($pattern) {
        return Router::isRoute($pattern);
    }
}

/**
 * Get current URL
 */
if (!function_exists('currentUrl')) {
    function currentUrl() {
        return Router::currentUrl();
    }
}