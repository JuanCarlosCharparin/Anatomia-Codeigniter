<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                
                <div class="row">
                    <div class="col-md-12">
                    <h1>Resultados de la Búsqueda</h1>
                        <?php if (!empty($estudios)): ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <!-- Agrega más encabezados según tus necesidades -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($estudios as $estudio): ?>
                                        <tr>
                                        <td><?php echo $estudio->id_estudio_personal; ?></td>
                                        <td><?php echo $estudio->N_Serv; ?></td>
                                        <td><?php echo $estudio->nombre_servicio; ?></td>
                                        <td><?php echo $estudio->nombre_tipo_estudio; ?></td>
                                        <td><?php echo $estudio->nombres_persona; ?></td>
                                        <td><?php echo $estudio->apellidos_persona; ?></td>
                                        <td><?php echo $estudio->obra_social; ?></td>
                                        <td><?php echo $estudio->Diagnostico; ?></td>
                                        <td><?php echo $estudio->Fecha_Carga; ?></td>
                                        <td><?php echo $estudio->nombres_profesional; ?></td>
                                        <td><?php echo $estudio->apellidos_profesional; ?></td>
                                        <td><?php echo $estudio->estado; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>No se encontraron estudios.</p>
                        <?php endif; ?>

 
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->