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
    <link href="../public/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="../public/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- Bootstrap Select-->
    <link href="../public/bootstrap/dist/css/bootstrap-select.min.css" rel="stylesheet">
<!-- Datatables -->
    
    <link href="../public/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../public/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../public/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../public/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../public/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
     <link href="css/ticket.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <!-- <link href="../public/build/css/custom.min.css" rel="stylesheet">-->
    <style>
    .scroll-list-group {
        max-height: 300px;
        overflow-y: auto;

        a {
            text-decoration: none;
        }

        /* Card Styles */


    }
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
    <div class="container-fluit mt-2 ml-1 mr-1">
        <form name="form_detalle" id="form_detalle" method="post">
            <input type="hidden" name="id_pedido" id="id_pedido">
            <input type="hidden" name="id_mesa" id="id_mesa">
            <div class="card">
                <div class="card-header ">
                    <button class="btn btn-info btn-sm" id="btn_comandar"><i class="fa fa-check-circle"
                            aria-hidden="true"></i>
                        Comandar</button>
                    <button class="btn btn-warning btn-sm"><i class="fa fa-book" aria-hidden="true"></i>
                        Pre Cuenta</button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!--primera columna para mesas-->
                        <div class="col-lg-6 col-md-6 col-sm-12" id="div_mesas">
                            <div class="card" >
                                <div class="card-header " style="background-color:#fb4e36; color: white;">
                                    Mesa Seleccionada: <span class="badge badge-danger" id="mesa_select">Sin Seleccionar</span>
                                </div>
                                <div class="card-body">

                                    <?php 
					                    require_once "../models/Pedidos.php";
					                    $pedido = new Pedidos();
					                    $mesas = $pedido->mostrar_mesas();
					                    while($mesa = $mesas->fetch_object()){
										
					                ?>
					              <?php if($mesa->estado=="OCUPADO"){
					                    
					              ?>
					                <div class="row float-left d-flex justify-content-center align-content-center m-1">

                                        <div class="dropdown bg-info">
                                            <button  class="btn btn-danger btn-sm dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <?php echo $mesa->numero?>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item  " href="#" onclick="obtener_idpedido('<?php echo $mesa->id?>','<?php echo $mesa->numero?>')"><i
                                                        class="fa fa-book" aria-hidden="true" ></i> Agregar Pedido</a>
                                                <a class="dropdown-item  " href="#" onclick="mostrar_modalDetalle('<?php echo $mesa->id?>','<?php echo $mesa->numero?>')"><i
                                                        class="fa fa-pencil" aria-hidden="true"></i> Listar Pedido</a>
                                            </div>
                                        </div>

                                    </div> 
                                   
									<?php }else if($mesa->estado=="LIBRE"){?>
									<div class="row float-left d-flex justify-content-center align-content-center m-1">

                                        <div class="dropdown bg-info">
                                            <button  class="btn btn-info btn-sm dropdown-toggle " type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <?php echo $mesa->numero?>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item  " href="#"
                                                    onclick="open_modal_pedidos('<?php echo $mesa->id?>','<?php echo $mesa->numero?>')"><i
                                                        class="fa fa-plus" aria-hidden="true"></i> Nuevo Pedido</a>
           
                                               
                                            </div>
                                        </div>

                                    </div> 
								    <?php }?>
                                    <?php }?>

                                </div>
                            </div>
                        </div>
                        <!--segunda columna para detalle-->
                        <div class="col-lg-6 col-md-6 col-sm-12">

                            <div class="card">
                                <div class="card-header " style="background-color:#fb4e36; color: white;">
                                    Productos
                                </div>
                                <div class="card-body">
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
                                    </table>
                                    <table class="table table-sm  " id="">
                                        <tr>
                                            <td style="width:5%;"></td>
                                            <td style="width:30%;"></td>
                                            <td style="width:5%;"><label class="h5" for="total">Total:</label></td>
                                            <td style="width:10%;"><input class="form-control form-control-sm"
                                                    type="text" name="lbl_total" id="lbl_total" readonly>
                                            </td>
                                            <td style="width:3%;"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </div>
        </form>
    </div>



    </div>
    </div>
    </div>

    <!--creamos el modal de pedidos y lo mostramos-->
    <!-- Button trigger modal -->


    <!-- Modal -->

    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade" id="modal_pedidos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#2A3F54; color:white">
                    <h5 class="modal-title" id="exampleModalLongTitle">Pedidos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">

                            <div class="list-group scroll-list-group list-btn-group-sm" id="lcategorias_m"
                                data-spy="scroll">
                                <a href="#" class="list-group-item list-group-item-action active"> <i
                                        class="fa fa-cubes" aria-hidden="true"></i> Categorias </a>

                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="container" id=galeria>

                            </div>
                            <table class=" mt-1 table table-bordered table-sm" id="tb_menu">
                                <thead style="background-color:#2A3F54; color:white">
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Opcines</th>

                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                        onclick="limpiarTabla()">Cerrar</button>

                </div>
            </div>
        </div>
    
    </div>

    <!-- modal de detalle de pedidos -->
       <div class="modal fade" id="modal_detalle_pedidos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#2A3F54; color:white">
                    <h5 class="modal-title" id="exampleModalLongTitle">Pedidos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                       
                        <div class="col-lg-12">
                           
                           <div class="card text-center">
							  <div class="card-header">
							    <span id="mesa_name"></span> <span id="id_fecha"></span>
							  </div>
							  <div class="card-body">
								
								 <table class="detalle-ticket" width="100%" id="tb_detalle_pedido">
                <thead>
                    <tr>
                        <th class="text-center">CANT</th>
                        <th>DESCRIPCIÓN</th>
                        <th class="text-center">PRECIO</th>
                        <th class="text-center">IMPORTE</th>
                    </tr>
                </thead>
                <tbody>
                                                
                 </tbody>
                  <tfoot>
                    
                    
                    
                    
                                       
                       <tr>
                        <td align="right" colspan="3">TOTAL A PAGAR</td>
                        <td align="center" class="subtotal">
                           0.00                               </td>
                    </tr>
            
                   
                </tfoot>
            </table>
						
							  </div>
							  <div class="card-footer text-muted">
							    <button type="button" class="btn btn-warning text-white">Imprimir</button>
							  </div>
							</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"
                        onclick="limpiar()">Cerrar</button>

                </div>
            </div>
        </div>
    
    </div>

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
    <script src="../public/build/js/custom.min.js"></script>
    <script src="scripts/pedidos.js"></script>
    <script src="scripts/webusb-receipt-printer.umd.js"></script>
    <script>
        const receiptPrinter = new WebUSBReceiptPrinter();
        function conectar() {
            console.log("sss");            
            receiptPrinter.connect();
            console.log(receiptPrinter.connect());
            
        }
    </script>
</body>

</html>