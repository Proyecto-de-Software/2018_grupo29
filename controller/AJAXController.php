<?php
/**
 * Description of PatientnController
 * @author copiarme? jamas!
 */

require_once('controller/APIController.php');
require_once('controller/ResourceController.php');

class AJAXController {

	private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    private function __construct() {
        
    }

    public function obtenerCiudades($datos){
        if($datos["id"]!== ""){
	    	$vectorCiudades = APIController::getInstance()->obtenerAPI("https://api-referencias.proyecto2018.linti.unlp.edu.ar/localidad");
	    	$arr = array_filter($vectorCiudades, function ($var) use ($datos) {
	    		return ($var['partido_id'] == $datos['id']);});
            echo json_encode($arr);
            //$filtrado = array_values($arr);
	    	//echo ('<label for="partidos">Localidad</label><select class="form-control" name="localidades" id="localidades"><option name="id_ciudad" value='.$filtrado[0]["id"].'">'.$filtrado[0]["nombre"].'</option></select>');
	    	//ResourceController::getInstance()->mostrarHTMLConParametros("optionCiudades.html.twig",$filtrado);
	    }
    }
}