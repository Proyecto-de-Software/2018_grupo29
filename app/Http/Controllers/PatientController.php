<?php

namespace App\Http\Controllers;

use App\Patient;
use App\Gender;
use Illuminate\Http\Request;
use App\Http\Requests\StorePatient;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:patients_index', ['only' => ['index']]);
        $this->middleware('permission:patients_show',   ['only' => ['show']]);
        $this->middleware('permission:patients_new',   ['only' => ['create', 'store']]);
        $this->middleware('permission:patients_destroy',   ['only' => ['delete', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $patients = Patient::search($request->first_name, $request->last_name, $request->dni_number)->paginate(3);

        return view('patients.index')->with('patients',$patients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipos_documentos = json_decode(file_get_contents('https://api-referencias.proyecto2018.linti.unlp.edu.ar/tipo-documento'));
        $partidos = json_decode(file_get_contents('https://api-referencias.proyecto2018.linti.unlp.edu.ar/partido'));
        $obras_sociales = json_decode(file_get_contents('https://api-referencias.proyecto2018.linti.unlp.edu.ar/obra-social'));

        return view('patients.create',compact('tipos_documentos', 'partidos', 'obras_sociales'));
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
    public function show($id)
    {
        $patient = Patient::findOrFail($id);

        return view('patients.show')->with('patient',$patient);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $patient = Patient::findOrFail($id);

        return view('patients.edit')->with('patient',$patient);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(StorePatient $request, $id)
    {
        $patient = Patient::findOrFail($id);
        $patient->update($request->all());
        flash('Los datos de ' . $patient->first_name . ' ' . $patient->last_name . ' han sido actualizados exitosamente')->success();

        return redirect()->route('patients.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        flash('El/La paciente ' . $patient->first_name . ' ' . $patient->last_name . ' ha sido eliminado/a')->warning();

        return redirect()->route('patients.index');
    }
}
