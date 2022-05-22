<?php

namespace App\Models;



use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends MyModel
{
    use \Venturecraft\Revisionable\RevisionableTrait;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'settings';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'title', 'value', 'day', 'deleted'];
    protected $dependency = [
        // 'User_Profile' => array('field' => 'state_id', 'model' => User_Profile::class),
    ];
}
