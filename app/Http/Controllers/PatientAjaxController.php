<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use App\Consultation;

class PatientAjaxController extends Controller
{
    public function patientConsultations(Request $request)
    {
        $consultations = Consultation::search($request->id);
        var_dump($consultations);
    }
}
