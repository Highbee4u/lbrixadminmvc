<?php
class ItemPics extends BaseModel {





{
    

    protected $table = 'itempics';
    protected $primaryKey = 'itempicid';
    public $timestamps = false;

    /**
     * Get the item this bid is for.
     */
    public function item()
    {
        return $this->belongsTo(Item::class, 'itemid', 'itemid');
    }
}
