<?php
class InspectionTask extends BaseModel {





{
    

     // Custom table name
    protected $table = 'inspectiontask';
    protected $primaryKey = 'inspectiontaskid';
    public $timestamps = false;

    protected $fillable = [
        'note',
        'inspectionlead',
        'startdate',
        'status',
        'supervisornote',
        'itemid',
        'docurl',
        'entryby',
        'entrydate',
        'modifyby',
        'modifydate',
        'isdeleted',
        'companyid'
    ];

    protected $casts = [
        'startdate' => 'datetime',
        'entrydate' => 'datetime',
        'modifydate' => 'datetime',
        'isdeleted' => 'boolean',
    ];

    public function inspectionLead()
    {
        return $this->belongsTo(User::class, 'inspectionlead', 'userid');
    }

    public function inspectionStatus()
    {
        return $this->belongsTo(InspectionStatus::class, 'status', 'inspectionstatusid');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'itemid', 'itemid');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'inspectiontaskid', 'inspectiontaskid');
    }

    public function teamMembers()
    {
        return $this->hasMany(InspectionTaskTeam::class, 'inspectiontaskid', 'inspectiontaskid');
    }
}
