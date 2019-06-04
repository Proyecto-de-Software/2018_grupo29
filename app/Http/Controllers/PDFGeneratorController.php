<?php

namespace App\Http\Controllers;
use App;
use App\Charts\ReasonsChart;
use Illuminate\Http\Request;

class PDFGeneratorController extends Controller
{
    public function invoice() 
    {
        $pdf = App::make('dompdf.wrapper');

        $chart = new ReasonsChart;
    	$chart->dataset('Cantidad', 'pie', [10, 20, 3, 4]);
    	$chart->labels(['Intento de suicidio', 'Consulta', 'Internación', 'Otro']);
    	$chart->title('Reportes 2019 - Motivo de consulta');
    	$chart->plotOptions()->series()->animation(false);

		$pdf->loadView('pdf.invoice', compact('chart'));
		return $pdf->stream();
    }
}
