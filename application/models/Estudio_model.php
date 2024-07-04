<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estudio_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db2 = $this->load->database('second_db', TRUE);
        $this->db_salutte = $this->load->database('salutte2', TRUE);
    }

    public function obtener_profesionales(){

        $sql4 = "SELECT DISTINCT
                        p.id,
                        p.nombres as nombres_profesional, 
                        p.apellidos as apellidos_profesional
                    FROM persona p
                    INNER JOIN personal pe ON pe.persona_id = p.id
                    INNER JOIN asignacion a ON pe.id = a.personal_id
                    INNER JOIN especialidad es ON a.especialidad_id = es.id
                    WHERE p.id in (106780, 198041);";

        $query = $this->db_salutte->query($sql4);
        return $query->result_array(); 
    }
    



    /*public function buscarPorNPaciente($persona_ids_str){
        $sql_second = "SELECT p.id, 
                    p.nombres, 
                    p.apellidos
                FROM persona p
                WHERE p.id IN ($persona_ids_str);"

    $result_second = $this->db_salutte->query($sql_second)->result_array();
            
    return $result_second;
    }*/

    public function insertar_estudio($data) {
        return $this->db2->insert('estudio', $data);
    }

    public function obtener_ultimo_servicio() {
        $sql_max = "SELECT MAX(nro_servicio) AS ultimo_servicio FROM estudio";
        $query = $this->db2->query($sql_max);
        $resultado = $query->row();
        
        return $resultado->ultimo_servicio;
    }

    public function insertar_codigo_nomenclador_ap($data) {
        $this->db2->insert('codigo_nomenclador_ap', $data);
    }


    public function filtrar_estudios($filtros) {
        // Query base
        $sql = "SELECT 
                    e.nro_servicio AS n_servicio,
                    s.nombre_servicio AS servicio,
                    tde.nombre AS tipo_estudio,
                    CONCAT(per.nombres, ' ', per.apellidos) AS paciente,
                    per.obra_social AS obra_social,
                    e.fecha_carga AS fecha_carga,
                    e.estado_estudio AS estado,
                    CONCAT(prof.nombres, ' ', prof.apellidos) AS profesional
                FROM estudio e
                INNER JOIN servicio s ON e.servicio_id = s.id
                INNER JOIN tipo_de_estudio tde ON e.tipo_estudio_id = tde.id
                INNER JOIN personal per ON e.personal_id = per.id
                INNER JOIN profesional prof ON e.profesional_id = prof.id 
                WHERE 1=1";
    
        $params = array();
        $where_clause = ""; // Inicializar la cláusula WHERE
    
        // Agregar condiciones según los filtros recibidos
        if (!empty($filtros['n_servicio'])) {
            $where_clause .= " AND e.nro_servicio = ?";
            $params[] = $filtros['n_servicio'];
        }
        if (!empty($filtros['servicio'])) {
            $where_clause .= " AND s.nombre_servicio LIKE ?";
            $params[] = '%' . $filtros['servicio'] . '%';
        }
        if (!empty($filtros['tipo_estudio'])) {
            $where_clause .= " AND tde.nombre LIKE ?";
            $params[] = '%' . $filtros['tipo_estudio'] . '%';
        }
        if (!empty($filtros['paciente'])) {
            // Filtrar por nombres y apellidos concatenados
            $where_clause .= " AND CONCAT(per.nombres, ' ', per.apellidos) LIKE ?";
            $params[] = '%' . $filtros['paciente'] . '%';
        }

        if (!empty($filtros['obra_social'])) {
            $where_clause .= " AND per.obra_social LIKE ?";
            $params[] = '%' . $filtros['obra_social'] . '%';
        }

        if (!empty($filtros['fecha_carga'])) {
            $where_clause .= " AND e.fecha_carga LIKE ? ORDER BY e.nro_servicio";
            $params[] = '%' . $filtros['fecha_carga'] . '%';
        }

        if (!empty($filtros['profesional'])) {
            // Filtrar por nombres y apellidos concatenados
            $where_clause .= " AND CONCAT(prof.nombres, ' ', prof.apellidos) LIKE ?";
            $params[] = '%' . $filtros['profesional'] . '%';
        }
    
        // Agregar la cláusula WHERE al SQL si hay condiciones
        $sql .= $where_clause;
    
        // Imprimir la consulta para depuración
        log_message('debug', 'Consulta SQL depurada: ' . $sql);
        log_message('debug', 'Parámetros: ' . print_r($params, true));
    
        // Ejecutar consulta
        $query = $this->db2->query($sql, $params);
        return $query->result_array();
    }


    public function obtener_paciente($persona_salutte_id) {
        $sql = "SELECT  
                    p.id, 
                    p.nombres, 
                    p.apellidos,
                    os.nombre AS obra_social
                FROM persona p
                INNER JOIN persona_plan pp ON p.id = pp.persona_id
                INNER JOIN plan pl ON pp.plan_id = pl.id
                INNER JOIN obra_social os ON pl.obra_social_id = os.id
                INNER JOIN persona_plan_por_defecto pppd ON pp.id = pppd.persona_plan_id 
                WHERE p.id = ?";
    
        $query = $this->db_salutte->query($sql, array($persona_salutte_id));
        return $query->row_array();
    }

    public function obtener_profesionales_filtrar($profesional_id){

        $sql4 = "SELECT DISTINCT
                        p.id,
                        p.nombres as nombres_profesional, 
                        p.apellidos as apellidos_profesional
                    FROM persona p
                    INNER JOIN personal pe ON pe.persona_id = p.id
                    INNER JOIN asignacion a ON pe.id = a.personal_id
                    INNER JOIN especialidad es ON a.especialidad_id = es.id
                    WHERE p.id in (106780, 198041);";

        $query = $this->db_salutte->query($sql4, array($profesional_id));
        return $query->row_array();
    }

    /*public function get_all_estudios() {

        $sql = "_SELECT 
                    e.nro_servicio AS n_servicio, 
                    s.nombre_servicio AS servicio, 
                    tde.nombre AS tipo_estudio, 
                    CONCAT(per.nombres, ' ', per.apellidos) AS paciente,
                    per.obra_social AS obra_social,
                    e.diagnostico_presuntivo AS diagnostico,
                    e.fecha_carga AS fecha_carga,
                    CONCAT(prof.nombres, ' ', prof.apellidos) AS profesional, 
                    e.estado_estudio AS estado
                    
                FROM estudio e 
                INNER JOIN servicio s ON e.servicio_id = s.id 
                INNER JOIN tipo_de_estudio tde ON e.tipo_estudio_id = tde.id 
                INNER JOIN personal per ON e.personal_id = per.id
                INNER JOIN profesional prof ON e.profesional_id = prof.id";

        $query = $this->db2->query($sql);
        return $query->row_array();
    }*/


}    

