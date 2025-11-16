<?php
class TitleType extends BaseModel {




{
    // Custom table name
    protected $table = 'titletypes';

    // Custom primary key
    protected $primaryKey = 'titletypeid';

    // Disable default created_at and updated_at since we have custom timestamps
    public $timestamps = false;

    public function items()
    {
        return $this->hasMany(Item::class, 'titletypeid', 'titletypeid');   
    }
}
