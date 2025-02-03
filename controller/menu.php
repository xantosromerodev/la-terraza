<?php
    require_once "../models/Menu.php";
    
    $menu = new Menu();
    
    $idmenu = isset($_POST["idmenu"])? limpiarCadena($_POST["idmenu"]):"";
    $codigo_producto = isset($_POST["codigo_producto"])? limpiarCadena($_POST["codigo_producto"]):"";
    $idcategoria = isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
    $nombre = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
    $descripcion = isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
    $precio = isset($_POST["precio"])? limpiarCadena($_POST["precio"]):"";
    
    
    switch ($_GET["op"]){
        case 'codigo_producto':
            $rspta=$menu->codigo_producto();
            echo json_encode($rspta);
            break;
        case 'guardaryeditar':
            if(empty($idmenu)){
                $data = array(
                   "0"=>$codigo_producto,
                   "1"=>$idcategoria,
                   "2"=>$nombre,
                   "3"=>$descripcion,
                   "4"=>$precio,
                   "5"=>"not found",
                   "6"=>"-"
                );
                $rspta = $menu->insertar($data);
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
            $p_idcate=$_POST["p_idcate"];
            $rspta = $menu->llenarLista($p_idcate);
            $data=array();
            while($reg = $rspta->fetch_object()){
               $data[]=$reg;
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            break;
        case 'listar':
            $id_cate=$_GET["p_id_cate"];
            $rspta = $menu->listar($id_cate);
           // print_r($rspta);
            $data = Array();
            $cont=1;
            while($reg = $rspta->fetch_object()){
                $data[] = array(
                    "0" => $cont,
                    "1" => $reg->codigo_producto,
                    "2" => $reg->nombre,
                    "3" => $reg->descripcion,
                    "4" => $reg->precio,
                    "5" => $reg->categoria,
                    "6" => '<span class="badge  badge-primary  text-center"><a style="color:white;cursor:pointer"  onclick="mostrar('.$reg->id_menu.')"><i class="fa fa-edit"></i></a></span>'." ".
                    '<span class="badge badge-danger  text-center"><a style="color:white;cursor:pointer"  onclick="eliminar('.$reg->id_menu.')"><i class="fa fa-trash" aria-hidden="true"></i></a></span>'
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