<?php
if(strlen(session_id()) < 1) 
session_start();

require_once '../models/Cajas.php';

$cajas=new Cajas();
$idcaja=isset($_POST["idcaja"])? limpiarCadena($_POST["idcaja"]):"";
$nombre_caja=isset($_POST["nombre_caja"])? limpiarCadena($_POST["nombre_caja"]):"";

switch ($_GET["op"]){

    case 'guardar_caja':
        if(empty($idcaja)){
            $data=array(
                "0"=>$nombre_caja,
                "1"=>"ACTIVO"

            );
            $rpta=$cajas->insertar_caja($data);
            $res=$rpta->fetch_object();
            echo $res->msg;
        }else{
            echo "existe";
        }
    break;
    case 'editar_caja':
        $data=array(
            "0"=>$idcaja,
            "1"=>$nombre_caja
        );
        $rpta=$cajas->editar_caja($data);
        $res=$rpta->fetch_object();
        echo $res->msj;
    break;

    case 'mostrar':
        $rpta=$cajas->mostrar_caja($idcaja);
        echo json_encode($rpta);
    break;
    case 'eliminar_caja':
        $rpta=$cajas->eliminar_caja($idcaja);
        echo $rpta ?"Caja eliminada":"error al eliminar caja";
    break;
    case 'listar_caja':
        $rspta=$cajas->listar_caja();
        $data=array();
        $cont=1;
        while($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>$cont,
                "1"=>$reg->nombre_caja,
                "2"=>$reg->estado,
                "3" => '<span class="badge  badge-primary  text-center"><a style="color:white;cursor:pointer"  onclick="mostrar('.$reg->id_caja.')"><i class="fa fa-edit"></i></a></span>'." ".
                    '<span class="badge badge-danger  text-center"><a style="color:white;cursor:pointer"  onclick="eliminar_caja('.$reg->id_caja.')"><i class="fa fa-trash" aria-hidden="true"></i></a></span>'
            );
            $cont++;
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total de registros al datatable
            "iTotalRecords" => count($data), //enviamos el total de registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
    break;
}

?>