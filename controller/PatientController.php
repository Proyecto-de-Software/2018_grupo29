<?php

/**
 * Description of PatientnController
 
 */
require_once('controller/ResourceController.php');
require_once('controller/APIController.php');
require_once('model/SessionRepository.php');
require_once('model/PatientRepository.php');
require_once('model/ConfigurationRepository.php');

class PatientController {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }

    public function menuPacientes(){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])) { 
            $parametros["session"] = $_SESSION;
            if ( 
                (in_array('paciente_show', $_SESSION['permisos'])) or 
                (in_array('paciente_new', $_SESSION['permisos'])) or 
                (in_array('paciente_update', $_SESSION['permisos'])) or
                (in_array('paciente_index', $_SESSION['permisos'])) or 
                (in_array('paciente_destroy', $_SESSION['permisos']))
                 ){
                $parametros["session"] = $_SESSION;
                ResourceController::getInstance()->mostrarHTMLConParametros('pacientes.html.twig', $parametros);
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }

    public function obtenerPacientes(){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (! isset($_POST['fueBusqueda'])) $_POST['fueBusqueda'] = 0;
        if (isset($_SESSION['id'])) {
            $parametros["session"] = $_SESSION;
            if (($_POST['fueBusqueda']) == 0) {
                if (in_array('paciente_index', $_SESSION['permisos'])) {
                    $pacientes = PatientRepository::getInstance()->getPacientes();                   
                    ResourceController::getInstance()->setPaginado($parametros,$pacientes);
                    $pacientes = array_chunk($pacientes, $parametros['cantElementosPorPagina']);
                    $parametros['pacientes'] = $pacientes[ResourceController::getInstance()->paginaActual()];
                    $parametros['fueBusqueda'] = 0;
                    ResourceController::getInstance()->mostrarHTMLConParametros('listadoPacientes.html.twig', $parametros);
                }
                else {
                    ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
                }
            }
            else{
                $this->buscarPaciente();
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }    

    public function mostrarFormulario($dato){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])) {
            $parametros["session"] = $_SESSION;
            if (in_array('paciente_index', $_SESSION['permisos'])) {
                $historiasClinicas = PatientRepository::getInstance()->getHistoriasClinicas();
                $i = 0;
                $numerosHistoriasClinicas = array();
                foreach ($historiasClinicas as $historia) {
                    $numerosHistoriasClinicas[$i] = $historia['nro_historia_clinica'];
                    $i++;
                }
                do {
                    $numero = rand(1, 999999);
                } while (in_array($numero, $numerosHistoriasClinicas));
                $parametros['historiaClinicaRandom'] = $numero;
                if ($dato == 1) {
                    $parametros['mensaje'] = 'No se ha encontrado ningún paciente con esos datos.';
                    $parametros['tipo_mensaje'] = 'text-danger';
                } else {
                    $parametros['mensaje'] = '';
                }
                ResourceController::getInstance()->mostrarHTMLConParametros('busquedaPaciente.html.twig', $parametros);
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }

        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }

    public function buscarPaciente(){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])) {
            if(in_array('paciente_index', $_SESSION['permisos'])){
                $parametros["session"] = $_SESSION;
                if ($_POST['nombre'] != NULL) {$parametro['nombre'] = $_POST['nombre'];}
                else {$parametro['nombre'] = '';}
                if ($_POST['apellido'] != NULL) {$parametro['apellido'] = $_POST['apellido'];}
                else {$parametro['apellido'] = '';}
                if ($_POST['nombre_tipo_documento'] != NULL) {$parametro['nombre_tipo_documento'] = $_POST['nombre_tipo_documento'];}
                else {$parametro['nombre_tipo_documento'] = '';}
                if ($_POST['numero_documento'] != NULL) {$parametro['numero_documento'] = $_POST['numero_documento'];}
                else {$parametro['numero_documento'] = '';}
                if ($_POST['nro_historia_clinica'] != NULL) {$parametro['nro_historia_clinica'] = $_POST['nro_historia_clinica'];}
                else {$parametro['nro_historia_clinica'] = '';} 
                $pacientes = PatientRepository::getInstance()->buscarPaciente($parametro);
                if (count($pacientes)==0){
                    $noHubo = 1;
                    $this->mostrarFormulario($noHubo);
                }
                else {
                    ResourceController::getInstance()->setPaginado($parametros,$pacientes);
                    $pacientes = array_chunk($pacientes, $parametros['cantElementosPorPagina']);
                    $parametros['pacientes'] = $pacientes[ResourceController::getInstance()->paginaActual()];
                    $parametros['fueBusqueda'] = 1;
                    $parametros['filtros'] = $_POST;
                    ResourceController::getInstance()->mostrarHTMLConParametros('listadoPacientes.html.twig', $parametros);
                }
            } else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        } else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }

    public function crearPacienteNN($datos){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])) {
            $parametros["session"] = $_SESSION;
            if(in_array('paciente_new', $_SESSION['permisos'])){
                //$parametro['nro_historia_clinica'] = $datos;
                PatientRepository::getInstance()->crearPacienteNN($datos);
                $parametros['mensaje'] = 'Se ha creado un NN con historia clínica '.$datos["historiaClinicaRandom"];
                $parametros['tipo_mensaje'] = 'text-success';
                $parametros['historiaClinicaRandom'] = 0;
                $parametros["session"] = $_SESSION;
                ResourceController::getInstance()->mostrarHTMLConParametros('busquedaPaciente.html.twig', $parametros);
            } else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        } else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }

    public function crearPaciente() {
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])) {
            $parametros["session"] = $_SESSION;
            if (in_array('paciente_new', $_SESSION['permisos'])){
                $parametros['listaPartidos'] = APIController::getInstance()->obtenerAPI("https://api-referencias.proyecto2018.linti.unlp.edu.ar/partido");
                ResourceController::getInstance()->mostrarHTMLConParametros('formularioAltaPaciente.html.twig', $parametros);
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }
    
    public function eliminarPaciente() {
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])){
            $parametros["session"] = $_SESSION;
            if (in_array('paciente_destroy', $_SESSION['permisos'])){
                PatientRepository::getInstance()->eliminarPaciente($_POST['id_paciente']);
                PatientController::getInstance()->obtenerPacientes();
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }

    /*public function obtenerPartidos() {
        //esta me parece que quedo al pedo
        if (isset($_SESSION['id'])){
            return PatientRepository::getInstance()->getPartidos();
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$_SESSION);
        }
    }

    public function obtenerLocalidades() {
        //esta me parece que quedo al pedo
        if (isset($_SESSION['id'])){
            $idLocalidad = $_POST['id_partido'];
            return PatientRepository::getInstance()->getLocalidades($idLocalidad);
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$_SESSION);
        }
    }*/

    public function crearPacienteNuevo(){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id']) && ($_POST !== array())){
            $parametros["session"] = $_SESSION;
            if (in_array('paciente_new', $_SESSION['permisos'])){
    
                //$_POST['localidades'] = intval($_POST['localidades']);
                //$_POST['genero_id'] = intval($_POST['genero_id']);
                //$_POST['tiene_documento'] = intval($_POST['tiene_documento']);
                //$_POST['tipo_documento'] = intval($_POST['tipo_documento']);
                //$_POST['numero'] = intval($_POST['numero']);
                //$_POST['nro_historia_clinica'] = intval($_POST['nro_historia_clinica']);
                //$_POST['nro_carpeta'] = intval($_POST['nro_carpeta']);
                //$_POST['obra_social_id'] = intval($_POST['obra_social_id']);
                //$regionesSanitarias = APIController::getInstance()->obtenerAPI("https://api-referencias.proyecto2018.linti.unlp.edu.ar/region-sanitaria");
                $partidos = APIController::getInstance()->obtenerAPI("https://api-referencias.proyecto2018.linti.unlp.edu.ar/partido");
                $localidades = APIController::getInstance()->obtenerAPI("https://api-referencias.proyecto2018.linti.unlp.edu.ar/localidad");
                $localidadPaciente = array_values(array_filter($localidades, function ($var) {
                    return ($var['partido_id'] == $_POST['localidades']);}));
                $idPartido = $localidadPaciente[0]["partido_id"];
                $partidoPaciente = array_values(array_filter($partidos, function ($var) use ($idPartido) {
                    return ($var['id'] == $idPartido);}));
                $_POST['region_sanitaria_id'] = $partidoPaciente[0]["region_sanitaria_id"];
                PatientRepository::getInstance()->crearPaciente($_POST);
                PatientController::getInstance()->obtenerPacientes();   
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }

    public function verDatosPaciente() {
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])){
            $parametros["session"] = $_SESSION;
            if (in_array('paciente_update', $_SESSION['permisos'])){
                $parametros['listaPartidos'] = APIController::getInstance()->obtenerAPI("https://api-referencias.proyecto2018.linti.unlp.edu.ar/partido");
                $parametros['datosPaciente'] = PatientRepository::getInstance()->datosPaciente($_POST['id_paciente']);
                $parametros["session"] = $_SESSION;
                ResourceController::getInstance()->mostrarHTMLConParametros('formularioAltaPaciente.html.twig', $parametros);
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }

    public function editarPaciente(){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])){
            $parametros["session"] = $_SESSION;
            if (in_array('paciente_update', $_SESSION['permisos'])){
                PatientRepository::getInstance()->actualizarPaciente($_POST);
                PatientController::getInstance()->obtenerPacientes();
            } else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        } else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);   
        }
    }
}