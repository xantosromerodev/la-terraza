<?php
 require 'header.php';
?>
<div class="right_col" role="main">
    <div class="">

        <div class="page-title">
            <div class="title_left">
                <h4></h4>
            </div>


        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Menu</h2>
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

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home"
                                    type="button" role="tab" aria-controls="home"
                                    aria-selected="true">Platillos</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile"
                                    type="button" role="tab" aria-controls="profile"
                                    aria-selected="false">Bebidas</button>
                            </li>
                            <li class="nav-item " role="presentation">
                                <button class="nav-link btn-outline-success" id="contact-tab" data-toggle="tab"
                                    data-target="#contact" type="button" role="tab" aria-controls="contact"
                                    aria-selected="false">Contact</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="row mt-2">
                                    <div class="col-lg-12">
                                        <div class="  form-group pull-right ">
                                            <div class="input-group">
                                                <button class="btn btn-primary btn-sm btn-round" id="btn_open_Modal"
                                                    onclick="open_modal_menu(2)"><i class="fa fa-plus"
                                                        aria-hidden="true"></i> Nuevo Menu</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row ">
                                    <div class="col-lg-12">
                                        <table id="datatable-responsive"
                                            class="table table-striped table-bordered dt-responsive nowrap table-sm"
                                            cellspacing="0" width="100%">
                                            <thead style="background-color:#2A3F54; color:white">
                                                <tr>
                                                   <th>N°</th>
                                                    <th>CODIGO</th>
                                                    <th>NOMBRE</th>
                                                    <th>DESCRIPCION</th>
                                                    <th>PRECIO</th>
                                                    <th>CATEGORIA</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Aquí se llena desde la bd -->

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="row mt-2">
                                    <div class="col-lg-12">
                                        <div class="  form-group pull-right ">
                                            <div class="input-group">
                                                <button class="btn btn-primary btn-sm btn-round" id="btn_open_Modal"
                                                    onclick="open_modal_menu(1)"><i class="fa fa-plus"
                                                        aria-hidden="true"></i> Agregar Bebidas</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-lg-12">
                                        <table id="tbl_bebidas"
                                            class="table table-striped table-bordered dt-responsive nowrap table-sm"
                                            cellspacing="0" width="100%">
                                            <thead style="background-color:#2A3F54; color:white">
                                                <tr>
                                                    <th>N°</th>
                                                    <th>CODIGO</th>
                                                    <th>NOMBRE</th>
                                                    <th>DESCRIPCION</th>
                                                    <th>PRECIO</th>
                                                    <th>CATEGORIA</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Aquí se llena desde la bd -->

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!---Ventana modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header " style="background-color:#2A3F54; color:white">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formulario">
                    <div class="row">

                        <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                            <label for="">Categoria</label>
                            <select name="idcategoria" id="idcategoria"
                                class="form-control form-control-sm " required>
                                
                            </select>
                        </div>

                        <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12">
                            <input type="hidden" name="idmenu" id="idmenu">
                            <label for="">Codigo Menú</label>
                            <input type="text" class="form-control form-control-sm " name="codigo_producto"
                                id="codigo_producto" readonly>
                        </div>
                        <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <label for="">Nombre Menú</label>
                            <input type="text" class="form-control form-control-sm " name="nombre"
                                id="nombre">
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-lg-2 col-md-12 col-sm-12 col-xs-12">
                            <label for="">Precio</label>
                            <input type="number" class="form-control form-control-sm " name="precio"
                                id="precio">
                        </div>

                        <div class="form-group col-lg-10 col-md-12 col-sm-12 col-xs-12">
                            <label for="">Descripción</label>
                            <textarea name="descripcion" id="descripcion"
                                class="form-control form-control-sm "></textarea>

                        </div>

                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-round btn-sm" id="btn_cancelar"></i> Cancelar</button>
                <button type="button" class="btn btn-primary btn-round btn-sm" id="btn-guardar"><i
                        class="fa fa-floppy-o" aria-hidden="true"></i> Agregar</button>
            </div>
            </form>
        </div>
    </div>
</div>
<?php
 include '../views/footer.php';
?>
<script src="scripts/menu.js"></script>