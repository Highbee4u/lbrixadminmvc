<?php
class AdminLoginController extends Controller {
    private $authService;

    public function __construct() {
        parent::__construct();
        $this->authService = new AdminAuthService();
    }

    public function show() {
        // If already logged in, redirect to dashboard
        if (Auth::check()) {
            $this->redirect('dashboard');
            return;
        }
        $this->viewWithLayout('auth/login', ['title' => 'Sign In'], 'layouts.guest');
    }

    public function login() {
        $request = Request::getInstance();
       
        // Validate input
        $validator = new Validator($request->post(), [
            'login' => 'required',
            'password' => 'required|min:6'
        ]);

        if (!$validator->validate()) {
            Session::flash('errors', $validator->errors());
            Session::setOld($request->post());
            $this->redirect('login');
            return;
        }

        // print_r($request->post()); exit();

        $credentials = [
            'login' => $request->post('login'),
            'password' => $request->post('password'),
            'remember' => $request->post('remember') ? true : false
        ];

        // print_r($credentials); exit();

        // Attempt login using the custom service logic
        if ($this->authService->attemptLogin($credentials)) {
            Session::regenerate();
            $this->redirect('dashboard');
            return;
        }

        // Failed login attempt
        Session::flash('errors', [
            'login' => ['Invalid username/email or password, or you are not authorized for this area.']
        ]);
        Session::setOld(['login' => $request->post('login')]);
        $this->redirect('login');
    }

    public function logout() {
        // Ensure user is logged in before logout
        if (!Auth::check()) {
            $this->redirect('login');
            return;
        }

        Auth::logout();

        // Prevent browser back button from showing cached pages
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');

        $this->redirect('login');
    }
}

