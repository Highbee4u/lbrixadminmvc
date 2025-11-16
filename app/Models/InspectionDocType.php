<?php
class InspectionDocType extends BaseModel {


use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\SoftDeletes;


{
    use HasFactory, AuditFields;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'InspectionDocTypes';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'itemdoctypeid';

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
        'title',
        'entryby',
        'entrydate',
        'modifyby',
        'modifydate',
        'isdeleted',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'companyid' => 'integer',
        'itemdoctypeid' => 'integer',
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


}