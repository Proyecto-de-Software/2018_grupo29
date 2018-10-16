<?php

/**
 * Description of SessionController
 *
 * @author fede
 */
require_once('controller/ResourceController.php');
require_once('model/SessionRepository.php');

class SessionController {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }
    
    public function iniciarSesion(){
        if(isset($_POST)){
            $user["nombre"] = $_POST["nombre"];
            $user["contra"] = $_POST["contra"];
            $usuario = SessionRepository::getInstance()->existeUsuario($user);
            if(count($usuario)==0){
                //no existe el usuario
            }else{
                //agarrar el id del usuario correspondiente e iniciar la sesion
            }
        }
        ResourceController::getInstance()->mostrarHTML('home.html.twig'); //parametros
    }
    
}