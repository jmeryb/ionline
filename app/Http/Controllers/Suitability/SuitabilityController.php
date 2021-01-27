<?php

namespace App\Http\Controllers\Suitability;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Suitability\PsiRequest;
use Illuminate\Support\Facades\Auth;

class SuitabilityController extends Controller
{
    //

    public function index(Request $request)
    {
        //return view('replacement_staff.index', compact('request'));
    }

    public function indexOwn()
    {

        $psirequests = PsiRequest::where('user_creator_id',Auth::id())->get();
        return view('suitability.indexown', compact('psirequests'));

    }


    public function validateRequest()
    {
        return view('suitability.validaterequest');
    }

    public function validateRun(Request $request)
    {
        $user = User::find($request->run);
        if(!$user)
        {
            return redirect()->route('suitability.create',$request->run);
            
            
        }
        else
        {
            dd("Si existe");
        }
    }
    


    public function create($run)
    {
        
        return view('suitability.create',compact('run'));
        
    }

    public function store(Request $request)
    {
        $user = new User($request->All());
        $user->email_personal = $request->email;
        $user->external = 1;
        $user->save();
        $psirequest = new PsiRequest();
        $psirequest->start_date = $request->input('start_date');
        $psirequest->disability = $request->input('disability');        
        $psirequest->status = "Esperando Firma de Director SSI";
        $psirequest->user_id = $request->input('id');
        $psirequest->user_creator_id = Auth::id();
        $psirequest->save();



        session()->flash('success', 'Solicitud Creada Exitosamente');

        return redirect()->route('suitability.own');


    }


}
