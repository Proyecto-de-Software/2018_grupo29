<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\ReasonsChart;
use App\User;

class ReportController extends Controller
{

    public function index() {

    	$chart = new ReasonsChart;
    	$chart->dataset('Cantidad', 'pie', [10, 20, 3, 4]);
    	$chart->labels(['Intento de suicidio', 'Consulta', 'Internación', 'Otro']);
    	$chart->title('Reportes 2019 - Motivo de consulta');

		return view('reports.index', compact('chart'));
    }
}
