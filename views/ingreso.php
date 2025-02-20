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
                        <button class="btn btn-primary btn-sm btn-round" onclick="mostrar_form(true)"><i
                                class="fa fa-plus" aria-hidden="true"></i> Nuevo Ingreso</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Ingresos </h2>
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
                    <div class="x_content" id=lista_ingreso>
                        <table id="tbl_proveedor" class="table table-bordered  dt-responsive nowrap table-sm"
                            cellspacing="0" width="100%">
                            <thead style="background-color:#2A3F54; color:white">
                                <tr>
                                    <th>NRO</th>
                                    <th>FECHA</th>
                                    <!--<th>N. COMERCIAL</th>-->
                                    <th>DOCUMENTO</th>
                                    <th>NUMERO</th>
                                    <!--<th>TEL. FIJO</th>-->
                                    <th>RUC</th>
                                    <th>PROVEEDOR</th>
                                    <th>TOTAL COMPRA</th>

                                </tr>
                            </thead>
                            <tbody>


                            </tbody>
                        </table>


                    </div>
                    <div class="x_content" id="form_ingreso">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-lg-4 col-md-12 col-sm-12">
                                    <label>PROVEEDOR (*) RUC/ DNI</label>
                                    <label for="">RUC</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control text-uppercase form-control-sm"
                                            name="ruc" id="ruc" require>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary btn-sm" type="button"
                                                id="btn_buscar_ruc_dni">Buscar</button>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12">
                                    <label>Fecha(*):</label>
                                    <input type="date" class="form-control form-control-sm" name="fecha_hora"
                                        id="fecha_hora" required="">
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12">
                                    <label>Tipo Comprobante(*):</label>
                                    <select name="tipo_comprobante" id="tipo_comprobante"
                                        class="form-control form-control-sm selectpicker" required=""
                                        title="Seleccione">
                                        <option value="Boleta">Boleta</option>
                                        <option value="Factura">Factura</option>
                                        <option value="Ticket">Ticket</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                    <label>Serie:</label>
                                    <input type="text" class="form-control form-control-sm text-uppercase"
                                        name="serie_comprobante" id="serie_comprobante" maxlength="7"
                                        placeholder="Serie">
                                </div>
                                <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                    <label>Número:</label>
                                    <input type="text" class="form-control form-control-sm" name="num_comprobante"
                                        id="num_comprobante" maxlength="10" placeholder="Número" required="">
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label>Agregar Producto:</label>
                                    <input type="text" class="form-control form-control-sm" name="cod_prod"
                                        id="cod_prod">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 table-responsive border-1">

                                    <table id="detalles"
                                        class="table table-striped table-bordered table-condensed table-hover table-sm">
                                        <thead style="background-color:#A9D0F5">
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio </th>
                                            <th>Total </th>
                                            <th>Eliminar</th>
                                        </thead>

                                        <tbody>

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-lg-12 d-flex justify-content-end">
                                    <label for="">Total S/. 0.00</label>

                                </div>

                            </div>
                            <div class="row ">
                                <div class="col-lg-12 d-flex justify-content-start">
                                    <button type="button" class="btn btn-primary btn-sm">GUARDAR</button>
                                    <button type="button" class="btn btn-danger btn-sm">Cancelar</button>

                                </div>

                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!---moda perfil-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header " style="background-color:#2A3F54; color:white">
                <h6 class="modal-title" id="exampleModalLabel">EMPRESA</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="frm_proveedor" method="POST">
                    <input type="hidden" id="idProveedor" name="idProveedor">
                    <div class="row ">
                        <div class="col-lg-12 col-md-12-col-sm-12">
                            <label id="lbltipodoc">Tipo Documento</label>
                            <select id="idTipoDoc" name="idTipoDoc" class="form-control selectpicker" title="Seleccione"
                                required></select>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-lg-12 col-md-12-col-sm-12">
                            <label>Ruc/DNI(*):</label>
                            <label for="">RUC</label>

                            <div class="input-group">
                                <input type="text" class="form-control text-uppercase form-control-sm" name="ruc"
                                    id="ruc" require>
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-sm" type="button"
                                        id="btn_buscar_ruc_dni">Buscar</button>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-lg-12 col-md-12-col-sm-12">
                            <label for="" class="form-label fw-bold">Razon Social</label>
                            <input type="text" class="form-control form-control-sm rounded-0 text-uppercase"
                                name="razon_social" id="razon_social" required>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-lg-12 col-md-12-col-sm-12">

                            <label for="" class="form-label fw-bold">Dirección</label>
                            <input type="text" class="form-control form-control-sm rounded-0 text-uppercase"
                                name="direccion" id="direccion" required>

                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-lg-6 col-md-12-col-sm-12">
                            <label for="" class="form-label fw-bold">Teléfono</label>
                            <input type="text" class="form-control form-control-sm rounded-0 text-uppercase"
                                name="telefono" id="telefono">

                        </div>
                        <div class="col-lg-6 col-md-12-col-sm-12">
                            <label for="" class="form-label fw-bold">Estado Sunat</label>
                            <input type="text" class="form-control form-control-sm rounded-0 text-uppercase"
                                name="estado_sunat" id="estado_sunat">

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
<script src="scripts/ingreso.js"></script>