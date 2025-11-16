<?php
class HomeController extends Controller {
    public function index() {
        // Check if user is authenticated
        if (Auth::check()) {
            // User is logged in, redirect to dashboard
            $this->redirect('dashboard');
            return;
        }

        // User is not logged in, redirect to login
        $this->redirect('login');
    }
}
