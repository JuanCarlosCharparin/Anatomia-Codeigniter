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
                                        <style>
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="saveChanges">Guardar cambios</button>
                <button type="button" class="btn btn-success" id="actualizarDatos">Actualizar</button>
                <button type="button" class="btn btn-secondary" id="limpiarDatos">Limpiar</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    // Delegar el evento click al documento para el botón #saveChanges
    $(document).on('click', '#saveChanges', function() {
        var formData = $('#editEstudioForm').serialize(); // Serializa los datos del formulario
        $.ajax({
            url: '<?php echo base_url(); ?>mantenimiento/Biopsia/adjuntarDetalle',
            type: 'POST',
            data: formData,
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    alert('Datos actualizados exitosamente');
                    $('#editModal').modal('hide'); // Cierra el modal
                    location.reload(); // Recarga la página para reflejar los cambios
                } else {
                    alert('Error al actualizar los datos');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la petición AJAX:', error);
            }
        });
    });

    // Manejar el evento click para abrir el modal
    $('.btn-edit').on('click', function () {
        let n_servicio = $(this).data('n_servicio');
        console.log('Clic en botón editar, n_servicio:', n_servicio);
        $.ajax({
            url: '<?php echo base_url(); ?>mantenimiento/Biopsia/getEditModalContent/' + n_servicio,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                console.log('Respuesta del servidor:', response);
                if (response.html) {
                    $('#editModal .modal-body').html(response.html);
                    $('#editModal').modal('show');
                } 
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
                console.error('Response:', xhr.responseText);
            }
        });
    });

    function toggleDetalle() {
        var tipoEstudio = $('#tipo_estudio').val();
        if (tipoEstudio === 'Biopsia') {
            $('#detalle_estudio').show();
        } else {
            $('#pap_estudio').hide();
        }
    }
    toggleDetalle(); // Inicializar visibilidad de los campos

    // Cambiar visibilidad de los campos al cambiar el tipo de estudio
    $('#tipo_estudio').on('change', toggleDetalle);

    // Función para guardar datos en localStorage
    function guardarDatos(n_servicio) {
        var tipoEstudio = $('#tipo_estudio').text().trim();

        // Prefijo para identificar los datos en localStorage por n_servicio
        var prefix = 'datos_' + n_servicio + '_';

        // Guardar datos según el tipo de estudio
        if (tipoEstudio === 'Pap') {
            localStorage.setItem(prefix + 'estado_especimen', $('#estado_especimen').val());
            localStorage.setItem(prefix + 'celulas_pavimentosas', $('#celulas_pavimentosas').val());
            localStorage.setItem(prefix + 'celulas_cilindricas', $('#celulas_cilindricas').val());
            localStorage.setItem(prefix + 'valor_hormonal', $('#valor_hormonal').val());
            localStorage.setItem(prefix + 'fecha_lectura', $('#fecha_lectura').val());
            localStorage.setItem(prefix + 'valor_hormonal_HC', $('#valor_hormonal_HC').val());
            localStorage.setItem(prefix + 'cambios_reactivos', $('#cambios_reactivos').val());
            localStorage.setItem(prefix + 'cambios_asoc_celula_pavimentosa', $('#cambios_asoc_celula_pavimentosa').val());
            localStorage.setItem(prefix + 'cambios_celula_glandulares', $('#cambios_celula_glandulares').val());
            localStorage.setItem(prefix + 'celula_metaplastica', $('#celula_metaplastica').val());
            localStorage.setItem(prefix + 'otras_neo_malignas', $('#otras_neo_malignas').val());
            localStorage.setItem(prefix + 'toma', $('#toma').val());
            localStorage.setItem(prefix + 'recomendaciones', $('#recomendaciones').val());
            localStorage.setItem(prefix + 'microorganismos', $('#microorganismos').val());
            localStorage.setItem(prefix + 'resultado', $('#resultado').val());
        } else {
            localStorage.setItem(prefix + 'macro', $('#macro').val());
            localStorage.setItem(prefix + 'micro', $('#micro').val());
            localStorage.setItem(prefix + 'conclusion', $('#conclusion').val());
            localStorage.setItem(prefix + 'observacion', $('#observacion').val());
            localStorage.setItem(prefix + 'maligno', $('#maligno').val());
            localStorage.setItem(prefix + 'guardado', $('#guardado').val());
            localStorage.setItem(prefix + 'observacion_interna', $('#observacion_interna').val());
            localStorage.setItem(prefix + 'recibe', $('#recibe').val());
            localStorage.setItem(prefix + 'tacos', $('#tacos').val());
            localStorage.setItem(prefix + 'diagnostico_presuntivo', $('#diagnostico_presuntivo').val());
            localStorage.setItem(prefix + 'tecnicas', $('#tecnicas').val());
        }
    }

    // Función para cargar datos desde localStorage
    function cargarDatos(n_servicio) {
        var tipoEstudio = $('#tipo_estudio').text().trim();

        // Prefijo para identificar los datos en localStorage por n_servicio
        var prefix = 'datos_' + n_servicio + '_';

        // Cargar datos según el tipo de estudio
        if (tipoEstudio === 'Pap') {
            $('#estado_especimen').val(localStorage.getItem(prefix + 'estado_especimen') || '');
            $('#celulas_pavimentosas').val(localStorage.getItem(prefix + 'celulas_pavimentosas') || '');
            $('#celulas_cilindricas').val(localStorage.getItem(prefix + 'celulas_cilindricas') || '');
            $('#valor_hormonal').val(localStorage.getItem(prefix + 'valor_hormonal') || '');
            $('#fecha_lectura').val(localStorage.getItem(prefix + 'fecha_lectura') || '');
            $('#valor_hormonal_HC').val(localStorage.getItem(prefix + 'valor_hormonal_HC') || '');
            $('#cambios_reactivos').val(localStorage.getItem(prefix + 'cambios_reactivos') || '');
            $('#cambios_asoc_celula_pavimentosa').val(localStorage.getItem(prefix + 'cambios_asoc_celula_pavimentosa') || '');
            $('#cambios_celula_glandulares').val(localStorage.getItem(prefix + 'cambios_celula_glandulares') || '');
            $('#celula_metaplastica').val(localStorage.getItem(prefix + 'celula_metaplastica') || '');
            $('#otras_neo_malignas').val(localStorage.getItem(prefix + 'otras_neo_malignas') || '');
            $('#toma').val(localStorage.getItem(prefix + 'toma') || '');
            $('#recomendaciones').val(localStorage.getItem(prefix + 'recomendaciones') || '');
            $('#microorganismos').val(localStorage.getItem(prefix + 'microorganismos') || '');
            $('#resultado').val(localStorage.getItem(prefix + 'resultado') || '');
        } else {
            $('#macro').val(localStorage.getItem(prefix + 'macro') || '');
            $('#micro').val(localStorage.getItem(prefix + 'micro') || '');
            $('#conclusion').val(localStorage.getItem(prefix + 'conclusion') || '');
            $('#observacion').val(localStorage.getItem(prefix + 'observacion') || '');
            $('#maligno').val(localStorage.getItem(prefix + 'maligno') || '');
            $('#guardado').val(localStorage.getItem(prefix + 'guardado') || '');
            $('#observacion_interna').val(localStorage.getItem(prefix + 'observacion_interna') || '');
            $('#recibe').val(localStorage.getItem(prefix + 'recibe') || '');
            $('#tacos').val(localStorage.getItem(prefix + 'tacos') || '');
            $('#diagnostico_presuntivo').val(localStorage.getItem(prefix + 'diagnostico_presuntivo') || '');
            $('#tecnicas').val(localStorage.getItem(prefix + 'tecnicas') || '');
        }
    }

    function limpiarDatos(n_servicio) {
        var tipoEstudio = $('#tipo_estudio').text().trim();

        // Prefijo para identificar los datos en localStorage por n_servicio
        var prefix = 'datos_' + n_servicio + '_';

        // Eliminar datos según el tipo de estudio
        if (tipoEstudio === 'Pap') {
            localStorage.removeItem(prefix + 'estado_especimen');
            localStorage.removeItem(prefix + 'celulas_pavimentosas');
            localStorage.removeItem(prefix + 'celulas_cilindricas');
            localStorage.removeItem(prefix + 'valor_hormonal');
            localStorage.removeItem(prefix + 'fecha_lectura');
            localStorage.removeItem(prefix + 'valor_hormonal_HC');
            localStorage.removeItem(prefix + 'cambios_reactivos');
            localStorage.removeItem(prefix + 'cambios_asoc_celula_pavimentosa');
            localStorage.removeItem(prefix + 'cambios_celula_glandulares');
            localStorage.removeItem(prefix + 'celula_metaplastica');
            localStorage.removeItem(prefix + 'otras_neo_malignas');
            localStorage.removeItem(prefix + 'toma');
            localStorage.removeItem(prefix + 'recomendaciones');
            localStorage.removeItem(prefix + 'microorganismos');
            localStorage.removeItem(prefix + 'resultado');
        } else {
            localStorage.removeItem(prefix + 'macro');
            localStorage.removeItem(prefix + 'micro');
            localStorage.removeItem(prefix + 'conclusion');
            localStorage.removeItem(prefix + 'observacion');
            localStorage.removeItem(prefix + 'maligno');
            localStorage.removeItem(prefix + 'guardado');
            localStorage.removeItem(prefix + 'observacion_interna');
            localStorage.removeItem(prefix + 'recibe');
            localStorage.removeItem(prefix + 'tacos');
            localStorage.removeItem(prefix + 'diagnostico_presuntivo');
            localStorage.removeItem(prefix + 'tecnicas');
        }

        // Limpiar los valores en los campos del formulario
        $('#estado_especimen').val('');
        $('#celulas_pavimentosas').val('');
        $('#celulas_cilindricas').val('');
        $('#valor_hormonal').val('');
        $('#fecha_lectura').val('');
        $('#valor_hormonal_HC').val('');
        $('#cambios_reactivos').val('');
        $('#cambios_asoc_celula_pavimentosa').val('');
        $('#cambios_celula_glandulares').val('');
        $('#celula_metaplastica').val('');
        $('#otras_neo_malignas').val('');
        $('#toma').val('');
        $('#recomendaciones').val('');
        $('#microorganismos').val('');
        $('#resultado').val('');
        $('#macro').val('');
        $('#micro').val('');
        $('#conclusion').val('');
        $('#observacion').val('');
        $('#maligno').val('');
        $('#guardado').val('');
        $('#observacion_interna').val('');
        $('#recibe').val('');
        $('#tacos').val('');
        $('#diagnostico_presuntivo').val('');
        $('#tecnicas').val('');
    }

    // Llamada para cargar datos cuando se abre el modal
    $('#editModal').on('shown.bs.modal', function() {
        var n_servicio = $('#n_servicio').val(); 
        console.log('n_servicio:', n_servicio); 
        cargarDatos(n_servicio);
    });

    // Evento al hacer clic en el botón Actualizar
    $('#actualizarDatos').on('click', function() {
        var n_servicio = $('#n_servicio').val(); 
        
        guardarDatos(n_servicio);

        Swal.fire({
            icon: 'success',
            title: '¡Datos actualizados!',
            text: '¡Datos actualizados para el número de servicio ' + n_servicio + '!',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Aceptar',
            timer: 3000, 
        });
    });

    // Evento al hacer clic en el botón Limpiar
    $('#limpiarDatos').on('click', function() {
        var n_servicio = $('#n_servicio').val(); // Obtener el valor de n_servicio
        console.log('Limpiando datos para el número de servicio:', n_servicio); // Agregar para depuración
        limpiarDatos(n_servicio);
        
        Swal.fire({
            icon: 'success',
            title: '¡Datos limpiados!',
            text: '¡Datos limpiados para el número de servicio ' + n_servicio + '!',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Aceptar',
            timer: 3000, 
        });
    });

});
</script>




