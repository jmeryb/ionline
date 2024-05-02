<?php

namespace App\Http\Controllers\Trainings;

use App\Http\Controllers\Controller;
use App\Models\Trainings\Training;
use Illuminate\Http\Request;
use App\Models\Documents\Approval;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view('trainings.index');
    }

    public function own_index()
    {
        return view('trainings.own_index');
    }

    public function all_index()
    {
        return view('trainings.all_index');
    }

    // EXTERNAL INDEX
    public function external_own_index()
    {
        return view('trainings.external_own_index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('trainings.create');
    }

    // EXTERNAL INDEX
    public function external_create()
    {
        return view('trainings.external_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Trainings\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function show(Training $training)
    {
        return view('trainings.show', compact('training'));
    }

    public function external_show(Training $training)
    {
        return view('trainings.external_show', compact('training'));
    }

    public function show_approval($training_id){
        $training = Training::find($training_id);

        return view('trainings.show_approval', compact('training'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Trainings\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function edit(Training $training)
    {
        if($training->user_creator_id == auth()->id())
            return view('trainings.edit', compact('training'));
        else
            return view('trainings.own_index');
    }

    // Edicion en plataforma externa
    public function external_edit(Training $training)
    {
        return view('trainings.external_edit', compact('training'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Trainings\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Training $training)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Trainings\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function destroy(Training $training)
    {
        //
    }

    public function approvalCallback($approval_id, $training_id, $process){
        $approval = Approval::find($approval_id);
        $training = Training::find($training_id);
        
        // APRUEBA
        if($approval->status == 1){
            if($process == 'end'){
                $training->status = 'complete';
                $training->save();
            }
        }   

        // RECHAZA
        if($approval->status == 0){
            $training->status = 'rejected';
            $training->save();
        }
    }
}
