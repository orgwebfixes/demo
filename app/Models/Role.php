<?php

namespace App\Models;

use Cartalyst\Sentinel\Roles\EloquentRole;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends EloquentRole
{
    use \Venturecraft\Revisionable\RevisionableTrait;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'roles';
    protected $fillable = ['slug', 'name', 'permissions'];
    protected $dependency = [
        'RoleUser' => ['field' => 'state_id', 'model' => RoleUser::class],
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public function roleuser()
    {
        return $this->hasOne(RoleUser::class, 'role_id')->count();
    }
}
