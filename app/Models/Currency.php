<?php

namespace App\Models;



use Sentinel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends MyModel
{
    use SoftDeletes;

    /**
     * [$dates softdelete]
     * @var array
     */
    protected $dates = ['deleted_at'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'currencies';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'sign', 'status','created_by', 'updated_by'];

    protected $dependency = [
        //'State' => array('field' => 'country_id', 'model' => State::class),
    ];

    public function deleteValidate($id)
    {
        return false;
    }
}
