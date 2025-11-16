<?php
class InspectionTaskTeam extends BaseModel {





{
    

     // Custom table name
    protected $table = 'inspectionteam';
    protected $primaryKey = 'inspectionteamid';
    public $timestamps = false;

    protected $fillable = [
        'inspectiontaskid',
        'comment',
        'userid',
        'status',
        'role',
        'entryby',
        'entrydate',
        'modifyby',
        'modifydate',
        'isdeleted',
        'companyid'
    ];

    protected $casts = [
        'entrydate' => 'datetime',
        'modifydate' => 'datetime',
        'isdeleted' => 'boolean',
    ];

    public function inspectionTask()
    {
        return $this->belongsTo(InspectionTask::class, 'inspectiontaskid', 'inspectiontaskid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userid', 'userid');
    }
}
