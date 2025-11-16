<?php
class ItemDoc extends BaseModel {





{
    

    protected $table = 'itemdocs';
    protected $primaryKey = 'itemdocid';
    public $timestamps = false;

    protected $fillable = [
        'companyid',
        'itemdocid',
        'itemid',
        'itemdoctypeid',
        'docname',
        'docpath',
        'entryby',
        'entrydate',
        'modifyby',
        'modifydate',
        'isdeleted'
    ];
    /**
     * Get the item this bid is for.
     */
    public function item()
    {
        return $this->belongsTo(Item::class, 'itemid', 'itemid');
    }

    public function itemDocType()
    {
        return $this->belongsTo(ItemDocType::class, 'itemdoctypeid', 'itemdoctypeid');
    }
}
