<?php

require_once('model/PDORepository.php');

class ReportesRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        
    }

    public function getConsultasPorMotivo($id_motivo) {
        $answer = $this->queryList("
            SELECT c.id, c.fecha, c.motivo_id, c.diagnostico, mc.nombre as forma, p.nombre as nombre_paciente, p.apellido
            FROM consulta c 
            INNER JOIN motivo_consulta mc ON c.motivo_id = mc.id 
            INNER JOIN paciente p ON c.paciente_id = p.id_paciente
            WHERE c.motivo_id = :id"

            ,["id" => $id_motivo]);
        
        return $answer;
    }

    public function getConsultasPorGenero($id_genero){
         $answer = $this->queryList("
            SELECT c.id, c.fecha, c.diagnostico, p.nombre as nombre_paciente, p.apellido, p.genero_id, g.nombre_genero as forma
            FROM consulta c 
            INNER JOIN paciente p ON c.paciente_id = p.id_paciente
            INNER JOIN genero g ON p.genero_id = g.id
            WHERE p.genero_id = :id"

            ,["id" => $id_genero]);
        
        return $answer;
    }

    public function getConsultasPorLocalidad($id_localidad){
         $answer = $this->queryList("
            SELECT c.id, c.fecha, c.diagnostico, p.nombre as nombre_paciente, p.apellido, p.genero_id, p.localidad_id as forma
            FROM consulta c 
            INNER JOIN paciente p ON c.paciente_id = p.id_paciente
            INNER JOIN genero g ON p.genero_id = g.id
            WHERE p.localidad_id = :id"

            ,["id" => $id_localidad]);
        
        return $answer;
    }
}

