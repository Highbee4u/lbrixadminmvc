<?php
class InspectionRequest extends BaseModel {





{
    

     // Custom table name
    protected $table = 'inspectionrequest';
    protected $primaryKey = 'inspectionrequestid';
    public $timestamps = false;

    protected $fillable = [
        'bidtypeid',
        'inspecteeid',
        'inspecteename',
        'inspecteephone',
        'inspecteeemail',
        'attorneyid',
        'note',
        'proposeddate',
        'itemid',
        'entryby',
        'entrydate',
        'modifyby',
        'modifydate',
        'isdeleted',
        'companyid'
    ];

    protected $casts = [
        'proposeddate' => 'date',
        'entrydate' => 'datetime',
        'modifydate' => 'datetime',
        'isdeleted' => 'boolean',
    ];

    public function bidType()
    {
        return $this->belongsTo(BidType::class, 'bidtypeid', 'bidtypeid');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'itemid', 'itemid');
    }

    public function inspectionStatus()
    {
        return $this->belongsTo(InspectionStatus::class, 'statusid', 'inspectionstatusid');
    }

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'inspecteeid', 'userid');
    }

    public function attorney()
    {
        return $this->belongsTo(User::class, 'attorneyid', 'userid');
    }

}
