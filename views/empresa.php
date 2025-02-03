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
                        <button class="btn btn-primary btn-sm btn-round" data-toggle="modal" data-target="#exampleModal"
                            data-whatever="@mdo"><i class="fa fa-plus" aria-hidden="true"></i> Nueva Empresa</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Empresa</h2>
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
                        <table id="datatable-responsive" class="table table-bordered  dt-responsive nowrap table-sm"
                            cellspacing="0" width="100%">
                            <thead style="background-color:#2A3F54; color:white">
                                <tr>
                                    <th>NRO</th>
                                    <th>RUC</th>
                                    <!--<th>N. COMERCIAL</th>-->
                                    <th>EMPRESA</th>
                                    <th>DOMICILIO</th>
                                    <!--<th>TEL. FIJO</th>-->
                                    <th>MODO</th>
                                    <th>ESTADO</th>
                                    <th>LOGO</th>
                                    <!--<th>ESTADO</th>-->
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
                <h6 class="modal-title" id="exampleModalLabel">EMPRESA</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="frm_empresa" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label for="">RUC</label>
                            <input type="hidden" name="idempresa" id="idempresa">
                            <div class="input-group">
                                <input type="text" class="form-control text-uppercase form-control-sm" name="ruc"
                                    id="ruc" require>
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-sm" type="button"
                                        id="btn_buscar_ruc">Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label for="nempresa">RAZON SOCIAL</label>
                            <input type="text" class="form-control text-uppercase form-control-sm" name="razon_social"
                                id="razon_social" require>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label for="celular">NOMBRE COMERCIAL</label>
                            <input type="text" class="form-control form-control-sm" name="nombre_comercial" id="nombre_comercial" require>
                        </div>
                        <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label for="correo">DOMICILIO FISCAL</label>
                            <input type="text" class="form-control text-uppercase form-control-sm" name="domicilio_fiscal"
                                id="domicilio_fiscal" require>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label for="domicilio">TELEFONO - CELULAR</label>
                            <input type="text" class="form-control text-uppercase form-control-sm" name="telefono_movil"
                                id="telefono_movil" require>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                            <label for="domicilio">DEPARTAMENTO - PROVINCIA - DISTRITO</label>
                            <select class=" form-control form-control-sm" name="id_ubigeo" id="id_ubigeo">
                                <option value="0">Seleccione</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label for="domicilio">UBIGEO</label>
                            <input type="text" class="form-control text-uppercase form-control-sm" name="ubigeo"
                                id="ubigeo" require>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                            <label for="domicilio">CORREO</label>
                            <input type="text" class="form-control text-uppercase form-control-sm" name="correo"
                                id="correo" require>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label for="domicilio">MODO</label>
                            <select class="form-control form-control-sm" name="modo" id="modo">
                                <option value="0">BETA</option>
                                <option value="1">PRODUCCION</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                            <label for="domicilio">USUARIO SECUNDARIO</label>
                            <input type="text" class="form-control text-uppercase form-control-sm" name="usuario_secundario"
                                id="usuario_secundario" require>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label for="domicilio">PASSWORD SECUNDARIO</label>
                            <input type="text" class="form-control text-uppercase form-control-sm" name="password_secundario"
                                id="password_secundario" require>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                            <label for="domicilio">LINK DEL SISTEMA</label>
                            <input type="text" class="form-control text-uppercase form-control-sm" name="link_sistema"
                                id="link_sistema" require>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label for="domicilio">CUENTA DETRACCION</label>
                            <input type="text" class="form-control text-uppercase form-control-sm" name="cuenta_detraccion"
                                id="cuenta_detraccion" require>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-xs-12">
                            <label for="">Imagen:</label>
                            <input class="form-control" type="file" name="imagen" id="imagen">
                            <input type="hidden" name="imagenactual" id="imagenactual">
                            <img src="" alt="" width="100px" height="100" id="imagenmuestra">
                        </div>
                    </div>
                     <div class="row">
                        <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label for="domicilio">ESTADO SUNAT</label>
                            <input type="text" class="form-control text-uppercase form-control-sm" name="estado_sunat"
                                id="estado_sunat" require>
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
<script src="scripts/empresa.js"></script>