<?php
class BidType extends BaseModel {
    protected $table = 'bidtype';
    protected $primaryKey = 'bidtypeid';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = [
        'bidtypeid', 'options', 'serviceid', 'isdeleted', 'entryby', 'entrydate', 'modifyby', 'modifydate', 'companyid'
    ];
    protected $casts = [
        'entrydate' => 'datetime',
        'modifydate' => 'datetime',
        'isdeleted' => 'boolean'
    ];
    public function getAllActive() {
        return $this->db->select("SELECT * FROM {$this->table} WHERE isdeleted = -1 ORDER BY bidtypeid ASC");
    }
}


// {
    

//     // Custom table name
//     protected $table = 'bidtype';

//     // Custom primary key
//     protected $primaryKey = 'bidtypeid';

//     // Disable auto-incrementing since DB doesn't support it
//     public $incrementing = false;

//     // Set the primary key type
//     protected $keyType = 'int';

//     // Disable default created_at and updated_at since we have custom timestamps
//     public $timestamps = false;

//     protected $fillable = [
//         'bidtypeid',
//         'options',
//         'serviceid',
//         'isdeleted',
//         'entryby',
//         'entrydate',
//         'modifyby',
//         'modifydate',
//         'companyid'
//     ];

//     protected $casts = [
//         'entrydate' => 'datetime',
//         'modifydate' => 'datetime',
//         'isdeleted' => 'boolean'
//     ];

//     /**
//      * Boot method to auto-generate bidtypeid before creating
//      */
//     protected static function boot()
//     {
//         parent::boot();

//         static::creating(function ($model) {
//             if (empty($model->bidtypeid)) {
//                 // Get the maximum bidtypeid and increment by 1
//                 $maxId = DB::table('bidtype')->max('bidtypeid');
//                 $model->bidtypeid = ($maxId ?? 0) + 1;
//             }
//         });
//     }
    

//     public function items()
//     {
//         return $this->hasMany(Item::class, 'bidtypeid', 'bidtypeid');
//     }

//     public function itemservices()
//     {
//         return $this->hasMany(ItemService::class, 'serviceid', 'itemserviceid');
//     }

//     public function service()
//     {
//         return $this->belongsTo(Service::class, 'serviceid', 'serviceid');
//     }
// }