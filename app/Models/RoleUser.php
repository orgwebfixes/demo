<?php

namespace App\Models;

use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleUser extends EloquentRole
{
    use \Venturecraft\Revisionable\RevisionableTrait;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'role_users';
    protected $fillable = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public function fetchUserData()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function fetchLockerCharge()
    {
        return $this->hasOne(Wallet::class, 'object_id', 'user_id')->where('object_type', 'add_locker');
    }

    public function roleName()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function userDetail()
    {
        return $this->belongsTo(User_Profile::class, 'user_id')->where('lang', 'en');
    }
}
