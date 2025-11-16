<?php
class UsersController extends Controller {

    private $usersService;

    public function __construct() {
        parent::__construct();
        $this->usersService = new UsersService();
    }

    /**
     * Display customers (usertypeid = 1)
     */
    public function customers() {
        $request = Request::getInstance();
        $page = (int)$request->get('page', 1);
        $perPage = 15;
        
        // Get filters from request
        $filters = [
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'entrydate' => $request->get('entrydate')
        ];
        
        $customers = $this->usersService->getCustomers($page, $perPage, $filters);

        $this->viewWithLayout('users/customers', compact('customers', 'filters'), 'layouts.app');
    }

    /**
     * Display attorneys (usertypeid = 2)
     */
    public function attorneys() {
        $request = Request::getInstance();
        $page = (int)$request->get('page', 1);
        $perPage = 15;
        
        // Get filters from request
        $filters = [
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'entrydate' => $request->get('entrydate')
        ];
        
        $attorneys = $this->usersService->getAttorneys($page, $perPage, $filters);

        $this->viewWithLayout('users/attorneys', compact('attorneys', 'filters'), 'layouts.app');
    }

    /**
     * Display inspectors (usertypeid = 3)
     */
    public function inspectors() {
        $request = Request::getInstance();
        $page = (int)$request->get('page', 1);
        $perPage = 15;
        
        // Get filters from request
        $filters = [
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'entrydate' => $request->get('entrydate')
        ];
        
        $inspectors = $this->usersService->getInspectors($page, $perPage, $filters);

        $this->viewWithLayout('users/inspectors', compact('inspectors', 'filters'), 'layouts.app');
    }

    /**
     * Display admin users (usertypeid >= 100)
     */
    public function admin() {
        $request = Request::getInstance();
        $page = (int)$request->get('page', 1);
        $perPage = 15;
        
        // Get filters from request
        $filters = [
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'entrydate' => $request->get('entrydate')
        ];
        
        $adminUsers = $this->usersService->getAdminUsers($page, $perPage, $filters);

        $this->viewWithLayout('users/admin', compact('adminUsers', 'filters'), 'layouts.app');
    }

    /**
     * Update user (status or usertype)
     */
    public function updateUser() {
        $request = Request::getInstance();
        $userid = $request->get('id');
        
        if (!$userid) {
            Response::json(['success' => false, 'message' => 'User ID is required'], 400);
            return;
        }

        $data = [];
        
        if ($request->post('usertypeid') !== null) {
            $data['usertypeid'] = $request->post('usertypeid');
        }
        
        if ($request->post('status') !== null) {
            $data['status'] = $request->post('status');
        }

        if (empty($data)) {
            Response::json(['success' => false, 'message' => 'No data to update'], 400);
            return;
        }

        $result = $this->usersService->updateUser($userid, $data);

        if ($result) {
            Response::json(['success' => true, 'message' => 'User updated successfully']);
        } else {
            Response::json(['success' => false, 'message' => 'Failed to update user'], 500);
        }
    }

    /**
     * Show edit form for customer/attorney/inspector
     */
    public function edit() {
        $request = Request::getInstance();
        $userid = $request->get('id');
        $userType = $request->get('type', 'customer'); // customer, attorney, inspector, admin
        
        // Handle redirect based on user type (admin is singular, others are plural)
        $redirectPath = $userType === 'admin' ? '/users/admin' : '/users/' . $userType . 's';
        
        if (!$userid) {
            Response::redirect($redirectPath);
            return;
        }

        $user = $this->usersService->getUserById($userid);
        
        if (!$user) {
            Response::redirect($redirectPath);
            return;
        }

        // Get additional data
        $adminRoles = $this->usersService->getAdminRoles();
        $services = $this->usersService->getServices();
        $userService = $this->usersService->getUserService($userid);

        $this->viewWithLayout('users/edit', compact('user', 'userType', 'adminRoles', 'services', 'userService'), 'layouts.app');
    }

    /**
     * Show create form for customer/attorney/inspector/admin
     */
    public function create() {
        $request = Request::getInstance();
        $userType = $request->get('type', 'customer'); // customer, attorney, inspector, admin
        
        // Get additional data
        $adminRoles = $this->usersService->getAdminRoles();
        $services = $this->usersService->getServices();

        $this->viewWithLayout('users/create', compact('userType', 'adminRoles', 'services'), 'layouts.app');
    }

