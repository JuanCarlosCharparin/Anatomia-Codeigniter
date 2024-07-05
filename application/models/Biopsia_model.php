<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Biopsia_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db2 = $this->load->database('second_db', TRUE);
        $this->db_salutte = $this->load->database('salutte2', TRUE);
    }

    public function buscarPorNServicio($n_servicio) {
        $sql_first = "SELECT 
                e.nro_servicio AS n_servicio, 
                s.nombre_servicio AS servicio, 
                tde.nombre AS tipo_estudio, 
                tde.id AS tipo_estudio_id,
                per.persona_salutte_id AS persona_id,
                CONCAT(per.nombres, ' ', per.apellidos) AS paciente,
                per.documento as documento,
                per.fecha_nacimiento as fecha_nacimiento,
                per.genero as genero,
                per.obra_social AS obra_social,
                e.diagnostico_presuntivo AS diagnostico,
                e.fecha_carga AS fecha_carga,
                CONCAT(prof.nombres, ' ', prof.apellidos) AS profesional, 
                e.estado_estudio AS estado,
                e.medico_solicitante AS medico,
                e.material as material
            FROM estudio e 
            INNER JOIN servicio s ON e.servicio_id = s.id 
            INNER JOIN tipo_de_estudio tde ON e.tipo_estudio_id = tde.id 
            INNER JOIN personal per ON e.personal_id = per.id
            INNER JOIN profesional prof ON e.profesional_id = prof.id 
            WHERE e.nro_servicio = ?";
    
    
    $result_first = $this->db2->query($sql_first, [$n_servicio])->row_array();

    
    
    return $result_first;
    }

    public function obtenerDatosDePaciente($paciente_id) {
        $sql_second = "SELECT 
                        p.id AS paciente_id,
                        p.nombres AS nombres,
                        p.apellidos AS apellidos,
                        p.documento as documento,
                        p.fecha_nacimiento as fecha_nacimiento,
                        p.sexo as sexo,
                        os.nombre AS obra_social
                    FROM persona p
                    inner JOIN persona_plan pp ON p.id = pp.persona_id
                    inner JOIN plan pl ON pp.plan_id = pl.id
                    inner JOIN obra_social os ON pl.obra_social_id = os.id
                    inner join persona_plan_por_defecto pppd ON pp.id = pppd.persona_plan_id 
                    WHERE p.id = ?";
        
        $result_second = $this->db_salutte->query($sql_second, [$paciente_id])->row_array();

        return $result_second;
    }

    public function obtenerProfesionales(){

        $sql4 = "SELECT DISTINCT
                        p.id,
                        p.nombres as nombres_profesional, 
                        p.apellidos as apellidos_profesional
                    FROM persona p
                    INNER JOIN personal pe ON pe.persona_id = p.id
                    INNER JOIN asignacion a ON pe.id = a.personal_id
                    INNER JOIN especialidad es ON a.especialidad_id = es.id
                    WHERE p.id IN (106780, 198041)";

        $query = $this->db_salutte->query($sql4);
        return $query->result_array(); 
    }

    public function obtenerServicio(){
        $sql5 = "SELECT DISTINCT 
                        e.nombre as nombre
                    FROM especialidad e 
                    INNER JOIN departamento d on d.id = e.departamento_id";

        $query = $this->db_salutte->query($sql5);
        return $query->result_array(); 
    }


    /*public function actualizarEstudio($nro_servicio, $data) {
        
        $sql_actualizar = "UPDATE estudio e
                           INNER JOIN servicio s ON e.servicio_id = s.id
                           INNER JOIN tipo_de_estudio tde ON e.tipo_estudio_id = tde.id
                           INNER JOIN detalle_estudio dt ON e.detalle_estudio_id = dt.id
                           INNER JOIN personal ps ON e.personal_id = ps.id
                           SET s.nombre_servicio = ?,
                               tde.nombre = ?,
                               e.diagnostico = ?,
                               e.fecha_carga = ?,
                               e.estado_estudio = ?,
                               dt.macro = ?
                           WHERE e.nro_servicio = ?";

       
        $params = [
            $data['servicio'],
            $data['tipo_estudio'],
            $data['diagnostico'],
            $data['fecha_carga'],
            $data['estado_estudio'],
            $data['macro'],
            /*$data['profesional_salutte_id'], // Agregado el profesional_salutte_id
            $data['macro'],                  // Asumiendo que 'macro' viene en $data
            $data['micro'],                  // Asumiendo que 'micro' viene en $data
            $data['conclusion'],             // Asumiendo que 'conclusion' viene en $data
            $data['observacion'],            // Asumiendo que 'observacion' viene en $data
            $data['observacion_interna'],*/
           // $nro_servicio
        //];

        /*
        $query = $this->db2->query($sql_actualizar, $params);

        // Retornar el resultado de la ejecución
        return $query;

    }*/

    public function insertar_pap($data_pap) {
        return $this->db2->insert('detalle_pap', $data_pap);
    }

    public function insertar_detalle($data) {
        return $this->db2->insert('detalle_estudio', $data);
    }

    /*public function actualizarDetalleId($n_servicio, $detalle_estudio_id) {
        if ($detalle_estudio_id !== null) {
            $data = array('detalle_estudio_id' => $detalle_estudio_id);
        } else {
            return false; 
        }
    
        $this->db2->where('nro_servicio', $n_servicio);
        $this->db2->update('estudio', $data);
    
        return $this->db2->affected_rows() > 0;
    }

    public function actualizarPapId($n_servicio, $detalle_pap_id) {
        if ($detalle_pap_id !== null) {
            $data = array('detalle_pap_id' => $detalle_pap_id);
        } else {
            return false; 
        }

        $this->db2->where('nro_servicio', $n_servicio);
        $this->db2->update('estudio', $data);
    
        return $this->db2->affected_rows() > 0;
    }

    public function ultimoDetalleInsertado() {
        // Consulta el último registro insertado en la tabla detalle_estudio
        $sql = "SELECT id FROM detalle_estudio ORDER BY id DESC LIMIT 1";
        $query = $this->db2->query($sql);
        return $query->row(); 
    }

    public function ultimoPapInsertado() {
        // Consulta el último registro insertado en la tabla detalle_estudio
        $sql = "SELECT id FROM detalle_pap ORDER BY id DESC LIMIT 1";
        $query = $this->db2->query($sql);
        return $query->row(); 
    }*/


}
