<?php
class ItemStatus extends BaseModel {




{
    // Custom table name
    protected $table = 'itemstatus';

    // Custom primary key
    protected $primaryKey = 'itemstatusid';

    // Disable default created_at and updated_at since we have custom timestamps
    public $timestamps = false;

    public function items()
    {
        return $this->hasMany(Item::class, 'itemstatusid', 'itemstatusid');   
    }
}
