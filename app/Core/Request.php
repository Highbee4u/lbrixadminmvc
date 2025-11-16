<?php
class Request {
    private static $instance = null;
    private $get;
    private $post;
    private $server;
    private $files;
    private $cookies;
    private $headers;
    private $json = [];

    private function __construct() {
        $this->get = $_GET;
        $this->server = $_SERVER;
        $this->files = $_FILES;
        $this->cookies = $_COOKIES ?? [];
        $this->headers = $this->parseHeaders();
        
        // Handle different content types
        $this->parseRequestBody();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function parseRequestBody() {
        $contentType = $this->header('Content-Type', '');
        
        // Check if JSON request
        if (strpos($contentType, 'application/json') !== false) {
            $rawInput = file_get_contents('php://input');
            $this->json = json_decode($rawInput, true) ?? [];
            $this->post = $this->json;
        } else {
            // For PUT/DELETE/PATCH, parse from php://input if $_POST is empty
            if (in_array($this->method(), ['PUT', 'PATCH', 'DELETE']) && empty($_POST)) {
                $rawInput = file_get_contents('php://input');
                parse_str($rawInput, $parsedData);
                $this->post = $parsedData;
            } else {
                $this->post = $_POST;
            }
        }
    }

    private function parseHeaders() {
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) == 'HTTP_') {
                $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
                $headers[$header] = $value;
            }
        }
        return $headers;
    }

    public function get($key = null, $default = null) {
        if ($key === null) {
            return $this->get;
        }
        return $this->get[$key] ?? $default;
    }

    public function post($key = null, $default = null) {
        if ($key === null) {
            return $this->post;
        }
        return $this->post[$key] ?? $default;
    }

    public function all() {
        return array_merge($this->get, $this->post);
    }

    public function input($key = null, $default = null) {
        if ($key === null) {
            return $this->all();
        }
        $all = $this->all();
        return $all[$key] ?? $default;
    }

    public function only($keys) {
        $keys = is_array($keys) ? $keys : func_get_args();
        $result = [];
        $all = $this->all();
        
        foreach ($keys as $key) {
            if (isset($all[$key])) {
                $result[$key] = $all[$key];
            }
        }
        
        return $result;
    }

    public function except($keys) {
        $keys = is_array($keys) ? $keys : func_get_args();
        $result = $this->all();
        
        foreach ($keys as $key) {
            unset($result[$key]);
        }
        
        return $result;
    }

    public function has($key) {
        $all = $this->all();
        return isset($all[$key]) && $all[$key] !== '';
    }

    public function file($key) {
        return $this->files[$key] ?? null;
    }

    public function hasFile($key) {
        return isset($this->files[$key]) && $this->files[$key]['error'] !== UPLOAD_ERR_NO_FILE;
    }

    public function method() {
        return strtoupper($this->server['REQUEST_METHOD']);
    }

    public function isMethod($method) {
        return $this->method() === strtoupper($method);
    }

    public function isGet() {
        return $this->method() === 'GET';
    }

    public function isPost() {
        return $this->method() === 'POST';
    }

    public function isPut() {
        return $this->method() === 'PUT';
    }

    public function isDelete() {
        return $this->method() === 'DELETE';
    }

    public function isAjax() {
        return isset($this->headers['X-Requested-With']) 
            && $this->headers['X-Requested-With'] === 'XMLHttpRequest';
    }

    public function ip() {
        if (isset($this->server['HTTP_CLIENT_IP'])) {
            return $this->server['HTTP_CLIENT_IP'];
        } elseif (isset($this->server['HTTP_X_FORWARDED_FOR'])) {
            return $this->server['HTTP_X_FORWARDED_FOR'];
        } else {
            return $this->server['REMOTE_ADDR'] ?? '';
        }
    }

    public function url() {
        return $this->server['REQUEST_URI'] ?? '/';
    }

    public function fullUrl() {
        $protocol = isset($this->server['HTTPS']) && $this->server['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $this->server['HTTP_HOST'] ?? 'localhost';
        $uri = $this->server['REQUEST_URI'] ?? '/';
        return $protocol . '://' . $host . $uri;
    }

    public function path() {
        return parse_url($this->url(), PHP_URL_PATH);
    }

    public function header($key, $default = null) {
        return $this->headers[$key] ?? $default;
    }

    public function bearerToken() {
        $header = $this->header('Authorization', '');
        if (preg_match('/Bearer\s+(.*)$/i', $header, $matches)) {
            return $matches[1];
        }
        return null;
    }

    public function validate($rules) {
        $validator = new Validator($this->all(), $rules);
        return $validator->validate();
    }

    public function sanitize($key = null) {
        if ($key) {
            $value = $this->all()[$key] ?? null;
            return Helpers::sanitize($value);
        }
        return Helpers::sanitize($this->all());
    }
}
