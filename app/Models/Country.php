<?php
class Country extends BaseModel {





{
        

     // Custom table name
    protected $table = 'countries';

    // Custom primary key
    protected $primaryKey = 'countryid';

    // Mass assignable attributes
    protected $fillable = [
        'country',
        'countrycode',
        'isdeleted',
        'entrydate',
        'modifyby',
        'modifydate'
    ];

    // Disable default created_at and updated_at since we have custom timestamps
    public $timestamps = false;

    public function items()
    {
        return $this->hasMany(Item::class, 'countryid', 'countryid');   
    }

    public function users()
    {
        return $this->hasMany(User::class, 'countryid', 'countryid');   
    }

    public function states()
    {
        return $this->hasMany(State::class, 'countryid', 'countryid');   
    }


}
