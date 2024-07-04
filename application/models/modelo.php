<?php
class Modelo extends CI_Model { 

    public function __construct() {
        parent::__construct();
    }

    public function guardar($nombre, $apellido, $edad, $id=null){
        $data = array(
        'nombre' => $nombre,
        'apellido' => $apellido,
        'edad' => $apellido,
        );
        if($id){
        $this->db->where('id', $id);
        $this->db->update('persona', $data);
        }else{
        $this->db->insert('persona', $data);
        } 
    }

    public function eliminar($id){
        $this->db->where('id', $id);
        $this->db->delete('persona');
    }

    public function obtener_por_id($id){
        $this->db->select('id, nombre, apellido, edad');
        $this->db->from('persona');
        $this->db->where('id', $id);
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }

    public function obtener_todos(){
        $this->db->select('id, nombre, apellido, edad');
        $this->db->from('persona');
        $this->db->order_by('apellido', 'asc');
        $consulta = $this->db->get();
        $resultado = $consulta->result();
        return $resultado;
    }
    
}