<?php

namespace App\Models\Drugs;

use Illuminate\Database\Eloquent\Model;

class PoliceUnit extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'status',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'drg_police_units';

    public function Receptions()
    {
        return $this->hasMany(Reception::class);
    }
}
