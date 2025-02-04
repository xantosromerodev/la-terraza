<?php
if(strlen(session_id()) < 1) 
  session_start();

require_once '../models/Pedidos.php';
date_default_timezone_set('America/Lima');
$fecha = date('Y-m-d');

$id_pedido=isset($_POST["id_pedido"])?limpiarCadena($_POST["id_pedido"]):"";
$idusuario=isset($_SESSION["id"])?limpiarCadena($_SESSION["id"]):"";
$idmesa=isset($_POST["id_mesa"])?limpiarCadena($_POST["id_mesa"]):"";
$total_pagar=isset($_POST["lbl_total"])?limpiarCadena($_POST["lbl_total"]):"";


// datos del detalle pedido


$pedido = new Pedidos();
switch ($_GET["op"]) {
    case 'mostrar_categoria_menu':
        $respuesta = $pedido->obtener_categoria_menu();
        $data = Array();
        if($respuesta->num_rows>0){
            while($rows=$respuesta->fetch_assoc()){
               $data[]=$rows;
            }
        }
        echo json_encode($data);
        break;
        case 'mostrar_mesas':
            $respuesta = $pedido->mostrar_mesas();
            $data = Array();
            if($respuesta->num_rows>0){
                while($rows=$respuesta->fetch_assoc()){
                   $data[]=$rows;
                }
            }
            echo json_encode($data);
            break;
    case 'mostrar_menu':
      if(isset($_POST['idcategoria'])){
        $idcategoria = $_POST['idcategoria'];
        $respuesta = $pedido->obtener_menu($idcategoria);
        $data = Array();
        if($respuesta->num_rows>0){
            while($rows=$respuesta->fetch_assoc()){
               $data[]=$rows;
            }
        }else{
            $data[] = array('msm' => 'No Existe Datos');
        }
        
      }
      echo json_encode($data);
    break;
    case 'mostrar_menu_detalle':
        if(isset($_POST['idmenu'])){
          $idmenu = $_POST['idmenu'];
          $respuesta = $pedido->mostrar_menu_detalle(idmenu);
          $data = Array();
          if($respuesta->num_rows>0){
              while($rows=$respuesta->fetch_assoc()){
                 $data[]=$rows;
              }
          }else{
              $data[] = array('msm' => 'No Existe Datos');
          }
          
        }
        echo json_encode($data);
      break;
      case 'insertar_pedido':
      if(empty($id_pedido)){
        $rpta=$pedido->insertar_pedido(
          $idusuario,
          $idmesa,
          $fecha,
          $total_pagar,
          $_POST["idmenu"],
          $_POST["cantidad"],
          $_POST["precio_venta"],
          $_POST["total"]);
          echo $rpta ?"Pedido Registrado":"error al registrar  pedido";
      }else{
      	$rpta=$pedido->editar_pedido(
      	  $id_pedido,
      	  $total_pagar,
      	  $_POST["idmenu"],
          $_POST["cantidad"],
          $_POST["precio_venta"],
          $_POST["total"]);
          echo $rpta ?"Pedido Actalizado":"Error al Actualzar Pedido";
      }
     break;
     case 'actualizar_estado':
      $rpta=$pedido->actualizar_estado($idmesa);
      echo $rpta?"Mesa Ocupada":"Ocurrio un error";
      break;
      
      case 'obtener_id_pedido':
	  //echo $idmesa. " ". $idusuario ;
	   $rpta=$pedido->obtener_id_pedido_ultimo($idmesa,$idusuario);
	   echo json_encode($rpta);
      break;
      case 'pedido_cabecera':
     
      	 $rpta=$pedido->pedido_cabecera($idusuario,$idmesa);
		 echo json_encode($rpta);
      break;
       case 'listar_pedido':
            $rspta = $pedido->detalle_pedido($idusuario,$idmesa);
           // print_r($rspta);
            $data = Array();
            $cont=0;
            while($reg = $rspta->fetch_object()){
                $data[] = array(
                    "0" => $reg->cantidad,
                    "1" => $reg->nombre,
                    "2"	=>$reg->precio,
                    "3"	=>$reg->importe,
                                     );
            }
            
           
            
            echo json_encode($data);
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
}

?>