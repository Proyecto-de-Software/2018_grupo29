<?php

/**
 * Description of ResourceController
 *
 * @author fede
 */
require_once('controller/ResourceController.php');
require_once('model/SessionRepository.php');
require_once('model/UserRepository.php');

class UserController {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }

    public function menuUsuarios(){
        if (isset($_SESSION['id'])) { 
            if ( 
                (in_array('usuario_show', $_SESSION['permisos'])) or 
                (in_array('usuario_new', $_SESSION['permisos'])) or 
                (in_array('usuario_update', $_SESSION['permisos'])) or
                (in_array('usuario_index', $_SESSION['permisos'])) or 
                (in_array('usuario_destroy', $_SESSION['permisos']))
                 ){
                ResourceController::getInstance()->mostrarHTMLConParametros('usuarios.html.twig', $_SESSION);
            }
            else {
                ResourceController::getInstance()->mostrarHTML('error.html.twig');
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTML('error.html.twig');
        }
    }

    public function getAllUsers($html){

        /* Anterior al paginado...
        $usuarios = UserRepository::getInstance()->listAll();
        $_SESSION["usuarios"] = $usuarios;
        ResourceController::getInstance()->mostrarHTMLConParametros($html,$_SESSION);
        */

        if (! isset($_POST['fueBusqueda'])) $_POST['fueBusqueda'] = 0;
        if (isset($_SESSION['id'])) {
            if (($_POST['fueBusqueda']) == 0) {
                if (in_array('usuario_index', $_SESSION['permisos'])) {
                    $usuarios = UserRepository::getInstance()->listAll($_SESSION['id']);
                    $answer = ConfigurationRepository::getInstance()->getCantPaginas();
                    $cantElementosPorPagina = $answer[0]['valor'];
                    $cantElementosPorPagina =  intval($cantElementosPorPagina);
                    $_SESSION['cantElementosPorPagina'] = $cantElementosPorPagina;
                    $cantidadUsuarios = count($usuarios);
                    $cantPaginas = $cantidadUsuarios / $cantElementosPorPagina;
                    $cantPaginas = ceil($cantPaginas);
                    $_SESSION['cantPaginas'] = $cantPaginas;
                    $usuarios = array_chunk($usuarios, $cantElementosPorPagina);
                    if (! isset($_POST['pagina'])) {
                        $actual = 0;
                    }
                    else {
                        $actual = $_POST['pagina'] - 1;
                    }
                    $_SESSION['usuarios'] = $usuarios[$actual];
                    $_SESSION['fueBusqueda'] = 0;
                    ResourceController::getInstance()->mostrarHTMLConParametros($html, $_SESSION);
                }
                else {
                    ResourceController::getInstance()->mostrarHTML('error.html.twig');
                }
            }
            else{
                $this->buscarUsuario();
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTML('error.html.twig');
        }
    } 

    

    public function obtenerPermisos($id){
    	$permisos = UserRepository::getInstance()->getPermisos($id);
    	$vectorPermisos = array();
    	foreach ($permisos as $elemento){
    		array_push($vectorPermisos, $elemento["nombre"]);
    	}
    	return $vectorPermisos;	
    }

    public function cambiarEstado($datos){
        if(isset($_SESSION['id'])){
            if(in_array('usuario_update', $_SESSION['permisos'])){
                if($datos["usuario_estado"]==0){
                    $datosNuevos["usuario_estado"] = 1;
                    $datosNuevos["usuario_id"] = $datos["usuario_id"];
                    UserRepository::getInstance()->cambiarEstado($datosNuevos);
                }else{
                    $datosNuevos["usuario_estado"] = 0;
                    $datosNuevos["usuario_id"] = $datos["usuario_id"];
                    UserRepository::getInstance()->cambiarEstado($datosNuevos);
                }
                $this->getAllUsers('listaUsuarios.html.twig');
            }else{
                ResourceController::getInstance()->mostrarHTML('error.html.twig');
            }
        }else{
            ResourceController::getInstance()->mostrarHTML('error.html.twig');
        }
    }

    public function nuevoUsuario(){
        if(isset($_SESSION['id'])){
            if(in_array('usuario_new', $_SESSION['permisos'])){
                ResourceController::getInstance()->mostrarHTMLConParametros('formularioAltaUsuario.html.twig', $_SESSION);
            }else{
                ResourceController::getInstance()->mostrarHTML('error.html.twig');
            }
        }else{
            ResourceController::getInstance()->mostrarHTML('error.html.twig');
        }
    }

    public function crearUsuarioNuevo(){
        if(isset($_SESSION['id'])){
            if(in_array('usuario_new', $_SESSION['permisos'])){
                $answer = UserRepository::getInstance()->verificarUnicidad($_POST);
                if (count($answer) == 0) {
                    $_POST['created_at'] = date("Y-m-d H:i:s");
                    $_POST['updated_at'] = date("Y-m-d H:i:s");
                    UserRepository::getInstance()->agregarUsuario($_POST);
                    $_SESSION['mensaje'] = "Se ha creado al usuario '".$_POST['username']."'";
                    $_SESSION['tipo_mensaje'] = 'text-success';
                    ResourceController::getInstance()->mostrarHTMLConParametros('formularioAltaUsuario.html.twig', $_SESSION);
                }
                else {
                    $_SESSION['mensaje'] = "El nombre de usuario '".$_POST['username']."'  ya existe. Por favor elija otro";
                    $_SESSION['tipo_mensaje'] = 'text-danger';
                    ResourceController::getInstance()->mostrarHTMLConParametros('formularioAltaUsuario.html.twig', $_SESSION);
                }
            }else{
                ResourceController::getInstance()->mostrarHTML('error.html.twig');
            }
        }else{
            ResourceController::getInstance()->mostrarHTML('error.html.twig');
        }
    }

    public function mostrarFormularioBusqueda(){
        if (isset($_SESSION['id'])) {
            if (in_array('usuario_index', $_SESSION['permisos'])) {
                
                ResourceController::getInstance()->mostrarHTMLConParametros('busquedaUsuario.html.twig', $_SESSION);
            }
            else {
                ResourceController::getInstance()->mostrarHTML('error.html.twig');
            }

        }
        else {
            ResourceController::getInstance()->mostrarHTML('error.html.twig');
        }
    }

    public function buscarUsuario(){
        if (isset($_SESSION['id'])) {
            if (in_array('usuario_index', $_SESSION['permisos'])) {
                $_POST['id'] = $_SESSION['id'];
                if (($_POST['activo']) == '') {
                    $usuarios = UserRepository::getInstance()->buscarUsuarioSinActivo($_POST);
                }
                else{
                    $usuarios = UserRepository::getInstance()->buscarUsuarioConActivo($_POST);
                }
                if (count($usuarios)==0){
                    $_SESSION['noHubo'] = 1;;
                    $this->mostrarFormularioBusqueda($_SESSION);
                }
                else {
                    if (isset($_SESSION['noHubo'])) $_SESSION['noHubo'] = '';
                    $answer = ConfigurationRepository::getInstance()->getCantPaginas();
                    $cantElementosPorPagina = $answer[0]['valor'];
                    $cantElementosPorPagina =  intval($cantElementosPorPagina);
                    $_SESSION['cantElementosPorPagina'] = $cantElementosPorPagina;
                    $cantidadUsuarios = count($usuarios);
                    $cantPaginas = $cantidadUsuarios / $cantElementosPorPagina;
                    $cantPaginas = ceil($cantPaginas);
                    $_SESSION['cantPaginas'] = $cantPaginas;
                    $usuarios = array_chunk($usuarios, $cantElementosPorPagina);
                    if (! isset($_POST['pagina'])) {
                        $actual = 0;
                    }
                    else {
                        $actual = $_POST['pagina'] - 1;
                    }
                    $_SESSION['usuarios'] = $usuarios[$actual];
                    $_SESSION['fueBusqueda'] = 1;
                    $_SESSION['filtros'] = $_POST;
                    ResourceController::getInstance()->mostrarHTMLConParametros('listaUsuarios.html.twig', $_SESSION);
                }
            
                
            }
            else {
                ResourceController::getInstance()->mostrarHTML('error.html.twig');
            }

        }
        else {
            ResourceController::getInstance()->mostrarHTML('error.html.twig');
        }
    }

    public function eliminarUsuario() {
        if (isset($_SESSION['id'])){
            if (in_array('usuario_destroy', $_SESSION['permisos'])){
                UserRepository::getInstance()->eliminarUsuario($_POST['usuario_id']);
                ResourceController::getInstance()->mostrarHTMLConParametros('listaUsuarios.html.twig', $_SESSION);
            }
            else {
                ResourceController::getInstance()->mostrarHTML('error.html.twig');
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTML('error.html.twig');
        }
    }

    public function verDatosUsuario(){
        if (isset($_SESSION['id'])){
            if (in_array('usuario_update', $_SESSION['permisos'])){
                $_SESSION['datosUsuario'] = UserRepository::getInstance()->datosUsuario($_POST['usuario_id']);
                ResourceController::getInstance()->mostrarHTMLConParametros('formularioAltaUsuario.html.twig', $_SESSION);
            }
            else {
                ResourceController::getInstance()->mostrarHTML('error.html.twig');
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTML('error.html.twig');
        }
    }

    public function editarUsuario(){
        UserRepository::getInstance()->actualizarUsuario($_POST);
        unset($_SESSION['datosUsuario']);
        ResourceController::getInstance()->mostrarHTMLConParametros('listaUsuarios.html.twig', $_SESSION);
    }
}