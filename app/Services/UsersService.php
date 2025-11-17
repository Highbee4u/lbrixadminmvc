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
    const ADMIN_USERTYPE = 3;

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
        return $this->getFilteredUsers('customer', $page, $perPage, $filters);
    }

    /**
     * Get attorneys (usertypeid = 2)
     */
    public function getAttorneys($page = 1, $perPage = 15, $filters = []) {
        return $this->getFilteredUsers('attorney', $page, $perPage, $filters);
    }

    /**
     * Get inspectors (usertypeid = 3)
     */
    public function getInspectors($page = 1, $perPage = 15, $filters = []) {
        return $this->getFilteredUsers('inspector', $page, $perPage, $filters);
    }

    /**
     * Get admin users (usertypeid = 100 AND userid > 100)
     */
    public function getAdminUsers($page = 1, $perPage = 15, $filters = []) {
        return $this->getFilteredUsers('admin', $page, $perPage, $filters);
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
     * Centralized method for getting filtered users
     */
    private function getFilteredUsers($userType, $page = 1, $perPage = 15, $filters = []) {
        $conditions = [
            'u.isdeleted = ?',
            'u.companyid = ?'
        ];
        $params = [self::NOT_DELETED, $this->companyId];

        // Set user type specific conditions
        switch ($userType) {
            case 'customer':
                $conditions[] = 'u.usertypeid = ?';
                $params[] = self::CUSTOMER_USERTYPE;
                break;
            case 'attorney':
                $conditions[] = 'u.usertypeid = ?';
                $params[] = self::ATTORNEY_USERTYPE;
                break;
            case 'inspector':
                $conditions[] = 'u.usertypeid = ?';
                $params[] = self::INSPECTOR_USERTYPE;
                break;
            case 'admin':
                $conditions[] = 'u.usertypeid = ?';
                $conditions[] = 'u.userid > ?';
                $params[] = self::ADMIN_USERTYPE;
                $params[] = 100;
                break;
        }

        // Apply comprehensive filters
        if (!empty($filters['email'])) {
            $conditions[] = 'u.email LIKE ?';
            $params[] = '%' . $filters['email'] . '%';
        }

        if (!empty($filters['phone'])) {
            $conditions[] = 'u.phone LIKE ?';
            $params[] = '%' . $filters['phone'] . '%';
        }

        // Name search (surname, firstname, or full name)
        if (!empty($filters['name'])) {
            $conditions[] = '(u.surname LIKE ? OR u.firstname LIKE ? OR CONCAT(u.firstname, " ", u.surname) LIKE ?)';
            $searchTerm = '%' . $filters['name'] . '%';
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        if (!empty($filters['surname'])) {
            $conditions[] = 'u.surname LIKE ?';
            $params[] = '%' . $filters['surname'] . '%';
        }

        if (!empty($filters['firstname'])) {
            $conditions[] = 'u.firstname LIKE ?';
            $params[] = '%' . $filters['firstname'] . '%';
        }

        if (!empty($filters['username'])) {
            $conditions[] = 'u.username LIKE ?';
            $params[] = '%' . $filters['username'] . '%';
        }

        if (!empty($filters['staffno'])) {
            $conditions[] = 'u.staffno LIKE ?';
            $params[] = '%' . $filters['staffno'] . '%';
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $conditions[] = 'u.status = ?';
            $params[] = $filters['status'];
        }

        if (!empty($filters['gender'])) {
            $conditions[] = 'u.gender = ?';
            $params[] = $filters['gender'];
        }

        // Date range filtering
        if (!empty($filters['entrydate_from'])) {
            $conditions[] = 'DATE(u.entrydate) >= ?';
            $params[] = $filters['entrydate_from'];
        }

        if (!empty($filters['entrydate_to'])) {
            $conditions[] = 'DATE(u.entrydate) <= ?';
            $params[] = $filters['entrydate_to'];
        }

        if (!empty($filters['entrydate'])) {
            // Single date filter (backward compatibility)
            $conditions[] = 'DATE(u.entrydate) = ?';
            $params[] = $filters['entrydate'];
        }

        $where = implode(' AND ', $conditions);

        // Build SELECT based on user type
        $baseSql = "
            SELECT 
                u.*,
                g.title as gender_title
        ";

        if ($userType === 'admin') {
            $baseSql .= ",
                ar.title as role_title
            FROM users u
            LEFT JOIN genders g ON u.gender = g.genderid
            LEFT JOIN adminroles ar ON u.usertypeid = ar.adminroleid";
        } else {
            $baseSql .= "
            FROM users u
            LEFT JOIN genders g ON u.gender = g.genderid";
        }

        $baseSql .= " WHERE $where ORDER BY u.surname, u.firstname, u.entrydate DESC";

        $countSql = "SELECT COUNT(*) as total FROM users u WHERE $where";

        return $this->paginate($baseSql, $countSql, $params, $page, $perPage);
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
                // Handle empty values for date fields - convert to NULL
                $value = $data[$field];
                if (in_array($field, ['dateofbirth']) && $value === '') {
                    $value = null;
                }
                
                $updates[] = "$field = ?";
                $params[] = $value;
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

        // Use withUpdateAudit to add audit fields
        $auditData = $this->withUpdateAudit([]);
        foreach ($auditData as $field => $value) {
            $updates[] = "$field = ?";
            $params[] = $value;
        }

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

        // Use withUpdateAudit to add audit fields for insert operation
        $auditData = $this->withUpdateAudit([]);
        foreach ($auditData as $field => $value) {
            $columns[] = $field;
            $placeholders[] = '?';
            $params[] = $value;
        }

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
            $updateData = $this->withUpdateAudit([
                'serviceid' => $serviceid
            ]);
            
            $setClause = [];
            $params = [];
            foreach ($updateData as $field => $value) {
                $setClause[] = "$field = ?";
                $params[] = $value;
            }
            
            $params[] = $userid;
            $params[] = self::NOT_DELETED;
            
            $sql = "
                UPDATE userservices
                SET " . implode(', ', $setClause) . "
                WHERE userid = ?
                    AND isdeleted = ?
            ";
            return $this->db->query($sql, $params);
        } else {
            // Insert new
            $insertData = $this->withUpdateAudit([
                'userid' => $userid,
                'serviceid' => $serviceid
            ]);
            
            $columns = array_keys($insertData);
            $placeholders = array_fill(0, count($insertData), '?');
            $params = array_values($insertData);
            
            $sql = "
                INSERT INTO userservices (" . implode(', ', $columns) . ")
                VALUES (" . implode(', ', $placeholders) . ")
            ";
            return $this->db->query($sql, $params);
        }
    }
}
