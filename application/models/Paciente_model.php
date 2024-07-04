<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paciente_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db_salutte = $this->load->database('salutte2', TRUE);
        $this->db2 = $this->load->database('second_db', TRUE);
    }

    public function obtener_paciente_por_documento($documento) {
        $sql_persona = "SELECT  p.id, 
                                p.nombres, 
                                p.apellidos, 
                                p.fecha_nacimiento as fecha_nacimiento, 
                                os.nombre AS obra_social,
                                p.documento as documento,
                                p.genero as genero
                            FROM persona p
                            INNER JOIN persona_plan pp ON p.id = pp.persona_id
                            INNER JOIN plan pl ON pp.plan_id = pl.id
                            INNER JOIN obra_social os ON pl.obra_social_id = os.id
                            INNER JOIN persona_plan_por_defecto pppd ON pp.id = pppd.persona_plan_id 
                            WHERE p.documento = ?";
       
        $query = $this->db_salutte->query($sql_persona, array($documento));
        return $query->row(); 
    }

    /*public function obtener_profesionales($profesional_salutte_id) {
        $sql_profesionales = "SELECT DISTINCT
                                p.id AS profesional_salutte_id,
                                p.nombres as nombres_profesional,
                                p.apellidos as apellidos_profesional
                            FROM persona p
                            INNER JOIN personal pe ON pe.persona_id = p.id
                            INNER JOIN asignacion a ON pe.id = a.personal_id
                            INNER JOIN especialidad es ON a.especialidad_id = es.id
                            WHERE p.id IN (106780, 198041);";
    
        $query = $this->db_salutte->query($sql_profesionales);
        return $query->result_array(); 
    }*/

    public function obtener_profesionales($profesional_salutte_ids) {
        $sql_profesionales = "SELECT DISTINCT
                                p.id AS profesional_salutte_id,
                                p.nombres as nombres_profesional,
                                p.apellidos as apellidos_profesional
                            FROM persona p
                            INNER JOIN personal pe ON pe.persona_id = p.id
                            INNER JOIN asignacion a ON pe.id = a.personal_id
                            INNER JOIN especialidad es ON a.especialidad_id = es.id
                            WHERE p.id IN (" . implode(',', $profesional_salutte_ids) . ")";
    
        $query = $this->db_salutte->query($sql_profesionales);
        return $query->result_array(); 
    }


    public function obtener_servicios_desde_salutte() {
        $sql_servicio = "SELECT DISTINCT 
                            e.id AS servicio_salutte_id,
                            e.nombre AS nombre_servicio,
                            e.departamento_id 
                        FROM especialidad e 
                        INNER JOIN departamento d ON d.id = e.departamento_id
                        WHERE e.departamento_id IN (6661180, 6661192, 6661178, 6661181, 6661162)";
    
        $query = $this->db_salutte->query($sql_servicio);
        return $query->result_array();
    }

    // Método para obtener un servicio específico por su ID
    public function obtener_servicio($servicio_salutte_id) {
        $sql_servicio = "SELECT 
                            e.nombre AS nombre_servicio
                        FROM especialidad e
                        WHERE e.id = ?";
    
        $query = $this->db_salutte->query($sql_servicio, array($servicio_salutte_id));
        return $query->row_array();
    }
   

}
