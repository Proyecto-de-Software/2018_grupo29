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
}

