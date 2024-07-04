<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empleado_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_empleados() {
        $this->db->select('e.id AS empleado_id, e.empresa, e.puesto, e.fecha_inicio, e.fecha_fin, p.nombres, p.apellidos');
        $this->db->from('empleado e');
        $this->db->join('persona p', 'e.persona_id = p.id');
        $query = $this->db->get();
        
        return $query->result_array();
    }
}