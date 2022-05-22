<?php

namespace App\Models;

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;


class User extends EloquentUser
{
    use \Venturecraft\Revisionable\RevisionableTrait;

    use SoftDeletes;

    use HasApiTokens;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'status', 'process_id', 'image', 'mobile_no'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $loginNames = ['email'];

    protected $dependency = [];

    public function getFullName()
    {
        return $this->hasOne(User::class, 'id');
    }

    public function UsersRole()
    {
        return $this->belongsTo(RoleUser::class, 'id', 'user_id');
    }

    public function isSuperUser()
    {
        $roles = $this->roles()->get()->first()->toArray();
        if (in_array('Administrator', $roles)) {
            return true;
        }
        return false;
    }

    public function deleteValidate($id)
    {
        return null;
    }
}
