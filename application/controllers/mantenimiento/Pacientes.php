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


    public function buscar_paciente() {
        $criterio = $this->input->post('criterio');
        $pacientes = $this->Paciente_model->obtener_pacientes($criterio);
        $html = '';
    
        if (!empty($pacientes)) {
            $html .= '<div class="table-responsive">';
            $html .= '<table class="table table-bordered">';
            $html .= '<thead>';
            $html .= '<tr>';
            $html .= '<th>Nombre</th>';
            $html .= '<th>Apellido</th>';
            $html .= '<th>Fecha de Nacimiento</th>';
            $html .= '<th>Obra Social</th>';
            $html .= '<th>Documento</th>';
            $html .= '<th>Género</th>';
            $html .= '<th>Celular</th>';
            $html .= '<th>Dirección</th>';
            $html .= '<th>País</th>';
            $html .= '<th>Provincia</th>';
            $html .= '<th>Ciudad</th>';
            $html .= '<th>Barrio</th>';
            $html .= '</tr>';
            $html .= '</thead>';
            $html .= '<tbody>';
            foreach ($pacientes as $paciente) {
                $html .= '<tr>';
                $html .= '<td>' . $paciente['nombres'] . '</td>';
                $html .= '<td>' . $paciente['apellidos'] . '</td>';
                $html .= '<td>' . $paciente['fecha_nacimiento'] . '</td>';
                $html .= '<td>' . $paciente['obra_social'] . '</td>';
                $html .= '<td>' . $paciente['documento'] . '</td>';
                $html .= '<td>' . $paciente['genero'] . '</td>';
                $html .= '<td>' . $paciente['celular'] . '</td>';
                $html .= '<td>' . $paciente['direccion'] . '</td>';
                $html .= '<td>' . $paciente['nombre_pais'] . '</td>';
                $html .= '<td>' . $paciente['nombre_provincia'] . '</td>';
                $html .= '<td>' . $paciente['nombre_ciudad'] . '</td>';
                $html .= '<td>' . $paciente['nombre_barrio'] . '</td>';
                $html .= '</tr>';
            }
            $html .= '</tbody>';
            $html .= '</table>';
            $html .= '</div>';
        } else {
            $html .= '<p>No se encontraron pacientes con el criterio proporcionado.</p>';
        }
    
        echo $html;
    }
    
}
