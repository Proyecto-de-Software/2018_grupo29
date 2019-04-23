<?php

namespace App\Http\Controllers;

use App\Patient;
use App\Gender;
use Illuminate\Http\Request;
use App\Http\Requests\StorePatient;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = Patient::paginate(3);

        return view('patients.index')->with('patients',$patients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePatient $request)
    {
        $patient = new Patient;
        $patient->fill($request->all());
        $patient->save();
        flash('El registro de ' . $patient->first_name . ' ' . $patient->last_name . ' ha sido exitoso')->success();

        return redirect()->route('patients.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        $patient = Patient::find($patient);

        return $patient;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {

        #Aca es donde deje...
        $patient = Patient::find($patient);
        $patient->delete();
        flash('El paciente ' . $patient->first_name . ' ' . $patient->last_name . ' ha sido eliminado')->warning();

        return redirect()->route('patients.index');
    }
}
