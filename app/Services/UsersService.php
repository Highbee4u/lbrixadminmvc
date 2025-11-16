<?php
class UsersService {
    use AuditFields;

    private $db;
    private $companyId;
    const IS_DELETED = -1;
    const NOT_DELETED = 0;
    const CUSTOMER_USERTYPE = 1;
    const ATTORNEY_USERTYPE = 2;
    const INSPECTOR_USERTYPE = 3;
    const ADMIN_USERTYPE = 100;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->companyId = Auth::companyId();
    }

    /**
     * Paginate helper
     */
    private function paginate($baseSql, $countSql, $params, $page = 1, $perPage = 15) {
        $offset = ($page - 1) * $perPage;
        $data = $this->db->select($baseSql . " LIMIT ? OFFSET ?", array_merge($params, [$perPage, $offset]));
        $count = $this->db->select($countSql, $params);
        $total = $count[0]['total'] ?? 0;
        return [
            'data' => $data,
            'total' => (int)$total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => (int)ceil($total / $perPage)
        ];
    }

    /**
     * Get all users
     */
    public function getUsers() {
        return $this->db->select("SELECT * FROM users WHERE isdeleted = 0 AND companyid = ? ORDER BY surname, firstname", [$this->companyId]);
    }

    /**
     * Get customers (usertypeid = 1)
     */
    public function getCustomers($page = 1, $perPage = 15, $filters = []) {
        $conditions = [
            'u.isdeleted = ?',
            'u.companyid = ?',
            'u.usertypeid = ?'
        ];
        $params = [self::NOT_DELETED, $this->companyId, self::CUSTOMER_USERTYPE];

        // Apply filters
        if (!empty($filters['email'])) {
            $conditions[] = 'u.email LIKE ?';
            $params[] = '%' . $filters['email'] . '%';
        }
        if (!empty($filters['phone'])) {
            $conditions[] = 'u.phone LIKE ?';
            $params[] = '%' . $filters['phone'] . '%';
        }
        if (!empty($filters['entrydate'])) {
            $conditions[] = 'DATE(u.entrydate) = ?';
            $params[] = $filters['entrydate'];
        }

        $where = implode(' AND ', $conditions);

        $baseSql = "
            SELECT 
                u.*,
                g.title as gender_title
            FROM users u
            LEFT JOIN genders g ON u.gender = g.genderid
            WHERE $where
            ORDER BY u.surname, u.firstname, u.entrydate DESC
        ";

        $countSql = "SELECT COUNT(*) as total FROM users u WHERE $where";

        return $this->paginate($baseSql, $countSql, $params, $page, $perPage);
    }

    /**
     * Get attorneys (usertypeid = 2)
     */
    public function getAttorneys($page = 1, $perPage = 15, $filters = []) {
        $conditions = [
            'u.isdeleted = ?',
            'u.companyid = ?',
            'u.usertypeid = ?'
        ];
        $params = [self::NOT_DELETED, $this->companyId, self::ATTORNEY_USERTYPE];

        // Apply filters
        if (!empty($filters['email'])) {
            $conditions[] = 'u.email LIKE ?';
            $params[] = '%' . $filters['email'] . '%';
        }
        if (!empty($filters['phone'])) {
            $conditions[] = 'u.phone LIKE ?';
            $params[] = '%' . $filters['phone'] . '%';
        }
        if (!empty($filters['entrydate'])) {
            $conditions[] = 'DATE(u.entrydate) = ?';
            $params[] = $filters['entrydate'];
        }

        $where = implode(' AND ', $conditions);

        $baseSql = "
            SELECT 
                u.*,
                g.title as gender_title
            FROM users u
            LEFT JOIN genders g ON u.gender = g.genderid
            WHERE $where
            ORDER BY u.surname, u.firstname, u.entrydate DESC
        ";

        $countSql = "SELECT COUNT(*) as total FROM users u WHERE $where";

        return $this->paginate($baseSql, $countSql, $params, $page, $perPage);
    }

    /**
     * Get inspectors (usertypeid = 3)
     */
    public function getInspectors($page = 1, $perPage = 15, $filters = []) {
        $conditions = [
            'u.isdeleted = ?',
            'u.companyid = ?',
            'u.usertypeid = ?'
        ];
        $params = [self::NOT_DELETED, $this->companyId, self::INSPECTOR_USERTYPE];

        // Apply filters
        if (!empty($filters['email'])) {
            $conditions[] = 'u.email LIKE ?';
            $params[] = '%' . $filters['email'] . '%';
        }
        if (!empty($filters['phone'])) {
            $conditions[] = 'u.phone LIKE ?';
            $params[] = '%' . $filters['phone'] . '%';
        }
        if (!empty($filters['entrydate'])) {
            $conditions[] = 'DATE(u.entrydate) = ?';
            $params[] = $filters['entrydate'];
        }

        $where = implode(' AND ', $conditions);

        $baseSql = "
            SELECT 
                u.*,
                g.title as gender_title
            FROM users u
            LEFT JOIN genders g ON u.gender = g.genderid
            WHERE $where
            ORDER BY u.surname, u.firstname, u.entrydate DESC
        ";

        $countSql = "SELECT COUNT(*) as total FROM users u WHERE $where";

        return $this->paginate($baseSql, $countSql, $params, $page, $perPage);
    }

    /**
     * Get admin users (usertypeid = 3 AND userid > 100)
     */
    public function getAdminUsers($page = 1, $perPage = 15, $filters = []) {
        $conditions = [
            'u.isdeleted = ?',
            'u.companyid = ?',
            'u.usertypeid = ?',
            'u.userid > ?'
        ];
        $params = [self::NOT_DELETED, $this->companyId, self::INSPECTOR_USERTYPE, 100];

        // Apply filters
        if (!empty($filters['email'])) {
            $conditions[] = 'u.email LIKE ?';
            $params[] = '%' . $filters['email'] . '%';
        }
        if (!empty($filters['phone'])) {
            $conditions[] = 'u.phone LIKE ?';
            $params[] = '%' . $filters['phone'] . '%';
        }
        if (!empty($filters['entrydate'])) {
            $conditions[] = 'DATE(u.entrydate) = ?';
            $params[] = $filters['entrydate'];
        }

        $where = implode(' AND ', $conditions);

        $baseSql = "
            SELECT 
                u.*,
                g.title as gender_title,
                ar.title as role_title
            FROM users u
            LEFT JOIN genders g ON u.gender = g.genderid
            LEFT JOIN adminroles ar ON u.usertypeid = ar.adminroleid
            WHERE $where
            ORDER BY u.surname, u.firstname, u.entrydate DESC
        ";

        $countSql = "SELECT COUNT(*) as total FROM users u WHERE $where";

        return $this->paginate($baseSql, $countSql, $params, $page, $perPage);
    }

    /**
     * Get user by ID
     */
    public function getUserById($userid) {
        $sql = "
            SELECT 
                u.*,
                g.title as gender_title
            FROM users u
            LEFT JOIN genders g ON u.gender = g.genderid
            WHERE u.userid = ?
                AND u.companyid = ?
                AND u.isdeleted = ?
            LIMIT 1
        ";

        $result = $this->db->select($sql, [$userid, $this->companyId, self::NOT_DELETED]);
        return $result[0] ?? null;
    }

    /**
     * Update user
     */
    public function updateUser($userid, $data) {
        $updates = [];
        $params = [];

        // Handle allowed fields for update
        $allowedFields = [
            'title', 'staffno', 'surname', 'firstname', 'middlename', 'email', 'phone',
            'gender', 'dateofbirth', 'occupation', 'address', 'username', 'status',
            'usertypeid', 'otherusertype', 'registrationnumber'
        ];

        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $updates[] = "$field = ?";
                $params[] = $data[$field];
            }
        }

        // Handle password if provided
        if (!empty($data['password'])) {
            $updates[] = 'password = ?';
            $params[] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        if (empty($updates)) {
            return false;
        }

        // Add updateby and updatedate
        $updates[] = 'modifyby = ?';
        $updates[] = 'modifydate = NOW()';
        $params[] = Auth::id();

        // Add WHERE conditions
        $params[] = $userid;
        $params[] = $this->companyId;
        $params[] = self::NOT_DELETED;

        $sql = "
            UPDATE users 
            SET " . implode(', ', $updates) . "
            WHERE userid = ?
                AND companyid = ?
                AND isdeleted = ?
        ";

        return $this->db->query($sql, $params);
    }

    /**
     * Create new user
     */
    public function createUser($data) {
        $fields = [
            'title', 'staffno', 'surname', 'firstname', 'middlename', 'email', 'phone',
            'gender', 'dateofbirth', 'occupation', 'address', 'username', 'status',
            'usertypeid', 'otherusertype', 'registrationnumber'
        ];

        $columns = [];
        $placeholders = [];
        $params = [];

        foreach ($fields as $field) {
            if (isset($data[$field])) {
                $columns[] = $field;
                $placeholders[] = '?';
                $params[] = $data[$field];
            }
        }

        // Handle password (required for new user)
        if (!empty($data['password'])) {
            $columns[] = 'password';
            $placeholders[] = '?';
            $params[] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        // Add audit fields
        $columns[] = 'companyid';
        $columns[] = 'entryby';
        $columns[] = 'entrydate';
        $columns[] = 'isdeleted';
        
        $placeholders[] = '?';
        $placeholders[] = '?';
        $placeholders[] = 'NOW()';
        $placeholders[] = '?';
        
        $params[] = $this->companyId;
        $params[] = Auth::id();
        $params[] = self::NOT_DELETED;

        $sql = "
            INSERT INTO users (" . implode(', ', $columns) . ")
            VALUES (" . implode(', ', $placeholders) . ")
        ";

        return $this->db->query($sql, $params);
    }

    /**
     * Get all admin roles
     */
    public function getAdminRoles() {
        $sql = "SELECT * FROM adminroles WHERE isdeleted = ? AND companyid = ? ORDER BY title";
        return $this->db->select($sql, [self::NOT_DELETED, $this->companyId]);
    }

    /**
     * Get all services
     */
    public function getServices() {
        $sql = "SELECT * FROM services WHERE isdeleted = ? AND companyid = ? ORDER BY title";
        return $this->db->select($sql, [self::NOT_DELETED, $this->companyId]);
    }

    /**
     * Get user service
     */
    public function getUserService($userid) {
        $sql = "SELECT * FROM userservices WHERE userid = ? AND isdeleted = ? LIMIT 1";
        $result = $this->db->select($sql, [$userid, self::NOT_DELETED]);
        return $result[0] ?? null;
    }

    /**
     * Update or create user service
     */
    public function updateUserService($userid, $serviceid) {
        if (empty($serviceid)) {
            return true; // No service to set
        }

        // Check if user service exists
        $existing = $this->getUserService($userid);

        if ($existing) {
            // Update existing
            $sql = "
                UPDATE userservices 
                SET serviceid = ?, 
                    modifyby = ?, 
                    modifydate = NOW()
                WHERE userid = ? 
                    AND isdeleted = ?
            ";
            return $this->db->query($sql, [$serviceid, Auth::id(), $userid, self::NOT_DELETED]);
        } else {
            // Insert new
            $sql = "
                INSERT INTO userservices (userid, serviceid, companyid, entryby, entrydate, isdeleted)
                VALUES (?, ?, ?, ?, NOW(), ?)
            ";
            return $this->db->query($sql, [$userid, $serviceid, $this->companyId, Auth::id(), self::NOT_DELETED]);
        }
    }
}
