<?php

namespace App\Models\Welfare\AmiPass;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Regularization extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'rut',
        'dv',
        'nombre',
        'lugar_desempenio',
        'fecha',
        'total_real_cargado'
    ];

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $table = 'well_ami_regularizations';
}
