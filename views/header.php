<?php
if (strlen(session_id()) < 1) 
  session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="views/images/favicon.ico" type="image/ico" />

    <title>Bienvenido | La Terraza</title>

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
    <!-- Datatables -->

    <link href="../public/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../public/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../public/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../public/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../public/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="../public/build/css/custom.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/autocomplete/jquery-ui.min.css">
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title">
                        <a href="home.php" class="site_title"><i class="fa fa-hand-rock-o" aria-hidden="true"></i>
                            <span>La Terraza</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <ul class="nav side-menu">
                                <li>
                                    <a href="home.php">
                                        <i class="fa fa-home"></i> Dashboard
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-cog" aria-hidden="true"></i> Configuración <span
                                            class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="empresa.php">Empresa</a></li>
                                        <li><a href="perfil.php">Perfiles</a></li>
                                        <li><a href="usuarios.php">Usuarios</a></li>
                                        <li><a href="mesa.php">Mesas</a></li>
                                    </ul>
                                </li>
                              

                                <li><a><i class="fa fa-edit"></i> Almacén <span
                                            class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="categorias.php">Categorias</a></li>
                                        <li><a href="menu.php">Productos</a></li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-cog"></i> Ingresos <span
                                            class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        
                                        <li><a href="proveedor.php">Proveedores</a></li>
                                        <li><a href="ingreso.php">Nuevo Ingreso</a></li>
                                        
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-cog"></i> Reporte de Ingresos <span
                                            class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        
                                        <li><a href="reporte_general.php">Reportes General</a></li>
                                        <li><a href="reporte_fecha.php">Reportes por Fecha</a></li>
                                        
                                    </ul>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <!-- /sidebar menu -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <nav class="nav navbar-nav">
                        <ul class=" navbar-right mr-4">
                            <li class="nav-item dropdown open">
                                <!-- <a href="javascript:;" class="user-profile" style="font-size: 20px;">
                                    <i class="fa fa-bell mr-2" style="font-size: 28px;"></i>
                                </a> -->
                                <a href="javascript:;" class="user-profile" aria-haspopup="true" id="navbarDropdown"
                                    data-toggle="dropdown" aria-expanded="false" style="font-size: 20px;">
                                    <i class="fa fa-user" style="font-size: 28px;"></i>
                                </a>
                                <div class="dropdown-menu dropdown-usermenu pull-right"
                                    aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item btn btn-default" href="#"> Perfil</a>
                                    <a class="dropdown-item btn btn-default"
                                        href="../controller/usuario.php?op=salir"><i
                                            class="fa fa-sign-out pull-right"></i> Cerrar sesión</a>
                                </div>
                            </li>

                        </ul>
                    </nav>
                </div>
            </div>