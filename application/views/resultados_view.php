<div class="content-wrapper">
    <section class="content-header">
        <h1>Resultados de la búsqueda</h1>
    </section>
    <section class="content">
        <div class="box box-solid">
            <div class="box-body">
                
                <?php if (!empty($resultados)): ?>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th>N° Servicio</th>
                                <th>Servicio</th>
                                <th>Tipo Estudio</th>
                                <th>Paciente</th>
                                <th>Obra Social</th>
                                <th>Diagnóstico</th>
                                <th>Fecha Carga</th>
                                <th>Profesional Solicitante</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultados as $resultado): ?>
                                <tr>
                                    <td>
                                        <button class="btn btn-primary btn-sm btn-edit"
                                            data-n_servicio="<?php echo $resultado['n_servicio']; ?>">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <a href="<?php echo base_url('mantenimiento/reportePdf/generar_pdf/' . $resultado['n_servicio']); ?>" class="btn btn-primary btn-sm" target="_blank">
                                            <i class="fa fa-file-pdf-o"></i>
                                        </a>
                                        <style>
                                            .btn-sm {
                                                padding: 2px 6px;
                                                border-radius: 3px;
                                            }
                                            .btn-sm .fa-file-pdf-o {
                                                font-size: 12px;
                                            }
                                            
                                            .btn-edit {
                                                padding: 2px 6px;
                                                border-radius: 3px;
                                            }

                                            .btn-edit .fa-edit {
                                                font-size: 12px;
                                            }
                                        </style>
                                    </td>
                                    <td><?php echo $resultado['n_servicio']; ?></td>
                                    <td><?php echo $resultado['servicio']; ?></td>
                                    <td id="tipo_estudio"><?php echo htmlspecialchars($resultado['tipo_estudio']); ?></td>
                                    <td>
                                        <?php echo $resultado['paciente']; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($resultado['paciente'])): ?>
                                            <?php echo $resultado['obra_social']; ?>
                                        <?php else: ?>
                                            Obra social no definida
                                        <?php endif; ?>
                                    </td>
                                    <td><?php /* echo $resultado['diagnostico']; */ ?></td>
                                    <td>
                                        <?php 
                                            $fecha_carga = new DateTime($resultado['fecha_carga']);
                                            echo $fecha_carga->format('d-m-Y'); 
                                        ?>
                                    </td>
                                    <td>
                                    <?php echo $resultado['profesional']; ?>
                                    </td>
                                    <td><?php echo $resultado['estado']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-info">
                        No se encontraron resultados.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>


