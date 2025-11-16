<?php
class Sublocation extends BaseModel {





{
    
    
     // Custom table name
    protected $table = 'sublocations';

    // Custom primary key
    protected $primaryKey = 'sublocationid';

    protected $guarded = ['sublocationid'];

    // Disable default created_at and updated_at since we have custom timestamps
    public $timestamps = false;

    public function state()
    {
        return $this->belongsTo(State::class, 'stateid', 'stateid');   
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'sublocationid', 'sublocationid');   
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'countryid', 'countryid');
    }


}
