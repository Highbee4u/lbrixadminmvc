<?php
class State extends BaseModel {





{
    

     // Custom table name
    protected $table = 'states';
    protected $primaryKey = 'stateid';
    public $timestamps = false;

    protected $guarded = ['stateid'];
    /**
     * Get the country that the state belongs to.
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'countryid', 'countryid');
    }

    /**
     * Get the items located in this state.
     */
    public function items()
    {
        return $this->hasMany(Item::class, 'stateid', 'stateid');
    }
}
