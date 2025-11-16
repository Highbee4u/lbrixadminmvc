<?php
/**
 * Simple View Handler
 */

class View
{
    /**
     * Render a view file
     */
    public function render($viewPath, $data = [])
    {
        // Convert dot notation to path (e.g., 'auth.login' -> 'auth/login.php')
        $viewPath = str_replace('.', '/', $viewPath);
        $viewFile = VIEWS_DIR . '/' . $viewPath . '.php';

        // Check if view exists
        if (!file_exists($viewFile)) {
            die("View not found: {$viewFile}");
        }

        // Extract data array into variables
        extract($data);

        // Output buffering
        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        echo $content;
    }

    /**
     * Render view with layout
     */
    public function renderWithLayout($viewPath, $data = [], $layout = 'layouts.app')
    {
        // Convert dot notation to path
        $viewPath = str_replace('.', '/', $viewPath);
        $layoutPath = str_replace('.', '/', $layout);

        $viewFile = VIEWS_DIR . '/' . $viewPath . '.php';
        $layoutFile = VIEWS_DIR . '/' . $layoutPath . '.php';

        // Check if view exists
        if (!file_exists($viewFile)) {
            die("View not found: {$viewFile}");
        }

        // Check if layout exists
        if (!file_exists($layoutFile)) {
            die("Layout not found: {$layoutFile}");
        }

        // Extract data array into variables
        extract($data);

        // Get view content
        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        // Render with layout
        require $layoutFile;
    }
}
