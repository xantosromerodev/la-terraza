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
    public function detalle_pedido_categoria($idusuario, $idmesa, $idcategoria){
        $sql="CALL SP_DETALLE_PEDIDO_CATEGORIA('$idusuario','$idmesa','$idcategoria')";
        //echo $sql;
        return ejecutarConsulta($sql);
    }
    // function para obtener las subcategorias para el menu
    public function obtener_subcategorias($idcategoria){
        $sql="CALL sp_llenar_lista_categoria_menu('$idcategoria')";
        return ejecutarConsulta($sql);
    }
    // datos para traer el diseñor del ticket de pedidos
    public function obtener_ultimo_pedido($idusuario){
        $sql="SELECT MAX(id) AS id FROM pedidos WHERE usuario_id='$idusuario'";;
        return ejecutarConsultaSimpleFila($sql);
    }
    public function obtener_pedido_cabecera($idpedido){
        $sql="CALL SP_OBTENER_PEDIDO_CABECERA('$idpedido')";
        //echo $sql;
        return ejecutarConsultaSimpleFila($sql);
    }
    public function obtener_detalle_pedido($idpedido,$idcategoria){
        $sql="SELECT menu.id AS id_menu, pedidos.id,detalles_pedido.cantidad ,menu.nombre,detalles_pedido.precio,
		detalles_pedido.importe FROM pedidos INNER JOIN detalles_pedido
		ON pedidos.id=detalles_pedido.pedido_id INNER JOIN mesas
		ON pedidos.mesa_id=mesas.id INNER JOIN menu 
		ON detalles_pedido.menu_id=menu.id INNER JOIN categorias_menu
		ON menu.categoria_id=categorias_menu.id
		WHERE pedido_id='$idpedido' AND categorias_menu.id_cate='$idcategoria'";
        //echo $sql;
        return ejecutarConsulta($sql);
    }
   public function obtener_menu_autocompletado($nombre){
        $sql="CALL SP_OBTENER_MENU_AUTOCOMPLETADO('$nombre')";
        return ejecutarConsulta($sql);
    }
   function obtener_pedido_delyvery_cabecera($idpedido){
    $sql="	SELECT pedidos.id,pedidos.fecha,pedidos.total,mesas.numero
	FROM pedidos INNER JOIN mesas
	ON pedidos.mesa_id=mesas.id INNER JOIN usuarios
	ON pedidos.usuario_id=usuarios.id WHERE pedidos.id='$idpedido'
	and mesas.id =17";
    return ejecutarConsultaSimpleFila($sql);
    
   }
   public function obtener_pedido_delyveryDetalle($idpedido){
    $sql="SELECT menu.id AS id_menu, pedidos.id,detalles_pedido.cantidad ,menu.nombre,detalles_pedido.precio,
    detalles_pedido.importe FROM pedidos INNER JOIN detalles_pedido
    ON pedidos.id=detalles_pedido.pedido_id INNER JOIN mesas
    ON pedidos.mesa_id=mesas.id INNER JOIN menu 
    ON detalles_pedido.menu_id=menu.id INNER JOIN categorias_menu
    ON menu.categoria_id=categorias_menu.id
    WHERE pedido_id='$idpedido'";
    return ejecutarConsulta($sql);
   }

}
?>