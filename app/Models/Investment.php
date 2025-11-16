<?php
class Investment extends BaseModel {
    protected $table = 'investments';
    protected $primaryKey = 'investmentid';
    public $timestamps = false;
    protected $fillable = [
        'title', 'jointstatus', 'status', 'startdate', 'isdeleted', 'entryby', 'entrydate', 'modifyby', 'modifydate', 'amount', 'companyid'
    ];
    public function getAllActive() {
        return $this->db->select("SELECT * FROM {$this->table} WHERE isdeleted = -1 ORDER BY investmentid ASC");
    }
}