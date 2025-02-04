<?php
require '../config/Conexion.php';

class Pedidos{
    public function __construct(){
        
    }
    public function mostrar_mesas(){
        $sql="CALL SP_MOSTRAR_MESAS()";
        return ejecutarConsulta($sql);
    }
    public function obtener_categoria_menu(){
        $sql="CALL SP_OBTENER_CATEGORIA_MENU()";
        return ejecutarConsulta($sql);
    }
    public function obtener_menu($idcategoria){
        $sql="CALL SP_OBTENER_MENU($idcategoria)";
        return ejecutarConsulta($sql);
    }
    public function mostrar_menu_detalle($idmenu){
        $sql="CALL sp_mostrar_menu($idmenu)";
        return ejecutarConsulta($sql);
    }
    public function insertar_pedido(
    $idusuario,
    $idmesa, 
    $fecha,
    $total_pago,
    $id_menu,
    $cantidad,
    $precio,
    $importe){
        
    $sql="INSERT INTO pedidos(usuario_id,mesa_id,fecha,total)
    values('$idusuario','$idmesa','$fecha','$total_pago')";

    $idventanew=ejecutarConsulta_retornarID($sql);
		$num_elementos=0;
		$sw=true;
        while ($num_elementos < count($id_menu))
		{
		$sql_detalle = "INSERT INTO detalles_pedido(pedido_id, menu_id,cantidad,precio,importe) 
        VALUES ('$idventanew', 
        '$id_menu[$num_elementos]',
        '$cantidad[$num_elementos]',
        '$precio[$num_elementos]',
        '$importe[$num_elementos]')";	
		ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;

    }
    public function editar_pedido(
	    $idpedido,
	    $total_pago,
	    $id_menu,
	    $cantidad,
	    $precio,
	    $importe
    ){
    	$sql_pedidos="UPDATE pedidos SET total=total+'$total_pago' WHERE id='$idpedido'";
    	ejecutarConsulta($sql_pedidos);
    	$num_elementos=0;
		$sw=true;
        while ($num_elementos < count($id_menu))
		{
		$sql_detalle = "INSERT INTO detalles_pedido(pedido_id, menu_id,cantidad,precio,importe) 
        VALUES ('$idpedido', 
        '$id_menu[$num_elementos]',
        '$cantidad[$num_elementos]',
        '$precio[$num_elementos]',
        '$importe[$num_elementos]')";	
		ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;

    	
    }
    public function obtener_id_pedido_ultimo($id_pedido,$id_usuario){
    	$sql="CALL SP_OBTENER_ID_PEDIDO('$id_pedido','$id_usuario')";
 
    	return ejecutarConsultaSimpleFila($sql);
    }
    public function actualizar_estado($idmesa){
        $sql="UPDATE mesas SET estado='OCUPADO' WHERE id='$idmesa'";
        return ejecutarConsulta($sql);
    }
    public function pedido_cabecera($idusuario, $idmesa){
    	$sql="CALL SP_PEDIDO_CABECERA('$idusuario','$idmesa')";
       
    	return ejecutarConsultaSimpleFila($sql);
    }
    public function detalle_pedido($idusuario, $idmesa){
    	$sql="CALL SP_DETALLE_PEDIDOD('$idusuario','$idmesa')";
    //	echo $sql;
    	return ejecutarConsulta($sql);
    }
    // function para obtener las subcategorias para el menu
    public function obtener_subcategorias($idcategoria){
        $sql="CALL sp_llenar_lista_categoria_menu('$idcategoria')";
        return ejecutarConsulta($sql);
    }
   

}
?>