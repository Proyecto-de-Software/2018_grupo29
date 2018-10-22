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
    
    public function crearPacienteNN($datos) {
        $answer = $this->queryList("INSERT INTO `paciente` (`id_paciente`, `apellido`, `nombre`, `fecha_nac`, `lugar_nac`, `localidad_id`, `region_sanitaria_id`, `domicilio`, `genero_id`, `tiene_documento`, `tipo_doc_id`, `numero`, `tel`, `nro_historia_clinica`, `nro_carpeta`, `obra_social_id`) VALUES (NULL, 'NN', '', '', NULL, '1', '1', '', '1', '0', '1', '', '', :nro_historia_clinica, NULL, '1')",["nro_historia_clinica" => $datos['nro_historia_clinica']]);
        return $answer;
    }

    public function getHistoriasClinicas() {
        $answer = $this->queryList("SELECT nro_historia_clinica FROM getPacientes",[]);
        return $answer;
    }

    public function eliminarPaciente($id) {
        $this->queryList("DELETE FROM consulta WHERE paciente_id = :id",["id" => $id]);
        $this->queryList("DELETE FROM paciente WHERE id_paciente = :id",["id" => $id]);
    }

    public function getPartidos(){
        $answer = $this->queryList("SELECT id, nombre FROM partido",[]);
        return $answer;
    }

    public function getLocalidades($idPartido) {
        $answer = $this->queryList("SELECT id, nombre_localidad FROM localidad WHERE partido_id = :id",["id" => $idPartido['id_partido']]);
        return $answer;
    }

    public function crearPaciente($datos) {
        $answer = $this->queryList("INSERT INTO paciente (apellido, nombre, fecha_nac, lugar_nac, localidad_id, region_sanitaria_id, domicilio, genero_id, tiene_documento, tipo_doc_id, numero, tel, nro_historia_clinica, nro_carpeta, obra_social_id) VALUES ( :apellido, :nombre, :fecha, NULL, :localidad, 1 , :domicilio, :genero_id, :tiene_documento, :tipo_documento_id, :numero , :tel, :nro_historia_clinica, :nro_carpeta, :obra_social_id);"

        ,[
            "apellido" => $datos['apellido'],
            "nombre" => $datos['nombre'],
            "fecha" => $datos['fecha_nac'],
            "localidad" => $datos['localidades'],
            "domicilio" => $datos['domicilio'],
            "genero_id" => $datos['genero_id'],
            "tiene_documento" => $datos['tiene_documento'],
            "tipo_documento_id" => $datos['tipo_documento'],
            "numero" => $datos['numero'],
            "tel" => $datos['tel'],
            "nro_historia_clinica" => $datos['nro_historia_clinica'],
            "nro_carpeta" => $datos['nro_carpeta'],
            "obra_social_id" => $datos['obra_social_id']
        ]);
        //Benja, no se por que esto no anda... $answer->debugDumpParams();
    }

    public function datosPaciente($id){
        $answer = $this->queryList("SELECT * FROM paciente where id_paciente=:id", ["id" => $id]);
        return $answer[0];
    }

    public function actualizarPaciente($datos){
        $this->queryList("UPDATE paciente set nombre=:nombre, apellido=:apellido, domicilio=:domicilio, localidad_id=:localidad, tiene_documento=:tieneDoc, obra_social_id=:obraSoc, genero_id=:genero, tipo_doc_id=:tipoDoc, fecha_nac=:fecha, numero=:nro, nro_historia_clinica=:nroHC, nro_carpeta=:nroC, tel=:tel WHERE id_paciente=:id"
            ,[
                "nombre" => $datos["nombre"],
                "apellido" => $datos["apellido"],
                "domicilio" => $datos["domicilio"],
                "localidad" => $datos["localidades"],
                "tieneDoc" => $datos["tiene_documento"],
                "obraSoc" => $datos["obra_social_id"],
                "genero" => $datos["genero_id"],
                "tipoDoc" => $datos["tipo_documento"],
                "fecha" => $datos["fecha_nac"],
                "nro" => $datos["numero"],
                "nroHC" => $datos["nro_historia_clinica"],
                "nroC" => $datos["nro_carpeta"],
                "tel" => $datos["tel"],
                "id" => $datos["id_paciente"],
            ]);
    }

}










