<?php

/**
 * Description of PatientRepository
 *
 * @author fer
 */

require_once('model/PDORepository.php');

class PatientRepository extends PDORepository {

    private static $instance;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        
    }

    public function getPacientes() {
        $answer = $this->queryList("
            SELECT
            *
            FROM
                paciente p
            INNER JOIN localidad l ON
                l.id = p.localidad_id
            INNER JOIN region_sanitaria rs ON
                rs.id = p.region_sanitaria_id
            INNER JOIN genero g ON
                g.id = p.genero_id
            INNER JOIN tipo_documento td ON
                td.id = p.tipo_doc_id
            INNER JOIN obra_social os ON
                os.id = p.obra_social_id"
            ,[]);
        return $answer;
    }

    public function buscarPaciente($datos){
        $answer = $this->queryList("
            SELECT
            *
            FROM
                paciente p
            INNER JOIN tipo_documento td ON
                td.id = p.tipo_doc_id
            WHERE 
                p.nombre LIKE CONCAT('%', :nombre, '%') AND
                p.apellido LIKE CONCAT('%', :apellido, '%') AND
                td.nombre_tipo_documento LIKE CONCAT('%', :nombre_tipo_documento, '%') AND
                p.numero LIKE CONCAT('%', :numero_documento, '%') AND
                p.nro_historia_clinica LIKE CONCAT('%', :nro_historia_clinica ,'%')",
            ["nombre" => $datos['nombre'],
             "apellido" => $datos['apellido'],
             "nombre_tipo_documento" => $datos['nombre_tipo_documento'],
             "numero_documento" => $datos['numero_documento'],
             "nro_historia_clinica" => $datos['nro_historia_clinica']
            ]);
        return $answer;
    }
    

}










