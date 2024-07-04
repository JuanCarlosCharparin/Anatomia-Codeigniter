<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pacientes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Paciente_model');
    }

    public function index() {
        if ($this->input->post()) {
            $datos = array(
                'nombres' => $this->input->post('nombres'),
                'apellidos' => $this->input->post('apellidos'),
                'mail' => $this->input->post('mail'),
                'documento' => $this->input->post('documento'),
                'fecha_nacimiento' => $this->input->post('fecha_nacimiento'),
                'sexo' => $this->input->post('sexo'),
                'obra_social' => $this->input->post('obra_social'),
                'plan' => $this->input->post('plan'),
                'codigo_nomenclador_ap' => $this->input->post('codigo_nomenclador_ap')
            );

            // Insertar los datos en la base de datos
            $this->Paciente_model->insertar($datos);

            // Redireccionar a la página de éxito
            redirect('mantenimiento/Pacientes/exito');
        } else {
            // Si no se ha enviado el formulario, cargar la vista de formulario
            $this->load->view('layouts/header');
            $this->load->view('layouts/aside');
            $this->load->view('formulario_paciente');
            $this->load->view('layouts/footer');
        }
    }

    public function exito() {
        // Vista de éxito
        $this->load->view('layouts/header');
        $this->load->view('layouts/aside');
        $this->load->view('exito_view');
        $this->load->view('layouts/footer');
    }
}