<!-- Modal Structure -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> <!-- modal-lg para hacerlo más grande -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Biopsia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Aquí va el contenido del modal-body -->
            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-primary" id="saveChanges">Finalizar</button>
                <p></p>
                <hr>
                <button type="button" class="btn btn-success" id="actualizarDatos">Actualizar</button>
                <p></p>
                <hr>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <!--button type="button" class="btn btn-secondary" id="limpiarDatos">Limpiar</button-->
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    // Delegar el evento click al documento para el botón #saveChanges
    $(document).on('click', '#saveChanges', function() {
        var formData = $('#editEstudioForm').serialize();
        $.ajax({
            url: '<?php echo base_url(); ?>mantenimiento/Biopsia/adjuntarDetalle',
            type: 'POST',
            data: formData,
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    var n_servicio = $('#n_servicio').val(); // Obtener el número de servicio
                    localStorage.setItem('isDataSaved_' + n_servicio, true); // Indicar que los datos han sido guardados de forma irreversible
                    cambiarEstadoEstudioFinalizado(n_servicio)
                    Swal.fire({
                        icon: 'success',
                        title: '¡Datos guardados!',
                        text: '¡Datos guardados para el número de servicio ' + n_servicio + '!',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar',
                        timer: 3000,
                    }).then((result) => {
                        $('#editModal').modal('hide');
                        window.location.href = window.location.href; // Redireccionar a la misma página
                    });
                } else {
                    alert('Error al guardar los datos');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la petición AJAX:', error);
            }
        });
    });

    // Mostrar modal con datos cargados
    $('.btn-edit').on('click', function () {
        let n_servicio = $(this).data('n_servicio');
        $.ajax({
            url: '<?php echo base_url(); ?>mantenimiento/Biopsia/getEditModalContent/' + n_servicio,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.html) {
                    $('#editModal .modal-body').html(response.html);
                    $('#editModal').modal('show');

                    // Cargar datos desde localStorage
                    cargarDatos(n_servicio);

                    // Deshabilitar campos según el estado del estudio
                    if (response.estudio_finalizado) {
                        $('#editModal .modal-body input, #editModal .modal-body textarea, #editModal .modal-body select, #limpiarDatos')
                            .prop('disabled', true)
                            .css('background-color', '#e9ecef');
                    } else if (localStorage.getItem('isDataSaved_' + n_servicio)) {
                        $('#editModal .modal-body input, #editModal .modal-body textarea, #editModal .modal-body select, #limpiarDatos')
                            .prop('disabled', true)
                            .css('background-color', '#e9ecef');
                    }
                } else if (response.error) {
                    alert(response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la petición AJAX:', error);
            }
        });
    });

    function toggleDetalle() {
        var tipoEstudio = $('#tipo_estudio').val();
        if (tipoEstudio === 'Biopsia') {
            $('#detalle_estudio').show();
            $('#pap_estudio').hide(); // Ocultar otro detalle si es necesario
        } else {
            $('#detalle_estudio').hide();
            $('#pap_estudio').show(); // Mostrar otro detalle si es necesario
        }
    }
    toggleDetalle(); // Inicializar visibilidad de los campos

    // Cambiar visibilidad de los campos al cambiar el tipo de estudio
    $('#tipo_estudio').on('change', toggleDetalle);

    // Función para guardar datos en localStorage
    function guardarDatos(n_servicio) {
        var tipoEstudio = $('#tipo_estudio').text().trim();
        var prefix = 'datos_' + n_servicio + '_';

        // Obtener los datos existentes de localStorage si los hay
        var savedData = localStorage.getItem(prefix + 'data');
        var dataToSave = {};

        if (savedData) {
            dataToSave = JSON.parse(savedData);
        }

        // Función para guardar el valor de un select2 en localStorage
        function guardarSelect2(key, selector) {
            var selectedOptions = $(selector).val(); // Obtener valores seleccionados como array
            dataToSave[key] = selectedOptions; // Almacenar en el objeto
        }

        // Guardar datos según el tipo de estudio
        if (tipoEstudio === 'Pap') {
            guardarSelect2('estado_especimen', '#estado_especimen');
            guardarSelect2('celulas_pavimentosas', '#celulas_pavimentosas');
            guardarSelect2('celulas_cilindricas', '#celulas_cilindricas');
            guardarSelect2('valor_hormonal', '#valor_hormonal');
            guardarSelect2('fecha_lectura', '#fecha_lectura');
            guardarSelect2('valor_hormonal_HC', '#valor_hormonal_HC');
            guardarSelect2('cambios_reactivos', '#cambios_reactivos');
            guardarSelect2('cambios_asoc_celula_pavimentosa', '#cambios_asoc_celula_pavimentosa');
            guardarSelect2('cambios_celula_glandulares', '#cambios_celula_glandulares');
            guardarSelect2('celula_metaplastica', '#celula_metaplastica');
            guardarSelect2('otras_neo_malignas', '#otras_neo_malignas');
            guardarSelect2('toma', '#toma');
            guardarSelect2('recomendaciones', '#recomendaciones');
            guardarSelect2('microorganismos', '#microorganismos');
            guardarSelect2('resultado', '#resultado');
        } else {
            dataToSave.macro = $('#macro').val();
            dataToSave.micro = $('#micro').val();
            dataToSave.conclusion = $('#conclusion').val();
            dataToSave.observacion = $('#observacion').val();
            dataToSave.maligno = $('#maligno').val();
            dataToSave.guardado = $('#guardado').val();
            dataToSave.observacion_interna = $('#observacion_interna').val();
            dataToSave.recibe = $('#recibe').val();
            dataToSave.tacos = $('#tacos').val();
            dataToSave.diagnostico_presuntivo = $('#diagnostico_presuntivo').val();
            dataToSave.tecnicas = $('#tecnicas').val();
        }

        // Guardar el objeto completo actualizado en localStorage
        localStorage.setItem(prefix + 'data', JSON.stringify(dataToSave));
    }

    // Función para cargar datos desde localStorage
    function cargarDatos(n_servicio) {
        var tipoEstudio = $('#tipo_estudio').text().trim();
        var prefix = 'datos_' + n_servicio + '_';

        // Obtener los datos guardados como objeto desde localStorage
        var savedData = localStorage.getItem(prefix + 'data');
        if (savedData) {
            var dataToLoad = JSON.parse(savedData);

            // Función para cargar el valor de un select2 desde el objeto
            function cargarSelect2(key, selector) {
                var selectedOptions = dataToLoad[key]; // Obtener valores guardados
                if (selectedOptions) {
                    $(selector).val(selectedOptions).trigger('change'); // Establecer opciones seleccionadas y actualizar select2
                }
            }

            // Cargar datos según el tipo de estudio
            if (tipoEstudio === 'Pap') {
                cargarSelect2('estado_especimen', '#estado_especimen');
                cargarSelect2('celulas_pavimentosas', '#celulas_pavimentosas');
                cargarSelect2('celulas_cilindricas', '#celulas_cilindricas');
                cargarSelect2('valor_hormonal', '#valor_hormonal');
                cargarSelect2('fecha_lectura', '#fecha_lectura');
                cargarSelect2('valor_hormonal_HC', '#valor_hormonal_HC');
                cargarSelect2('cambios_reactivos', '#cambios_reactivos');
                cargarSelect2('cambios_asoc_celula_pavimentosa', '#cambios_asoc_celula_pavimentosa');
                cargarSelect2('cambios_celula_glandulares', '#cambios_celula_glandulares');
                cargarSelect2('celula_metaplastica', '#celula_metaplastica');
                cargarSelect2('otras_neo_malignas', '#otras_neo_malignas');
                cargarSelect2('toma', '#toma');
                cargarSelect2('recomendaciones', '#recomendaciones');
                cargarSelect2('microorganismos', '#microorganismos');
                cargarSelect2('resultado', '#resultado');
            } else {
                $('#macro').val(dataToLoad.macro || '');
                $('#micro').val(dataToLoad.micro || '');
                $('#conclusion').val(dataToLoad.conclusion || '');
                $('#observacion').val(dataToLoad.observacion || '');
                $('#maligno').val(dataToLoad.maligno || '');
                $('#guardado').val(dataToLoad.guardado || '');
                $('#observacion_interna').val(dataToLoad.observacion_interna || '');
                $('#recibe').val(dataToLoad.recibe || '');
                $('#tacos').val(dataToLoad.tacos || '');
                $('#diagnostico_presuntivo').val(dataToLoad.diagnostico_presuntivo || '');
                $('#tecnicas').val(dataToLoad.tecnicas || '');
            }
        }
    }

    // Evento al hacer clic en el botón Actualizar
    $('#actualizarDatos').on('click', function() {
        var n_servicio = $('#n_servicio').val(); 
        
        guardarDatos(n_servicio); // Guardar datos en localStorage
        cambiarEstadoEstudio(n_servicio);
        registrarCambios(n_servicio);
        
        Swal.fire({
            icon: 'success',
            title: '¡Datos actualizados!',
            text: '¡Datos actualizados para el número de servicio ' + n_servicio + '!',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Aceptar',
            timer: 3000, 
        });
    });

    // Llamada para cargar datos cuando se abre el modal
    $('#editModal').on('shown.bs.modal', function() {
        var n_servicio = $('#n_servicio').val(); 
        cargarDatos(n_servicio); // Cargar datos desde localStorage al abrir el modal
    });

    function cambiarEstadoEstudio(n_servicio) {
        $.ajax({
            url: '<?php echo base_url(); ?>mantenimiento/Biopsia/modificarEstado/' + n_servicio,
            type: 'GET',
            data: { nuevo_estado: 'informando' }, // Aquí puedes ajustar el nuevo estado si es dinámico
            success: function(response) {
                console.log('Estado del estudio cambiado a informando');
                // Puedes agregar aquí más acciones después de actualizar el estado, como cerrar el modal o actualizar la interfaz.
            },
            error: function(xhr, status, error) {
                console.error('Error al cambiar el estado del estudio:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un error al intentar actualizar los datos.',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar',
                });
            }
        });
    }

    function cambiarEstadoEstudioFinalizado(n_servicio) {
        $.ajax({
            url: '<?php echo base_url(); ?>mantenimiento/Biopsia/modificarEstadoFinalizado/' + n_servicio,
            type: 'GET',
            data: { nuevo_estado_finalizado: 'finalizado' }, // Aquí puedes ajustar el nuevo estado si es dinámico
            success: function(response) {
                console.log('Estado del estudio cambiado a finalizado');
                // Puedes agregar aquí más acciones después de actualizar el estado, como cerrar el modal o actualizar la interfaz.
            },
            error: function(xhr, status, error) {
                console.error('Error al cambiar el estado del estudio:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un error al intentar actualizar los datos.',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar',
                });
            }
        });
    }



    function registrarCambios(n_servicio) {
    var tipoEstudio = $('#tipo_estudio').text().trim();
    var prefix = 'datos_' + n_servicio + '_';

    // Obtener los datos existentes de localStorage si los hay
    var savedData = localStorage.getItem(prefix + 'data');
    var dataToSave = {};
    var cambios = [];

    if (savedData) {
        dataToSave = JSON.parse(savedData);
    }
    
}





});
</script>





