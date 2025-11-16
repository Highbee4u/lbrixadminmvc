<?php
class Currency extends BaseModel {





{
    

    // Custom table name
    protected $table = 'currency';

    // Custom primary key
    protected $primaryKey = 'currencyid';

    protected $guarded = ['currencyid'];

    // Disable default created_at and updated_at since we have custom timestamps
    public $timestamps = false;

    public function items()
    {
        return $this->hasMany(Item::class, 'currencyid', 'currencyid');   
    }

    public function itembids()
    {
        return $this->hasMany(ItemBid::class, 'currencyid', 'currencyid');  
    }
}
