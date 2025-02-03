<?php
    require_once "../models/Empresa.php";
    
    $empresa = new Empresa();
    
    $idempresa = isset($_POST["idempresa"])? limpiarCadena($_POST["idempresa"]):"";
    $ruc = isset($_POST["ruc"])? limpiarCadena($_POST["ruc"]):"";
    $nempresa = isset($_POST["nempresa"])? limpiarCadena($_POST["nempresa"]):"";
    $domicilio = isset($_POST["domicilio"])? limpiarCadena($_POST["domicilio"]):"";
    $celular = isset($_POST["celular"])? limpiarCadena($_POST["celular"]):"";
    $correo = isset($_POST["correo"])? limpiarCadena($_POST["correo"]):"";
    $logo = isset($_POST["logo"])? limpiarCadena($_POST["logo"]):"";
    
    switch ($_GET["op"]){
        case 'guardaryeditar':
            if(empty($idempresa)){
                $rspta = $empresa->insertar($ruc, $nempresa, $domicilio, $celular, $correo, $logo);
                echo $rspta ? "Empresa registrada" : "Empresa no se pudo registrar";
            }else{
                $rspta = $empresa->editar($idempresa, $ruc, $nempresa, $domicilio, $celular, $correo, $logo);
                echo $rspta ? "Empresa actualizada" : "Empresa no se pudo actualizar";
            }
            break;
        case 'eliminar':
            $rspta = $empresa->eliminar($idempresa);
            echo $rspta ? "Empresa eliminada" : "Empresa no se pudo eliminar";
            break;
        case 'mostrar':
            $rspta = $empresa->mostrar($idempresa);
            echo json_encode($rspta);
            break;
        case 'listar':
            $rspta = $empresa->listar();
           // print_r($rspta);
            $data = Array();
            
            while($reg = $rspta->fetch_object()){
                $data[] = array(
                    "0" => $reg->id,
                    "1" => $reg->ruc,
                    "2" => $reg->nempresa,
                    "3" => $reg->domicilio,
                    "4" => $reg->celular,
                    "5" => $reg->correo,
                    "6" => $reg->logo,
                    "7" => '<span class="badge  badge-primary  text-center"><a style="color:white;cursor:pointer"  onclick="mostrar('.$reg->id.')"><i class="fa fa-edit"></i></a></span>'." ".
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