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
                    $this->agregarDatosApi($pacientes);                    
                    ResourceController::getInstance()->setPaginado($parametros,$pacientes);
                    $listaPacientes = array_chunk($pacientes, $parametros['cantElementosPorPagina']);
                    $parametros['pacientes'] = $listaPacientes[ResourceController::getInstance()->paginaActual()];
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

    public function agregarDatosApi(&$vector){
        foreach ($vector as $id => $paciente) {
            $vector[$id]["nombre_tipo_documento"] = json_decode(file_get_contents("https://api-referencias.proyecto2018.linti.unlp.edu.ar/tipo-documento/".$paciente["tipo_doc_id"]))->nombre;
            $vector[$id]["nombre_obra_social"] = json_decode(file_get_contents("https://api-referencias.proyecto2018.linti.unlp.edu.ar/obra-social/".$paciente["obra_social_id"]))->nombre;
            $vector[$id]["nombre_region_sanitaria"] = json_decode(file_get_contents("https://api-referencias.proyecto2018.linti.unlp.edu.ar/region-sanitaria/".$paciente["region_sanitaria_id"]))->nombre;
            $vector[$id]["nombre_localidad"] = json_decode(file_get_contents("https://api-referencias.proyecto2018.linti.unlp.edu.ar/localidad/".$paciente["localidad_id"]))->nombre;
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
                $parametros["listaTipoDocumento"] = APIController::getInstance()->obtenerAPI("https://api-referencias.proyecto2018.linti.unlp.edu.ar/tipo-documento");
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
                    $this->agregarDatosApi($pacientes);                    
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
                $this->datosAPI($parametros);
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
<<<<<<< HEAD
    }*/
    
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
        if(!$this->existeLaHistoriaClinica()){
            $msj = 'El número de historia clinica ya existe';
            return false;
        }     
        if(!$this->existeLaCarpeta()){
            $msj = 'El número de carpeta ya existe';
            return false;
        }   
        return true;
    }

    public function existeLaHistoriaClinica(){
        if ($_POST['nro_historia_clinica'] !== "") {
            if (count(PatientRepository::getInstance()->unicidadNroHistoriaClinica($_POST['nro_historia_clinica'],$_POST["id_paciente"])) != 0){
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    public function existeLaCarpeta(){
        if ($_POST['nro_carpeta'] !== "") {
            if (count(PatientRepository::getInstance()->unicidadNroCarpeta($_POST['nro_carpeta'],$_POST["id_paciente"])) != 0){
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }

        /*$parametros = ResourceController::getInstance()->getConfiguration();
        if ($_POST['nro_carpeta'] != 0) {
            $nc = PatientRepository::getInstance()->unicidadNroCarpeta($_POST['nro_carpeta']);
            if (count($nc) != 0){
                $parametros["session"] = $_SESSION;
                $parametros['mensaje'] = 'El número de carpeta ya existe';
                $parametros['tipo_mensaje'] = 'text-danger';
                ResourceController::getInstance()->mostrarHTMLConParametros('formularioAltaPaciente.html.twig', $parametros);
                exit();
            }
        }
        else {
            $_POST['nro_carpeta'] = '';
        }*/
    }

    public function crearPacienteNuevo(){
        //cambios de api no aplicados
        
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id']) && ($_POST !== array())){
            $parametros["session"] = $_SESSION;
            if (in_array('paciente_new', $_SESSION['permisos'])){
                $msj = '';
                if ($this->validarFormularioPaciente($_POST,$msj)) {
                    if (isset($_POST['localidades'])) {
                        $partidos = APIController::getInstance()->obtenerAPI("https://api-referencias.proyecto2018.linti.unlp.edu.ar/partido");
                        $localidades = APIController::getInstance()->obtenerAPI("https://api-referencias.proyecto2018.linti.unlp.edu.ar/localidad");
                        $localidadPaciente = array_values(array_filter($localidades, function ($var) {
                            return ($var['partido_id'] == $_POST['localidades']);}));
                        $idPartido = $localidadPaciente[0]["partido_id"];
                        $partidoPaciente = array_values(array_filter($partidos, function ($var) use ($idPartido) {
                            return ($var['id'] == $idPartido);}));
                        $_POST['region_sanitaria_id'] = $partidoPaciente[0]["region_sanitaria_id"];
                    }
                    else {
                        $_POST['localidades'] = '1';
                        $_POST['region_sanitaria_id'] = '1';
                    }
                    if ($_POST['nro_carpeta'] == "") $_POST['nro_carpeta'] = 0;
                    if ($_POST['nro_historia_clinica'] == "") $_POST['nro_historia_clinica'] = 0;
                    if ($_POST['obra_social_id'] == 0) $_POST['obra_social_id'] = 1;
                    $answer = PatientRepository::getInstance()->crearPaciente($_POST);
                    $parametros['id_paciente'] = $answer;
                    $parametros['nombre_paciente'] = $_POST['nombre'];
                    $parametros['apellido_paciente'] = $_POST['apellido'];
                    $this->mostrarFormularioConsulta($parametros);
                }
                else {
                    $parametros['mensaje'] = $msj;
                    $parametros['tipo_mensaje'] = 'text-danger';
                    $this->datosAPI($parametros);
                    ResourceController::getInstance()->mostrarHTMLConParametros('formularioAltaPaciente.html.twig', $parametros);
                }
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
                $parametros['datosPaciente'] = PatientRepository::getInstance()->datosPaciente($_POST['id_paciente']);
                $this->datosAPI($parametros);
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
                if (! isset($_POST['localidades'])) $_POST['localidades'] = 1;
                if ($_POST['obra_social_id'] == "") $_POST['obra_social_id'] = 1;
                $msj = '';
                if ($this->validarFormularioPaciente($_POST,$msj)) {
                    if ($_POST['nro_carpeta'] == "") $_POST['nro_carpeta'] = 0;
                    if ($_POST['nro_historia_clinica'] == "") $_POST['nro_historia_clinica'] = 0;
                    PatientRepository::getInstance()->actualizarPaciente($_POST);
                    PatientController::getInstance()->obtenerPacientes();
                }
                else {
                    $parametros['mensaje'] = $msj;
                    $parametros['tipo_mensaje'] = 'text-danger';
                    $this->datosAPI($parametros);
                    $parametros['datosPaciente'] = PatientRepository::getInstance()->datosPaciente($_POST['id_paciente']);
                    $parametros["session"] = $_SESSION;
                    ResourceController::getInstance()->mostrarHTMLConParametros('formularioAltaPaciente.html.twig', $parametros);
                }
            } else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        } else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);   
        }
    }

    public function datosAPI(&$vector){
        $vector['listaPartidos'] = APIController::getInstance()->obtenerAPI("https://api-referencias.proyecto2018.linti.unlp.edu.ar/partido");
        $vector['listaObraSocial'] = APIController::getInstance()->obtenerAPI("https://api-referencias.proyecto2018.linti.unlp.edu.ar/obra-social");
        $vector['listaTipoDocumento'] = APIController::getInstance()->obtenerAPI("https://api-referencias.proyecto2018.linti.unlp.edu.ar/tipo-documento");
    }

    public function mostrarFormularioConsulta($datos){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])) {
            $parametros['session'] = $_SESSION;
            if (in_array('consulta_new', $_SESSION['permisos'])) {
                $parametros['motivos'] = PatientRepository::getInstance()->getMotivos(); 
                $parametros['derivaciones'] = APIController::getInstance()->obtenerAPI('https://grupo29.proyecto2018.linti.unlp.edu.ar/api.php/instituciones');
                if ($datos != array()) {
                    $parametros['nombre_paciente'] = $datos['nombre_paciente'];
                    $parametros['apellido_paciente'] = $datos['apellido_paciente'];
                    $parametros['mensaje'] = 'Se ha creado un nuevo Paciente';
                    $parametros['tipo_mensaje'] = 'text-success';
                    $parametros['id_paciente'] = $datos['id_paciente'];
                }
                else {
                    $parametros['pacientes'] = PatientRepository::getInstance()->getPacientes();
                }
                ResourceController::getInstance()->mostrarHTMLConParametros('formularioAltaConsulta.html.twig', $parametros);
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }

    public function utf8ize($mixed) {
        if (is_array($mixed)) {
            foreach ($mixed as $key => $value) {
                $mixed[$key] = $this->utf8ize($value);
            }
        } else if (is_string ($mixed)) {
            return utf8_encode($mixed);
        }
        return $mixed;
    }

    public function obtenerConsultas($datos) {
        $answer = PatientRepository::getInstance()->getConsultas($datos['id']);
        $clean = $this->utf8ize($answer);
        echo json_encode($clean);
    }

    public function validarFormularioConsulta($datos,&$msj) {
        if ($datos['diagnostico'] == '') {
            $msj = 'El diagnostico es obligatorio';
            return false;
        }
        return true;
    }

    public function agregarConsulta($datos) {
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])){
            $parametros["session"] = $_SESSION;
            if (in_array('consulta_new', $_SESSION['permisos'])){
                $msj = '';
                if ($this->validarFormularioConsulta($datos,$msj)) {
                    var_dump($_POST);
                    PatientRepository::getInstance()->agregarConsulta($_POST);
                    $parametros['mensaje'] = 'Consulta agregada';
                    $parametros['tipo_mensaje'] = 'text-success';
                    $parametros['motivos'] = PatientRepository::getInstance()->getMotivos();
                    $parametros['pacientes'] = PatientRepository::getInstance()->getPacientes();
                    ResourceController::getInstance()->mostrarHTMLConParametros('formularioAltaConsulta.html.twig', $parametros);
                }
                else {
                    $parametros['motivos'] = PatientRepository::getInstance()->getMotivos();
                    $parametros['pacientes'] = PatientRepository::getInstance()->getPacientes();
                    $parametros['mensaje'] = $msj;
                    $parametros['tipo_mensaje'] = 'text-danger';
                    ResourceController::getInstance()->mostrarHTMLConParametros('formularioAltaConsulta.html.twig', $parametros);
                }
            } 
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);   
        }
    }

    public function showConsulta(){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])){
            $parametros["session"] = $_SESSION;
            if (in_array('consulta_show', $_SESSION['permisos'])){
                $parametros['consulta'] = PatientRepository::getInstance()->getConsulta($_POST['id_consulta']);
                $id_d = ($parametros['consulta'][0]['derivacion_id']);
                $parametros['derivacion'] = APIController::getInstance()->obtenerAPI("https://grupo29.proyecto2018.linti.unlp.edu.ar/api.php/instituciones/".$id_d);
                ResourceController::getInstance()->mostrarHTMLConParametros('mostrarConsulta.html.twig',$parametros);
            } 
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);   
        }
    }

    public function editConsulta(){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])){
            $parametros["session"] = $_SESSION;
            if (in_array('consulta_update', $_SESSION['permisos'])){
                $parametros['motivos'] = PatientRepository::getInstance()->getMotivos();
                $parametros['derivaciones'] = APIController::getInstance()->obtenerAPI('https://grupo29.proyecto2018.linti.unlp.edu.ar/api.php/instituciones');
                $parametros['consulta'] = PatientRepository::getInstance()->getConsulta($_POST['id_consulta']);
                ResourceController::getInstance()->mostrarHTMLConParametros('editarConsulta.html.twig',$parametros);
            } 
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);   
        }
    }

    public function updateConsulta() {
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])){
            $parametros["session"] = $_SESSION;
            if (in_array('consulta_update', $_SESSION['permisos'])){
                $msj = '';
                if ($this->validarFormularioConsulta($_POST,$msj)) {
                    PatientRepository::getInstance()->updateConsulta($_POST);
                    $parametros['mensaje'] = 'Consulta modificada';
                    $parametros['tipo_mensaje'] = 'text-success';
                    $parametros['motivos'] = PatientRepository::getInstance()->getMotivos();
                    $parametros['pacientes'] = PatientRepository::getInstance()->getPacientes();
                    ResourceController::getInstance()->mostrarHTMLConParametros('formularioAltaConsulta.html.twig', $parametros);
                }
                else {
                    $parametros['motivos'] = PatientRepository::getInstance()->getMotivos();
                    $parametros['pacientes'] = PatientRepository::getInstance()->getPacientes();
                    $parametros['mensaje'] = $msj;
                    $parametros['tipo_mensaje'] = 'text-danger';
                    ResourceController::getInstance()->mostrarHTMLConParametros('formularioAltaConsulta.html.twig', $parametros);
                }
            } 
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);   
        }
    }

    public function deleteConsulta() {
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])){
            $parametros["session"] = $_SESSION;
            if (in_array('consulta_destroy', $_SESSION['permisos'])){
                if ($_POST != array()) {
                    PatientRepository::getInstance()->deleteConsulta($_POST['id_consulta']);
                    $parametros['mensaje'] = 'Consulta eliminada';
                    $parametros['tipo_mensaje'] = 'text-success';
                    $parametros['motivos'] = PatientRepository::getInstance()->getMotivos();
                    $parametros['pacientes'] = PatientRepository::getInstance()->getPacientes();
                    ResourceController::getInstance()->mostrarHTMLConParametros('formularioAltaConsulta.html.twig', $parametros);
                }
                else {

                }
            } 
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);   
        }
    }
}