<?php
class UserService extends BaseModel {


use Illuminate\Database\Eloquent\Factories\HasFactory;


{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'userservices';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'userserviceid';

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
        'userid',
        'serviceid',
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
        'userserviceid' => 'integer',
        'userid' => 'integer',
        'serviceid' => 'integer',
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

    /**
     * Scope a query to only include non-deleted records.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('isdeleted', 0);
    }

    /**
     * Scope a query to filter by company.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $companyId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCompany($query, $companyId)
    {
        return $query->where('companyid', $companyId);
    }

    /**
     * Scope a query to filter by user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('userid', $userId);
    }

    /**
     * Scope a query to filter by service.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $serviceId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByService($query, $serviceId)
    {
        return $query->where('serviceid', $serviceId);
    }

    /**
     * Get the user assigned to this service.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

    /**
     * Get the service associated with this user service.
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'serviceid');
    }

    /**
     * Get the user who created this record.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'entryby');
    }

    /**
     * Get the user who last modified this record.
     */
    public function modifier()
    {
        return $this->belongsTo(User::class, 'modifyby');
    }

    /**
     * Get the company that owns this user service.
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'companyid');
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically set entryby and entrydate on creation
        static::creating(function ($model) {
            if (auth()->check()) {
                $model->entryby = $model->entryby ?? auth()->id();
            }
            $model->entrydate = $model->entrydate ?? now();
            $model->isdeleted = $model->isdeleted ?? 0;
        });

        // Automatically set modifyby and modifydate on update
        static::updating(function ($model) {
            if (auth()->check()) {
                $model->modifyby = auth()->id();
            }
            $model->modifydate = now();
        });

        // Apply global scope to exclude soft deleted records by default
        static::addGlobalScope('notDeleted', function ($builder) {
            $builder->where('isdeleted', 0);
        });
    }

    /**
     * Soft delete the record by setting isdeleted to 1.
     *
     * @return bool
     */
    public function softDelete()
    {
        $this->isdeleted = 1;
        if (auth()->check()) {
            $this->modifyby = auth()->id();
        }
        $this->modifydate = now();
        return $this->save();
    }

    /**
     * Restore a soft deleted record.
     *
     * @return bool
     */
    public function restore()
    {
        $this->isdeleted = 0;
        if (auth()->check()) {
            $this->modifyby = auth()->id();
        }
        $this->modifydate = now();
        return $this->save();
    }

    /**
     * Query with deleted records included.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function withDeleted()
    {
        return static::withoutGlobalScope('notDeleted');
    }

    /**
     * Query only deleted records.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function onlyDeleted()
    {
        return static::withoutGlobalScope('notDeleted')->where('isdeleted', 1);
    }

    /**
     * Check if user has access to a specific service.
     *
     * @param  int  $userId
     * @param  int  $serviceId
     * @return bool
     */
    public static function userHasService($userId, $serviceId)
    {
        return static::where('userid', $userId)
            ->where('serviceid', $serviceId)
            ->exists();
    }

    /**
     * Get all services for a user.
     *
     * @param  int  $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getUserServices($userId)
    {
        return static::with('service')
            ->where('userid', $userId)
            ->get();
    }

    /**
     * Get all users assigned to a service.
     *
     * @param  int  $serviceId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getServiceUsers($serviceId)
    {
        return static::with('user')
            ->where('serviceid', $serviceId)
            ->get();
    }
}