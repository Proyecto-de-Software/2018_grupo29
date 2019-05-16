<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use App\Consultation;

class PatientAjaxController extends Controller
{
    /**
     * Display the consultations of the patient.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function patientConsultations(Request $request)
    {
        return (new Consultation)->consultationsOfPatient($request->id);
    }

    public function getLocalidades($id) {
        $localidades = json_decode(file_get_contents('https://api-referencias.proyecto2018.linti.unlp.edu.ar/localidad/partido/'.$id));

        return $localidades;
    }
}
