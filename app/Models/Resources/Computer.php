<?php

namespace App\Models\Resources;

use App\Models\Inv\Inventory;
use App\Models\Inv\InventoryLabel;
use App\Models\Parameters\Place;
use App\Models\Resources\ComputerLabel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Computer extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'res_computers';

    protected $fillable = [
        'id',
        'type',
        'brand',
        'model',
        'serial',
        'hostname',
        'domain',
        'ip',
        'mac_address',
        'ip_group',
        'rack',
        'vlan',
        'network_segment',
        'operating_system',
        'processor',
        'ram',
        'hard_disk',
        'inventory_number',
        'active_type',
        'intesis_id',
        'comment',
        'status',
        'office_serial',
        'windows_serial',
        'fusion_at',
        'place_id',
        'inventory_id',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function users()
    {
        return $this->belongsToMany('\App\Models\User', 'res_computer_user')->withTimestamps();
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function labels()
    {
        return $this->belongsToMany(InventoryLabel::class, 'res_computer_label', 'computer_id', 'label_id')
            ->using(ComputerLabel::class)
            ->withPivot(['computer_id', 'label_id'])
            ->withTimestamps();
    }

    public function isMerged()
    {
        return $this->fusion_at != null;
    }

    public function scopeSearch($query, $search)
    {
        if ($search != "")
        {
            return $query->where('brand', 'LIKE', '%' . $search . '%')
                ->orWhere('model', 'LIKE', '%' . $search . '%')
                ->orWhere('ip', 'LIKE', '%' . $search . '%')
                ->orWhere('serial', 'LIKE', '%' . $search . '%')
                ->orWhere('inventory_number', 'LIKE', '%' . $search . '%');
        }
    }

    public function tipo()
    {
        switch ($this->type)
        {
            case 'desktop':
                $valor = 'PC Escritorio';
                break;
            case 'all-in-one':
                $valor = 'PC all-in-one';
                break;
            case 'notebook':
                $valor = 'PC Notebook';
                break;
            case 'other':
                $valor = 'PC Otro';
                break;
            default:
                $valor = '';
                break;
        }
        return $valor;
    }

    public function tipoActivo()
    {
        switch ($this->active_type)
        {
            case 'leased':
                $valor = 'Arrendado';
                break;
            case 'own':
                $valor = 'Propio';
                break;
            case 'user':
                $valor = 'Usuario';
                break;
            default:
                $valor = '';
                break;
        }
        return $valor;
    }
}
