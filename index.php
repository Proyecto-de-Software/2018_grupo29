<?php


session_start();
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

require_once('controller/APIController.php');
require_once('controller/AJAXController.php');
require_once('controller/ResourceController.php');
require_once('controller/SessionController.php');
require_once('controller/UserController.php');
require_once('controller/PatientController.php');
require_once('controller/ConfigurationController.php');
require_once('model/PDORepository.php');
require_once('model/UserRepository.php');
require_once('model/PatientRepository.php');
require_once('model/Resource.php');
require_once('model/ConfigurationRepository.php');
require_once('view/TwigView.php');
require_once('view/SimpleResourceList.php');
require_once('view/Home.php');

$GLOBALS["conf"] = ConfigurationRepository::getInstance()->getConfiguraciones();

//esto se va a modificar a los actions que tengamos 
if(!(isset($_GET["action"]))) {
    ResourceController::getInstance()->menuPrincipal('home.html.twig');
}elseif ($_GET["action"] == 'login'){
    SessionController::getInstance()->mostrarFormularioInicioSesion('login.html.twig'); 
}elseif ($_GET["action"] == 'inicioSesion'){
    SessionController::getInstance()->iniciarSesion(); 
}elseif ($_GET["action"] == 'logout'){
	SessionController::getInstance()->cerrarSesion(); 
}elseif($_GET["action"] == 'moduloUsuarios'){
	UserController::getInstance()->menuUsuarios('usuarios.html.twig');
}elseif($_GET["action"] == 'listarUsuarios'){
	UserController::getInstance()->getAllUsers('listaUsuarios.html.twig'); //andando 95%
}elseif ($_GET["action"] == 'cambiarEstadoUsuario') {
	UserController::getInstance()->cambiarEstado($_POST); 
}elseif ($_GET["action"] == 'moduloPacientes'){
	PatientController::getInstance()->menuPacientes('pacientes.html.twig');
}elseif ($_GET["action"] == 'listarPacientes'){
	PatientController::getInstance()->obtenerPacientes();  
}elseif ($_GET["action"] == 'formularioBusquedaPaciente'){
	PatientController::getInstance()->mostrarFormulario(0);
}elseif ($_GET["action"] == 'buscarPaciente'){
	PatientController::getInstance()->buscarPaciente(); 
}elseif ($_GET["action"] == 'nuevoPacienteNN'){
	PatientController::getInstance()->crearPacienteNN($_POST); 
}elseif ($_GET["action"] == 'nuevoPaciente'){
	PatientController::getInstance()->crearPaciente(); 
}elseif ($_GET["action"] == 'eliminarPaciente'){
	PatientController::getInstance()->eliminarPaciente();
}elseif ($_GET["action"] == 'moduloConfiguracion'){
	ConfigurationController::getInstance()->menuConfiguracion();
}elseif ($_GET["action"] == 'actualizarConfiguracion'){
	ConfigurationController::getInstance()->actualizarConfiguracion();
}elseif ($_GET["action"] == 'nuevoUsuario'){
	UserController::getInstance()->nuevoUsuario(array()); 
}elseif ($_GET["action"] == 'crearUsuario'){
	UserController::getInstance()->crearUsuarioNuevo();
}elseif ($_GET["action"] == 'obtenerCiudades'){
	AJAXController::getInstance()->obtenerCiudades($_POST);
}elseif ($_GET["action"] == 'formularioBusquedaUsuarios'){
	UserController::getInstance()->mostrarFormularioBusqueda('');
}elseif ($_GET["action"] == 'buscarUsuario'){
	UserController::getInstance()->buscarUsuario();
}elseif ($_GET["action"] == 'crearPacienteNuevo'){
	PatientController::getInstance()->crearPacienteNuevo();
}elseif ($_GET["action"] == 'editarPaciente'){
	PatientController::getInstance()->verDatosPaciente();
}elseif ($_GET["action"] == 'modificarPaciente'){
	PatientController::getInstance()->editarPaciente();
}elseif ($_GET["action"] == 'eliminarUsuario'){
	UserController::getInstance()->eliminarUsuario();
}elseif ($_GET["action"] == 'editarUsuario'){
	UserController::getInstance()->verDatosUsuario();
}elseif ($_GET["action"] == 'modificarUsuario'){
	UserController::getInstance()->editarUsuario();
}elseif ($_GET["action"] == 'manejoRoles'){
	UserController::getInstance()->mostrarRoles();
}elseif ($_GET["action"] == 'asignarRol'){
	UserController::getInstance()->asignarRol($_POST);
}elseif ($_GET["action"] == 'desasignarRol'){
	UserController::getInstance()->desasignarRol($_POST);
}elseif ($_GET["action"] == 'mostrarFormularioConsulta'){
	PatientController::getInstance()->mostrarFormularioConsulta(array());
}elseif ($_GET["action"] == 'obtenerConsultas'){
	PatientController::getInstance()->obtenerConsultas($_POST);
}elseif ($_GET["action"] == 'agregarConsulta'){
	PatientController::getInstance()->agregarConsulta($_POST);
}elseif ($_GET["action"] == 'showConsulta'){
	PatientController::getInstance()->showConsulta();
}elseif ($_GET["action"] == 'editConsulta'){
	PatientController::getInstance()->editConsulta();
}elseif ($_GET["action"] == 'updateConsulta'){
	PatientController::getInstance()->updateConsulta();
}elseif ($_GET["action"] == 'deleteConsulta'){
	PatientController::getInstance()->deleteConsulta();
}else{
	ResourceController::getInstance()->menuPrincipal('home.html.twig');
}