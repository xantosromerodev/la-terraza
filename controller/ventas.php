<?php  

if(strlen(session_id()) < 1) 
  session_start();

require_once '../models/Ventas.php';
$id_pedido=isset($_POST["id_pedido"])?limpiarCadena($_POST["id_pedido"]):"";
$idusuario=isset($_SESSION["id"])?limpiarCadena($_SESSION["id"]):"";
$idmesa=isset($_POST["id_mesa"])?limpiarCadena($_POST["id_mesa"]):"";
$total_pagar=isset($_POST["lbl_total"])?limpiarCadena($_POST["lbl_total"]):"";
$nro_doc=isset($_POST["nro_doc"])? limpiarCadena($_POST["nro_doc"]):"";

// variables para la venta
$id_venta1=isset($_POST["venta_id"])? limpiarCadena($_POST["venta_id"]):"";
$idventa=isset($_POST["idventa"])? limpiarCadena($_POST["idventa"]):"";
$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$idusuario=$_SESSION["id"];
$id_usuario=isset($_POST["id_usuario"])? limpiarCadena($_POST["id_usuario"]):"";
$id_usuario=$idusuario;
$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
$tipo_operacion=isset($_POST['tipo_ope'])?limpiarCadena($_POST["tipo_ope"]):"";
$serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
$num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";
$fecha_emision=isset($_POST["fecha_emision"])? limpiarCadena($_POST["fecha_emision"]):"";
$fecha_vencimiento=isset($_POST["fecha_venc"])? limpiarCadena($_POST["fecha_venc"]):"";
$hora= date("H:i:s");
$modo_pago=isset($_POST["modo_pago"])?limpiarCadena($_POST["modo_pago"]):"";
$id_moneda=isset($_POST["id_moneda"])?limpiarCadena($_POST["id_moneda"]):"";
$total_gravada=isset($_POST["total_gravada"])?limpiarCadena($_POST["total_gravada"]):"";
$total_igv=isset($_POST["total_igv"])?limpiarCadena($_POST["total_igv"]):"";
$total_gratuita=isset($_POST["total_gratuita"])? limpiarCadena($_POST["total_gratuita"]):"";
$total_venta=isset($_POST["total_a_pagar"])? limpiarCadena($_POST["total_a_pagar"]):"";
$nro_doc=isset($_POST["nro_doc"])? limpiarCadena($_POST["nro_doc"]):"";
$observaciones=isset($_POST["obs"])? limpiarCadena($_POST["obs"]):"";
$nro_ope=isset($_POST["n_op"])? limpiarCadena($_POST["n_op"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";

$ventas=new Ventas();

switch ($_GET["op"]) {
	// enviamos los valores de la venta y detalle venta
	case 'guardar_venta':
		if (empty($idventa)){
			$rspta=$ventas->insertar($idcliente,
			$tipo_comprobante,
			1,
			$serie_comprobante,
			$num_comprobante,
			$fecha_emision,
			$fecha_vencimiento,
			$hora,
			1,
			1,
			$total_gravada,
			$total_igv,
			$total_gratuita,
			0,
			0,
			0,
			0,
			$total_venta,
			'',
			'Pendiente',
			$idusuario,
			$observaciones,
			$nro_ope,
			$modo_pago,
			'1.18',
			'',
			'',
			'',
			'',
			'',
			$_POST["idarticulo"],
			$_POST["cantidad"],
			1,
			$_POST["precio_venta"],
			$_POST["total"],
			0);
			echo $rspta ? "Venta registrada" : "No se pudieron registrar todos los datos de la venta";
		}
		else {
		}
	break;


	case 'llenar_combo_doc':
		$rpta=$ventas->llenar_documento();
		$data=array();
		while($reg=$rpta->fetch_object()){
		$data[]=$reg;
		}
		echo json_encode($data,JSON_UNESCAPED_UNICODE);
	break;
	case 'obtener_detalle_pedido':
		

	 	$rspta = $ventas->obtener_detallepedido($idmesa);
           
            $data = Array();
            $cont=0;
            while($reg = $rspta->fetch_object()){
                $data[] =$reg;
                                    
            }
		echo json_encode($data);
	break;
	case 'auto_complete_cliente':
			$filtro=filter_input(INPUT_GET,trim('term',FILTER_SANITIZE_STRING));
		$rpta=$ventas->auto_complete_cliente($filtro);
		$data=array();
	while($reg=$rpta->fetch_object()){
		$data[]=$reg;
	}
	echo json_encode($data,JSON_UNESCAPED_UNICODE);
	break;
		case 'obtener_cliente':
		$rspta=$ventas->obtener_clientes($nro_doc);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
		break;
		case 'modo_pago':
			$rspta=$ventas->obtener_modo_pago();
		
			$data=array();	
			while($reg=$rspta->fetch_object()){
			$data[]=$reg;
			}
			echo json_encode($data,JSON_UNESCAPED_UNICODE);
			break;
			case 'obtener_series_numero':
				$rpta=$ventas->obtener_serie_doc_documento($tipo_comprobante);
				echo json_encode ($rpta);
			break;
		case 'obtener_correlativo_venta':
		$rpta=$ventas->obtener_generar_correlativo_venta($serie_comprobante);
		//echo "valor variable desde php ". $serie_comprobante;
		echo json_encode($rpta);

break;
case 'liberar_mesa':
	$_POST["id_mesa"];
	$rpta=$ventas->librerar_mesa($idmesa);
	echo $rpta ? "Mesa liberada" : "No se pudo liberar la mesa";
	break;
case 'ventas_del_dia':
	$rpta=$ventas->ventas_del_dia();
	$data=array();
	$cont =1;
	while($reg=$rpta->fetch_object()){
		$data[]=array(
			'0'=>$cont,
			'1'=>$reg->fecha_emision,
			'2'=>$reg->nombre_tipo_doc,
			'3'=>'<span class="badge bg-info"><a class="" style="color:white;cursor:pointer"  onclick="mostrar('.$reg->idventa.')">'.$reg->comprobante.'</a></span>',
			'4'=>$reg->razon_social,
			'5'=>$reg->modo_pago_desc,
			'6'=>$reg->total_venta,	
			'7'=>$reg->estado,
			'8'=>'<span class="badge bg-danger"><a  style="color:white;cursor:pointer"><i class="fa fa-print" aria-hidden="true"></i></a></span>'
 				.' '.'<span class="badge bg-success"><a  style="color:white;cursor:pointer"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></span>'
				
			);
			$cont++;
		}
		$results = array(
			"sEcho"=>1,
			"iTotalRecords"=>count($data),
			"iTotalDisplayRecords"=>count($data),
			"aaData"=>$data);
			echo json_encode($results,JSON_UNESCAPED_UNICODE);
		
	break;
}




?>