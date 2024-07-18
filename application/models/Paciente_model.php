<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paciente_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db_salutte = $this->load->database('salutte2', TRUE);
        $this->db2 = $this->load->database('second_db', TRUE);
    }

    public function obtener_paciente_por_documento($documento) {
        $sql_persona = "SELECT  
                        p.id, 
                        p.nombres, 
                        p.apellidos, 
                        p.fecha_nacimiento AS fecha_nacimiento, 
                        os.nombre AS obra_social,
                        p.documento AS documento,
                        p.genero AS genero,
                        CONCAT(p.contacto_celular_prefijo, ' ', p.contacto_celular_codigo, ' ', p.contacto_celular_numero) AS celular,
                        p.contacto_email_direccion as mail,
                        pai.nombre AS nombre_pais,
                        pr.nombre AS nombre_provincia,
                        c.nombre AS nombre_ciudad
                        
                    FROM persona p
                    INNER JOIN persona_plan pp ON p.id = pp.persona_id
                    INNER JOIN plan pl ON pp.plan_id = pl.id
                    INNER JOIN obra_social os ON pl.obra_social_id = os.id
                    INNER JOIN persona_plan_por_defecto pppd ON pp.id = pppd.persona_plan_id
                    INNER JOIN pais pai ON p.pais_id = pai.id
                    inner join direccion d on p.direccion_id = d.id 
                    LEFT JOIN provincia pr ON d.provincia_id = pr.id
                    LEFT JOIN ciudad c ON d.ciudad_id = c.id
                    WHERE p.documento = ?";
       
        $query = $this->db_salutte->query($sql_persona, array($documento));
        return $query->row(); 
    }

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

    public function obtener_pacientes($documento) {
        $sql_profesionales = "SELECT  
                                p.nombres, 
                                p.apellidos, 
                                p.fecha_nacimiento AS fecha_nacimiento, 
                                os.nombre AS obra_social,
                                p.documento AS documento,
                                p.genero AS genero,
                                CONCAT(p.contacto_celular_prefijo, ' ', p.contacto_celular_codigo, ' ', p.contacto_celular_numero) AS celular,
                                p.contacto_email_direccion as direccion,
                                pai.nombre AS nombre_pais,
                                pr.nombre AS nombre_provincia,
                                c.nombre AS nombre_ciudad,
                                br.nombre AS nombre_barrio
                                
                            FROM persona p
                            INNER JOIN persona_plan pp ON p.id = pp.persona_id
                            INNER JOIN plan pl ON pp.plan_id = pl.id
                            INNER JOIN obra_social os ON pl.obra_social_id = os.id
                            INNER JOIN persona_plan_por_defecto pppd ON pp.id = pppd.persona_plan_id
                            INNER JOIN pais pai ON p.pais_id = pai.id
                            inner join direccion d on p.direccion_id = d.id 
                            LEFT JOIN provincia pr ON d.provincia_id = pr.id
                            LEFT JOIN ciudad c ON d.ciudad_id = c.id
                            LEFT JOIN barrio br ON d.barrio_id = br.id
                            WHERE p.documento = ?";
    
        $query = $this->db_salutte->query($sql_persona, array($documento));
        return $query->result_array(); 
    }
   

}
