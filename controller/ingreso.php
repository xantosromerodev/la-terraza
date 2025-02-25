<?php
ob_start();
if (strlen(session_id()) < 1) {
    session_start(); //Validamos si existe o no la sesión
}
if (!isset($_SESSION["nombre"])) {
    header("Location: ../views/login.html"); //Validamos el acceso solo a los usuarios logueados al sistema.
} else {
    require_once '../models/Ingreso.php';
    $ingreso = new Ingreso();
    $nro_doc = isset($_POST["nro_doc"]) ? limpiarCadena($_POST["nro_doc"]) : "";

    $idingreso = isset($_POST["idingreso"]) ? limpiarCadena($_POST["idingreso"]) : "";
    $idproveedor = isset($_POST["idproveedor"]) ? limpiarCadena($_POST["idproveedor"]) : "";
    $idusuario = $_SESSION["id"];
    $tipo_comprobante = isset($_POST["tipo_comprobante"]) ? limpiarCadena($_POST["tipo_comprobante"]) : "";
    $serie_comprobante = isset($_POST["serie_comprobante"]) ? limpiarCadena($_POST["serie_comprobante"]) : "";
    $serie_upper=strtoupper($serie_comprobante);
    $num_comprobante = isset($_POST["num_comprobante"]) ? limpiarCadena($_POST["num_comprobante"]) : "";
    $fecha_hora = isset($_POST["fecha_hora"]) ? limpiarCadena($_POST["fecha_hora"]) : "";
    //$impuesto=isset($_POST["impuesto"])? limpiarCadena($_POST["impuesto"]):"";
    //$total_gravada=isset($_POST["total_gravada"])? limpiarCadena($_POST["total_gravada"]):"";
    //$total_igv=isset($_POST["total_igv"])? limpiarCadena($_POST["total_igv"]):"";
    $total_compra = isset($_POST["total_a_pagar"]) ? limpiarCadena($_POST["total_a_pagar"]) : "";
    //$nro_doc=isset($_POST["nro_doc"])? limpiarCadena($_POST["nro_doc"]):"";
    // aca va los imputs de los campos


    //fin de los imputs
    switch ($_GET["op"]) {
        case 'guardaryeditar':
            if (empty($idingreso)) {
                $rspta = $ingreso->insertar($idproveedor, $idusuario, $tipo_comprobante, $serie_upper, $num_comprobante, $fecha_hora, 0, 0, $total_compra, $_POST["idarticulo"], $_POST["cantidad"], $_POST["precio_venta"], $_POST["total"]);

                ///---------!!!-------------
                echo $rspta ? "Ingreso registrado" : "No se pudieron registrar todos los datos del ingreso";
            } else {
            }
            break;
        case 'selectTipoDoc':
            $rspta = $ingreso->llenar_combo_documento();
            while ($reg = $rspta->fetch_object()) {
                echo '<option value=' . $reg->cod_tipo_doc . '>' . $reg->descripcion_documento . '</option>';
            }
            break;
        case 'obtener_proveedor':
            $rspta = $ingreso->obtener_proveedores($nro_doc);
            //Codificar el resultado utilizando json
            echo json_encode($rspta);
            break;
        case "autocompleteProveedor":
            $filtro = filter_input(INPUT_GET, trim('term', FILTER_SANITIZE_STRING));
            $rpta = $ingreso->autocomplet_Prov($filtro);
            $data = array();
            while ($reg = $rpta->fetch_object()) {
                $data[] = $reg;
            }
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            break;
        case "autocomplete_producto":
            $filtro = filter_input(INPUT_GET, trim('term', FILTER_SANITIZE_STRING));
            $rpta = $ingreso->obtener_menu_autocompletado($filtro);
            $data = array();
            while ($reg = $rpta->fetch_object()) {
                $data[] = $reg;
            }
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            break;
        case 'listar':
            $rspta = $ingreso->listar();
            //Declaramos un array
            $data = array();
            $cont=1;
            while($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0" => $cont,
                    "1" => $reg->fecha,
                    "2" => $reg->tipo_comprobante,
                    "3" => '<button class=" btn badge bg-warning text-white" onclick="abrir_detalle('.$reg->idingreso.')">'.$reg->serie_comprobante.'-'.$reg->num_comprobante.'</button>',
                    "4" => $reg->nro_documento,
                    "5" => $reg->proveedor,
                    "6" => $reg->total_compra,
                 
                );
                $cont++;
            }
            $results = array(
                "sEcho" => 1, //Información para el datatables
                "iTotalRecords" => count($data), //enviamos el total registros al datatable
                "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
                "aaData" => $data);
              echo  json_encode($results);

        break;
        case 'ingreso_cabecera':
            $rspta = $ingreso->ingreso_cabecera($idingreso);
            echo json_encode($rspta);
        break;
        case 'ingreso_detalle':
            $rspta = $ingreso->ingreso_detalle($idingreso);
            $data = array();
            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0" => $reg->cantidad,
                    "1" => $reg->producto,
                    "2" => $reg->precio,
                    "3" => $reg->importe
               
                );
            }
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
    }
}
ob_end_flush();
