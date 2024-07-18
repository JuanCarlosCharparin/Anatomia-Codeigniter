<div class="content-wrapper">
    <section class="content">
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Buscar Paciente</h3>
                    
                        <?php if ($this->session->flashdata('success')): ?>
                            <p class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></p>
                        <?php endif; ?>
                        <?php if ($this->session->flashdata('error')): ?>
                            <p class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></p>
                        <?php endif; ?>
                        
                        <!-- Botón para abrir el modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crearEstudioModal">
                            Buscar Paciente <i class="fa fa-search"></i>
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

<div class="modal fade" id="crearEstudioModal" tabindex="-1" role="dialog" aria-labelledby="crearEstudioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearEstudioModalLabel">Buscar paciente</h5>
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
                        <label for="servicio">Seleccione un servicio:</label>
                        <select name="servicio_salutte_id" id="servicio" class="form-control">
                            <option value="">Seleccione un servicio</option>
                            <?php foreach ($servicios_salutte as $servicio): ?>
                                <option value="<?= $servicio['servicio_salutte_id'] ?>"><?= $servicio['nombre_servicio'] ?></option>
                            <?php endforeach; ?>
                        </select>
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
    });
<script>