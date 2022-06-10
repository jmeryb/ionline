<?php

namespace App\Http\Livewire\Parameters\Program;

use App\Models\Parameters\Program;
use App\Models\Parameters\Subtitle;
use Livewire\Component;

class ProgramCreate extends Component
{
    public $name;
    public $alias;
    public $alias_finance;
    public $financial_type;
    public $folio;
    public $subtitle_id;
    public $amount;
    public $period;
    public $start_date;
    public $end_date;
    public $description;

    public $subtitles;

    public function render()
    {
        return view('livewire.parameters.program.program-create');
    }

    public function mount()
    {
        $this->subtitles = Subtitle::pluck('name','id');
    }

    public function rules()
    {
        return [
            'name'          => 'required|string|min:2|max:255',
            'alias'         => 'required|string|min:2|max:50',
            'alias_finance' => 'nullable|string|min:2|max:150',
            'financial_type'=> 'nullable|string|min:2|max:50',
            'folio'         => 'nullable|integer|min:2|max:9999',
            'subtitle_id'   => 'required|exists:cfg_subtitles,id',
            'amount'        => 'nullable|integer|min:1|max:9999999999',
            'period'        => 'required|integer|min:2000|max:2100',
            'start_date'    => 'nullable|date_format:Y-m-d',
            'end_date'      => 'nullable|date_format:Y-m-d',
            'description'   => 'nullable|string|min:2|max:255',
        ];
    }

    public function createProgram()
    {
        $dataValidated = $this->validate();
        Program::create($dataValidated);

        session()->flash('success', 'El programa fue creado exitosamente.');
        return redirect()->route('parameters.programs.index');
    }
}