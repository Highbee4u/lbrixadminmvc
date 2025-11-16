<?php
class PaymentTerm extends BaseModel {





{
    
    
    // Custom table name
    protected $table = 'payterms';

    // Custom primary key
    protected $primaryKey = 'paytermid';

    // Disable default created_at and updated_at since we have custom timestamps
    public $timestamps = false;

    protected $fillable = [
        'companyid',
        'title',
        'entryby',
        'entrydate',
        'modifyby',
        'modifydate',
        'isdeleted'
    ];

    protected $casts = [
        'companyid' => 'integer',
        'entryby' => 'integer',
        'modifyby' => 'integer',
        'isdeleted' => 'integer',
        'entrydate' => 'datetime',
        'modifydate' => 'datetime'
    ];

}