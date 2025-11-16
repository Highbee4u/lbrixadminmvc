<?php
class ItemProfileOption extends BaseModel {





{
    
    
    // Custom table name
    protected $table = 'itemprofileoptions';

    // Custom primary key
    protected $primaryKey = 'itemprofileoptionid';

    // Disable default created_at and updated_at since we have custom timestamps
    public $timestamps = false;

    protected $fillable = [
        'companyid',
        'itemtypeid',
        'optiontype',
        'title',
        'basetitle',
        'listmenu',
        'listtype',
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
        'itemtypeid' => 'integer',
        'entryby' => 'integer',
        'modifyby' => 'integer'
    ];

    // Relationship to ItemType
    public function itemType()
    {
        return $this->belongsTo(ItemType::class, 'itemtypeid', 'itemtypeid');
    }

    // Scopes for common queries
    public function scopeNotDeleted($query)
    {
        return $query->where('isdeleted', 0);
    }

    public function scopeForUser($query)
    {
        return $query->where('showuser', 1);
    }

    public function scopeByOptionType($query, $type)
    {
        return $query->where('optiontype', $type);
    }

    // Accessor for list menu as array (if stored as comma-separated or JSON)
    public function getListMenuArrayAttribute()
    {
        if (empty($this->listmenu)) {
            return [];
        }
        
        // If it's JSON
        $decoded = json_decode($this->listmenu, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $decoded;
        }
        
        // If it's comma-separated
        return array_map('trim', explode(',', $this->listmenu));
    }
}