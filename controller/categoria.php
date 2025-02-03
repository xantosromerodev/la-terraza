<?php
    require_once "../models/Categorias.php";
    
    $categoria = new categoria();
    
    $idcategoria = isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
    $nombre = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
    
    switch ($_GET["op"]){
        case 'guardaryeditar':
            if(empty($idcategoria)){
                $rspta = $categoria->insertar($nombre);
                echo $rspta ? "Categoria registrada" : "Categoria no se pudo registrar";
            }else{
                $rspta = $categoria->editar($idcategoria, $nombre);
                echo $rspta ? "Categoria actualizada" : "Categoria no se pudo actualizar";
            }
            break;
        case 'eliminar':
            $rspta = $categoria->eliminar($idcategoria);
            echo $rspta ? "Categoria eliminada" : "Categoria no se pudo eliminar";
            break;
        case 'mostrar':
            $rspta = $categoria->mostrar($idcategoria);
            echo json_encode($rspta);
            break;
        case 'listar':
            $rspta = $categoria->listar();
           // print_r($rspta);
            $data = Array();
            
            while($reg = $rspta->fetch_object()){
                $data[] = array(
                    "0" => $reg->id,
                    "1" => $reg->nombre,
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