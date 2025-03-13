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
	// datos para los comprobantes en pdf

	public function obtener_empresa(){
        $sql="select * from empresas";
        return ejecutarConsultaSimpleFila($sql);

    }
	function obtener_id_venta(){
		$sql="SELECT MAX(idventa) AS id FROM  venta";
		return ejecutarConsultaSimpleFila($sql);
	}
	public function obtener_venta($idventa){
        $sql="SELECT venta.serie,venta.numero , type_doc.idtipo_doc,type_doc.nombre_tipo_doc, venta.fecha_emision fecha_emision_sf,
			DATE_FORMAT(venta.fecha_emision,'%d/%m/%Y') AS fecha_emision,
			DATE_FORMAT( venta.fecha_vemcimiento,'%d/%m/%Y')AS fecha_vencimiento,venta.fecha_vemcimiento fecha_vencimiento_sf,
		 	venta.hora_emision,tipo_doc_contribuyente.cod_tipo_doc,clientes.num_documento, clientes.razon_social,
			clientes.direccion,forma_pagos.id_forma_pago,UPPER(forma_pagos.forma_pago)AS forma_pago,UPPER(monedas.moneda) AS moneda,monedas.abrstandar,monedas.id_moneda,venta.total_igv,
			venta.total_exonerada,venta.total_gratuita,venta.total_inafecta,venta.total_venta,venta.total_gravada,venta.total_exportacion,venta.total_bolsa,
			usuarios.nombre_ape,tipo_operaciones.codigo,type_doc.codigo_documento,venta.porcentaje_igv,venta.nota
			FROM venta INNER JOIN tipo_documento
			ON venta.idtipo_documento=tipo_documento.idtipo_documento INNER JOIN type_doc
			ON tipo_documento.idtipo_doc=type_doc.idtipo_doc INNER JOIN clientes
			ON venta.idcliente=clientes.idcliente INNER JOIN tipo_doc_contribuyente
			ON clientes.cod_tipo_doc=tipo_doc_contribuyente.cod_tipo_doc INNER JOIN forma_pagos
			ON venta.id_forma_pago=forma_pagos.id_forma_pago INNER JOIN monedas
			ON venta.id_moneda=monedas.id_moneda INNER JOIN usuarios
			ON venta.idusuario=usuarios.id  INNER JOIN tipo_operaciones
			ON venta.id_operacion=tipo_operaciones.id_operacion
			WHERE venta.idventa='$idventa'";
        return ejecutarConsultaSimpleFila($sql);
    }
	public function obtener_detalle_pdf($idventa){
        $sql="SELECT detalle_venta.iddetalle_venta,detalle_venta.idventa,menu.codigo_sunat,menu.codigo_producto,menu.nombre AS nombre_producto,
		detalle_venta.cantidad,tipo_igvs.codigo_de_tributo,tipo_igvs.codigo AS tipo_igv_codigo,ROUND(detalle_venta.precio_venta*(1.18),2)  AS precio_venta,
		detalle_venta.id_tipo_igv,detalle_venta.descuento,detalle_venta.impuesto_bolsa,'NIU' AS codigo_unidad,
		ROUND(detalle_venta.total*(1.18),2) AS total
		 FROM detalle_venta
		INNER JOIN menu
		ON detalle_venta.idarticulo=menu.id  INNER JOIN tipo_igvs
		ON detalle_venta.id_tipo_igv=tipo_igvs.id_tipo_igv 
		 WHERE idventa='$idventa'";
        return ejecutarConsulta($sql);
    }
	public function cuadre_caja($fecha_desde, $fecha_hasta){
		$sql = "SELECT modo_pago_desc, total FROM (
				SELECT fp.modo_pago_desc, SUM(v.total_venta) AS total 
				FROM venta v 
				INNER JOIN modo_pago fp ON v.id_modo_pago = fp.id_modo_pago 
				WHERE DATE(v.fecha_emision) BETWEEN '$fecha_desde' AND '$fecha_hasta'
				GROUP BY fp.modo_pago_desc
				UNION ALL
				SELECT 'TOTAL GENERAL' as modo_pago_desc, SUM(total_venta) as total
				FROM venta 
				WHERE DATE(fecha_emision) BETWEEN '$fecha_desde' AND '$fecha_hasta'
				) AS result
				ORDER BY CASE WHEN modo_pago_desc = 'TOTAL GENERAL' THEN 1 ELSE 0 END";
		return ejecutarConsulta($sql);
	}
}

?>