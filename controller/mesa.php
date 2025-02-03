<?php
    require_once "../models/Mesa.php";
    
    $mesa = new Mesa();
    
    $idmesa = isset($_POST["idmesa"])? limpiarCadena($_POST["idmesa"]):"";
    $nombre = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
    
    switch ($_GET["op"]){
        case 'guardaryeditar':
            if(empty($idmesa)){
                $rspta = $mesa->insertar($nombre);
                echo $rspta ? "Mesa registrada" : "Mesa no se pudo registrar";
            }else{
                $rspta = $mesa->editar($idmesa, $nombre);
                echo $rspta ? "Mesa actualizada" : "Mesa no se pudo actualizar";
            }
            break;
        case 'eliminar':
            $rspta = $mesa->eliminar($idmesa);
            echo $rspta ? "Mesa eliminada" : "Mesa no se pudo eliminar";
            break;
        case 'mostrar':
            $rspta = $mesa->mostrar($idmesa);
            echo json_encode($rspta);
            break;
        case 'listar':
            $rspta = $mesa->listar();
           // print_r($rspta);
            $data = Array();
            
            while($reg = $rspta->fetch_object()){
                $data[] = array(
                    "0" => $reg->id,
                    "1" => $reg->numero,
                    "2" => '<span class="badge  badge-primary  text-center"><a style="color:white;cursor:pointer"  onclick="mostrar('.$reg->id.')"><i class="fa fa-edit"></i></a></span>'." ".
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