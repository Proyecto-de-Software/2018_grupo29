<?php

/**
 * Description of ResourceController
 *
 * @author fede
 */

require_once('model/ConfigurationRepository.php');

class ResourceController {
    
    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }
    
    public function mostrarHTML($html){
        //creo que quedo sin usos
        $view = new Home();
        $view->show($html);
    }
    
    public function mostrarHTMLConParametros($html, $datos){
        $view = new Home();
        $view->showConParametros($html, $datos);
    }

    public function menuPrincipal($html){
        $datos = $this->getConfiguration();
        if(isset($_SESSION['id'])){
            $datos["session"] = $_SESSION;
            $this->mostrarHTMLConParametros($html, $datos);
        }
        else{ 
            $estado = ConfigurationRepository::getInstance()->getEstadoSitio();
            $es = $estado[0]['valor'];   
            if ($es == '0'){
                $this->mostrarHTMLConParametros($html, $datos);
            }
            else{
                $this->mostrarHTMLConParametros('mantenimiento.html.twig', $datos);
            }
        }
    }

    public function getConfiguration(){
        $datos['tituloHospital'] = $GLOBALS["conf"][0]['valor'];
        $datos['mailContacto'] = $GLOBALS["conf"][1]['valor'];
        return $datos;
    }

    public function setPaginado(&$vector, $datos){
        $vector['cantElementosPorPagina'] = intval(ConfigurationRepository::getInstance()->getCantPaginas()[0]['valor']);
        $cantidadUsuarios = count($datos);
        $vector['cantPaginas'] = ceil($cantidadUsuarios / $vector['cantElementosPorPagina']);
    }

    public function paginaActual(){
        if (! isset($_POST['pagina'])) {
            $actual = 0;
        } else {
            $actual = $_POST['pagina'] - 1;
        }
        return $actual;
    }
}
