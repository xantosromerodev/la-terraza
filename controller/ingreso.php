<?php
ob_start();
if (strlen(session_id()) < 1){
	session_start();//Validamos si existe o no la sesión
} 
if (!isset($_SESSION["nombre"]))
{
  header("Location: ../views/login.html");//Validamos el acceso solo a los usuarios logueados al sistema.
}else{
require_once '../models/Ingreso.php';
$ingreso = new Ingreso();
$nro_doc=isset($_POST["nro_doc"])? limpiarCadena($_POST["nro_doc"]):"";
// aca va los imputs de los campos


//fin de los imputs
switch($_GET["op"]){
    case 'selectTipoDoc':
        $rspta=$ingreso->llenar_combo_documento();
        while($reg = $rspta->fetch_object()){
            echo '<option value=' . $reg->cod_tipo_doc . '>' . $reg->descripcion_documento . '</option>';
        }
    break;
    case 'obtener_proveedor':
		$rspta=$ingreso->obtener_proveedores($nro_doc);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
		break;
        case "autocompleteProveedor":
            $filtro=filter_input(INPUT_GET,trim('term',FILTER_SANITIZE_STRING));
            $rpta=$ingreso->autocomplet_Prov($filtro);
        $data=array();
        while($reg=$rpta->fetch_object()){
            $data[]=$reg;
        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        break;
        case "autocomplete_producto":
            $filtro=filter_input(INPUT_GET,trim('term',FILTER_SANITIZE_STRING));
            $rpta=$ingreso->obtener_menu_autocompletado($filtro);
            $data=array();
        while($reg=$rpta->fetch_object()){
            $data[]=$reg;
        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
        break;
}

}
ob_end_flush();
?>