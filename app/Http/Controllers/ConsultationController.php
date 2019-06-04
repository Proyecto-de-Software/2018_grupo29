<?php

namespace App\Http\Controllers;

use App\Consultation;
use App\Patient;
use App\Institution;
use App\Accompaniment;
use App\Reason;
use App\Treatment;
use App\Http\Requests\StoreConsultation;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:consultations_index', ['only' => ['index']]);
        $this->middleware('permission:consultations_show',   ['only' => ['show']]);
        $this->middleware('permission:consultations_new',   ['only' => ['create', 'store']]);
        $this->middleware('permission:consultations_destroy',   ['only' => ['delete', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = Patient::all();

        return view('consultations.index')->with('patients',$patients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $patient_id
     * @return \Illuminate\Http\Response
     */
    public function create($patient_id)
    {
        $patient = Patient::findOrFail($patient_id);
        $institutions = Institution::all();
        return view('consultations.create',compact('institutions','patient'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreConsultation $request)
    {
        $consultation = new Consultation;
        // dd($request);
        $consultation->fill($request->all());
        $consultation->patient_id = $request->patient_id;
        $consultation->save();
        flash('El registro de la consulta ha sido exitoso')->success();

        return redirect()->route('consultations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $consultation = Consultation::findOrFail($id);
        $institution = Institution::findOrFail($consultation->derivation_id); //aca iria con la API
        $patient = Patient::findOrFail($consultation->patient_id);
        $reason = Reason::findOrFail($consultation->reason_id);
        $accompaniment = Accompaniment::find($consultation->accompaniment_id);
        $treatment = Treatment::find($consultation->treatment_id);   
        if(isset($accompaniment)){
            $accompaniment = $accompaniment->name;
        } else {
            $accompaniment = 'No tiene acompañamiento';
        }
        if(isset($treatment)){
            $treatment = $treatment->name;
        } else {
            $treatment = 'No tiene tratamiento';
        }
        // dd($consultation);
        return view('consultations.show',compact('consultation','institution','patient','accompaniment', 'treatment', 'reason'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $consultation = Consultation::findOrFail($id);
        $patient = Patient::findOrFail($consultation->patient_id);
        $institutions = Institution::all();
        return view('consultations.edit', compact('consultation','patient','institutions'))->with('consultation',$consultation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function update(StoreConsultation $request,$id)
    {
        $consultation = Consultation::findOrFail($id);
        $consultation->update($request->all());
        flash('Los datos de la consulta han sido actualizados exitosamente')->success();

        return redirect()->route('consultations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $consultation = Consultation::findOrFail($id);
        $consultation->delete();
        flash('La consulta ha sido eliminada')->warning();

        return redirect()->route('consultations.index');
    }
}
