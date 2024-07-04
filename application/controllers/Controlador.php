<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controlador extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('modelo');
    }

	public function index()
	{
        $this->load->view('principal_view');
	}

    public function agregar(){

    }

    public function listar(){
        $data['personas'] = $this->modelo->obtener_todos();
		$this->load->view('listar_view', $data);
    }
}