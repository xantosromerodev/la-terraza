<?php 

require '../config/Conexion.php';

class Ventas{
	
	public function __construct(){
		
	}
	//codigo para insertar registro de venta y detalle de venta
		public function insertar(
		$idcliente,
		$id_tipo_doc,
		$id_operacion,
		$serie,
		$numero,
		$fecha_emision,
		$fecha_vencimiento,
		$hora_emision,
		$id_forma_pago,
		$id_moneda,
		$total_gravada,
		$total_igv,
		$total_gratuita,
		$total_exonerada,
		$total_inafecta,
		$total_exportacion,
		$total_bolsa,
		$total_venta,
		$nota,
		$estado,
		$idusuario,
		$obs,
		$nro_ope,
		$id_modo_pago,
		$porcentaje_igv,
		$relacionado_motivo_codigo,
		$serie_nota,
		$numero_nota,
		$estado_operacion,
		$respuesta_sunat,
		$idarticulo,
		$cantidad,
		$id_tipo_igv,
		$precio_venta,
		$total
		
		)
	{
		$sql="INSERT INTO venta (idventa,
		idcliente,
		idtipo_documento,
		id_operacion,
		serie,
		numero,
		fecha_emision,
		fecha_vemcimiento,
		hora_emision,
		id_forma_pago,
		id_moneda,
		total_gravada,
		total_igv,
		total_gratuita,
		total_exonerada,
		total_inafecta,
		total_exportacion,
		total_bolsa,
		total_venta,
		nota,
		estado,
		idusuario,
		observaciones,
		nro_operacion,
		id_modo_pago,
		porcentaje_igv,
		relacionado_motivo_codigo,
		serie_nota,
		numero_nota,
		estado_operacion,
		respuesta_sunat
		
		)
		VALUES (0,'$idcliente',
		'$id_tipo_doc',
		'$id_operacion',
		'$serie',
		'$numero',
		'$fecha_emision',
		'$fecha_vencimiento',
		'$hora_emision',
		'$id_forma_pago',
		'$id_moneda',
		'$total_gravada',
		'$total_igv',
		'$total_gratuita',
		'$total_exonerada',
		'$total_inafecta',
		'$total_exportacion',
		'$total_bolsa',
		'$total_venta',
		'$nota',
		'$estado',
		'$idusuario',
		'$obs',
		'$nro_ope',
		'$id_modo_pago',
		'$porcentaje_igv',
		'$relacionado_motivo_codigo',
		'$serie_nota',
		'$numero_nota',
		'$estado_operacion',
		'$respuesta_sunat'
		
		)";
		
		//return ejecutarConsulta($sql);
		$idventanew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($idarticulo))
		{
		$sql_detalle = "INSERT INTO detalle_venta(idventa, idarticulo,cantidad,id_tipo_igv,precio_venta,total) VALUES ('$idventanew', '$idarticulo[$num_elementos]','$cantidad[$num_elementos]','1', ('$precio_venta[$num_elementos]'/1.18), ('$total[$num_elementos]'/1.18))";
		//echo $sql_detalle;
			ejecutarConsulta($sql_detalle) or $sw = false;
			
			$num_elementos=$num_elementos + 1;
		}

		return $sw;
	}

	public function llenar_documento(){
		$sql="CALL SP_LLENAR_COMBO_DOCUMENTO()";
		return ejecutarConsulta($sql);
	}
	 public function obtener_id_pedido_ultimo($id_pedido,$id_usuario){
    	$sql="CALL SP_OBTENER_ID_PEDIDO('$id_pedido','$id_usuario')";
 
    	return ejecutarConsultaSimpleFila($sql);
    }
	 public function obtener_detallepedido($idmesa){
    	$sql="CALL SP_OBTENER_DETALLE_PEDIDO('$idmesa')";
    	//echo $sql;
    	return ejecutarConsulta($sql);
    }
	public function mostrar_mesas_ocupadas(){
		$sql="CALL sp_filtro_mesa_ocupada()";
		return ejecutarConsulta($sql);
	}
	    public function auto_complete_cliente($dato){
        $sql="CALL SP_AUTOCOMPLETE_CLIENTE('$dato')";
        return ejecutarConsulta($sql);
    }
		function obtener_clientes($documento){
		$sql="CALL SP_OBTENER_CLIENTES('$documento')";
		return ejecutarConsultaSimpleFila ($sql);

	}
	public function obtener_modo_pago(){
		$sql="CALL SP_OBTENER_MODO_PAGO()";
		return ejecutarConsulta($sql);
	}
		function obtener_serie_doc_documento($idtipodoc){
		$sql="CALL SP_OBTENER_SERIE_NUMERO('$idtipodoc')";
		return ejecutarConsultaSimpleFila($sql);
	}
		function obtener_generar_correlativo_venta($serie){
		$sql="CALL SP_GENERAR_CORRELATIVO_COMPROVANTE('$serie')";	
		return ejecutarConsultaSimpleFila($sql);
	}
	public function librerar_mesa($id_mesa){
		$sql="CALL SP_LIBERAR_MESA('$id_mesa')";
		return ejecutarConsulta($sql);
	}
	public function ventas_del_dia(){
		$sql="CALL SP_VENTAS_DIA()";
		return ejecutarConsulta($sql);
	}
	   
}

// Función generar formato PDF


?>