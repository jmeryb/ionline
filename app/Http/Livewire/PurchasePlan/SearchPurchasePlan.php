<?php

namespace App\Http\Livewire\PurchasePlan;

use App\Models\Parameters\Parameter;
use Livewire\Component;
use App\Models\PurchasePlan\PurchasePlan;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class SearchPurchasePlan extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $index;

    public function delete(PurchasePlan $purchasePlan)
    {
        $purchasePlan->delete();
    }

    public function render()
    {
        // $result = PurchasePlan::latest()
        //             ->where('user_creator_id', Auth::user()->id)
        //             ->orWhere('user_responsible_id', Auth::user()->id)
        //             ->orWhere('organizational_unit_id', Auth::user()->organizationalUnit->id)
        //             ->when(Auth::user()->organizationalUnit->id == Parameter::get('ou', 'SaludMentalSSI'),
        //                 fn($q) => $q->orwhereHas('organizationalUnit', 
        //                     fn($q2) => $q2->whereIn('establishment_id', explode(',', Parameter::get('establishment', 'EstablecimientosDispositivos')))))
        //             /*
        //             ->search($this->selectedStatus,
        //                 $this->selectedId,
        //                 $this->selectedUserAllowance)
        //             */
        //             ->toSql();
        // dd($result);
        if($this->index == 'own'){
            //PLANES DE COMPRAS: OWN INDEX 
            return view('livewire.purchase-plan.search-purchase-plan', [
                'purchasePlans' => PurchasePlan::with('organizationalUnit.establishment', 'approvals.sentToOu', 'userResponsible', 'userCreator')->latest()
                    ->where('user_creator_id', Auth::user()->id)
                    ->orWhere('user_responsible_id', Auth::user()->id)
                    ->orWhere('organizational_unit_id', Auth::user()->organizationalUnit->id)
                    ->when(Auth::user()->organizationalUnit->id == Parameter::get('ou', 'SaludMentalSSI'),
                        fn($q) => $q->orwhereHas('organizationalUnit', 
                            fn($q2) => $q2->whereIn('establishment_id', explode(',', Parameter::get('establishment', 'EstablecimientosDispositivos')))))
                    /*
                    ->search($this->selectedStatus,
                        $this->selectedId,
                        $this->selectedUserAllowance)
                    */
                    ->paginate(50)
                ]
            );
        }

        if($this->index == 'all'){
            //PLANES DE COMPRAS: ALL INDEX 
            return view('livewire.purchase-plan.search-purchase-plan', [
                'purchasePlans' => PurchasePlan::with('organizationalUnit.establishment', 'approvals.sentToOu', 'userResponsible', 'userCreator')->latest()
                    /*
                    ->where('user_allowance_id', Auth::user()->id)
                    ->orWhere('creator_user_id', Auth::user()->id)
                    ->orWhere('organizational_unit_allowance_id', Auth::user()->organizationalUnit->id)
                    ->search($this->selectedStatus,
                        $this->selectedId,
                        $this->selectedUserAllowance)
                    */
                    ->paginate(50)
                ]
            );
        }
    }
}
