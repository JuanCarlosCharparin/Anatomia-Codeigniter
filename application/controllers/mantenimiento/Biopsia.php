<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Biopsia extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Biopsia_model');
        $this->load->helper('url');
    }

    public function getEditModalContent($n_servicio) {
        try {
        
            $estudio = $this->Biopsia_model->buscarPorNServicio($n_servicio);
            if ($estudio) {
                
                /*$datos_paciente = $this->Biopsia_model->obtenerDatosDePaciente($estudio['paciente_id']);
                if ($datos_paciente) {
                    $datos_paciente['edad'] = $this->calcularEdad($datos_paciente['fecha_nacimiento']);
                    if (isset($datos_paciente['sexo'])) {
                        $datos_paciente['sexo'] = $this->convertirGenero($datos_paciente['sexo']);
                    } else {
                        $datos_paciente['sexo'] = 'desconocido'; 
                    }
                }*/
                $estudio['edad'] = $this->calcularEdad($estudio['fecha_nacimiento']);
                $estudio['sexo'] = $this->convertirGenero($estudio['genero']);
                
                $data = array_merge($estudio);
                $html = $this->load->view('biopsia_edit', ['estudio' => $data], true);
                $response = ['html' => $html];
                echo json_encode($response);
            } else {
                $response = ['error' => 'Estudio no encontrado'];
                echo json_encode($response);
            }
        } catch (Exception $e) {
            $response = ['error' => 'Ocurrió un error al obtener el estudio: ' . $e->getMessage()];
            echo json_encode($response);
        }
    }

    private function convertirGenero($sexo) {
        switch ($sexo) {
            case 'm':
                return 'masculino';
            case 'f':
                return 'femenino';
            default:
                return 'desconocido';
        }
    }

    private function calcularEdad($fecha_nacimiento) {
        $fecha_nacimiento = new DateTime($fecha_nacimiento);
        $hoy = new DateTime();
        $edad = $hoy->diff($fecha_nacimiento);
        return $edad->y;
    }


    //Actualizar los datos en la db

    public function updateEstudio() {
        try {
            $n_servicio = $this->input->post('n_servicio');
            $data = [
                'servicio' => $this->input->post('servicio'),
                'tipo_estudio' => $this->input->post('tipo_estudio'),
                'diagnostico' => $this->input->post('diagnostico'),
                'fecha_carga' => $this->input->post('fecha_carga'),
                'estado_estudio' => $this->input->post('estado'),
                'macro' => $this->input->post('macro')
            ];
    
            $result = $this->Biopsia_model->actualizarEstudio($n_servicio, $data);

            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Ocurrió un error al actualizar el estudio: ' . $e->getMessage()]);
        }
    }

}
    