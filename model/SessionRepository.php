<?php

/**
 * Description of ResourceRepository
 *
 * @author fede
 */

require_once('model/PDORepository.php');

class SessionRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        
    }

    public function existeUsuario($datos){
        $answer = $this->queryList("SELECT * FROM usuario where username=:user and password=:pass",["user" => $datos['nombre'], "pass" => $datos['contra']]);
        return $answer;
    }

    /*public function listAll() {
        $answer = $this->queryList("select * from usuarios where estado=?;", ['Confirmado']);
        $final_answer = [];
        foreach ($answer as &$element) {
            $final_answer[] = new Resource($element['apellido'].", ".$element['nombre'], $element['id']);
        }
        return $final_answer;
    }*/

    

}