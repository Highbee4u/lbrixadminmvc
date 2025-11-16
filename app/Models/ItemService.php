<?php

class ItemService extends BaseModel {
    protected $table = 'itemservices';
    protected $primaryKey = 'itemserviceid';
    public $timestamps = false;
    protected $fillable = [
        'serviceid', 'itemtypeid', 'isdeleted', 'entryby', 'entrydate', 'modifyby', 'modifydate', 'companyid'
    ];
    // Relationship methods removed for Core PHP MVC compatibility
    public function getAllWithRelations() {
        $sql = "SELECT isv.*, s.title as service_title, it.title as itemtype_title FROM {$this->table} isv
                LEFT JOIN services s ON isv.serviceid = s.serviceid
                LEFT JOIN itemtypes it ON isv.itemtypeid = it.itemtypeid
                WHERE isv.isdeleted = -1 ORDER BY isv.itemserviceid ASC";
        return $this->db->select($sql);
    }
}




