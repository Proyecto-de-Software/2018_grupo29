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
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])) { 
            $parametros["session"] = $_SESSION;
            if ( 
                (in_array('usuario_show', $_SESSION['permisos'])) or 
                (in_array('usuario_new', $_SESSION['permisos'])) or 
                (in_array('usuario_update', $_SESSION['permisos'])) or
                (in_array('usuario_index', $_SESSION['permisos'])) or 
                (in_array('usuario_destroy', $_SESSION['permisos']))
                 ){
                ResourceController::getInstance()->mostrarHTMLConParametros('usuarios.html.twig', $parametros);
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }

    public function getAllUsers($html){

        $parametros = ResourceController::getInstance()->getConfiguration();
        if (! isset($_POST['fueBusqueda'])) $_POST['fueBusqueda'] = 0;
        if (isset($_SESSION['id'])) {
            $parametros["session"] = $_SESSION;
            if (($_POST['fueBusqueda']) == 0) {
                if (in_array('usuario_index', $_SESSION['permisos'])) {
                    $usuarios = UserRepository::getInstance()->listAll($_SESSION['id']);
                    ResourceController::getInstance()->setPaginado($parametros,$usuarios);
                    $usuarios = array_chunk($usuarios, $parametros['cantElementosPorPagina']);
                    $parametros['usuarios'] = $usuarios[ResourceController::getInstance()->paginaActual()];
                    $parametros['fueBusqueda'] = 0;
                    ResourceController::getInstance()->mostrarHTMLConParametros($html, $parametros);
                }
                else {
                    ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
                }
            }
            else{
                $this->buscarUsuario();
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    } 

    public function buscarUsuario(){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])) {
            $parametros["session"] = $_SESSION;
            if (in_array('usuario_index', $_SESSION['permisos'])) {
                $_POST['id'] = $_SESSION['id'];
                if (($_POST['activo']) == '') {
                    $usuarios = UserRepository::getInstance()->buscarUsuarioSinActivo($_POST);
                }
                else{
                    $usuarios = UserRepository::getInstance()->buscarUsuarioConActivo($_POST);
                }
                if (count($usuarios)==0){
                    //$parametros['noHubo'] = 1;
                    $this->mostrarFormularioBusqueda();
                }
                else {
                    ResourceController::getInstance()->setPaginado($parametros,$usuarios);
                    $usuarios = array_chunk($usuarios, $parametros['cantElementosPorPagina']);
                    $parametros['usuarios'] = $usuarios[ResourceController::getInstance()->paginaActual()];
                    $parametros['fueBusqueda'] = 1;
                    $parametros['filtros'] = $_POST;
                    ResourceController::getInstance()->mostrarHTMLConParametros('listaUsuarios.html.twig', $parametros);
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

    public function mostrarFormularioBusqueda(){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])) {
            $parametros["session"] = $_SESSION;
            if (in_array('usuario_index', $_SESSION['permisos'])) {
                ResourceController::getInstance()->mostrarHTMLConParametros('busquedaUsuario.html.twig', $parametros);
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
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
        $parametros = ResourceController::getInstance()->getConfiguration();
        if(isset($_SESSION['id'])){
            $parametros["session"] = $_SESSION;
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
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        }else{
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }

    public function nuevoUsuario(){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if(isset($_SESSION['id'])){
            $parametros["session"] = $_SESSION;
            if(in_array('usuario_new', $_SESSION['permisos'])){
                $parametros['roles'] = UserRepository::getInstance()->getRoles();
                ResourceController::getInstance()->mostrarHTMLConParametros('formularioAltaUsuario.html.twig', $parametros);
            }else{
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        }else{
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }

    public function crearUsuarioNuevo(){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if(isset($_SESSION['id']) && ($_POST !== array())){
            $parametros["session"] = $_SESSION;
            if(in_array('usuario_new', $_SESSION['permisos'])){
                $answer = UserRepository::getInstance()->verificarUnicidad($_POST);
                if (count($answer) == 0) {
                    $_POST['created_at'] = date("Y-m-d H:i:s");
                    $_POST['updated_at'] = date("Y-m-d H:i:s");
                    UserRepository::getInstance()->agregarUsuario($_POST);
                    $id = UserRepository::getInstance()->getIdByUsername($_POST['username'])[0];
                    $id = intval($id['id']);
                    if (isset($_POST['roles'])) {
                        $checkbox = ($_POST['roles']);
                        $N = count($checkbox);
                        $parametro['usuario_id'] = $id;
                        for($i=0; $i < $N; $i++) {
                            $parametro['rol_id'] = intval($checkbox[$i]);
                            UserRepository::getInstance()->asignarRol($parametro);
                        }
                    }
                    $parametros['mensaje'] = "Se ha creado al usuario '".$_POST['username']."'";
                    $parametros['tipo_mensaje'] = 'text-success';
                    ResourceController::getInstance()->mostrarHTMLConParametros('formularioAltaUsuario.html.twig', $parametros);
                }
                else {
                    $parametros['mensaje'] = "El nombre de usuario '".$_POST['username']."'  ya existe. Por favor elija otro";
                    $parametros['tipo_mensaje'] = 'text-danger';
                    ResourceController::getInstance()->mostrarHTMLConParametros('formularioAltaUsuario.html.twig', $parametros);
                }
            }else{
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        }else{
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }

    public function eliminarUsuario() {
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])){
            $parametros["session"] = $_SESSION;
            if (in_array('usuario_destroy', $_SESSION['permisos'])){
                UserRepository::getInstance()->eliminarUsuario($_POST['usuario_id']);
                ResourceController::getInstance()->mostrarHTMLConParametros('listaUsuarios.html.twig', $parametros);
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }

    public function verDatosUsuario(){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])){
            $parametros["session"] = $_SESSION;
            if (in_array('usuario_update', $_SESSION['permisos'])){
                $parametros['datosUsuario'] = UserRepository::getInstance()->datosUsuario($_POST['usuario_id']);
                ResourceController::getInstance()->mostrarHTMLConParametros('formularioAltaUsuario.html.twig', $parametros);
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }

    public function editarUsuario(){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])){
            $parametros["session"] = $_SESSION;
            if(in_array('usuario_update', $_SESSION['permisos'])){
                UserRepository::getInstance()->actualizarUsuario($_POST);
                ResourceController::getInstance()->mostrarHTMLConParametros('listaUsuarios.html.twig', $_SESSION);
            } else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        } else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }

    public function mostrarRoles() {
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])){
            $parametros["session"] = $_SESSION;
            if (in_array('usuario_update', $_SESSION['permisos'])){
                /*
                Cuando cambiemos todo de SESSION deberia ser algo asi.
                $parametro['roles'] = UserRepository::getInstance()->getRoles();
                $parametro['datosSession'] = $_SESSION;
                */
                $parametros['roles'] = UserRepository::getInstance()->getRolesQueNoTieneUnUsuario($_POST['usuario_id']);
                $parametros['rolesDeUsuario'] = UserRepository::getInstance()->getRolesDeUsuario($_POST['usuario_id']);
                $parametros['nombreUsuarioRoles'] = $_POST['first_name'];
                $parametros['apellidoUsuarioRoles'] = $_POST['last_name'];
                $parametros['idUsuarioRoles'] = $_POST['usuario_id'];
                ResourceController::getInstance()->mostrarHTMLConParametros('roles.html.twig', $parametros);
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }

    public function asignarRol($datos){
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])){
            $parametros["session"] = $_SESSION;
            if (in_array('usuario_update', $_SESSION['permisos'])){
                $parametro['usuario_id'] = $_POST['usuario_id'];
                $parametro['rol_id'] = $_POST['rol_id'];
                UserRepository::getInstance()->asignarRol($parametro);
                $this->mostrarRoles();
            }
            else {
                ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
            }
        }
        else {
            ResourceController::getInstance()->mostrarHTMLConParametros('error.html.twig',$parametros);
        }
    }

    public function desasignarRol($datos) {
        $parametros = ResourceController::getInstance()->getConfiguration();
        if (isset($_SESSION['id'])){
            $parametros["session"] = $_SESSION;
            if (in_array('usuario_update', $_SESSION['permisos'])){
                $parametros['usuario_id'] = $_POST['usuario_id'];
                $parametros['rol_id'] = $_POST['rol_id'];
                UserRepository::getInstance()->desasignarRol($parametros);
                $this->mostrarRoles();
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