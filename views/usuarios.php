<?php
 require 'header.php';
?>
<div class="right_col" role="main">
    <div class="">

        <div class="page-title">
            <div class="title_left">
                <h4>Usuarios</h4>
            </div>

            <div class="title_right">
                <div class="  form-group pull-right ">
                    <div class="input-group">
                        <button class="btn btn-primary btn-sm btn-round" data-toggle="modal" data-target="#exampleModal"
                            data-whatever="@mdo"><i class="fa fa-plus" aria-hidden="true"></i> NUEVO PERFIL</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Lista de Usuarios</h2>
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
                        <table id="datatable-responsive" class="table table-bordered  dt-responsive nowrap table-sm" cellspacing="0"
                            width="100%">
                            <thead style="background-color:#2A3F54; color:white">
                                <tr>
                                    <th >N°</th>
                                    <th>N° DNI</th>
                                    <th>NOMBRES APELLIDOS</th>
                                    <th>CORREO</th>
                                    <th>N° CELULAR</th>
                                    <th>DIRECCION</th>
                                    <th>ROL</th>
                                    <th>OPCIONES</th>

                                </tr>
                            </thead>
                            <tbody>


                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!---moda perfil-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header " style="background-color:#2A3F54; color:white">
                <h6 class="modal-title" id="exampleModalLabel">USUARIOS</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="frm_usuario">
                    <div class="row">
                        <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label for="">INGRESE DNI(*)CONSULTA RENIEC</label>
                             <input type="hidden" name="id_user" id="id_user">
                            <div class="input-group">
                              <input type="text" class="form-control text-uppercase form-control-sm" name="dni_user"
                                id="dni_user" require>
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-sm" type="button" id="btn_buscar_ruc_dni">Button</button>
                                </div>
                            </div>
                           
                           
                        </div>
                        <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label for="">NOMBRES Y APELLIDOS(*)</label>
                            <input type="text" class="form-control text-uppercase form-control-sm" name="nombre_user"
                                id="nombre_user" require>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label for="">CORREOS(*)</label>
                            <input type="text" class="form-control text-uppercase form-control-sm" name="correo_user"
                                id="correo_user" require>
                        </div>
                        <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label for="">N° CELULAR(*)</label>
                            <input type="text" class="form-control form-control-sm" name="celular_user"
                                id="celular_user" require>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="">DIRECCION(*)</label>
                            <input type="text" class="form-control text-uppercase form-control-sm" name="direccion_user"
                                id="direccion_user" require>
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label for="">ROL(*)</label>
                            <select name="rol_user" id="rol_user" class="form-control selectpicker form-control-sm">

                            </select>
                        </div>
                        <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label for="">CONTRASEÑA(*)</label>
                            <input type="text" class="form-control text-uppercase form-control-sm"
                                name="contraseña_user" id="contraseña_user" require>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-round btn-sm" data-dismiss="modal"
                    onclick="limpiar()"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>
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
<script src="scripts/usuarios.js"></script>