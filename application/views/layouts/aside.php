        <!-- =============================================== -->

        <!-- Left side column. contains the sidebar -->
        <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">      
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">PRINCIPAL</li>
            <li>
                <a href="<?php echo base_url();?>mantenimiento/Home">
                    <i class="fa fa-home"></i> <span>Inicio</span>
                </a>
            </li>
            <?php if ($this->session->userdata('rol') == 1 || $this->session->userdata('rol') == 3): ?>
                <!-- Mostrar solo para SuperAdmin, Creador -->
                <li>
                    <a href="<?php echo base_url();?>mantenimiento/Pacientes">
                        <i class="fa fa-user"></i> Pacientes
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->session->userdata('rol') == 1 || $this->session->userdata('rol') == 2): ?>
                <!-- Mostrar solo para SuperAdmin y Admin -->
                <li>
                    <a href="<?php echo base_url();?>mantenimiento/Estudios">
                        <i class="fa fa-file"></i> Estudios
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->session->userdata('rol') == 1 || $this->session->userdata('rol') == 3): ?>
                <!-- Mostrar solo para SuperAdmin y Creador -->
                <li>
                    <a href="<?php echo base_url();?>mantenimiento/CrearEstudio">
                        <i class="fa fa-plus"></i> Crear Estudio
                    </a>
                </li>
            <?php endif; ?>
            <!--li class="treeview">
                <a href="#">
                    <i class="fa fa-share-alt"></i> <span>Movimientos</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../../index.html"><i class="fa fa-circle-o"></i> Generar Boleta</a></li>
                    <li><a href="../../index.html"><i class="fa fa-circle-o"></i> Generar Factura</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-print"></i> <span>Reportes</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../../index.html"><i class="fa fa-circle-o"></i> Categorias</a></li>
                    <li><a href="../../index.html"><i class="fa fa-circle-o"></i> Clientes</a></li>
                    <li><a href="../../index.html"><i class="fa fa-circle-o"></i> Productos</a></li>
                    <li><a href="../../index.html"><i class="fa fa-circle-o"></i> Ventas</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user-circle-o"></i> <span>Administrador</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../../index.html"><i class="fa fa-circle-o"></i> Tipo Documentos</a></li>
                    <li><a href="../../index.html"><i class="fa fa-circle-o"></i> Usuarios</a></li>
                </ul>
            </li>
        </ul>-->
    </section>
    <!-- /.sidebar -->
</aside>

        <!-- =============================================== -->