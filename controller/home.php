<?php
    require_once "../models/Home.php";
    
    $home = new Home();
    
    switch ($_GET["op"]){
        case 'total_ventas_hoy':
            $rspta = $home->total_ventas_hoy();
            echo json_encode($rspta);
            break;
        case 'total_dinero_hoy':
            $rspta = $home->total_dinero_hoy();
            echo json_encode($rspta);
            break;
        case 'total_delivery_hoy':
            $rspta = $home->total_delivery_hoy();
            echo json_encode($rspta);
            break;
    }
?>