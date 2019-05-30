<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\ReasonsChart;
use App\User;
use App\Consultation;
use DB;
use App\Reason;
use App\Gender;

class ReportController extends Controller
{
	/*
	
	Punto de partida para el módulo.
	El gráfico por defecto es definido en el archivo 'js/logicaGraficos.js',
	en la función first().
	
	*/
    public function start() {

		return view('reports.index');
    }

    public function byReason() {

    	$consultas = Consultation::join('reasons','consultations.reason_id', '=', 'reasons.id')
    	->select('*',DB::raw('count(*) as total'))
    	->groupBy('consultations.reason_id')
    	->get();

    	$listado = Consultation::join('patients','consultations.patient_id', '=', 'patients.id')
    	->get()
    	->groupBy('reason_id');
 		
    	$collection = collect();
		foreach($listado as $key => $value) {
			$reason = Reason::find($key);
			$collection->put($reason->name, $value);
		}

    	return $this->armadoDeArreglo($consultas,'Gráfico por Motivo', $collection);
    }

    public function byGender() {

    	$consultas = Consultation::join('patients','consultations.patient_id', '=', 'patients.id')
    	->join('genders','patients.gender_id', '=', 'genders.id')
    	->select('*',DB::raw('count(*) as total'))
    	->groupBy('patients.gender_id')
    	->get();

    	$listado = Consultation::join('patients','consultations.patient_id', '=', 'patients.id')
    	->join('genders','patients.gender_id', '=', 'genders.id')
    	->get()
    	->groupBy('gender_id');

    	$collection = collect();
		foreach($listado as $key => $value) {
			$reason = Gender::find($key);
			$collection->put($reason->name, $value);
		}
    	return $this->armadoDeArreglo($consultas,'Gráfico por Género', $collection);
    }

    public function byLocation() {
    	$consultas = Consultation::join('patients','consultations.patient_id', '=', 'patients.id')
    	->select('*',DB::raw('count(*) as total'))
    	->groupBy('patients.location_id')
    	->get();

    	$listado = Consultation::join('patients','consultations.patient_id', '=', 'patients.id')
    	->get()
    	->groupBy('location_id');

    	$data = array();
    	foreach ($consultas as $consulta) {
    		$localidad = json_decode(file_get_contents('https://api-referencias.proyecto2018.linti.unlp.edu.ar/localidad/'.$consulta->location_id));
    		array_push($data, ["name" => $localidad->nombre, "y" => $consulta->total]);
    	}

    	$collection = collect();
		foreach($listado as $key => $value) {
			$localidad = json_decode(file_get_contents('https://api-referencias.proyecto2018.linti.unlp.edu.ar/localidad/'.$key));
			$collection->put($localidad->nombre, $value);
		}

		$data = array('series' => $data, 'titulo' => 'Gráfico por Localidad');		
    	$todo = array('data' => $data, 'consultas' => $consultas, 'listado' => $collection);		

    	return $todo;
    }

    protected function armadoDeArreglo($consultas, $titulo, $listado) {
    	$data = array();
    	foreach ($consultas as $consulta) {
    		array_push($data, ["name" => $consulta->name, "y" => $consulta->total]);
    	}
		$data = array('series' => $data, 'titulo' => $titulo);		
    	$todo = array('data' => $data, 'consultas' => $consultas, 'listado' => $listado);

    	return $todo;
    }
}
