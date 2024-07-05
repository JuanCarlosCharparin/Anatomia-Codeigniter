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

    public function adjuntarDetalle($tipo_estudio_id){
        $this->db2 = $this->load->database('second_db', TRUE);
        $tipo_estudio = $this->input->post('tipo_estudio');
        if ($$tipo_estudio == 'Pap') {
            // Tipo de estudio es Pap, guardar en detalle_pap
            $estado_especimen = $this->input->post('estado_especimen');
            $celulas_pavimentosas = $this->input->post('celulas_pavimentosas');
            $celulas_cilindricas = $this->input->post('celulas_cilindricas');
            $valor_hormonal = $this->input->post('valor_hormonal');
            $fecha_lectura = $this->input->post('fecha_lectura');
            $valor_hormonal_HC = $this->input->post('valor_hormonal_HC');
            $cambios_reactivos = $this->input->post('cambios_reactivos');
            $cambios_asoc_celula_pavimentosa = $this->input->post('cambios_asoc_celula_pavimentosa');
            $cambios_celula_glandulares = $this->input->post('cambios_celula_glandulares');
            $celula_metaplastica = $this->input->post('celula_metaplastica');
            $otras_neo_malignas = $this->input->post('otras_neo_malignas');
            $toma = $this->input->post('toma');
            $recomendaciones = $this->input->post('recomendaciones');
            $microorganismos = $this->input->post('microorganismos');
            $resultado = $this->input->post('resultado');

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

            $this->Biopsia_model->insertar_pap($data_pap);
        
        } else {

            $macro = $this->input->post('macro');
            $micro = $this->input->post('micro');
            $conclusion = $this->input->post('conclusion');
            $observacion = $this->input->post('observacion');
            $maligno = $this->input->post('maligno');
            $guardado = $this->input->post('guardado');
            $observacion_interna = $this->input->post('observacion_interna');
            $recibe = $this->input->post('recibe');
            $tacos = $this->input->post('tacos');
            $diagnostico_presuntivo = $this->input->post('diagnostico_presuntivo');
            $tecnicas = $this->input->post('tecnicas');
            $material = $this->input->post('material');
            $tipo_estudio_id = $this->input->post('tipo_estudio_id');

           
            // Otros tipos de estudio, guardar en detalle_estudio
            $data_detalle = array(
                'macro' => $macro,
                'micro' => $micro,
                'conclusion' => $conclusion,
                'observacion' => $observacion,
                'maligno' => $maligno,
                'guardado' => $guardado,
                'observacion_interna' => $observacion_interna,
                'recibe' => $recibe,
                'tacos' => $tacos,
                'diagnostico_presuntivo' => $diagnostico_presuntivo,
                'tecnicas' => $tecnicas,
                'material' => $material,
                'tipo_estudio_id' => $tipo_estudio_id
                
            );

            $this->Biopsia_model->insertar_detalle($data_detalle);
        }
    }

}
    