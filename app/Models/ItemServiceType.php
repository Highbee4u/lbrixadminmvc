<?php
class ItemServiceType extends BaseModel {





{
    

     // Custom table name
    protected $table = 'itemservicetypes';
    protected $primaryKey = 'itemservicetypeid';
    public $timestamps = false;

    protected $guarded = ['itemservicetypeid'];

    // public function items()
    // {
    //     return $this->hasMany(Item::class, 'servicetypeid', 'itemservicetypeid');
    // }

    // public function itemServices()
    // {
    //     return $this->hasMany(ItemService::class, 'serviceid', 'itemservicetypeid');
    // }

    
}
