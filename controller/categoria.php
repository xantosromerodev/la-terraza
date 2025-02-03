<?php
    require_once "../models/Categorias.php";
    
    $categoria = new categoria();
    
    $idcategoria = isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
    $id_cate = isset($_POST["id_cate"])? limpiarCadena($_POST["id_cate"]):"";
    $nombre = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
    
    
    switch ($_GET["op"]){
        case 'obtener_categoria_general':
            $rspta=$categoria->obtener_categorias();
            $data=array();
            while($reg = $rspta->fetch_object()){
                $data[] = $reg;
            }
            echo json_encode($data);
                    
         break;
        case 'guardaryeditar':
            if(empty($idcategoria)){
                $data=array(
                   "0"=> $id_cate,
                   "1"=>$nombre
                );
                $rspta = $categoria->insertar($data);
                echo $rspta ? "Categoria registrada" : "Categoria no se pudo registrar";
            }else{
                $data=array(
                 "0"=> $idcategoria,
                "1"=>$nombre,
                "2"=> $id_cate
                );
                $rspta = $categoria->editar($data);
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
            $cont = 1;
            while($reg = $rspta->fetch_object()){
                $data[] = array(
                    "0" => $cont,
                    "1" => $reg->nombre,
                    "2" => $reg->descripcion,
                    "3" => '<span class="badge  badge-primary  text-center"><a style="color:white;cursor:pointer"  onclick="mostrar('.$reg->id.')"><i class="fa fa-edit"></i></a></span>'." ".
                    '<span class="badge badge-danger  text-center"><a style="color:white;cursor:pointer"  onclick="eliminar('.$reg->id.')"><i class="fa fa-trash" aria-hidden="true"></i></a></span>'
                );
                $cont++;
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