
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Lista de Empleados
        <small>Visualizar</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Informe de empleados</h2>

                        <table class="table table-striped mt-4">
                            <tr>
                                <th>Empleado ID</th>
                                <th>Empresa</th>
                                <th>Puesto</th>
                                <th>Fecha de Inicio</th>
                                <th>Fecha de Fin</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                            </tr>
                            <?php foreach ($empleados as $empleado): ?>
                            <tr>
                                <td><?php echo $empleado['empleado_id']; ?></td>
                                <td><?php echo $empleado['empresa']; ?></td>
                                <td><?php echo $empleado['puesto']; ?></td>
                                <td><?php echo $empleado['fecha_inicio']; ?></td>
                                <td><?php echo $empleado['fecha_fin']; ?></td>
                                <td><?php echo $empleado['nombres']; ?></td>
                                <td><?php echo $empleado['apellidos']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
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
