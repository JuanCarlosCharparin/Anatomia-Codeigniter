<div class="content-wrapper">
    <section class="content">
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Crear Estudio</h3>
                    
                        <?php if ($this->session->flashdata('success')): ?>
                            <p class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></p>
                        <?php endif; ?>
                        <?php if ($this->session->flashdata('error')): ?>
                            <p class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></p>
                        <?php endif; ?>
                        
                        <!-- Botón para abrir el modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crearEstudioModal">
                            Crear Estudio <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div id="ultimos-registros">
            <!-- Aquí se mostrarán los últimos registros -->
        </div>
    </footer>
    
</div>

<!-- Modal -->
<div class="modal fade" id="crearEstudioModal" tabindex="-1" role="dialog" aria-labelledby="crearEstudioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearEstudioModalLabel">Nuevo Estudio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="crearEstudioForm" action="<?php echo base_url('mantenimiento/CrearEstudio/guardar'); ?>" method="post">
                    <div class="form-group">
                        <label for="n_servicio">N° de Servicio:</label>
                        <input type="text" id="n_servicio" name="n_servicio" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label for="fecha">Ingrese la fecha: </label>
                        <div id="date-container">
                            <div class="form-group input-group mb-3">
                                <input type="date" name="fecha" id="fecha" class="form-control" placeholder="Ingrese la fecha">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="documento_paciente">Documento del Paciente:</label>
                        <div class="input-group">
                            <input type="text" id="documento_paciente" name="documento_paciente" class="form-control" required>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-secondary" id="buscarPacienteBtn">
                                    <i class="fa fa-search"></i> 
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="resultadoBusquedaPaciente" style="margin-top: 10px;"></div>
                    <div class="form-group">
                        <label for="paciente">Paciente:</label>
                        <input type="text" id="paciente" name="paciente" class="form-control" readonly required>
                    </div>

                    <div class="form-group">
                        <label for="profesional">Seleccione un profesional:</label>
                        <select id="profesional" name="profesional" class="form-control" required>
                            <?php if (!empty($profesionales)): ?>
                                <?php foreach ($profesionales as $profesional): ?>
                                    <option value="<?php echo $profesional['profesional_salutte_id']; ?>">
                                        <?php echo $profesional['nombres_profesional'] . ' ' . $profesional['apellidos_profesional']; ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="">No hay profesionales disponibles</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="servicio">Seleccione un servicio:</label>
                        <select name="servicio_salutte_id" id="servicio" class="form-control">
                            <option value="">Seleccione un servicio</option>
                            <?php foreach ($servicios_salutte as $servicio): ?>
                                <option value="<?= $servicio['servicio_salutte_id'] ?>"><?= $servicio['nombre_servicio'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tipo_estudio">Seleccione un tipo de estudio:</label>
                        <select id="tipo_estudio" name="tipo_estudio" required>
                            <option value="1">Biopsia</option>
                            <option value="2">Citología</option>
                            <option value="3">Pap</option>
                            <option value="4">Intraoperatorio</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="material">Material remitido:</label>
                        <input type="text" id="material" name="material" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="diagnostico">Diagnostico presuntivo:</label>
                        <input type="text" id="diagnostico" name="diagnostico" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="solicitante">Profesional solicitante :</label>
                        <input type="text" id="solicitante" name="solicitante" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Ingrese código nomenclador AP: </label>
                        <div id="input-container">
                            <div class="form-group input-group mb-3">
                                <input type="text" name="codigos[]" class="form-control" placeholder="Ingrese código">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary add-input" type="button">+</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Otros campos que necesites -->
                    <button type="button" id="submitForm" class="btn btn-primary">Crear Estudio</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        // Obtener el número de servicio correlativo
        $('#crearEstudioModal').on('show.bs.modal', function (e) {
            $.ajax({
                url: "<?php echo base_url('mantenimiento/CrearEstudio/get_n_servicio'); ?>",
                method: "GET",
                success: function(data) {
                    $('#n_servicio').val(data);
                }
            });
        });

        // Buscar paciente por documento
        $('#buscarPacienteBtn').click(function() {
            var documento = $('#documento_paciente').val();
            $.ajax({
                url: "<?php echo base_url('mantenimiento/CrearEstudio/buscar_paciente'); ?>",
                method: "POST",
                data: { documento: documento },
                success: function(data) {
                    $('#resultadoBusquedaPaciente').html(data);
                    actualizarURL(documento);

                    // Añadir evento a los botones de selección generados dinámicamente
                    $('#resultadoBusquedaPaciente').find('.btn-seleccionar').off('click').on('click', function() {
                        var nombrePaciente = $(this).data('nombre');
                        seleccionarPaciente(nombrePaciente);
                    });
                }
            });
        });

        // Submit del formulario usando AJAX
        $('#submitForm').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo base_url('mantenimiento/CrearEstudio/guardar'); ?>",
                method: "POST",
                data: $('#crearEstudioForm').serialize(),
                success: function(response) {
                    // Mostrar alerta de éxito
                    Swal.fire({
                        icon: 'success',
                        title: '¡Estudio creado con exito!',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar',
                        timer: 3000,
                    });
                    $('#crearEstudioModal').modal('hide'); // Opcional: cerrar el modal después de crear el estudio
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Estudio creado con exito!',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar',
                        timer: 3000,
                    });
                    $('#crearEstudioModal').modal('hide'); 
                }
            });
        });
    });

    function seleccionarPaciente(nombrePaciente) {
        $('#paciente').val(nombrePaciente);
        $('#resultadoBusquedaPaciente').empty();
    }

    function actualizarURL(documento) {
        var url = window.location.href;
        if (url.indexOf('documento_paciente=') !== -1) {
            var nuevaURL = url.replace(/(\?|\&)documento_paciente=[^&]+/, '$1documento_paciente=' + documento);
            window.history.replaceState(null, '', nuevaURL);
        } else {
            var separador = url.indexOf('?') !== -1 ? '&' : '?';
            var nuevaURL = url + separador + 'documento_paciente=' + documento;
            window.history.replaceState(null, '', nuevaURL);
        }
    }

    $(document).ready(function() {
        $(document).on('click', '.add-input', function() {
            var inputGroup = $(this).closest('.input-group').clone();
            inputGroup.find('input').val('');
            inputGroup.find('.add-input').removeClass('add-input btn-outline-secondary').addClass('remove-input btn-outline-danger').text('-');
            $('#input-container').append(inputGroup);
        });

        $(document).on('click', '.remove-input', function() {
            $(this).closest('.input-group').remove();
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
        var yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById('fecha').value = today;
    });





    $(document).ready(function(){
        function actualizarRegistros() {
            $.ajax({
                url: "<?php echo base_url('mantenimiento/CrearEstudio/obtener_ultimo_registro'); ?>",
                method: "GET",
                dataType: "json",
                success: function(data) {
                    var registros = data.registros; // Acceder directamente a `data.registros` que contiene los registros
                    var html = '';

                    $.each(registros, function(index, registro) {
                        // Convertir la fecha a un objeto Date para formatearla adecuadamente
                        var fecha = new Date(registro.createdAt);
                        var fechaFormateada = fecha.toLocaleDateString() + ' a las ' + fecha.toLocaleTimeString();

                        html += '<p style="background-color: #f9f9f9; padding: 10px; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 10px;">' +
                        registro.nombres + ' ' + registro.apellidos + ' creó el estudio con número de servicio: ' + registro.nro_servicio + ' el día ' + fechaFormateada + '</p>';
                    });

                    $('#ultimos-registros').html(html);
                },
                error: function(xhr, status, error) {
                    console.error("Error al obtener los registros:", error);
                }
            });
        }

        // Llamar la función para actualizar los registros al cargar la página
        actualizarRegistros();

        // Actualizar los registros cada 10 segundos
        setInterval(actualizarRegistros, 10000);
    });



    /*$(document).ready(function() {
        function cargarUltimosRegistros() {
            $.ajax({
                url: "<?php /*echo base_url('mantenimiento/CrearEstudio/obtener_ultimo_registro');*/ ?>",
                method: "GET",
                dataType: "json",
                success: function(data) {
                    var registrosHtml = '';
                    $.each(data, function(index, registro) {
                        var createdAt = new Date(registro.createdAt);
                        var fecha = createdAt.toLocaleDateString(); // Obtener la fecha
                        var hora = createdAt.toLocaleTimeString();  // Obtener la hora

                        registrosHtml += '<div style="background-color: #f9f9f9; margin-bottom: 10px; padding: 10px; border: 1px solid #ddd;">';
                        registrosHtml += '<p style="margin: 0;">' + registro.nombres + ' creó el estudio con número de servicio: ' + registro.nro_servicio + ' el día ' + fecha + ' a las ' + hora + ' hs</p>';
                        registrosHtml += '</div>';
                    });
                    $('#ultimos-registros').html(registrosHtml);
                }
            });
        }

        // Cargar los registros al cargar la página
        cargarUltimosRegistros();

        // Recargar los registros cada 10 segundos
        setInterval(cargarUltimosRegistros, 10000);
    });*/
    

</script>
