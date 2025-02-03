<?php
if (strlen(session_id()) < 1) 
  session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Terraza</title>
    <!-- Bootstrap -->
    <link href="../public/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../public/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../public/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="../public/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="../public/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
    <!-- bootstrap-daterangepicker -->
    <link href="../public/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- Bootstrap Select-->
    <link href="../public/bootstrap/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/autocomplete/jquery-ui.min.css">
    <!-- Datatables -->

    <link href="../public/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../public/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../public/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../public/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../public/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <link href="css/ticket.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <!-- Custom Theme Style -->
    <!-- <link href="../public/build/css/custom.min.css" rel="stylesheet">-->
    <style>
    @font-face {
        font-family: 'Glyphicons Halflings';
        src: url("https://netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.eot");
        src: url("https://netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.eot?#iefix") format("embedded-opentype"), url("https://netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.woff") format("woff"), url("https://netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.ttf") format("truetype"), url("https://netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.svg#glyphicons-halflingsregular") format("svg")
    }

    body {
        color: #73879C;
        font-family: "Helvetica Neue", Roboto, Arial, "Droid Sans", sans-serif;
        font-size: 13px;
        font-weight: 400;
        line-height: 1.471
    }
    </style>
</head>

<body>

    <!-- /top navigation -->

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#"><?php echo $_SESSION["nombre"]?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">

                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../controller/usuario.php?op=salir"><i class="fa fa-sign-out"
                            aria-hidden="true"></i> Cerrar Sesión</a>
                </li>
                <!--
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
-->
                </li>

            </ul>

        </div>
    </nav>

    <!--lista de mesas--->
    <div class="container-fluit mt-2 ml-1 mr-1" id="ventana_generrar_comprobante">
            <input type="hidden" name="id_pedido" id="id_pedido">
            <input type="hidden" name="id_mesa" id="id_mesa">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-info btn-sm" onclick="mostrar_lista(true)"
                            id="btn_ver_lista"><i class="fa fa-check-circle" aria-hidden="true"></i> ver lsita de
                            comprobantes</button>
                    </div>


                </div>
                <div class="card-body">
                    <div class="row">
                        <!--primera columna para mesas-->
                        <div class="col-lg-4 col-md-6 col-sm-12" id="div_mesas">
                            <div class="card">
                                <div class="card-header " style="background-color:#fb4e36; color: white;">
                                    Mesa Seleccionada: <span class="badge badge-danger" id="mesa_select">Sin
                                        Seleccionar</span>
                                </div>
                                <div class="card-body">

                                    <?php 
					                    require_once "../models/Ventas.php";
					                    $ventas= new Ventas();
                        
					                    $mesas = $ventas->mostrar_mesas_ocupadas();
					                    while($mesa = $mesas->fetch_object()){
										
					                ?>

                                    <div class="row float-left d-flex justify-content-center align-content-center m-1">

                                        <div class="dropdown bg-info">
                                            <button class="btn btn-danger " type="button" id="dropdownMenuButton"
                                                onclick="mostrar_detalle(<?=  $mesa->id?>)">
                                                <?php echo $mesa->numero?>
                                            </button>

                                        </div>

                                    </div>
                                    <?php } ?>



                                </div>
                            </div>
                        </div>
                        <!--segunda columna para detalle-->
                        <div class="col-lg-8 col-md-6 col-sm-12">

                            <div class="card">
                                <div class="card-header " style="background-color:#fb4e36; color: white;">
                                    COMPROBANTE DE PAGO
                                </div>
                                <div class="card-body">
                                    <form name="form_venta" id="form_venta" method="POST">
                                        <div class="row">
                                            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-3">
                                                <input type="text" hidden="" name="idventa" id="idventa">
                                                <input type="hidden" name="idcliente" id="idcliente">
                                                <label for="">Tipo Documento</label>
                                                <select name="tipo_comprobante" id="tipo_comprobante"
                                                    class="form-control  form-control-sm">
                                                    <option value="0">Seleccione</option>
                                                </select>

                                            </div>
                                            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-3">

                                                <label for="">Serie</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="serie_comprobante" id="serie_comprobante">

                                            </div>
                                            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-3">

                                                <label for="">Numero</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="num_comprobante" id="num_comprobante">

                                            </div>
                                            <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-3">

                                                <label for="">Fecha Emisión</label>
                                                <input type="date" class="form-control form-control-sm"
                                                    name="fecha_emision" id="fecha_emision">

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-8 col-md-12 col-sm-12 col-xs-6">
                                                <label for="">Cliente</label>
                                                <input type="hidden" name="id_user" id="id_user">
                                                <div class="input-group">
                                                    <input type="text"
                                                        class="form-control text-uppercase form-control-sm"
                                                        name="nro_documento" id="nro_documento" require>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary btn-sm" type="button"
                                                            id="btn_buscar_ruc_dni">Buscar</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-4 col-md-6 col-sm-12 col-xs-6">

                                                <label for="">Forma de Pago</label>
                                                <select name="modo_pago" id="modo_pago"
                                                    class="form-control form-control-sm">
                                                    <option value="0" disabled>Seleccione</option>
                                                </select>

                                            </div>
                                        </div>



                                        <table class="table table-sm   " id="tb_detalle">
                                            <thead style="background-color:#2A3F54; color:white">
                                                <th style="width:5%;">Cant.</th>
                                                <th style="width:30%;">Menu</th>
                                                <th style="width:5%;">Precio</th>
                                                <th style="width:5%;">Importe</th>
                                                <th style="width:3%;"></th>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tr>
                                                <td align="right" colspan="3">Sub Total: S/.</td>
                                                <td align="center" class="subtotal"><input type="text"
                                                        class="form-control form-control-sm" readonly
                                                        name="total_gravada" id="total_gravada"></td>
                                            </tr>
                                            <tr>
                                                <td align="right" colspan="3">Total IGV (18%): S/</td>
                                                <td align="center" class="subtotal"><input type="text"
                                                        class="form-control form-control-sm" readonly name="total_igv"
                                                        id="total_igv"></td>
                                            </tr>
                                            <tr>
                                                <td align="right" colspan="3">Total a Pagar: S/.</td>
                                                <td align="center" class="subtotal"><input type="text"
                                                        class="form-control form-control-sm" readonly
                                                        name="total_a_pagar" id="total_a_pagar"></td>
                                            </tr>
                                        </table>



                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-info btn-sm" id="btn_guardar_venta"><i
                                                    class="fa fa-check-circle" aria-hidden="true"></i> Generar</button>
                                        </div>


                                    </form>
                                </div>
                            </div>

                        </div>

                    </div>



                </div>
            </div>
    </div>

    <!--creamos el modal de pedidos y lo mostramos-->
    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="container-fluid m-lg-2" id="lista_conetenedora">
        <div class="card text-center">
            <div class="card-header" style="background-color:#fb4e36; color: white;">
                COMPROBANTES DE PAGO
            </div>
            <div class="card-body">
               <div class="row">
                <div class="col-lg-12">
                     <table class="table table-sm table-bordered table-hover " id="tb_comprobantes">
                    <thead style="background-color:#2A3F54; color:white">
                        <th>N°</th>
                        <th>FECHA</th>
                        <th>TIPO DOCUMENTO</th>
                        <th>NUMERO</th>
                        <th>CLIENTE</th>
                        <th>F. PAGO</th>
                        <th>TOTAL</th>
                        <th>ESTADO SUNAT</th>
                        <th>OPCIONES</th>
                    </thead>
                </table>
                </div>
               </div>
            </div>
            <div class="card-footer text-muted">
                <button class="btn btn-danger btn-sm" id="btn_cancelar_lista" onclick="mostrar_lista(false)"><i
                        class="fa fa-check-circle" aria-hidden="true"></i>
                    Cancelar</button>
            </div>
        </div>

    </div>

    <!-- Button trigger modal -->

    <!-- Modal clienete-->
    <div class="modal fade" id="mdlClientes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Clientes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                    <form action="" id="for_clientes">


                        <div class="row ">

                            <div class="col-lg-12 col-md-12-col-sm-12">

                                <label id="lbltipodoc">TIPO DOCUMENTO</label>
                                <select id="idTipoDoc" name="idTipoDoc"
                                    class="form-control form-control-sm selectpicker" required></select>

                            </div>
                        </div>

                        <div class="row ">

                            <div class="col-lg-12 col-md-12-col-sm-12">
                                <label for="" class="form-label fw-bold">RUC/DNI(*):</label>
                                <input type="text" class="form-control form-control-sm rounded-0 text-uppercase"
                                    name="nro_doc" id="nro_doc" required>



                            </div>
                        </div>


                        <div class="row ">
                            <div class="col-lg-12 col-md-12-col-sm-12">
                                <label for="" class="form-label fw-bold">RAZON SOCIAL</label>
                                <input type="text" class="form-control form-control-sm rounded-0 text-uppercase"
                                    name="razon_social" id="razon_social" required>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-lg-12 col-md-12-col-sm-12">

                                <label for="" class="form-label fw-bold">DIRECCION</label>
                                <input type="text" class="form-control form-control-sm rounded-0 text-uppercase"
                                    name="direccion" id="direccion">

                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-lg-6 col-md-12-col-sm-12">
                                <label for="" class="form-label fw-bold">TELEFONO</label>
                                <input type="text" class="form-control form-control-sm rounded-0 text-uppercase"
                                    name="telefono" id="telefono">

                            </div>
                            <div class="col-lg-6 col-md-12-col-sm-12">
                                <label for="" class="form-label fw-bold">ESTADO SUNAT</label>
                                <input type="text" class="form-control form-control-sm rounded-0 text-uppercase"
                                    name="estado_sunat" id="estado_sunat">

                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="insertar_clientes()">Guardar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- modal de detalle de pedidos -->


    <!-- FIN PRUEBA CARD CON ESTILO -->






    <!-- jQuery -->
    <script src="../public/jquery/dist/jquery.min.js"></script>
    <script src="../public/jquery/dist/notify.min.js"></script>
    <!-- Bootstrap -->
    <script src="../public/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="../public/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../public/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="../public/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="../public/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../public/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../public/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="../public/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="../public/Flot/jquery.flot.js"></script>
    <script src="../public/Flot/jquery.flot.pie.js"></script>
    <script src="../public/Flot/jquery.flot.time.js"></script>
    <script src="../public/Flot/jquery.flot.stack.js"></script>
    <script src="../public/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="../public/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="../public/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="../public/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="../public/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="../public/jqvmap/dist/jquery.vmap.js"></script>
    <script src="../public/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="../public/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../public/moment/min/moment.min.js"></script>
    <script src="../public/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="../public/bootstrap/dist/js/bootstrap-select.min.js"></script>

    <!-- Datatables -->
    <!-- Datatables -->
    <script src="../public/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../public/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../public/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../public/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../public/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../public/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../public/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../public/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../public/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../public/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../public/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../public/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../public/jszip/dist/jszip.min.js"></script>
    <script src="../public/pdfmake/build/pdfmake.min.js"></script>
    <script src="../public/pdfmake/build/vfs_fonts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom Theme Scripts -->
    <script src="../public/autocomplete/jquery-ui.min.js"></script>
    <script src="../public/build/js/custom.min.js"></script>
    <script src="scripts/ventas.js"></script>
</body>

</html>