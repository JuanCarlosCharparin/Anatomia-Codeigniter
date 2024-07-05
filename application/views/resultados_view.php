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
                                    <td><?php echo $resultado['tipo_estudio']; ?></td>
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
                url: '<?php echo base_url(); ?>mantenimiento/Biopsia/updateEstudio',
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
});


    
</script>



