<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pacientes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Paciente_model');
    }

    public function index() {
        $this->load->view('layouts/header');
        $this->load->view('layouts/aside');
        $this->load->view('formulario_paciente');
        $this->load->view('layouts/footer');
    }
}
