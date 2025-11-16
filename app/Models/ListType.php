<?php
class ListType extends BaseModel {


use Illuminate\Database\Eloquent\Factories\HasFactory;




{
    use HasFactory, AuditFields;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'listtype';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'listtypeid';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'companyid',
        'listtypeid',
        'title',
        'isdeleted',
        'entryby',
        'entrydate',
        'modifyby',
        'modifydate',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'companyid' => 'integer',
        'listtypeid' => 'integer',
        'entryby' => 'integer',
        'modifyby' => 'integer',
        'entrydate' => 'datetime',
        'modifydate' => 'datetime',
        'isdeleted' => 'boolean',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'isdeleted',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->bidtypeid)) {
                // Get the maximum bidtypeid and increment by 1
                $maxId = DB::table('listtype')->max('listtypeid');
                $model->listtypeid = ($maxId ?? 0) + 1;
            }
        });
    }

}