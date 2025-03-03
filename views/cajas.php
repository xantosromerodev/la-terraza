<?php
 require 'header.php';
?>
<div class="right_col" role="main">
    <div class="">

        <div class="page-title">
            <div class="title_left">
                <h4></h4>
            </div>

            <div class="title_right">
                <div class="  form-group pull-right ">
                    <div class="input-group">
                        <button class="btn btn-primary btn-sm btn-round" onclick="limpiar()"
                        data-toggle="modal" data-target="#modal_cajas"
                            data-whatever="@mdo"><i class="fa fa-plus" aria-hidden="true"></i> Nueva Caja</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>CAJAS</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Settings 1</a>
                                    <a class="dropdown-item" href="#">Settings 2</a>
                                </div>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="tbla_cajas"
                            class="table table-striped table-bordered dt-responsive nowrap table-sm" cellspacing="0"
                            width="100%">
                            <thead style="background-color:#2A3F54; color:white">
                                <tr>
                                    <th>N°</th>
                                    <th>NOMBRE</th>
                                    <th>ESTADO</th>
                                    <th>OPCIONES</th>

                                </tr>
                            </thead>
                            <tbody>
                                <!-- Aquí se llena desde la bd -->

                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!---modal perfil-->
<div class="modal fade" id="modal_cajas" tabindex="-1" role="dialog" aria-labelledby="modal_cajasLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header "style="background-color:#2A3F54; color:white">
                <h5 class="modal-title" id="modal_cajasLabel">Nueva Caja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formulario">
                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <input type="text" hidden="" name="idcaja" id="idcaja">
                            <label for="">Nombre Caja</label>
                            <input type="text"  name="nombre_caja" id="nombre_caja"
                            class="form-control form-control-sm text-uppercase">

                        </div>
                        
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-round btn-sm" data-dismiss="modal"
                    onclick="cancelar()"><i class="fa fa-sign-out" aria-hidden="true"></i> Cancelar</button>
                <button type="button" class="btn btn-primary btn-round btn-sm" id="btn-guardar"><i
                        class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
            </div>
            </form>
        </div>
    </div>
</div>
<?php
 include '../views/footer.php';
?>
<script src="scripts/cajas.js"></script>