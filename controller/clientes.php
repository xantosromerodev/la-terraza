<?php

if(strlen(session_id()) < 1) 
  session_start();

require '../models/Clientes.php';
$clientes = new Clientes();
$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$tipo_doc=isset($_POST["idTipoDoc"])? limpiarCadena($_POST["idTipoDoc"]):"";
$num_documento=isset($_POST["nro_doc"])? limpiarCadena($_POST["nro_doc"]):"";
$razon_social=isset($_POST["razon_social"])? limpiarCadena($_POST["razon_social"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$estado_sunat=isset($_POST["estado_sunat"])? limpiarCadena($_POST["estado_sunat"]):"";

switch ($_GET["op"]) {
	case 'gaurdar_clientes':
		if (empty($idcliente)) {
			$data=array(
				"0"=>$tipo_doc,
				"1"=>$num_documento,
				"2"=>$razon_social,
				"3"=>$direccion,
				"4"=>$telefono,
				"5"=>$estado_sunat
			);
			$respuesta = $clientes->insertar($data);
			echo $respuesta ? "Cliente registrado" : "Cliente no se pudo registrar";
		}
		break;
        case 'llenar_combo_tipo_doc':
            $respuesta=$clientes->obtener_tipo_doc_cont();
           
            foreach ($respuesta as $row) {
                echo "<option value='".$row['cod_tipo_doc']."'>".$row['descripcion_documento']."</option>";
            }
        break;

	
}
?>