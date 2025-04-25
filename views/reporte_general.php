<?php
 require 'header.php';
?>
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

    .modal-dialog {
        max-width: 90%;
        height: 90%;
    }

    .modal-content {
        height: 100%;
    }

    .modal-body {
        height: calc(100% - 56px);
        /* Ajuste por el header */
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }

    .pdf-container {
        width: 100%;
        height: 100%;
    }
    </style>
<div class="right_col" role="main">
    <div class="">

        <div class="page-title">
            <div class="title_left">
                <h4></h4>
            </div>

           
        </div>

        <div class="clearfix "></div>

        <div class="row">
            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                    <div class="x_title bg-danger">
                        <h2 class="text-center" style="color:white" >REPORTE GENERAL DE VENTAS</h2>
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
                    <div class="row mt-3">
                    <div class="col-lg-12">
                        <table class="table table-sm  table-hover dt-responsive" id="datatable-responsive">
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
                        <p class="text-center text-white bg-danger text-bold" id="total_general">TOTAL</p>
                    </div>
                </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!---modal perfil-->
<div class="modal fade" id="mdl_pdf" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">TICKET DE VENTA</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe class="pdf-container" src="" id="pdf_container"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" id="btn_cerrar_pdf" onclick="cerrar_pdf()">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
<?php
 include '../views/footer.php';
?>
<script src="scripts/reportes.js"></script>