    /**
     * Update user profile
     */
    public function update() {
        $request = Request::getInstance();
        $userid = $request->get('id');
        $userType = $request->post('user_type', 'customer');
        
        // Handle redirect based on user type (admin is singular, others are plural)
        $redirectPath = $userType === 'admin' ? '/users/admin' : '/users/' . $userType . 's';
        
        if (!$userid) {
            Response::redirect($redirectPath);
            return;
        }

        // Prepare data for update
        $data = [
            'title' => $request->post('title'),
            'staffno' => $request->post('staffno'),
            'surname' => $request->post('surname'),
            'firstname' => $request->post('firstname'),
            'middlename' => $request->post('middlename'),
            'email' => $request->post('email'),
            'phone' => $request->post('phone'),
            'gender' => $request->post('gender'),
            'dateofbirth' => $request->post('dateofbirth'),
            'occupation' => $request->post('occupation'),
            'address' => $request->post('address'),
            'username' => $request->post('username'),
            'status' => $request->post('status') ? 1 : 0,
            'usertypeid' => $request->post('usertypeid'),
        ];

        // Attorney-specific fields
        if ($userType === 'attorney') {
            $data['otherusertype'] = $request->post('otherusertype');
            $data['registrationnumber'] = $request->post('registrationnumber');
        }

        // Handle password update
        $password = $request->post('password');
        $passwordConfirm = $request->post('password_confirmation');
        
        if (!empty($password)) {
            if ($password === $passwordConfirm) {
                $data['password'] = $password;
            } else {
                // Password mismatch - redirect back with error
                Session::flash('error', 'Passwords do not match');
                Response::redirect('/users/edit?id=' . $userid . '&type=' . $userType);
                return;
            }
        }

        // Update user
        $result = $this->usersService->updateUser($userid, $data);

        // Update user service if provided
        $serviceid = $request->post('serviceid');
        if ($serviceid) {
            $this->usersService->updateUserService($userid, $serviceid);
        }

        if ($result) {
            Session::flash('success', ucfirst($userType) . ' updated successfully');
        } else {
            Session::flash('error', 'Failed to update ' . $userType);
        }

        // Handle redirect based on user type (admin is singular, others are plural)
        $redirectPath = $userType === 'admin' ? '/users/admin' : '/users/' . $userType . 's';
        Response::redirect($redirectPath);
    }

    /**
     * Store new user
     */
    public function store() {
        $request = Request::getInstance();
        $userType = $request->post('user_type', 'customer');
        
        // Validate required fields
        $surname = $request->post('surname');
        $firstname = $request->post('firstname');
        $email = $request->post('email');
        $username = $request->post('username');
        $password = $request->post('password');
        $passwordConfirm = $request->post('password_confirmation');
        
        if (empty($surname) || empty($firstname) || empty($email) || empty($username) || empty($password)) {
            Session::flash('error', 'Please fill in all required fields');
            Response::redirect('/users/create?type=' . $userType);
            return;
        }

        // Validate password confirmation
        if ($password !== $passwordConfirm) {
            Session::flash('error', 'Passwords do not match');
            Response::redirect('/users/create?type=' . $userType);
            return;
        }

        // Prepare data for creation
        $data = [
            'title' => $request->post('title'),
            'staffno' => $request->post('staffno'),
            'surname' => $surname,
            'firstname' => $firstname,
            'middlename' => $request->post('middlename'),
            'email' => $email,
            'phone' => $request->post('phone'),
            'gender' => $request->post('gender'),
            'dateofbirth' => $request->post('dateofbirth'),
            'occupation' => $request->post('occupation'),
            'address' => $request->post('address'),
            'username' => $username,
            'password' => $password,
            'status' => $request->post('status') ? 1 : 0,
            'usertypeid' => $request->post('usertypeid'),
        ];

        // Attorney-specific fields
        if ($userType === 'attorney') {
            $data['otherusertype'] = $request->post('otherusertype');
            $data['registrationnumber'] = $request->post('registrationnumber');
        }

        // Create user
        $result = $this->usersService->createUser($data);

        if ($result) {
            // Get the last inserted ID to update user service
            $serviceid = $request->post('serviceid');
            if ($serviceid) {
                // We need to get the last inserted user ID
                // For now, we'll skip this as we need the userid
            }

            Session::flash('success', ucfirst($userType) . ' created successfully');
        } else {
            Session::flash('error', 'Failed to create ' . $userType);
        }

        // Handle redirect based on user type (admin is singular, others are plural)
        $redirectPath = $userType === 'admin' ? '/users/admin' : '/users/' . $userType . 's';
        Response::redirect($redirectPath);
    }
}
