<?php
class OwnershipType extends BaseModel {





{
    
    
    // Custom table name
    protected $table = 'ownershiptypes';

    // Custom primary key
    protected $primaryKey = 'ownershiptypeid';

    protected $guarded = ['ownershiptypeid'];

    // Disable default created_at and updated_at since we have custom timestamps
    public $timestamps = false;

    public function items()
    {
        return $this->hasMany(Item::class, 'ownershiptypeid', 'ownershiptypeid');
    }
}
