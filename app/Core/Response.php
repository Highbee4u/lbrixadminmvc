<?php
class Response {
    private $content;
    private $statusCode = 200;
    private $headers = [];

    public function __construct($content = '', $statusCode = 200, $headers = []) {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    public static function make($content = '', $statusCode = 200, $headers = []) {
        return new self($content, $statusCode, $headers);
    }

    public static function json($data, $statusCode = 200, $headers = []) {
        $instance = new self(json_encode($data), $statusCode, $headers);
        $instance->header('Content-Type', 'application/json');
        return $instance->send();
    }

    public static function redirect($url, $statusCode = 302) {
        header("Location: $url", true, $statusCode);
        exit;
    }

    public static function back() {
        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        self::redirect($referer);
    }

    public static function route($routeName, $params = []) {
        // For now, simple redirect - can be enhanced with route name resolution
        $url = $routeName;
        foreach ($params as $key => $value) {
            $url = str_replace('{' . $key . '}', $value, $url);
        }
        self::redirect($url);
    }

    public function with($key, $value) {
        Session::flash($key, $value);
        return $this;
    }

    public function withErrors($errors) {
        Session::flash('errors', $errors);
        return $this;
    }

    public function withInput() {
        Session::flash('old', $_POST);
        return $this;
    }

    public function header($key, $value) {
        $this->headers[$key] = $value;
        return $this;
    }

    public function status($statusCode) {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function send() {
        http_response_code($this->statusCode);
        
        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }
        
        echo $this->content;
        return $this;
    }

    public static function view($view, $data = [], $statusCode = 200) {
        $instance = new self();
        $instance->statusCode = $statusCode;
        
        ob_start();
        View::make($view, $data);
        $content = ob_get_clean();
        
        $instance->content = $content;
        return $instance->send();
    }

    public static function download($filePath, $fileName = null) {
        if (!file_exists($filePath)) {
            http_response_code(404);
            echo "File not found";
            return;
        }

        $fileName = $fileName ?? basename($filePath);
        $fileSize = filesize($filePath);

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Content-Length: ' . $fileSize);
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        readfile($filePath);
        exit;
    }

    public static function success($message = 'Operation successful', $data = null, $statusCode = 200) {
        return self::json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    public static function error($message = 'Operation failed', $errors = null, $statusCode = 400) {
        return self::json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $statusCode);
    }

    public static function notFound($message = 'Resource not found') {
        return self::json([
            'success' => false,
            'message' => $message
        ], 404);
    }

    public static function unauthorized($message = 'Unauthorized') {
        return self::json([
            'success' => false,
            'message' => $message
        ], 401);
    }

    public static function forbidden($message = 'Forbidden') {
        return self::json([
            'success' => false,
            'message' => $message
        ], 403);
    }

    public static function serverError($message = 'Internal server error') {
        return self::json([
            'success' => false,
            'message' => $message
        ], 500);
    }
}
