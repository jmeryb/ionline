<?php

namespace App\Http\Livewire\Authorities;

use Livewire\Component;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Rrhh\OrganizationalUnit;
use App\Rrhh\NewAuthority;
use App\Models\Parameters\Holiday;
use App\Models\Profile\Subrogation;
use Illuminate\Support\Facades\Validator;

class Calendar extends Component
{
    public $organizationalUnit;
    public $subrogations;
    public $date = null;
    public $type = null;
    
    /** atributos de modelo authority */
    public $user_id;
    public $startDate;
    public $endDate;
    public $position;


    /** Input selector de mes */
    public $monthSelection;

    /** Primer día del mes seleccionado */
    public $startOfMonth;

    /** Último día del mes seleccionado */
    public $endOfMonth;

    /** Array con los datos para imprimir el calendario */
    public $data;

    /** Flag para mostrar o no el cuadro de editar */
    public $editForm = false;

    public $today;

    /** Cantidad de cuadros en blanco antes del primer día del mes */
    public $blankDays;

    protected function rules()
    {
        return [
            'user_id' => 'required',
            'position' => 'required',
            'endDate' => 'required|date|after:start_date',
        ];
    }

    protected $messages = [
        'user_id.required' => 'El campo de usuario es requerido',
        'position.required' => 'El campo de cargo es requerido',
        'endDate.required' => 'El campo de fecha final es requerido',
        'endDate.after' => 'La fecha final debe ser posterior a la fecha de inicio',
    ];

    /**
     * Mount
     */
    public function mount(OrganizationalUnit $organizationalUnit)
    {
        $this->monthSelection = date('Y-m');
        $this->today = now()->format('Y-m-d');
    }

    /**
     * Muestra formulario para editar una autoridad en una fecha
     */
    public function edit($date, $type)
    {
        $this->date = $date;
        $this->startDate = $date;
        $this->type = $type;

        $this->subrogations = Subrogation::where('organizational_unit_id', $this->organizationalUnit->id)
            ->where('type',$this->type)
            ->get();

        /** Muestra el formulario de edición */
        $this->editForm = true;
    }

    /**
     * Guarda la edición de una autoridad
     */
    public function save()
    {
        $this->validate();
    
        NewAuthority::where('organizational_unit_id', $this->organizationalUnit->id)
            ->where('type', $this->type)
            ->whereBetween('date', [$this->date, $this->endDate])
            ->update([
                'user_id' => $this->user_id,
            ]);

        /** Agrega un mensaje de éxito */
        session()->flash('info', 'El usuario  ha sido creado.');

        /** Oculta el formulario de edición */
        $this->editForm = false;
    }
    
    

    public function render()
    {
        $this->data = [];
        $this->startOfMonth = Carbon::createFromFormat('Y-m', $this->monthSelection)->startOfMonth();
        $this->endOfMonth = $this->startOfMonth->copy()->endOfMonth();

        $this->blankDays = ($this->startOfMonth->dayOfWeek == 0) ? 7 : $this->startOfMonth->dayOfWeek;

        $holidays = Holiday::whereBetween('date', [$this->startOfMonth, $this->endOfMonth])
            ->get();

        $newAuthorities = NewAuthority::where('organizational_unit_id', $this->organizationalUnit->id)
            ->whereBetween('date', [$this->startOfMonth, $this->endOfMonth])
            ->get();

        foreach (CarbonPeriod::create($this->startOfMonth, '1 day', $this->endOfMonth) as $day) {
            $this->data[$day->format('Y-m-d')] = array(
                'holiday' => false,
                'date' => $day,
                'manager' => false,
                'delegate' => false,
                'secretary' => false,
            );
        }

        foreach ($holidays as $holiday) {
            $this->data[$holiday->date->format('Y-m-d')]['holiday'] = true;
        }

        foreach ($newAuthorities as $authority) {
            $this->data[$authority->date->format('Y-m-d')][$authority->type] = $authority->user;
        }

        return view('livewire.authorities.calendar');
    }
}

