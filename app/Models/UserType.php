<?php
class UserType extends BaseModel {


use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\HasMany;

{
    use HasFactory;

    // Custom table name
    protected $table = 'usertypes';

    // Custom primary key
    protected $primaryKey = 'usertypeid';

    // Disable default created_at and updated_at since we have custom timestamps
    public $timestamps = false;

    // Specify guarded attributes to allow mass assignment on all fields except the primary key
    protected $guarded = ['usertypeid'];
    
    // Cast custom boolean/date fields
    protected $casts = [
        'isdeleted' => 'boolean',
        'entrydate' => 'datetime',
        'modifydate' => 'datetime',
    ];

    /**
     * Get the users associated with this user type.
     */
    public function users(): HasMany
    {
        // A UserType has many Users
        return $this->hasMany(User::class, 'usertypeid', 'usertypeid');
    }
}
