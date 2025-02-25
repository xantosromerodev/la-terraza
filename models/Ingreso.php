<?php

require_once "../config/Conexion.php";

class Ingreso
{
	//Implementamos nuestro constructor
	public function __construct() {}

	//Implementamos un método para insertar registros
	public function insertar($idproveedor, $idusuario, $tipo_comprobante, $serie_comprobante, $num_comprobante, $fecha_hora, $total_gravada, $total_igv, $total_compra, $idarticulo, $cantidad, $precio_compra, $importe)
	{
		$sql = "INSERT INTO ingreso (idproveedor,idusuario,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,total_gravada,total_igv,total_compra,estado)
			VALUES ('$idproveedor','$idusuario','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$total_gravada','$total_igv','$total_compra','Aceptado')";
		//return ejecutarConsulta($sql);
		//echo $sql;
		$idingresonew = ejecutarConsulta_retornarID($sql);

		$num_elementos = 0;
		$sw = true;

		while ($num_elementos < count($idarticulo)) {
			$sql_detalle = "INSERT INTO detalle_ingreso(idingreso, idarticulo,cantidad,precio_compra,precio_venta) VALUES ('$idingresonew', 
				'$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_compra[$num_elementos]','$importe[$num_elementos]')";
			$update_stk = "UPDATE menu set stock=stock+'$cantidad[$num_elementos]' where id='$idarticulo[$num_elementos]'";
			//echo $update_stk;
			ejecutarConsulta($sql_detalle) or $sw = false;
			ejecutarConsulta($update_stk);
			$num_elementos = $num_elementos + 1;
		}

		return $sw;
	}
	public function listar(){
		$sql="CALL SP_LISTAR_INGRESOS()";
		return ejecutarConsulta($sql);
	}
	function llenar_combo_documento()
	{
		$sql = "CALL SP_OBTENER_TIPO_DOC_CONT()";
		return ejecutarConsulta($sql);
	}
	function obtener_proveedores($documento)
	{
		$sql = "SELECT
		idproveedor,
		cod_tipo_doc,
		nro_documento,
		razon_social,
		direccion,
		telefono,
		estado_sunat	
		 FROM proveedor WHERE nro_documento='$documento'";
		return ejecutarConsultaSimpleFila($sql);
	}
	public function obtener_menu_autocompletado($nombre)
	{
		$sql = "CALL SP_OBTENER_MENU_AUTOCOMPLETADO('$nombre')";
		return ejecutarConsulta($sql);
	}
	function autocomplet_Prov($nombre)
	{
		$sql = "select idproveedor,nro_documento,razon_social from  proveedor where nro_documento like '%$nombre%' or razon_social like '%$nombre%' ";
		return ejecutarConsulta($sql);
	}
	public function ingreso_cabecera($idingreso){
		$sql = "CALL SP_CABEBCERA_INGRESO('$idingreso')";
		return ejecutarConsultaSimpleFila($sql);
	}
	public function ingreso_detalle($idingreso){
		$sql = "CALL SP_DETALLE_INGRESO('$idingreso')";
		return ejecutarConsulta($sql);
	}
}
