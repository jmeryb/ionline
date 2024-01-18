<?php

namespace App\Http\Livewire\ProfAgenda;

use Livewire\Component;

use App\Models\ProfAgenda\OpenHour;
use App\User;
use App\Models\Parameters\Holiday;

class BookingAgenda extends Component
{
    public $profession_id;
    public $profesional_id;
    public $user_id;

    public $events = '';
    // public $proposals;

    public function render()
    {
        $array = array();
        $count = 0;

        $openHours = OpenHour::where('profesional_id',$this->profesional_id)
                            ->where('profession_id',$this->profession_id)
                            ->with('patient','activityType')
                            // ->where('id',2947)
                            ->get();

        $min_date=$openHours->min('start_date');
        $max_date=$openHours->max('end_date');
        $holidays = Holiday::whereBetween('date', [$min_date, $max_date])->get();

        foreach($openHours as $hour){
            $array[$count]['id'] = $hour->id;
            $array[$count]['observation'] = $hour->observation;
            $array[$count]['rut'] = $hour->patient_id;
            $array[$count]['contact_number'] = $hour->contact_number;
            $array[$count]['start'] = $hour->start_date;
            $array[$count]['end'] = $hour->end_date;
            
            // reservado
            if($hour->patient_id){
                // hora reservada
                if($hour->patient_id == auth()->user()->id){
                    $array[$count]['rut'] = $hour->patient_id;
                    $array[$count]['color'] = "#C4F7BF"; // verde
                    $array[$count]['title'] = $hour->patient->shortName;
                    $array[$count]['textColor'] = "black";
                    $array[$count]['status'] = "Reservado";
                }else{
                    $array[$count]['rut'] = 0;
                    $array[$count]['color'] = "#85C1E9"; // celeste
                    $array[$count]['title'] = "No disponible";
                }
                
            }
            // sin reserva
            else{
                $array[$count]['color'] = "#CACACA"; //plomo
                $array[$count]['title'] = $hour->activityType->name;
                $array[$count]['status'] = "Disponible";
            }
            // bloqueado
            if($hour->blocked){
                $array[$count]['rut'] = 0;
                $array[$count]['color'] = "#85C1E9"; // celeste
                $array[$count]['title'] = "No disponible";
                $array[$count]['status'] = "No disponible";
            }
            $count += 1;
        }

        foreach($holidays as $holiday){
            $array[$count]['id'] = 0;
            $array[$count]['observation'] = null;
            $array[$count]['rut'] = null;
            $array[$count]['contact_number'] = null;
            $array[$count]['start'] = $holiday->date->format('Y-m-d') . " 00:00";
            $array[$count]['end'] = $holiday->date->format('Y-m-d') . " 23:59";
            $array[$count]['color'] = '#444444'; //amarillo
            $array[$count]['title'] = "Feriado: " . $holiday->name;
            $array[$count]['status'] = "Feriado: " . $holiday->name;
            $array[$count]['deleted_bloqued_observation'] = null;
        }

        // dd($array);

        $this->events = json_encode($array);
        // dd($this->events);

        return view('livewire.prof-agenda.booking-agenda');
    }
}