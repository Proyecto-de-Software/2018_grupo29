<?php

/**
 * Description of PatientRepository
 *
 * @author fer
 */

require_once('model/PDORepository.php');

class ConfigurationRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        
    }

    public function getConfiguraciones(){
        $answer = $this->queryList("SELECT * FROM configuracion",[]);
        return $answer;
    }

    public function getTitulo() {
        $answer = $this->queryList("SELECT valor FROM configuracion WHERE id=1",[]);
        return $answer;

    }

    public function getEstadoSitio() {
        $answer = $this->queryList("SELECT valor FROM configuracion WHERE id = 4",[]);
        return $answer;

    }


    public function updateConfiguration($datos) {
        $this->queryList("UPDATE configuracion SET valor = :titulo WHERE id = 1 ",["titulo" => $datos['Titulo']]);
        $this->queryList("UPDATE configuracion SET valor = :mail WHERE id = 2 ",["mail" => $datos['mail']]);
        $this->queryList("UPDATE configuracion SET valor = :hojas_por_pagina WHERE id = 3 ",["hojas_por_pagina" => $datos['hojas_por_pagina']]);
        $this->queryList("UPDATE configuracion SET valor = :estado WHERE id = 4 ",["estado" => $datos['estado_sitio']]);
    }
}

