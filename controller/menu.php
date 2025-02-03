<?php
    require_once "../models/Menu.php";
    
    $menu = new Menu();
    
    $idmenu = isset($_POST["idmenu"])? limpiarCadena($_POST["idmenu"]):"";
    $nombre = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
    $precio = isset($_POST["precio"])? limpiarCadena($_POST["precio"]):"";
    $idcategoria = isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
    
    switch ($_GET["op"]){
        case 'guardaryeditar':
            if(empty($idmenu)){
                $rspta = $menu->insertar($nombre, $precio, $idcategoria);
                echo $rspta ? "Menu registrado" : "Menu no se pudo registrar";
            }else{
                $rspta = $menu->editar($idmenu, $nombre, $precio, $idcategoria);
                echo $rspta ? "Menu actualizado" : "Menu no se pudo actualizar";
            }
            break;
        case 'eliminar':
            $rspta = $menu->eliminar($idmenu);
            echo $rspta ? "Menu eliminado" : "Menu no se pudo eliminar";
            break;
        case 'mostrar':
            $rspta = $menu->mostrar($idmenu);
            echo json_encode($rspta);
            break;
        case 'llenar':
            $rspta = $menu->llenarLista();
            while($reg = $rspta->fetch_object()){
                echo '<option value=' . $reg->id . '>' . $reg->nombre . '</option>';
            }
            break;
        case 'listar':
            $rspta = $menu->listar();
           // print_r($rspta);
            $data = Array();
            
            while($reg = $rspta->fetch_object()){
                $data[] = array(
                    "0" => $reg->id,
                    "1" => $reg->nombre,
                    "2" => $reg->precio,
                    "3" => $reg->categoria,
                    "4" => '<span class="badge  badge-primary  text-center"><a style="color:white;cursor:pointer"  onclick="mostrar('.$reg->id.')"><i class="fa fa-edit"></i></a></span>'." ".
                    '<span class="badge badge-danger  text-center"><a style="color:white;cursor:pointer"  onclick="eliminar('.$reg->id.')"><i class="fa fa-trash" aria-hidden="true"></i></a></span>'
                );
            }
            
            $results = array(
                "sEcho" => 1, //Información para el datatables
                "iTotalRecords" => count($data), //enviamos el total de registros al datatable
                "iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
                "aaData" => $data
            );
            
            echo json_encode($results);
            break;
    }
?>