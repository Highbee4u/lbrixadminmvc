<?php
class ProjectType extends BaseModel {





{
    
    
    // Custom table name
    protected $table = 'projecttypes';
    protected $primaryKey = 'projecttypeid';
    public $timestamps = false;

    protected $guarded = ['projecttypeid'];

    public function items()
    {
        return $this->hasMany(Item::class, 'projecttypeid', 'projecttypeid');
    }
}
