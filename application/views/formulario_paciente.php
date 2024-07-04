<!-- =============================================== -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Pacientes
        <small>Cargar</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                
                <div class="row">
                    <div class="col-md-12">
                    <h2>Cargar Paciente</h2>

                    <form method="post" action="<?php echo current_url(); ?>">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Nombres: </label>
                            <input type="text" name="nombres" class="form-control" placeholder="Nombres">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Apellidos: </label>
                            <input type="text" name="apellidos" class="form-control" placeholder="Apellidos">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email: </label>
                            <input type="email" name="email" class="form-control" placeholder="Ingresa email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">DNI: </label>
                            <input type="text" name="documento" class="form-control"  placeholder="Ingresa DNI">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Fecha de Nacimiento: </label>
                            <input type="date" name="fecha_nacimiento" class="form-control" placeholder="Ingresa fecha de nacimiento">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Sexo: </label>
                            <input type="text" name="sexo" class="form-control" placeholder="Ingresa sexo">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Obra social: </label>
                            <input type="text" name="obra_social" class="form-control" placeholder="Ingresa obra social">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Plan : </label>
                            <input type="text" name="plan" class="form-control" placeholder="Ingresa plan">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Codigo Nomenclador : </label>
                            <input type="text" name="codigo_nomenclador_ap" class="form-control" placeholder="Ingresa codigo nomenclador">
                        </div>
                        <button type="submit" class="btn btn-primary">Cargar</button>
                    </form>
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
