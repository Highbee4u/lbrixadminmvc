<?php
class User extends BaseModel {
    protected $primaryKey = 'userid';
    protected $fillable = [
        'companyid',
        'title',
        'staffno',
        'surname',
        'firstname',
        'middlename',
        'username',
        'email',
        'password',
        'gender',
        'dateofbirth',
        'occupation',
        'address',
        'phone',
        'usertypeid',
        'otherusertype',
        'registrationnumber',
        'status',
        'entryby',
        'entrydate',
        'modifyby',
        'modifydate',
        'isdeleted',
    ];

    protected $hidden = [
        'password',
    ];

    public function userType() {
        // Simple relationship - in a full implementation you'd join manually
        return $this->db->selectOne("SELECT * FROM user_types WHERE usertypeid = ?", [$this->usertypeid]);
    }

    public function userServices() {
        return $this->db->select("SELECT * FROM user_services WHERE userid = ?", [$this->userid]);
    }

    public function authenticate($username, $password) {
        $user = $this->db->selectOne("SELECT * FROM {$this->table} WHERE username = ? AND status = 1 AND isdeleted = 0", [$username]);

        if ($user && password_verify($password, $user['password'])) {
            // Remove sensitive data
            unset($user['password']);
            return $user;
        }

        return false;
    }

    public function findByEmail($email) {
        return $this->db->selectOne("SELECT * FROM {$this->table} WHERE email = ? AND status = 1 AND isdeleted = 0", [$email]);
    }

    public function createUser($data) {
        // Hash password if provided
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        return $this->create($data);
    }

    public function updatePassword($userId, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        return $this->update($userId, ['password' => $hashedPassword]);
    }
}
