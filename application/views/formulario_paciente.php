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
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#buscarPacienteModal">
                            Buscar Paciente <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para buscar paciente -->
<div class="modal fade" id="buscarPacienteModal" tabindex="-1" role="dialog" aria-labelledby="buscarPacienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="buscarPacienteModalLabel">Buscar paciente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="buscarPacienteForm">
                    <div class="form-group">
                        <label for="criterio_paciente">Documento, Nombres o Apellidos del Paciente:</label>
                        <div class="input-group">
                            <input type="text" id="criterio_paciente" name="criterio_paciente" class="form-control" required>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-secondary" id="buscarPacienteBtn">
                                    <i class="fa fa-search"></i> 
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <div id="resultadoBusquedaPaciente" style="margin-top: 10px;"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
    $('#buscarPacienteBtn').click(function() {
        var criterio = $('#criterio_paciente').val();
        $.ajax({
            url: "<?php echo base_url('mantenimiento/Pacientes/buscar_paciente'); ?>",
            method: "POST",
            data: { criterio: criterio },
            success: function(data) {
                $('#resultadoBusquedaPaciente').html(data);
            }
        });
    });
});
</script>