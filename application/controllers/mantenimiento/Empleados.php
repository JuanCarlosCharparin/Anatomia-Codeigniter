<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empleados extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Empleado_model'); // Carga el modelo Empleado_model
    }

    public function index() {
        $data['empleados'] = $this->Empleado_model->get_empleados(); /// Obtener datos de empleados desde el modelo
        $this->load->view('layouts/header');
        $this->load->view('layouts/aside');
        $this->load->view('empleado_view', $data); // Cargar la vista y pasar los datos
        $this->load->view('layouts/footer');
    }
}

