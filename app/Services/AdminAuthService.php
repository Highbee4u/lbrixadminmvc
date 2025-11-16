<?php
class AdminAuthService {
    private $db;
    private const ADMIN_USERTYPE_ID = 3;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function attemptLogin($credentials) {
        $login = $credentials['login'] ?? '';
        $password = $credentials['password'] ?? '';
        $remember = $credentials['remember'] ?? false;

        // Determine if login field is email or username
        $loginField = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        Logger::debug("Login attempt - Using field: {$loginField}, value: {$login}");
        
        // Find user with admin privileges and active status
        // Build query with direct comparison since PDO parameter binding might not work with column names
        $sql = "SELECT * FROM users WHERE {$loginField} = :login AND isdeleted != -1 LIMIT 1";
        
        Logger::debug("Login attempt - SQL: {$sql}");
        
        $user = $this->db->selectOne($sql, [':login' => $login]);

        if (!$user) {
            // User not found at all
            Logger::error("Login attempt - User not found with {$loginField}: {$login}");
            return false;
        }

        // Log what we found for debugging
        Logger::info("Login attempt - Found user: " . json_encode([
            'userid' => $user['userid'],
            'username' => $user['username'] ?? 'N/A',
            'email' => $user['email'] ?? 'N/A',
            'usertypeid' => $user['usertypeid'] ?? 'N/A',
            'status' => $user['status'] ?? 'N/A',
            'password_length' => strlen($user['password'] ?? '')
        ]));

        // Check if user is admin type (usertypeid = 3)
        if (isset($user['usertypeid']) && $user['usertypeid'] != self::ADMIN_USERTYPE_ID) {
            Logger::warning("Login attempt - User type mismatch. Expected: " . self::ADMIN_USERTYPE_ID . ", Got: " . $user['usertypeid']);
            return false;
        }

        // Check if user is active
        if (isset($user['status']) && $user['status'] != 1) {
            Logger::warning("Login attempt - User status is not active: " . $user['status']);
            return false;
        }

        $inputPassword = $password;
        $storedHash = $user['password'];

        Logger::info("Login attempt - Password verification starting. Hash length: " . strlen($storedHash));

        // First, try bcrypt verification (for already migrated passwords)
        if (password_verify($inputPassword, $storedHash)) {
            Logger::info("Login attempt - Bcrypt verification successful");
            Auth::login($user, $remember);
            return true;
        }

        Logger::debug("Login attempt - Bcrypt verification failed, trying MD5");

        // Check if it's an MD5 hash (32 chars, hexadecimal)
        if (strlen($storedHash) === 32 && ctype_xdigit($storedHash)) {
            Logger::debug("Login attempt - Hash appears to be MD5 format");
            $md5Input = md5($inputPassword);
            Logger::debug("Login attempt - MD5 comparison: stored={$storedHash}, input={$md5Input}");
            
            // Try MD5 verification
            if (hash_equals($storedHash, $md5Input)) {
                Logger::info("Login attempt - MD5 verification successful, migrating to bcrypt");
                // Migrate to bcrypt
                try {
                    $newHash = password_hash($inputPassword, PASSWORD_DEFAULT);
                    $this->db->update('users', [
                        'password' => $newHash
                    ], 'userid = ?', [$user['userid']]);
                    
                    // Update user array with new password for session
                    $user['password'] = $newHash;
                    
                    Logger::info("Login attempt - Password migrated successfully");
                    Auth::login($user, $remember);
                    return true;
                } catch (Exception $e) {
                    Logger::error("Login attempt - Password migration failed: " . $e->getMessage());
                    // Still log them in even if migration fails
                    Auth::login($user, $remember);
                    return true;
                }
            }
        }

        // Fallback MD5 check
        Logger::debug("Login attempt - Trying fallback MD5 check");
        if (hash_equals($storedHash, md5($inputPassword))) {
            Logger::info("Login attempt - Fallback MD5 verification successful");
            try {
                $newHash = password_hash($inputPassword, PASSWORD_DEFAULT);
                $this->db->update('users', [
                    'password' => $newHash
                ], 'userid = ?', [$user['userid']]);
                
                $user['password'] = $newHash;
                
                Auth::login($user, $remember);
                return true;
            } catch (Exception $e) {
                Auth::login($user, $remember);
                return true;
            }
        }

        Logger::error("Login attempt - All password verification methods failed");
        return false;
    }
}
