<!-- =============================================== -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Estudios
            <small>Filtrar</small>
        </h1>
    </section>

    <section class="content">
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="searchForm" action="<?php echo base_url('mantenimiento/estudios/filtrar'); ?>" method="post">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="n_servicio">N Servicio:</label>
                                    <input type="number" class="form-control" id="n_servicio" name="n_servicio" placeholder="N Servicio">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="servicio">Servicio:</label>
                                    <input type="text" class="form-control" id="servicio" name="servicio" placeholder="Servicio">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="tipo_estudio">Tipo:</label>
                                    <select id="tipo_estudio" name="tipo_estudio" class="form-control">
                                        <option value="">Seleccionar tipo de estudio</option>
                                        <option value="Biopsia">Biopsia</option>
                                        <option value="Citologia">Citologia</option>
                                        <option value="Pap">Pap</option>
                                        <option value="Intraoperatorio">Intraoperatorio</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="paciente">Paciente:</label>
                                <input type="text" class="form-control" id="paciente" name="paciente" placeholder="Paciente">
                            </div>
                                <div class="form-group col-md-4">
                                    <label for="obra_social">Obra Social:</label>
                                    <input type="text" class="form-control" id="obra_social" name="obra_social" placeholder="Obra Social">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="diagnostico">Diagnostico:</label>
                                    <input type="text" class="form-control" id="diagnostico" name="diagnostico" placeholder="Diagnostico">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="fecha">Fecha Carga:</label>
                                    <input type="date" class="form-control" id="fecha" name="fecha">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="profesional">Profesional :</label>
                                    <select id="profesional" name="profesional" class="form-control">
                                        <option value="">Seleccionar un profesional</option>
                                        <option value="Maria Fernanda Contreras">Maria Fernanda Contreras</option>
                                        <option value="Adriana Cecilia Torres">Adriana Cecilia Torres</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="estado">Estado:</label>
                                    <select id="estado" name="estado" class="form-control">
                                        <option value="">Seleccionar un estado</option>
                                        <option value="Creado">Creado</option>
                                        <option value="Informando">Informando</option>
                                        <option value="Finalizado">Finalizado</option>
                                        <option value="Archivado/Entregado">Archivado/Entregado</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12 text-center">
                                    <button type="submit" name="btn_buscar" id="btn_buscar" class="btn btn-primary">Buscar</button>
                                    <button type="reset" name="btn_limpiar" class="btn btn-secondary">Limpiar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


