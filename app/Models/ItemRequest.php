<?php
class ItemRequest extends BaseModel {
    
    protected $table = 'itemsrequest';
    protected $primaryKey = 'itemsrequestid';
    
    public function __construct() {
        parent::__construct();
    }
}
