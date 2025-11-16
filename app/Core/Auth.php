<?php
class Auth {
    
    public static function check() {
        Session::start();
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }

    public static function guest() {
        return !self::check();
    }

    public static function id() {
        Session::start();
        return $_SESSION['user_id'] ?? null;
    }

    public static function user() {
        if (!self::check()) {
            return null;
        }

        $userId = self::id();
        $db = Database::getInstance();
        
        return $db->selectOne(
            "SELECT * FROM users WHERE userid = ? AND isdeleted != -1",
            [$userId]
        );
    }

    public static function attempt($credentials, $remember = false) {
        $email = $credentials['email'] ?? null;
        $password = $credentials['password'] ?? null;

        if (!$email || !$password) {
            return false;
        }

        $db = Database::getInstance();
        $user = $db->selectOne(
            "SELECT * FROM users WHERE email = ? AND isdeleted != -1",
            [$email]
        );

        if (!$user) {
            return false;
        }

        // Verify password
        if (!password_verify($password, $user['password'])) {
            return false;
        }

        // Check if user is active
        if (isset($user['status']) && $user['status'] != 1) {
            return false;
        }

        // Login successful
        self::login($user, $remember);
        return true;
    }

    public static function login($user, $remember = false) {
        Session::start();
        Session::regenerate();

        // Set core session values
        $_SESSION['user_id'] = $user['userid'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = trim(($user['surname'] ?? '') . ' ' . ($user['firstname'] ?? '') . ' ' . ($user['middlename'] ?? ''));
        $_SESSION['user_type'] = $user['usertypeid'] ?? null;
        $_SESSION['user_role'] = $user['adminroleid'] ?? null;
        $_SESSION['company_id'] = $user['companyid'] ?? 1;

        // Track last activity time for inactivity logout
        $_SESSION['last_activity'] = time();

        if ($remember) {
            self::setRememberToken($user['userid']);
        }

        // Update last login
        // $db = Database::getInstance();
        // $db->update('users', [
        //     'lastlogindate' => date('Y-m-d H:i:s')
        // ], 'userid = ?', [$user['userid']]);
    }

    public static function loginById($userId, $remember = false) {
        $db = Database::getInstance();
        $user = $db->selectOne(
            "SELECT * FROM users WHERE userid = ? AND isdeleted != -1",
            [$userId]
        );

        if ($user) {
            self::login($user, $remember);
            return true;
        }

        return false;
    }

    public static function logout() {
        Session::start();
        
        // Remove remember me cookie if exists
        if (isset($_COOKIE['remember_token'])) {
            self::removeRememberToken();
            setcookie('remember_token', '', time() - 3600, '/');
        }

        // Clear session
        Session::destroy();
    }

    private static function setRememberToken($userId) {
        try {
            $token = bin2hex(random_bytes(32));
            $hashedToken = hash('sha256', $token);

            $db = Database::getInstance();
            $db->update('users', [
                'remember_token' => $hashedToken
            ], 'userid = ?', [$userId]);

            // Set cookie for 30 days
            setcookie('remember_token', $token, time() + (86400 * 30), '/');
        } catch (Exception $e) {
            // If remember_token column doesn't exist, just skip it
            Logger::warning("Remember token not set: " . $e->getMessage());
        }
    }

    private static function removeRememberToken() {
        if (self::check()) {
            try {
                $db = Database::getInstance();
                $db->update('users', [
                    'remember_token' => null
                ], 'userid = ?', [self::id()]);
            } catch (Exception $e) {
                // If remember_token column doesn't exist, just skip it
                Logger::warning("Remember token not removed: " . $e->getMessage());
            }
        }
    }

    public static function checkRememberToken() {
        if (self::check()) {
            return;
        }

        if (!isset($_COOKIE['remember_token'])) {
            return;
        }

        $token = $_COOKIE['remember_token'];
        $hashedToken = hash('sha256', $token);

        $db = Database::getInstance();
        $user = $db->selectOne(
            "SELECT * FROM users WHERE remember_token = ? AND isdeleted != -1",
            [$hashedToken]
        );

        if ($user) {
            self::login($user, true);
        }
    }

    public static function hasRole($role) {
        $user = self::user();
        if (!$user) {
            return false;
        }

        return isset($user['adminroleid']) && $user['adminroleid'] == $role;
    }

    public static function isAdmin() {
        $user = self::user();
        if (!$user) {
            return false;
        }

        // User type 1 is admin
        return isset($user['usertypeid']) && $user['usertypeid'] == 1;
    }

    public static function isCustomer() {
        $user = self::user();
        if (!$user) {
            return false;
        }

        // User type 2 is customer
        return isset($user['usertypeid']) && $user['usertypeid'] == 2;
    }

    public static function isInspector() {
        $user = self::user();
        if (!$user) {
            return false;
        }

        // User type 3 is inspector
        return isset($user['usertypeid']) && $user['usertypeid'] == 3;
    }

    public static function isAttorney() {
        $user = self::user();
        if (!$user) {
            return false;
        }

        // User type 4 is attorney
        return isset($user['usertypeid']) && $user['usertypeid'] == 4;
    }

    public static function can($permission) {
        // Check if user has specific permission
        // This can be implemented based on your role/permission system
        return true; // Placeholder
    }

    public static function companyId() {
        Session::start();
        return $_SESSION['company_id'] ?? 1;
    }

    public static function userType() {
        Session::start();
        return $_SESSION['user_type'] ?? null;
    }

    public static function userRole() {
        Session::start();
        return $_SESSION['user_role'] ?? null;
    }

    public static function userName() {
        Session::start();
        return $_SESSION['user_name'] ?? 'Guest';
    }

    public static function userEmail() {
        Session::start();
        return $_SESSION['user_email'] ?? null;
    }
}
