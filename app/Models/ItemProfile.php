<?php
class ItemProfile extends BaseModel {





{
    

    // Custom table name
    protected $table = 'itemprofiles';

    // Custom primary key
    protected $primaryKey = 'itemprofileid';

    // Disable default created_at and updated_at since we have custom timestamps
    public $timestamps = false;

    protected $fillable = [
        'companyid',
        'itemprofileid',
        'itemid',
        'profileoptionid',
        'profilevalue',
        'basevalue',
        'showuser',
        'entryby',
        'entrydate',
        'modifyby',
        'modifydate',
        'isdeleted'
    ];

    protected $casts = [
        'showuser' => 'boolean',
        'isdeleted' => 'integer',
        'entrydate' => 'datetime',
        'modifydate' => 'datetime',
        'companyid' => 'integer',
        'itemprofileid' => 'integer',
        'itemid' => 'integer',
        'profileoptionid' => 'integer',
        'entryby' => 'integer',
        'modifyby' => 'integer'
    ];

    // Relationship to Item
    public function item()
    {
        return $this->belongsTo(Item::class, 'itemid', 'itemid');
    }

    // Relationship to ItemProfileOption
    public function profileOption()
    {
        return $this->belongsTo(ItemProfileOption::class, 'profileoptionid', 'itemprofileoptionid');
    }

    // Scopes for common queries
    public function scopeNotDeleted($query)
    {
        return $query->where('isdeleted', 0);
    }

    public function scopeForItem($query, $itemId)
    {
        return $query->where('itemid', $itemId);
    }
}