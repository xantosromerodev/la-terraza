<?php
    require_once "../models/Empresa.php";
    
    $empresa = new Empresa();
    
    $idempresa = isset($_POST["idempresa"])? limpiarCadena($_POST["idempresa"]):"";
    $ruc = isset($_POST["ruc"])? limpiarCadena($_POST["ruc"]):"";
    $razon_social = isset($_POST["razon_social"])? limpiarCadena($_POST["razon_social"]):"";
    $nombre_comercial = isset($_POST["nombre_comercial"])? limpiarCadena($_POST["nombre_comercial"]):"";
    $domicilio_fiscal = isset($_POST["domicilio_fiscal"])? limpiarCadena($_POST["domicilio_fiscal"]):"";
    $telefono_movil = isset($_POST["telefono_movil"])? limpiarCadena($_POST["telefono_movil"]):"";
    $id_ubigeo=isset($_POST["id_ubigeo"])? limpiarCadena($_POST["id_ubigeo"]):"";
    $correo=isset($_POST["correo"])? limpiarCadena($_POST["correo"]):"";
    $modo=isset($_POST["modo"])? limpiarCadena($_POST["modo"]):"";
    $usuario_secundario=isset($_POST["usuario_secundario"])? limpiarCadena($_POST["usuario_secundario"]):"";
    $password_secundario=isset($_POST["password_secundario"])? limpiarCadena($_POST["password_secundario"]):"";
    $link_sistema=isset($_POST["link_sistema"])? limpiarCadena($_POST["link_sistema"]):"";
    $cuenta_detraccion=isset($_POST["cuenta_detraccion"])? limpiarCadena($_POST["cuenta_detraccion"]):"";
    $imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
    $estado=isset($_POST["estado_sunat"])? limpiarCadena($_POST["estado_sunat"]):"";

    switch ($_GET["op"]){
        case 'guardaryeditar':
            if (!file_exists($_FILES['imagen']['tmp_name'])|| !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
		$imagen=$_POST["imagenactual"];
	}else{
		$ext=explode(".", $_FILES["imagen"]["name"]);
		if ($_FILES['imagen']['type']=="image/jpg" || $_FILES['imagen']['type']=="image/jpeg" || $_FILES['imagen']['type']=="image/png") {
			$imagen=round(microtime(true)).'.'. end($ext);
			move_uploaded_file($_FILES["imagen"]["tmp_name"], "../images/logo/".$imagen);
		}
	}
            if(empty($idempresa)){
                $data=array(
                    "0"=>$ruc,
                    "1"=>$razon_social,
                    "2"=>$nombre_comercial,
                    "3"=>$domicilio_fiscal,
                    "4"=>$telefono_movil,
                    "5"=>$id_ubigeo,
                    "6"=>$correo,
                    "7"=>$modo,
                    "8"=>$usuario_secundario,
                    "9"=>$password_secundario,
                    "10"=>$link_sistema,
                    "11"=>$cuenta_detraccion,
                    "12"=>$imagen,
                    "13"=>$estado
                );
                $rspta = $empresa->insertar($data);
               
            }else{
                $rspta = $empresa->editar($idempresa, $ruc, $nempresa, $domicilio, $celular, $correo, $fileName);
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
            case 'obtener_region':
                $rspta = $empresa->obtener_region();
                $data = Array();
                while($reg = $rspta->fetch_object()){
                    $data[] = $reg;
                    
                }
                echo json_encode($data);
            break;
        case 'listar':
            $rspta = $empresa->listar();
           // print_r($rspta);
            $data = Array();
            $cont=1;
            while($reg = $rspta->fetch_object()){
                $data[] = array(
                    "0" => $cont,
                    "1" => $reg->ruc,
                    "2" => $reg->razon_social,
                    "3" => $reg->domicilio_fiscal,
                    "4" => ($reg->modo)?'<a href="#" class="badge badge-success">PRODUCCION<a/>':'<a href="#" class="badge badge-danger">BETA<a/>',
                    "5" => $reg->estado,
                    "6" =>"<img src='../images/logo/".$reg->logo."' height='50px' width='50px'>",
                    "7" => '<span class="badge  badge-primary  text-center"><a style="color:white;cursor:pointer"  onclick="mostrar('.$reg->id_empresa.')"><i class="fa fa-edit"></i></a></span>'." ".
                    '<span class="badge badge-danger  text-center"><a style="color:white;cursor:pointer"  onclick="eliminar('.$reg->id_empresa.')"><i class="fa fa-trash" aria-hidden="true"></i></a></span>'
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
            case 'obtener_ubigeo':
                $rspta = $empresa->obtener_ubigeo($id_ubigeo);
                echo json_encode($rspta);
        }
        
    
?>