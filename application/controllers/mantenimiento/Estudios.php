<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Estudios extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Estudio_model');
    }

    public function index() {
        $this->load->view('layouts/header');
        $this->load->view('layouts/aside');
        $this->load->view('estudio_view');
        $this->load->view('layouts/footer');
    }

    public function filtrar() {
        // Recibir datos del formulario de filtrado
        $filtros = array(
            'n_servicio' => $this->input->post('n_servicio'),
            'servicio' => $this->input->post('servicio'),
            'tipo_estudio' => $this->input->post('tipo_estudio'),
            'paciente' => $this->input->post('paciente'),
            'fecha_carga' => $this->input->post('fecha'),
            'estado' => $this->input->post('estado'),
            'obra_social' => $this->input->post('obra_social'),
            'profesional' => $this->input->post('profesional'),
        );
    
        // Filtrar estudios con los datos recibidos
        $data['resultados'] = $this->Estudio_model->filtrar_estudios($filtros);
        

        // Obtener datos del paciente si se ha filtrado por paciente
        if (!empty($filtros['paciente'])) {
            $data['paciente'] = $this->Estudio_model->obtener_paciente($filtros['paciente']);
            var_dump($data['paciente']);
        }
    
        // Cargar vistas con los resultados
        $this->load->view('layouts/header');
        $this->load->view('layouts/aside');
        $this->load->view('resultados_view', $data);
        $this->load->view('layouts/footer');
    }
}

    



