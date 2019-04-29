<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PatientAjaxController extends Controller
{
    public function test()
    {
        return "view('consultations.create');";
    }
}
