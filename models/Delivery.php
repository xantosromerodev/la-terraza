<?php

require '../config/Conexion.php';

class Delivery
{
    public function __construct(){}
   public function insertar_delivery(
   $idusuario,
   $fecha,
   $total_pago,
   $id_menu,
   $cantidad,
   $precio,
   $importe){

    $sql="INSERT INTO pedido_delivery(usuario_id,fecha,total)
    values('$idusuario','$fecha','$total_pago')";

    $idventanew=ejecutarConsulta_retornarID($sql);
		$num_elementos=0;
		$sw=true;
        while ($num_elementos < count($id_menu))
		{
		$sql_detalle = "INSERT INTO detalle_delivery(id_pd_delivery, menu_id,cantidad,precio,importe) 
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
   public function obtener_ultimo_pedido($idusuario){
    $sql="SELECT MAX(id_pd_delivery) AS id FROM pedido_delivery WHERE usuario_id='$idusuario'";;
    return ejecutarConsultaSimpleFila($sql);
}
function obtener_pedido_delyvery_cabecera($idpedido){
    $sql="	SELECT pedido_delivery.id_pd_delivery,pedido_delivery.fecha,pedido_delivery.total
	FROM pedido_delivery  INNER JOIN usuarios
	ON pedido_delivery.usuario_id=usuarios.id WHERE pedido_delivery.id_pd_delivery='$idpedido'";
    return ejecutarConsultaSimpleFila($sql);
    
   }
   public function obtener_pedido_delyveryDetalle($idpedido){
    $sql="SELECT menu.id AS id_menu,pedido_delivery.id_pd_delivery,detalle_delivery.cantidad ,menu.nombre,detalle_delivery.precio,
    detalle_delivery.importe FROM pedido_delivery INNER JOIN detalle_delivery
    ON pedido_delivery.id_pd_delivery=detalle_delivery.id_pd_delivery INNER JOIN menu 
    ON detalle_delivery.menu_id=menu.id INNER JOIN categorias_menu
    ON menu.categoria_id=categorias_menu.id
    WHERE detalle_delivery.id_pd_delivery='$idpedido'";
   // echo $sql;
    return ejecutarConsulta($sql);
   }

}
?>