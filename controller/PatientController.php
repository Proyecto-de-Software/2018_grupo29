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
        if (isset($_SESSION['id'])) { 
            if ( 
                (in_array('paciente_show', $_SESSION['permisos'])) or 
                (in_array('paciente_new', $_SESSION['permisos'])) or 
                (in_array('paciente_update', $_SESSION['permisos'])) or
                (in_array('paciente_index', $_SESSION['permisos'])) or 
                (in_array('paciente_destroy', $_SESSION['permisos']))
                 ){
                ResourceController::getInstance()->mostrarHTMLConParametros('pacientes.html.twig', $_SESSION);
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$_SESSION);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$_SESSION);
        }
    }

    public function obtenerPacientes(){
        //acomodar session
        if (! isset($_POST['fueBusqueda'])) $_POST['fueBusqueda'] = 0;
        if (isset($_SESSION['id'])) {
            if (($_POST['fueBusqueda']) == 0) {
                if (in_array('paciente_index', $_SESSION['permisos'])) {
                    $pacientes = PatientRepository::getInstance()->getPacientes();
                    $answer = ConfigurationRepository::getInstance()->getCantPaginas();
                    $cantElementosPorPagina = $answer[0]['valor'];
                    $cantElementosPorPagina =  intval($cantElementosPorPagina);
                    $_SESSION['cantElementosPorPagina'] = $cantElementosPorPagina;
                    $cantidadPacientes = count($pacientes);
                    $cantPaginas = $cantidadPacientes / $cantElementosPorPagina;
                    $cantPaginas = ceil($cantPaginas);
                    $_SESSION['cantPaginas'] = $cantPaginas;
                    $pacientes = array_chunk($pacientes, $cantElementosPorPagina);
                    if (! isset($_POST['pagina'])) {
                        $actual = 0;
                    }
                    else {
                        $actual = $_POST['pagina'] - 1;
                    }
                    $_SESSION['pacientes'] = $pacientes[$actual];
                    $_SESSION['fueBusqueda'] = 0;
                    if (in_array('paciente_destroy', $_SESSION['permisos'])) $_SESSION['puedeBorrar'] = 1;
                    ResourceController::getInstance()->mostrarHTMLConParametros('listadoPacientes.html.twig', $_SESSION);
                }
                else {
                    ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$_SESSION);
                }
            }
            else{
                $this->buscarPaciente();
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$_SESSION);
        }
    }    

    public function mostrarFormulario(){
        //acomodar session
        if (isset($_SESSION['id'])) {
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
                $_SESSION['historiaClinicaRandom'] = $numero;
                if (isset($_SESSION['noHubo'])){
                    if ($_SESSION['noHubo'] == 1) {
                        $_SESSION['mensaje'] = 'No se ha encontrado ningún paciente con esos datos.';
                        $_SESSION['tipo_mensaje'] = 'text-danger';
                    }
                }
                else
                {
                    $_SESSION['mensaje'] = '';
                }
                ResourceController::getInstance()->mostrarHTMLConParametros('busquedaPaciente.html.twig', $_SESSION);
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$_SESSION);
            }

        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$_SESSION);
        }
    }

    public function buscarPaciente(){
        //acomodar session
        if (isset($_SESSION['id'])) {
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
                $_SESSION['noHubo'] = 1;
                $this->mostrarFormulario();
            }
            else {
                if (isset($_SESSION['noHubo'])) unset($_SESSION['noHubo']);
                $answer = ConfigurationRepository::getInstance()->getCantPaginas();
                $cantElementosPorPagina = $answer[0]['valor'];
                $cantElementosPorPagina =  intval($cantElementosPorPagina);
                $_SESSION['cantElementosPorPagina'] = $cantElementosPorPagina;
                $cantidadPacientes = count($pacientes);
                $cantPaginas = $cantidadPacientes / $cantElementosPorPagina;
                $cantPaginas = ceil($cantPaginas);
                $_SESSION['cantPaginas'] = $cantPaginas;
                $pacientes = array_chunk($pacientes, $cantElementosPorPagina);
                if (! isset($_POST['pagina'])) {
                    $actual = 0;
                }
                else {
                    $actual = $_POST['pagina'] - 1;
                }
                $_SESSION['pacientes'] = $pacientes[$actual];
                $_SESSION['fueBusqueda'] = 1;
                $_SESSION['filtros'] = $_POST;
                ResourceController::getInstance()->mostrarHTMLConParametros('listadoPacientes.html.twig', $_SESSION);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$_SESSION);
        }
    }

    public function crearPacienteNN(){
        //acomodar session
        //acomodar permisos?
        $parametro['nro_historia_clinica'] = $_SESSION['historiaClinicaRandom'];
        PatientRepository::getInstance()->crearPacienteNN($parametro);
        $_SESSION['mensaje'] = 'Se ha creado un NN con historia clínica '.$parametro['nro_historia_clinica'];
        $_SESSION['tipo_mensaje'] = 'text-success';
        $_SESSION['historiaClinicaRandom'] = 0;
        ResourceController::getInstance()->mostrarHTMLConParametros('busquedaPaciente.html.twig', $_SESSION);
    }

    public function crearPaciente() {
        if (isset($_SESSION['id'])) {
            if (in_array('paciente_new', $_SESSION['permisos'])){
                // = $this->obtenerPartidos();
                $_SESSION['listaPartidos'] = APIController::getInstance()->obtenerAPI("https://api-referencias.proyecto2018.linti.unlp.edu.ar/partido");
                ResourceController::getInstance()->mostrarHTMLConParametros('formularioAltaPaciente.html.twig', $_SESSION);
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$_SESSION);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$_SESSION);
        }
    }
    
    public function eliminarPaciente() {
        if (isset($_SESSION['id'])){
            if (in_array('paciente_destroy', $_SESSION['permisos'])){
                PatientRepository::getInstance()->eliminarPaciente($_POST['id_paciente']);
                PatientController::getInstance()->obtenerPacientes();
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$_SESSION);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$_SESSION);
        }
    }

    public function obtenerPartidos() {
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
    }
    public function tieneSoloLetras($string) {
        return  preg_match("/[a-zA-Z]+$/", $string);
    }
    public function tieneSoloNumeros($param) {
        return  preg_match("/[0-9]+$/", $param);
    }
    public function validarFormularioPaciente($datos,&$msj){
        if (! $this->tieneSoloLetras($datos['nombre'])) {
            $msj = "El nombre debe tener solo letras";
            return false;
        }

          if (! $this->tieneSoloLetras($datos["apellido"])) {
            $msj = "El apellido debe tener solo letras";
            return false;
          }

          if (! $this->tieneSoloNumeros($datos['numero'])) {
             $msj = "El número de documento debe tener solo números";
            return false;
          }

          if ($datos['nro_historia_clinica'] != NULL) {
            if ((! $this->tieneSoloNumeros($datos['nro_historia_clinica'])) || (strlen($datos['nro_historia_clinica']) > 6 )){
              $msj = "El número de historia clínica debe tener solo números y máximo 6 dígitos";
              return false;
            }
          }

          if ($datos['nro_carpeta'] != NULL) {
            if ((! $this->tieneSoloNumeros($datos['nro_carpeta'])) || (strlen($datos['nro_carpeta']) > 5)) {
              $msj = "El número de carpeta debe tener solo números y máximo 5 dígitos";
              return false;
            }
          }

          if ($datos['tel'] != NULL) {
            if ((! $this->tieneSoloNumeros($datos['tel'])) || (strlen($datos['tel'])< 8)) {
              $msj = "El número de teléfono debe tener sólo números y al menos 8 dígitos";
              return false;
            }
          }

          return true;
    }

    public function crearPacienteNuevo(){
        if (isset($_SESSION['id']) && ($_POST !== array())){
            if (in_array('paciente_new', $_SESSION['permisos'])){
                if (! isset($_POST['localidades'])) {
                    $_POST['localidades'] = 1;
                }
                $msj = '';
                if ($this->validarFormularioPaciente($_POST,$msj)) {
                    $_POST['localidades'] = intval($_POST['localidades']);
                    $_POST['genero_id'] = intval($_POST['genero_id']);
                    $_POST['tiene_documento'] = intval($_POST['tiene_documento']);
                    $_POST['tipo_documento'] = intval($_POST['tipo_documento']);
                    $_POST['numero'] = intval($_POST['numero']);
                    $_POST['nro_historia_clinica'] = intval($_POST['nro_historia_clinica']);
                    $_POST['nro_carpeta'] = intval($_POST['nro_carpeta']);
                    $_POST['obra_social_id'] = intval($_POST['obra_social_id']);
                    //hacer region sanitaria con api
                    if ($_POST['partidos'] != ''){
                    $_POST['region_sanitaria_id'] = PatientRepository::getInstance()->obtenerRegionSanitaria($_POST["partidos"]);
                    }
                    else {
                        $_POST['region_sanitaria_id'] = 1;
                    }
                    if ($_POST['obra_social_id'] == 0) $_POST['obra_social_id'] = 1;
                    PatientRepository::getInstance()->crearPaciente($_POST);
                    $_SESSION['mensaje'] = 'Se ha creado un nuevo Paciente';
                    $_SESSION['tipo_mensaje'] = 'text-success';
                    ResourceController::getInstance()->mostrarHTMLConParametros('formularioAltaPaciente.html.twig', $_SESSION);
                }
                else {
                    $_SESSION['mensaje'] = $msj;
                    $_SESSION['tipo_mensaje'] = 'text-danger';
                    ResourceController::getInstance()->mostrarHTMLConParametros('formularioAltaPaciente.html.twig', $_SESSION);
                }
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$_SESSION);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$_SESSION);
        }
    }

    public function verDatosPaciente() {
        if (isset($_SESSION['id'])){
            if (in_array('paciente_update', $_SESSION['permisos'])){
                $_SESSION['listaPartidos'] = APIController::getInstance()->obtenerAPI("https://api-referencias.proyecto2018.linti.unlp.edu.ar/partido");
                $_SESSION['datosPaciente'] = PatientRepository::getInstance()->datosPaciente($_POST['id_paciente']);
                ResourceController::getInstance()->mostrarHTMLConParametros('formularioAltaPaciente.html.twig', $_SESSION);
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$_SESSION);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$_SESSION);
        }
    }

    public function editarPaciente(){
        PatientRepository::getInstance()->actualizarPaciente($_POST);
        unset($_SESSION['datosPaciente']);
        PatientController::getInstance()->obtenerPacientes();
    }
}