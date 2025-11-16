<?php
class Service  extends BaseModel {
    // Custom table name
    protected $table = 'services';
    // Custom primary key
    protected $primaryKey = 'serviceid';
    // Disable default created_at and updated_at since we have custom timestamps
    public $timestamps = false;
    
    protected $fillable = [
        'title', 'isadmin', 'isparticipant', 'isdeleted', 'entryby', 'entrydate', 'modifyby', 'modifydate', 'companyid'
    ];
    public function getAllActive() {
        return $this->db->select("SELECT * FROM {$this->table} WHERE isdeleted = -1 ORDER BY serviceid ASC");
    }
}