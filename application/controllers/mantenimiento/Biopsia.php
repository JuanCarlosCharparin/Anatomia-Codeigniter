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
                'material' => $this->input->post('material'),
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

    //Agregar el detalle de estudio

    public function adjuntarDetalle() {
        try {
            $this->db2 = $this->load->database('second_db', TRUE);
            $tipo_estudio = $this->input->post('tipo_estudio_id');
    
            $n_servicio = $this->input->post('n_servicio');
    
            if ($tipo_estudio == 3) {  // Si es PAP
                // Asegurémonos de que las variables que se pasan a implode sean arrays
                $estado_especimen = is_array($this->input->post('estado_especimen')) ? implode(',', $this->input->post('estado_especimen')) : '';
                $celulas_pavimentosas = is_array($this->input->post('celulas_pavimentosas')) ? implode(',', $this->input->post('celulas_pavimentosas')) : '';
                $celulas_cilindricas = is_array($this->input->post('celulas_cilindricas')) ? implode(',', $this->input->post('celulas_cilindricas')) : '';
                $valor_hormonal = $this->input->post('valor_hormonal');
                $fecha_lectura = $this->input->post('fecha_lectura');
                $valor_hormonal_HC = $this->input->post('valor_hormonal_HC');
                $cambios_reactivos = is_array($this->input->post('cambios_reactivos')) ? implode(',', $this->input->post('cambios_reactivos')) : '';
                $cambios_asoc_celula_pavimentosa = is_array($this->input->post('cambios_asoc_celula_pavimentosa')) ? implode(',', $this->input->post('cambios_asoc_celula_pavimentosa')) : '';
                $cambios_celula_glandulares = $this->input->post('cambios_celula_glandulares');
                $celula_metaplastica = is_array($this->input->post('celula_metaplastica')) ? implode(',', $this->input->post('celula_metaplastica')) : '';
                $otras_neo_malignas = $this->input->post('otras_neo_malignas'); // No se usa implode para este campo
                $toma = is_array($this->input->post('toma')) ? implode(',', $this->input->post('toma')) : '';
                $recomendaciones = is_array($this->input->post('recomendaciones')) ? implode(',', $this->input->post('recomendaciones')) : '';
                $microorganismos = is_array($this->input->post('microorganismos')) ? implode(',', $this->input->post('microorganismos')) : '';
                $resultado = is_array($this->input->post('resultado')) ? implode(',', $this->input->post('resultado')) : '';
    
                // Ajustar el uso de implode para campos que realmente requieren arrays
                $data_pap = array(
                    'estado_especimen' => $estado_especimen,
                    'celulas_pavimentosas' => $celulas_pavimentosas,
                    'celulas_cilindricas' => $celulas_cilindricas,
                    'valor_hormonal' => $valor_hormonal,
                    'fecha_lectura' => $fecha_lectura,
                    'valor_hormonal_HC' => $valor_hormonal_HC,
                    'cambios_reactivos' => $cambios_reactivos,
                    'cambios_asoc_celula_pavimentosa' => $cambios_asoc_celula_pavimentosa,
                    'cambios_celula_glandulares' => $cambios_celula_glandulares,
                    'celula_metaplastica' => $celula_metaplastica,
                    'otras_neo_malignas' => $otras_neo_malignas,
                    'toma' => $toma,
                    'recomendaciones' => $recomendaciones,
                    'microorganismos' => $microorganismos,
                    'resultado' => $resultado
                );
    
                $result = $this->Biopsia_model->insertar_pap($data_pap);
                $detalle_pap_id = $this->Biopsia_model->ultimoPapInsertado();
    
                // Actualizar el registro de estudio con el detalle_pap_id
                $result_pap = $this->Biopsia_model->actualizarPapId($n_servicio, $detalle_pap_id);
    
            } else {
                // Para otros tipos de estudio que no sean PAP
                $data_detalle = array(
                    'macro' => $this->input->post('macro'),
                    'micro' => $this->input->post('micro'),
                    'conclusion' => $this->input->post('conclusion'),
                    'observacion' => $this->input->post('observacion'),
                    'maligno' => $this->input->post('maligno'), // Agrega este campo si aplica
                    'guardado' => $this->input->post('guardado'),
                    'observacion_interna' => $this->input->post('observacion_interna'),
                    'recibe' => $this->input->post('recibe'),
                    'tacos' => $this->input->post('tacos'),
                    'diagnostico_presuntivo' => $this->input->post('diagnostico_presuntivo'),
                    'tecnicas' => $this->input->post('tecnicas'),
                    'material' => $this->input->post('material'),
                    'tipo_estudio_id' => $this->input->post('tipo_estudio_id')
                );
    
                $result = $this->Biopsia_model->insertar_detalle($data_detalle);
                $detalle_estudio_id = $this->Biopsia_model->ultimoDetalleInsertado();
    
                // Actualizar el registro de estudio con el detalle_estudio_id
                $result_detalle = $this->Biopsia_model->actualizarDetalleId($n_servicio, $detalle_estudio_id);
            }
    
            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Ocurrió un error al adjuntar el detalle: ' . $e->getMessage()]);
        }
    }

}
    