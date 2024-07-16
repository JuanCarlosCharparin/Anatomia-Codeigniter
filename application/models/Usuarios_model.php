<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db2 = $this->load->database('second_db', TRUE);
    }

	public function login($username, $password){
        $this->db2->where("username", $username);
        $this->db2->where("password", $password);

        $resultados = $this->db2->get("usuario");
        if ($resultados->num_rows() > 0){
            return $resultados->row();
        }
        else {
            return false;
        }
    }
}
