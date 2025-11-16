<?php
/**
 * Base Controller
 * All controllers should extend this class
 */

class Controller
{
    protected $view;

    public function __construct()
    {
        $this->view = new View();
    }

    /**
     * Load a view
     */
    protected function view($viewPath, $data = [])
    {
        $this->view->render($viewPath, $data);
    }

    /**
     * Load a view with layout
     */
    protected function viewWithLayout($viewPath, $data = [], $layout = 'layouts.app')
    {
        $this->view->renderWithLayout($viewPath, $data, $layout);
    }

    /**
     * Return JSON response
     */
    protected function json($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Redirect to another page
     */
    protected function redirect($path = '')
    {
        redirect($path);
    }

    /**
     * Redirect back to previous page
     */
    protected function back()
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? url();
        header('Location: ' . $referer);
        exit;
    }

    /**
     * Check if user is authenticated (middleware-like)
     */
    protected function requireAuth()
    {
        if (!isAuth()) {
            $_SESSION['intended_url'] = $_SERVER['REQUEST_URI'];
            redirect('login');
        }
    }

    /**
     * Flash a message to session
     */
    protected function flash($key, $message)
    {
        flash($key, $message);
    }
}
