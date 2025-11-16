<?php
class AdminRole extends BaseModel {
    protected $primaryKey = 'adminroleid';
    protected $table = 'adminroles';
    protected $fillable = [
        'companyid',
        'title',
        'status',
        'adminrank',
        'isdeleted',
        'entryby',
        'entrydate',
        'modifyby',
        'modifydate'
    ];

    public function scopeActive() {
        return $this->db->select("SELECT * FROM {$this->table} WHERE isdeleted = -1");
    }

    public function creator() {
        return $this->db->selectOne("SELECT * FROM users WHERE id = ?", [$this->entryby]);
    }

    public function modifier() {
        return $this->db->selectOne("SELECT * FROM users WHERE id = ?", [$this->modifyby]);
    }

    public function getActiveRoles() {
        return $this->db->select("SELECT * FROM {$this->table} WHERE status = 1 AND isdeleted = -1 ORDER BY adminrank ASC");
    }

    public function findByRank($rank) {
        return $this->db->selectOne("SELECT * FROM {$this->table} WHERE adminrank = ? AND status = 1 AND isdeleted = -1", [$rank]);
    }
}