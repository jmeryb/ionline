<?php

namespace App\Http\Livewire\Warehouse\Control;

use App\Models\Parameters\Program;
use App\Models\Warehouse\Control;
use App\Models\Warehouse\Store;
use App\Models\Warehouse\TypeDispatch;
use App\Models\Warehouse\TypeReception;
use Livewire\Component;

class ControlCreate extends Component
{
    public $store;
    public $type;
    public $type_reception_id;
    public $date;
    public $note;
    public $program_id;
    public $origin_id;
    public $destination_id;
    public $type_dispatch_id;
    public $store_origin_id;
    public $store_destination_id;
    public $organizational_unit_id;
    public $technical_signer_id;
    public $stores;
    public $programs;
    public $typeDispatches;
    public $typeReceptions;
    public $nav;

    protected $listeners = [
        'organizationalId',
        'technicalSignerId',
    ];

    public $rulesReceiving = [
        'date'              => 'required|date_format:Y-m-d',
        'note'              => 'nullable|string|min:2|max:255',
        'program_id'        => 'nullable|exists:cfg_programs,id',
        'origin_id'         => 'required|integer|exists:wre_origins,id',
        'type_reception_id' => 'required|integer|exists:wre_type_receptions,id',
        'technical_signer_id' => 'required|integer|exists:users,id',
    ];

    public $rulesDispatch = [
        'date'                  => 'required|date_format:Y-m-d',
        'note'                  => 'nullable|string|min:2|max:255',
        'type_dispatch_id'      => 'required|exists:wre_type_dispatches,id',
        'program_id'            => 'nullable|exists:cfg_programs,id',
        'destination_id'        => 'nullable|required_if:type_dispatch_id,4|exists:wre_destinations,id',
        'store_destination_id'  => 'nullable|required_if:type_dispatch_id,3|exists:wre_type_receptions,id',
        'organizational_unit_id' => 'nullable|required_if:type_dispatch_id,1|exists:organizational_units,id',
    ];

    public function mount()
    {
        $this->destination_id = null;
        $this->store_destination_id = null;
        $this->type_dispatch_id = 1;
        $this->typeDispatches = TypeDispatch::orderByRaw("FIELD(id, '1', '4', '2', '3') ASC")->get();
        $this->typeReceptions = TypeReception::all();
        $this->stores = Store::whereNotIn('id', [$this->store->id])->get();
        $this->programs = $this->getPrograms();
    }

    public function render()
    {
        return view('livewire.warehouse.control.control-create');
    }

    public function createControl()
    {
        $rules = ($this->type == 'receiving') ? $this->rulesReceiving : $this->rulesDispatch;

        $dataValidated = $this->validate($rules);
        $dataValidated['status'] = true;
        $dataValidated['confirm'] = $this->getConfirm();
        $dataValidated['type'] = ($this->type == 'receiving') ? 1 : 0;
        $dataValidated['store_id'] = $this->store->id;
        $dataValidated['program_id'] = ($dataValidated['program_id'] != '') ? $dataValidated['program_id'] : null;
        $dataValidated['type_reception_id'] = ($this->type == 'receiving') ? $dataValidated['type_reception_id'] : null;
        $dataValidated['reception_visator_id'] = auth()->id();
        $dataValidated['completed_invoices'] = false;

        $control = Control::create($dataValidated);

        session()->flash('success', "Se ha guardado el encabezado del $control->type_format.");

        return redirect()->route('warehouse.control.add-product', [
            'store' => $this->store,
            'control' => $control,
            'type' => $control->isReceiving() ? 'receiving' : 'dispatch',
            'nav' => $this->nav,
        ]);
    }

    public function getPrograms()
    {
        $programs = Program::query()
            ->orderByDesc('period')
            ->orderBy('name')
            ->onlyValid()
            ->get(['id', 'name', 'period']);

        return $programs;
    }

    public function getConfirm()
    {
        if ($this->type == 'receiving')
            $confirm = true;
        else {
            if ($this->type_dispatch_id == TypeDispatch::sendToStore())
                $confirm = false;
            else
                $confirm = true;
        }
        return $confirm;
    }

    public function updatedTypeDispatchId()
    {
        $this->reset([
            'date',
            'note',
            'destination_id',
            'store_destination_id',
            'program_id',
            'organizational_unit_id',
        ]);
    }

    public function organizationalId($value)
    {
        $this->organizational_unit_id = $value;
    }

    public function technicalSignerId($value)
    {
        $this->technical_signer_id = $value;
    }
}
