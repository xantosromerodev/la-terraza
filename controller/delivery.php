<?php
if(strlen(session_id()) < 1) 
  session_start();

require_once '../models/Delivery.php';
date_default_timezone_set('America/Lima');
$fecha = date('Y-m-d');

$id_pedido=isset($_POST["id_pedido_"])?limpiarCadena($_POST["id_pedido_"]):"";
$idusuario=isset($_SESSION["id"])?limpiarCadena($_SESSION["id"]):"";
$idmesa=17;
$total_pagar=isset($_POST["lbl_total_"])?limpiarCadena($_POST["lbl_total_"]):"";
//$total_pagar_del=isset($_POST["lbl_total_del"])?limpiarCadena($_POST["lbl_total_del"]):"";

// datos del detalle pedido
$pedido_delivery = new Delivery();
$idP=$pedido_delivery->obtener_ultimo_pedido($idusuario);
$idPedido=$idP['id'];
switch ($_GET["op"]) {
      case 'insertar_delivry':
      if(empty($id_pedido)){
        $rpta=$pedido_delivery->insertar_delivery(
          $idusuario,
          $fecha,
          $total_pagar,
          $_POST["idmenu_"],
          $_POST["cantidad_"],
          $_POST["precio_venta_"],
          $_POST["total_"]);
          echo $rpta ?"Pedido Registrado":"error al registrar  pedido";
      }else{
      	$rpta=$pedido->editar_pedido(
      	  $id_pedido,
      	  $total_pagar,
      	  $_POST["idmenu_"],
          $_POST["cantidad_"],
          $_POST["precio_venta_"],
          $_POST["total_"]);
          echo $rpta ?"Pedido Actalizado":"Error al Actualzar Pedido";
      }
     break;
     
      
      case 'obtener_id_pedido':
	  //echo $idmesa. " ". $idusuario ;
	   $rpta=$pedido->obtener_id_pedido_ultimo($idmesa,$idusuario);
	   echo json_encode($rpta);
      break;
     
      
      //function para listar las subcategorias segun categoria general
      case 'listar_subcategorias':
        $idcategoria = $_POST['idcategoria'];
        $respuesta = $pedido->obtener_subcategorias($idcategoria);
        $data = Array();
        if($respuesta->num_rows>0){
              while($rows=$respuesta->fetch_object()){
                $data[]=$rows;
              }
        }
        echo json_encode($data);
        break;
       
       
          case 'auto_complete_menu':
            $filtro=filter_input(INPUT_GET,trim('term',FILTER_SANITIZE_STRING));
          $rpta=$pedido->obtener_menu_autocompletado($filtro);
          $data=array();
        while($reg=$rpta->fetch_object()){
          $data[]=$reg;
        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        break;
        case 'obtener_pedido_delyvery_cabecera':
          $rpta=$pedido_delivery->obtener_pedido_delyvery_cabecera($idPedido);
          echo json_encode($rpta);
          break;
          case 'obtener_pedido_delyveryDetalle':
            $rpta=$pedido_delivery->obtener_pedido_delyveryDetalle($idPedido);
            $data = Array();
            while($reg = $rpta->fetch_object()){
              $data[] = array(
                "0" => $reg->cantidad,
                "1" => $reg->nombre,
      
              );
            }
            echo json_encode($data);
            break;
}

?>