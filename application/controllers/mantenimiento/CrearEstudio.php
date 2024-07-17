<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CrearEstudio extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Estudio_model');
        $this->load->model('Paciente_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $profesional_salutte_ids = array(106780, 198041);
        $data['profesionales'] = $this->Paciente_model->obtener_profesionales($profesional_salutte_ids);
        $data['servicios_salutte'] = $this->Paciente_model->obtener_servicios_desde_salutte();
        $data['nombre_servicio'] = $this->Paciente_model->obtener_servicios_desde_salutte();
        $this->load->view('layouts/header');
        $this->load->view('layouts/aside');
        $this->load->view('crear_estudio_view', $data);
        $this->load->view('layouts/footer');
    }

    public function guardar() {
        // Validación del formulario
        $this->form_validation->set_rules('n_servicio', 'Número de Servicio', 'required');
        $this->form_validation->set_rules('documento_paciente', 'Documento del Paciente', 'required');
        $this->form_validation->set_rules('profesional', 'Profesional', 'required');
        $this->form_validation->set_rules('servicio_salutte_id', 'Servicio Salutte ID');
        $this->form_validation->set_rules('nombre_servicio', 'Nombre del Servicio');
        $this->form_validation->set_rules('tipo_estudio', 'Tipo de Estudio', 'required');
        $this->form_validation->set_rules('fecha', 'Fecha');
        $this->form_validation->set_rules('diagnostico', 'Diagnostico');
        $this->form_validation->set_rules('solicitante', 'Profesional Solicitante');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Por favor complete todos los campos obligatorios.');
            redirect(base_url('crearEstudio'));
        }

        $this->db2 = $this->load->database('second_db', TRUE);

        // Datos recibidos del formulario
        $nro_servicio = $this->input->post('n_servicio');
        $documento_paciente = $this->input->post('documento_paciente');
        $profesional_salutte_id = $this->input->post('profesional');
        $servicio_salutte_id = $this->input->post('servicio_salutte_id');
        $nombre_servicio = $this->input->post('nombre_servicio');
        $tipo_estudio_id = $this->input->post('tipo_estudio');
        $material = $this->input->post('material');
        $codigos_nomenclador = $this->input->post('codigos');
        $fecha = $this->input->post('fecha');
        $diagnostico = $this->input->post('diagnostico');
        $solicitante = $this->input->post('solicitante');

        log_message('debug', "Valor de nombre_servicio recibido: " . $nombre_servicio);

        // Iniciar transacción
        $this->db2->trans_start();

        try {
            // Obtener o insertar el paciente en `db-sistema-ap`
            $personal_id = $this->obtener_o_insertar_paciente($documento_paciente);

            // Obtener el ID del profesional desde `db-sistema-ap`
            $profesional_id = $this->obtener_id_profesional($profesional_salutte_id);

            // Insertar o obtener el servicio en `db-sistema-ap`
            $servicio_id = $this->obtener_o_insertar_servicio($servicio_salutte_id, $nombre_servicio);

            // Datos del estudio
            $data_estudio = array(
                'nro_servicio' => $nro_servicio,
                'personal_id' => $personal_id,
                'profesional_id' => $profesional_id,
                'servicio_id' => $servicio_id,
                'tipo_estudio_id' => $tipo_estudio_id,
                'estado_estudio' => 'creado',
                'material' => $material,
                'fecha_carga' => $fecha,
                'diagnostico_presuntivo' => $diagnostico,
                'medico_solicitante' => $solicitante,
                'createdBy' => $this->session->userdata('id')
            );

            // Insertar el estudio
            $this->Estudio_model->insertar_estudio($data_estudio);

            // Insertar los códigos de nomenclador asociados
            if (!empty($codigos_nomenclador)) {
                foreach ($codigos_nomenclador as $codigo) {
                    $codigo_data = array(
                        'nro_servicio' => $nro_servicio,
                        'codigo' => $codigo
                    );
                    $this->Estudio_model->insertar_codigo_nomenclador_ap($codigo_data); 
                }
            }

            // Commit de la transacción
            $this->db2->trans_commit();

            $this->session->set_flashdata('success', 'Estudio creado exitosamente');
            redirect(base_url('crearEstudio'));
        } catch (Exception $e) {
            // Rollback en caso de error
            $this->db2->trans_rollback();

            $this->session->set_flashdata('error', 'Ocurrió un error al crear el estudio: ' . $e->getMessage());
            redirect(base_url('crearEstudio'));
        }
    }

    // Función para obtener o insertar el paciente en `db-sistema-ap`
    private function obtener_o_insertar_paciente($documento_paciente) {
        $paciente = $this->Paciente_model->obtener_paciente_por_documento($documento_paciente);

        if ($paciente) {
            // Verificar si ya existe el registro en la tabla personal
            $this->db2->select('id');
            $this->db2->from('personal');
            $this->db2->where('persona_salutte_id', $paciente->id);
            $query = $this->db2->get();

            if ($query->num_rows() > 0) {
                return $query->row()->id;
            } else {
                // Insertar el nuevo registro en la tabla personal
                $this->db2->insert('personal', [
                    'persona_salutte_id' => $paciente->id,
                    'nombres' => $paciente->nombres,
                    'apellidos' => $paciente->apellidos,
                    'obra_social' =>$paciente->obra_social,
                    'fecha_nacimiento' =>$paciente->fecha_nacimiento,
                    'documento' =>$paciente->documento,
                    'genero' =>$paciente->genero,
                ]);

                // Obtener el ID del paciente insertado
                return $this->db2->insert_id();
            }
        } else {
            throw new Exception('No se encontró el paciente con el documento proporcionado.');
        }
    }

    // Función para obtener el ID del profesional desde `db-sistema-ap`
    private function obtener_id_profesional($profesional_salutte_id) {
        $this->db2->select('id');
        $this->db2->from('profesional');
        $this->db2->where('profesional_salutte_id', $profesional_salutte_id);
        $query = $this->db2->get();

        if ($query->num_rows() > 0) {
            return $query->row()->id;
        } else {
            throw new Exception('No se encontró el ID del profesional en la base de datos.');
        }
    }

    // Función para insertar o obtener el servicio en `db-sistema-ap`
    private function obtener_o_insertar_servicio($servicio_salutte_id, $nombre_servicio) {
        // Obtener el servicio desde db_salutte
        $servicio = $this->Paciente_model->obtener_servicio($servicio_salutte_id);
    
        // Si se encontró el servicio en db_salutte, usar su nombre
        if ($servicio) {
            $nombre_servicio = $servicio['nombre_servicio'];
        }
    
        // Consultar si el servicio ya existe en db2
        $this->db2->select('id');
        $this->db2->from('servicio');
        $this->db2->where('servicio_salutte_id', $servicio_salutte_id);
        $query = $this->db2->get();
    
        if ($query->num_rows() > 0) {
            // Si existe, retornar su ID
            return $query->row()->id;
        } else {
            // Si no existe, insertarlo y retornar el ID insertado
            $this->db2->insert('servicio', [
                'nombre_servicio' => $nombre_servicio,
                'servicio_salutte_id' => $servicio_salutte_id,
            ]);
    
            // Obtener el ID del servicio insertado
            return $this->db2->insert_id();
        }
    }
    // Función para insertar los códigos de nomenclador asociados
    

    public function get_n_servicio() {
        $ultimo_servicio = $this->Estudio_model->obtener_ultimo_servicio();
        $nuevo_servicio = $ultimo_servicio + 1;
        echo $nuevo_servicio;
    }

    public function buscar_paciente() {
        $documento = $this->input->post('documento');
        echo "Documento recibido: " . $documento;
        $paciente = $this->Paciente_model->obtener_paciente_por_documento($documento);
        if ($paciente) {
            echo '<p>id: ' . $paciente->id . '</p>';
            echo '<p>Nombre: ' . $paciente->nombres . '</p>';
            echo '<p>Apellido: ' . $paciente->apellidos . '</p>';
            echo '<p>Fecha Nac: ' . $paciente->fecha_nacimiento . '</p>';
            echo '<button type="button" class="btn btn-primary" onclick="seleccionarPaciente(\'' . $paciente->nombres . ' ' . $paciente->apellidos . '\')">Seleccionar</button>';
            echo '<p></p>';
        } else {
            echo '<p>No se encontró ningún paciente con ese documento.</p>';
        }
    }


    public function obtener_ultimo_registro() {
        $data['registros'] = $this->Estudio_model->obtener_ultimo_registro();
        echo json_encode($data);
    }
}



