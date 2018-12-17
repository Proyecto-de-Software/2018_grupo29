<?php
require_once('controller/ResourceController.php');
require_once('controller/APIController.php');
require_once('model/PatientRepository.php');
require_once('model/ReportesRepository.php');

class ReportesController {

	private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }

    public function mostrarReportes() {
    	$parametros = ResourceController::getInstance()->getConfiguration();
    	if (isset($_SESSION['id'])) {
    		$parametros["session"] = $_SESSION;
    		ResourceController::getInstance()->mostrarHTMLConParametros('reportes.html.twig',$parametros);
    	}
    	else {
    		ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
    	}
    }

    public function cantidadConsultas(){
        $totalConsultas = PatientRepository::getInstance()->cantConsultas();
        $totalConsultas = ($totalConsultas[0]['cantidad']);
        return $totalConsultas;
    }

    public function mostrarPorMotivo(){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])) {
            $parametros["session"] = $_SESSION;
            $motivos = PatientRepository::getInstance()->getMotivos();   
            foreach ($motivos as $motivo) {
                $aux[$motivo[0]] = ReportesRepository::getInstance()->getConsultasPorMotivo($motivo[0]);
                $cantConsultas[$motivo[0]] = count($aux[$motivo[0]]);
            }
            $parametros['todo'] = $aux;
            
            $totalConsultas = $this->cantidadConsultas();
            $series = array
              (
              array("name" => 'Receta Medica', "y" => ($cantConsultas[1]*100)/$totalConsultas),
              array("name" => 'Control por Guardia', "y" => ($cantConsultas[2]*100)/$totalConsultas),
              array("name" => 'Consulta', "y" => ($cantConsultas[3]*100)/$totalConsultas),
              array("name" => 'Intento de Suicidio', "y" => ($cantConsultas[4]*100)/$totalConsultas),
              array("name" => 'Interconsulta', "y" => ($cantConsultas[5]*100)/$totalConsultas),
              array("name" => 'Otras', "y" => ($cantConsultas[6]*100)/$totalConsultas)
              );
            $parametros['titulo'] = 'Consultas agrupadas por motivo';
            $arr = array('series' => $series, 'titulo' => 'Gráfico por motivo');
            $parametros['data'] = json_encode($arr);
            ResourceController::getInstance()->mostrarHTMLConParametros('mostrarReporte2.html.twig',$parametros);
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }

    public function mostrarPorGenero(){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])) {
            $parametros["session"] = $_SESSION;
            $generos = PatientRepository::getInstance()->getGeneros();   
            foreach ($generos as $genero) {
                $aux[$genero[0]] = ReportesRepository::getInstance()->getConsultasPorGenero($genero[0]);
                $cantConsultas[$genero[0]] = count($aux[$genero[0]]);
            }
            $parametros['todo'] = $aux;
            
            $totalConsultas = $this->cantidadConsultas();
            $series = array
              (
              array("name" => 'Masculino', "y" => ($cantConsultas[1]*100)/$totalConsultas),
              array("name" => 'Femenino', "y" => ($cantConsultas[2]*100)/$totalConsultas),
              array("name" => 'Otro', "y" => ($cantConsultas[3]*100)/$totalConsultas)
              );

            $parametros['titulo'] = 'Consultas agrupadas por género';
            $arr = array('series' => $series, 'titulo' => 'Gráfico por género');
            $parametros['data'] = json_encode($arr);
            ResourceController::getInstance()->mostrarHTMLConParametros('mostrarReporte2.html.twig',$parametros);
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }

    public function mostrarPorLocalidad(){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])) {
            $parametros["session"] = $_SESSION;
            $localidades = APIController::getInstance()->obtenerAPI("https://api-referencias.proyecto2018.linti.unlp.edu.ar/localidad");
            foreach ($localidades as $localidad) {
                $aux[$localidad['id']] = ReportesRepository::getInstance()->getConsultasPorLocalidad($localidad['id']);
                $cantConsultas[$localidad['id']] = count($aux[$localidad['id']]);
                if ($cantConsultas[$localidad['id']] != 0) {
                    $aux[$localidad['id']][0]['forma'] = $localidad['nombre'];
                }
            }
            $parametros['todo'] = $aux;
            $totalConsultas = $this->cantidadConsultas();
            
            $series = array();

            foreach ($localidades as $loc) {
                array_push($series, array("name" => $loc['nombre'], "y" => ($cantConsultas[$loc['id']]*100)/$totalConsultas));
            }

            $parametros['titulo'] = 'Consultas agrupadas por localidad';
            $arr = array('series' => $series, 'titulo' => 'Gráfico por localidad');
            $parametros['data'] = json_encode($arr);
            ResourceController::getInstance()->mostrarHTMLConParametros('mostrarReporte2.html.twig',$parametros);
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }
}