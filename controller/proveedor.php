<?php

require '../models/Proveedor.php';

$proveedor=new Proveedor();

$idproveedor=isset($_POST["idProveedor"])? limpiarCadena($_POST["idProveedor"]):"";
$tipo_doc=isset($_POST["idTipoDoc"])? limpiarCadena($_POST["idTipoDoc"]):"";
$num_documento=isset($_POST["nro_doc"])? limpiarCadena($_POST["nro_doc"]):"";
$razon_social=isset($_POST["razon_social"])? limpiarCadena($_POST["razon_social"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$estado_sunat=isset($_POST["estado_sunat"])? limpiarCadena($_POST["estado_sunat"]):"";

switch ($_GET["op"]){
    case 'llenar_combo_documento':
        $rspta=$proveedor->llenar_combo_documento();
        while($reg = $rspta->fetch_object()){
            echo '<option value=' . $reg->cod_tipo_doc . '>' . $reg->descripcion_documento . '</option>';
        }
    break;
    case 'guardar_proveedor':
        if(empty($idproveedor)){
            $data=array(
                "0"=>$tipo_doc,
                "1"=>$num_documento,
                "2"=>$razon_social,
                "3"=>$direccion,
                "4"=>$telefono,
                "5"=>$estado_sunat
            );
            $rspta = $proveedor->insertar($data);
            echo $rspta ?"Proveedor Registrado":"Ocurrio un error al registrar";
        }else{
            $data=array(
                "0"=>$idproveedor,
                "1"=>$tipo_doc,
                "2"=>$num_documento,
                "3"=>$razon_social,
                "4"=>$direccion,
                "5"=>$telefono, 
            );
            $rspta = $proveedor->editar($data);
            echo $rspta ?"Proveedor Actualizado":"Ocurrio un error al Actualizar";
            
        }
    break;
    case 'mostrar_proveedor':
        $rspta = $proveedor->mostrar($idproveedor);
        echo json_encode($rspta);
    break;
    case 'eliminar_proveedor':
        $rspta = $proveedor->eliminar($idproveedor);
        echo $rspta ?"Proveedor Eliminado":"Ocurrio un error al Eliminar";
    break;
    case 'listar_proveedor':
        $rspta = $proveedor->listar();
        $data = Array();
        $cont=1;
        while($reg = $rspta->fetch_object()){
            $data[] = array(
                "0"=>$cont,
                "1"=>$reg->nro_documento,
                "2"=>$reg->razon_social,
                "3"=>$reg->direccion,
                "4"=>$reg->telefono,
                "5"=>$reg->estado_sunat,
                 "6" => '<span class="badge  badge-primary  text-center"><a style="color:white;cursor:pointer"  onclick="mostrar('.$reg->idproveedor.')"><i class="fa fa-edit"></i></a></span>'." ".
                    '<span class="badge badge-danger  text-center"><a style="color:white;cursor:pointer"  onclick="eliminar('.$reg->idproveedor.')"><i class="fa fa-trash" aria-hidden="true"></i></a></span>'
            );
            $cont++;
            }
            $results = array(
                "sEcho"=>1, //Información técnica para el datatables
                "iTotalRecords"=>count($data), //enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
                "aaData"=>$data);
               echo json_encode($results,JSON_UNESCAPED_UNICODE);   
        
    break;
	


}

?>