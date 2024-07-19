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

    public function insertar_pap($data_pap) {
        return $this->db2->insert('detalle_pap', $data_pap);
    }

    public function insertar_detalle($data) {
        return $this->db2->insert('detalle_estudio', $data);
    }

    public function actualizarDetalleId($n_servicio, $detalle_estudio_id) {
        $data = array('detalle_estudio_id' => $detalle_estudio_id);
        $this->db2->where('nro_servicio', $n_servicio);
        $this->db2->update('estudio', $data);
        return $this->db2->affected_rows() > 0;
    }

    public function actualizarPapId($n_servicio, $detalle_pap_id) {
        $data = array('detalle_pap_id' => $detalle_pap_id);
        $this->db2->where('nro_servicio', $n_servicio);
        $this->db2->update('estudio', $data);
        return $this->db2->affected_rows() > 0;
    }

    public function ultimoPapInsertado() {
        // Consulta el último registro insertado en la tabla detalle_estudio
        return $this->db2->insert_id();
    }

    public function ultimoDetalleInsertado() {
        // Consulta el último registro insertado en la tabla detalle_estudio
        return $this->db2->insert_id();
    }


    public function cambiarEstado($n_servicio, $nuevo_estado) {
        $data = array(
            'estado_estudio' => $nuevo_estado
        );

        $this->db2->where('nro_servicio', $n_servicio);
        $this->db2->update('estudio', $data);

        return $this->db2->affected_rows() > 0; // Retorna true si se actualizó al menos una fila
    }

    

    public function cambiarEstadoFinalizado($n_servicio, $nuevo_estado_finalizado) {
        $data = array(
            'estado_estudio' => $nuevo_estado_finalizado
        );

        $this->db2->where('nro_servicio', $n_servicio);
        $this->db2->update('estudio', $data);

        return $this->db2->affected_rows() > 0; 
    }


    //Armado de ficha pdf

    public function tipo_estudio($nro_servicio){
        $sql = "SELECT e.nro_servicio, e.tipo_estudio_id FROM estudio e WHERE e.nro_servicio = ?";
        $query = $this->db2->query($sql, array($nro_servicio));
        return $query->row_array();
    }

    public function obtener_datos_ficha($nro_servicio) {
        $sql = "SELECT e.nro_servicio AS n_servicio,
                       e.fecha_carga AS fecha,
                       CONCAT(p.nombres, ' ', p.apellidos) AS paciente,
                       p.documento AS documento,
                       p.obra_social AS obra_social,
                       TIMESTAMPDIFF(YEAR, p.fecha_nacimiento, CURDATE()) AS edad,
                       e.medico_solicitante AS medico_solicitante,
                       e.material AS material,
                       e.diagnostico_presuntivo AS antecedentes,
                       de.macro,
                       de.micro,
                       de.diagnostico_presuntivo AS diagnostico,
                       tde.nombre AS tipo_estudio,
                       tde.id as tipo_estudio_id
                FROM estudio e
                INNER JOIN personal p ON e.personal_id = p.id
                INNER JOIN detalle_estudio de ON e.detalle_estudio_id = de.id
                INNER JOIN tipo_de_estudio tde ON e.tipo_estudio_id = tde.id
                WHERE e.nro_servicio = ?
                ORDER BY e.nro_servicio";
        $query = $this->db2->query($sql, array($nro_servicio));
        return $query->row_array();
    }

    public function obtener_datos_pap($nro_servicio) {
        $sql = "SELECT  e.nro_servicio AS n_servicio,
                        e.fecha_carga AS fecha,
                        CONCAT(p.nombres, ' ', p.apellidos) AS paciente,
                        p.documento AS documento,
                        p.obra_social AS obra_social,
                        TIMESTAMPDIFF(YEAR, p.fecha_nacimiento, CURDATE()) AS edad,
                        e.medico_solicitante AS medico_solicitante,
                        e.material AS material,
                        e.diagnostico_presuntivo AS antecedentes,
                        dp.tipo_estudio_id AS tipo_estudio_id,
                        dp.estado_especimen AS estado_especimen,
                        dp.celulas_pavimentosas AS celulas_pavimentosas,
                        dp.celulas_cilindricas AS celulas_cilindricas,
                        dp.valor_hormonal AS valor_hormonal,
                        DATE_FORMAT(dp.fecha_lectura, '%d/%m/%Y') AS fecha_lectura,
                        dp.valor_hormonal_HC AS valor_hormonal_HC,
                        dp.cambios_reactivos AS cambios_reactivos,
                        dp.cambios_asoc_celula_pavimentosa AS cambios_asoc_celula_pavimentosa,
                        dp.cambios_celula_glandulares AS cambios_celula_glandulares,
                        dp.celula_metaplastica AS celula_metaplastica, 
                        dp.otras_neo_malignas AS otras_neo_malignas,
                        dp.toma AS toma, 
                        dp.recomendaciones AS recomendaciones,
                        dp.microorganismos AS microorganismos,
                        dp.resultado AS resultado
                    FROM estudio e
                    INNER JOIN personal p ON e.personal_id = p.id
                    INNER JOIN detalle_pap dp ON e.detalle_pap_id = dp.id

                    WHERE e.nro_servicio = ?
                    ORDER BY e.nro_servicio";

        $query = $this->db2->query($sql, array($nro_servicio));
        return $query->row_array();
    }

    public function obtener_ultimo_registro_pap() {
        $sql = "SELECT dp.createdAt, dp.createdBy, u.nombres, u.apellidos, e.nro_servicio, 'Pap' as tipo_estudio
                FROM detalle_pap dp
                INNER JOIN usuario u ON u.id = dp.createdBy
                INNER JOIN estudio e ON e.detalle_pap_id = dp.id
                ORDER BY dp.createdAt DESC
                LIMIT 5";
        $query = $this->db2->query($sql);
        return $query->result();
    }
    
    public function obtener_ultimo_registro_estudio() {
        $sql = "SELECT de.createdAt, de.createdBy, tde.nombre as tipo_estudio, u.nombres, u.apellidos, e.nro_servicio
                FROM detalle_estudio de
                JOIN usuario u ON u.id = de.createdBy
                JOIN tipo_de_estudio tde ON tde.id = de.tipo_estudio_id
                JOIN estudio e ON e.detalle_estudio_id = de.id
                ORDER BY de.createdAt DESC
                LIMIT 5";
        $query = $this->db2->query($sql);
        return $query->result();
    }


}
