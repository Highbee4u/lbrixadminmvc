<?php
class InspectionStatus extends BaseModel {
    protected $table = 'inspectionstatus';
    protected $primaryKey = 'inspectionstatusid';
    public $timestamps = false;
    protected $fillable = [
        'title', 'isdeleted', 'entryby', 'entrydate', 'modifyby', 'modifydate', 'companyid'
    ];
    // Relationship method removed for Core PHP MVC compatibility
    public function getAllActive() {
        return $this->db->select("SELECT * FROM {$this->table} WHERE isdeleted = -1 ORDER BY inspectionstatusid ASC");
    }
}