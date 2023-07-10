<?php

namespace App\Models\Welfare\AmiPass;


use Illuminate\Database\Eloquent\Model;

class BeneficiaryRequest extends Model
{

    protected $table = 'well_ami_beneficiary_requests';

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = [
        'fecha_inicio_contrato',
        'fecha_nacimiento',
    ];

    protected $fillable = [
        'nombre_jefatura',
        'cargo_unidad_departamento',
        'correo_jefatura',
        'motivo_requerimiento',
        'nombre_funcionario_reemplazar',
        'nombre_completo',
        'rut_funcionario',
        'donde_cumplira_funciones',
        'correo_personal',
        'celular',
        'fecha_inicio_contrato',
        'fecha_termino_contrato',
        'jornada_laboral',
        'residencia',
        'ha_utilizado_amipass',
        'fecha_nacimiento',
        'establecimiento',
        'estado',
        'ami_manager_id',
        'ami_manager_at',
    ];

    public function scopeSearch($query, $filter)
    {

        return $query->where('nombre_jefatura', 'LIKE', '%'.$filter.'%')
                ->orWhere('rut_funcionario', 'LIKE', '%'.$filter.'%')
                ->orWhere('nombre_completo', 'LIKE', '%'.$filter.'%');

    }
    
}
