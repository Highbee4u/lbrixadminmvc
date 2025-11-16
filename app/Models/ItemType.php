<?php
class ItemType extends BaseModel {





{
    

     // Custom table name
    protected $table = 'itemtypes';
    protected $primaryKey = 'itemtypeid';
    public $timestamps = false;

    protected $guarded = ['itemtypeid'];

    /**
     * Get the items of this type.
     */
    public function items()
    {
        return $this->hasMany(Item::class, 'itemtypeid', 'itemtypeid');
    }

    public function services()
    {
        return $this->hasMany(ItemService::class, 'itemtypeid', 'itemtypeid');
    }
}
