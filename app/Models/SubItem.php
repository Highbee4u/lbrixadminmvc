<?php
class SubItem extends BaseModel {





{
    

     // Custom table name
    protected $table = 'subitem';
    protected $primaryKey = 'subitemid';
    public $timestamps = false;

    protected $guarded = ['subitemid'];

    public function item()
    {
        return $this->belongsTo(Item::class, 'itemid', 'itemid');
    }
}
