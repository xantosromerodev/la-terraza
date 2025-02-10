<?php

//require_once ('../libraries/fpdf/fpdf.php');
//require_once '../libraries/NumeroALetras.php';
require_once '../libs/tcpdf/tcpdf_include.php';
require_once "../models/Ventas.php";
//require_once "../libraries/Variables_diversas_model.php";
//require_once "../libraries/efactura.php";
//require_once '../libraries/qr/phpqrcode/qrlib.php';
session_start();
date_default_timezone_set('America/Lima');
$idventa=$_GET['idventa'];
$opc=$_GET['op'];

// objetos para obtener data
//$idsede=$_SESSION["idsede"];
//$variables_diversas_model=new variables_diversas_model();
$obj_venta=new Ventas();
$empresa=$obj_venta->obtener_empresa();

//$sede=$obj_venta->obtener_sede($idsede);

if($idventa!=0){
$venta=$obj_venta->obtener_venta($idventa);

$detalle=$obj_venta->obtener_detalle_pdf($idventa);
}else{
    $venta_id=$obj_venta->obtener_id_venta();
    $idventa_1=$venta_id["id"];
    $venta=$obj_venta->obtener_venta($idventa_1);
    $detalle=$obj_venta->obtener_detalle_pdf($idventa_1);
}


switch($opc){
    case 'enviar_sunat':
    if($idventa==0){
        envio_sunat($idventa_1);
    }else{
    envio_sunat($idventa);
    }
    break;
    case "imprime_pdf":
        
       // imprimir_pdf($empresa,$sede,$venta,$detalle,$variables_diversas_model);
       
        break;
    case "imprime_ticket":
       generar_pdf_ticket($empresa,$venta,$detalle );
     break;
     case 'anular':
        baja($idventa);
        break;
}
 function envio_sunat($idventa){
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        
        $obj_venta=new Venta();
        $empresa=$obj_venta->obtener_empresa();
        $idsede=$_SESSION["idsede"];
        $sede=$obj_venta->obtener_sede($idsede);
        
        $datos_empresa = $obj_venta->obtener_empresa();                         
        $empresa['ruc']                                 = $datos_empresa['ruc'];
        $empresa['razon_social']                        = $datos_empresa['nom_empresa'];
        $empresa['nombre_comercial']                    = $datos_empresa['nombre_comercial'];        
        $empresa['domicilio_fiscal']                    = $datos_empresa['domicilio_fiscal'];
        $empresa['ubigeo']                              = $sede['codigo_ubigeo'];
        $empresa['urbanizacion']                        = $sede['urbanizacion'];
        $empresa['distrito']                            = $sede['distrito'];
        $empresa['provincia']                           = $sede['provincia'];
        $empresa['departamento']                        = $sede['departamento'];
        $empresa['cuenta_detraccion']                   = $empresa['cuenta_detraccion'];                  
        $empresa['modo']                                = $datos_empresa['modo'];        //1 beta, 2 produccion
        $empresa['usu_secundario_produccion_user']      = $datos_empresa['user_sec_prueba'];
        $empresa['usu_secundario_produccion_password']  = $datos_empresa['pass_sec_prueba'];
                
        $datos_comprobante = $obj_venta->obtener_venta($idventa);
        $cliente['razon_social_nombres']= $datos_comprobante['razon_social'];
        $cliente['numero_documento']    = $datos_comprobante['num_documento'];
        $cliente['codigo_tipo_entidad'] = $datos_comprobante['cod_tipo_doc']; //catalogo 06 (DNI 1, RUC 6)
        $cliente['cliente_direccion']   = $datos_comprobante['direccion'];
       
        $venta['serie']                 = $datos_comprobante['serie'];
        $venta['numero']                = $datos_comprobante['numero'];
        $venta['fecha_emision']         = $datos_comprobante['fecha_emision_sf'];
        $venta['hora_emision']          = $datos_comprobante['hora_emision'];
        $venta['fecha_vencimiento']     = $datos_comprobante['fecha_vencimiento_sf'];
        $venta['moneda_id']             = $datos_comprobante['id_moneda'];  //1 soles --  2 dólares  --  3 euros
        $venta['forma_pago_id']         = $datos_comprobante['id_forma_pago']; //
        $venta['total_bolsa']           = $datos_comprobante['total_bolsa'];
        $venta['total_gravada']         = $datos_comprobante['total_gravada'];
        $venta['total_igv']             = $datos_comprobante['total_igv'];
        $venta['total_exonerada']       = $datos_comprobante['total_exonerada'];
        $venta['total_inafecta']        = $datos_comprobante['total_inafecta'];
        $venta['tipo_documento_codigo'] = $datos_comprobante['codigo_documento']; //catalogo 01 (Para facturas 01, boletas 03, nota de credito 07, nota de debito 08)        
        $venta['nota'] = $datos_comprobante['nota'];
       /*  $cuotas_datos = $this->cuotas_model->select(3, '', array('venta_id' => $venta_id), ' ORDER BY id DESC');        
        $cuotas = array();
        $i = 0;
        foreach ($cuotas_datos as $cuota_detalle){
            $cuotas[$i]['monto']        = $cuota_detalle['monto'];
            $cuotas[$i]['fecha_cuota']  = $cuota_detalle['fecha_cuota'];
            $i ++;
        } */
        
        $detalle = $obj_venta->obtener_detalle($idventa);        
        $indice = 0;
        foreach ($detalle as $value_detalle){
            $items[$indice]['producto']             = $value_detalle['nombre_producto'];
            $items[$indice]['cantidad']             = $value_detalle['cantidad'];
            $items[$indice]['precio_base']          = $value_detalle['precio_venta'];
            $items[$indice]['codigo_sunat']         = $value_detalle['codigo_sunat'];
            $items[$indice]['codigo_producto']      = $value_detalle['codigo_producto'];            
            $items[$indice]['codigo_unidad']        = $value_detalle['codigo_unidad'];   //catalogo 3 (para bienes NIU, servicios ZZ, kilogramo KGM), revisar tabla unidades de BBDD monstruo7.0
            $items[$indice]['tipo_igv_codigo']      = $value_detalle['tipo_igv_codigo']; //catalogo 7 (generalmente con IGV se pone 10)                        
            $items[$indice]['impuesto_bolsa']       = $value_detalle['impuesto_bolsa']; //monto de impuesto (0.50) si el item lleva bolsa plastica
            $indice ++;
        }
                
        $post = array(
            "empresa"   =>  $empresa,
            "cliente"   =>  $cliente,
            "venta"     =>  $venta,            
            "items"     =>  $items,
           
        );
        
        // var_dump($post);exit;
        //$ruta = 'https://facturacionintegral.com/aplicaciones_sistemas/API_SUNAT/post.php';
       // $ruta = 'https://demo.sichasoft.com/API_SUNAT/post.php';
       $ruta = 'https://apis.sichasoft.com/DEMO_API_SUNAT/post.php';
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $ruta,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($post),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
       //echo $response;
       echo json_encode( $response,JSON_UNESCAPED_UNICODE);        
    }
 function generar_pdf_ticket( $empresa,$venta,$detalle){

// Crear instancia de TCPDF
$pdf = new TCPDF('P', 'mm', array(80, 250), true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('SICHASOFT');
$pdf->SetTitle($venta["razon_social"]."-".$venta["serie"]."-".$venta["numero"]);
$pdf->SetMargins(5, 5, 5);
$pdf->SetAutoPageBreak(true, 10);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetMargins(2, 2, 2);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);
// Agregar una página
$pdf->AddPage();

// Encabezado del ticket
$image_file = '../images/logo/'.$empresa['logo'];
// Insertar una imagen centrado
$img_width = 40; // Ancho de la imagen
$page_width = $pdf->getPageWidth();
$x = ($page_width - $img_width) / 2; 

$pdf->Image($image_file, $x, 5,$img_width , '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
$pdf->Ln(25);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 5, $empresa["razon_social"], 0, 1, 'C');
$pdf->SetFont('helvetica', '', 9);
$pdf->Cell(0, 5, 'RUC: '.$empresa["ruc"], 0, 1, 'C');
$pdf->MultiCell(0, 5, $empresa["domicilio_fiscal"], 0, 'C', false, 1, '', '', true);
//$pdf->Cell(0, 5, $empresa["domicilio_fiscal"], 0, 1, 'C');
$pdf->Cell(0, 5,'TEL/CEL. '. $empresa["telefono_movil"], 0, 1, 'C');
$pdf->Ln(0);
$pdf->Cell(0, 0, str_repeat('--', 48), 0, 1, 'C');
switch ($venta['idtipo_doc']) {
    case '01':
        $tipo_documento = 'FACTURA';
        $mensaje = 'ELECTRONICA';
        break;  
    case '02':
        $tipo_documento='PROFORMA';
        $mensaje = ' DE VENTA';
        break;     
    case '03':
        $tipo_documento = 'BOLETA';
        $mensaje = 'ELECTRONICA';
        break;        
} 
$pdf->SetFont('helvetica', 'B', 9);
$pdf->Cell(0, 5,$tipo_documento ." ".$mensaje, 0, 1, 'C');
$pdf->SetFont('helvetica', '', 9);
$pdf->Cell(0, 5,$venta["serie"] ."-".$venta["numero"], 0, 1, 'C');
$pdf->Cell(0, 5, 'FECHA EM.: ' . $venta["fecha_emision"] ." FECHA VENC.". $venta["fecha_vencimiento"], 0, 1, 'L');
$pdf->Cell(0, 0, str_repeat('--', 48), 0, 1, 'C');
$pdf->SetFont('helvetica', 'B', 9);
$pdf->Cell(0, 5,"DATOS DEL CLIENTE", 0, 1, 'C');
$pdf->Cell(0, 0, str_repeat('--', 48), 0, 1, 'C');
switch ($venta['cod_tipo_doc']) {
    case '1':
        $tipo_documento_cliente = 'DNI';
        break;        
    case '6':
        $tipo_documento_cliente = 'RUC';
        break;        
} 
$pdf->SetFont('helvetica', '', 9);
$pdf->Cell(0, 5, $tipo_documento_cliente.": ".$venta["num_documento"], 0, 1, 'L');

$pdf->Cell(0, 5, "RAZON SOCIAL: ".$venta["razon_social"], 0, 1, 'L');
//$pdf->Cell(0, 5, "DIRECCION: ".$venta["direccion"], 0, 1, 'L');
$pdf->MultiCell(0, 6,"DIRECCION: ".$venta["direccion"], 0, 'L');
$pdf->Cell(0, 5, "MONEDA: ".$venta["moneda"], 0, 1, 'L');
$pdf->Cell(0, 5, "MODO PAGO: ".$venta["forma_pago"], 0, 1, 'L');
// Detalle de la venta en tabla HTML

$pdf->Cell(0, 0, str_repeat('--', 48), 0, 1, 'C');
$pdf->Cell(0, 5,"DETALLE DE VENTA", 0, 1, 'C');

$pdf->Cell(0, 0, str_repeat('--', 48), 0, 1, 'C');
$total = 0;
$pdf->SetFont('helvetica', '', 9);
$pdf->Cell(10, 5, 'CANT', 0, 0, 'C');
$pdf->Cell(30, 5, 'DESCRIPCION', 0, 0, 'L');
$pdf->Cell(15, 5, 'PRECIO', 0, 0, 'R');
$pdf->Cell(20, 5, 'IMPORTE', 0, 1, 'R');
$pdf->Ln(1);

while ($item = $detalle->fetch_object()) {
  $importe = $item->cantidad * $item->precio_venta;
  $total += $importe;
  $pdf->Cell(10, 4, $item->cantidad, 0, 0, 'C');
  $yInicio = $pdf->GetY();
  $pdf->MultiCell(30, 6, $item->nombre_producto, 0, 'L');
  $yFin = $pdf->GetY();
  $pdf->SetXY(45, $yInicio);
  //$pdf->MultiCell(30, 4, $item->nombre_producto, 0, 'L', false, 1, '', '', true);
  //$pdf->MultiCell(30, 5, $item->nombre_producto, 0, 0, 'L');
  $pdf->Cell(15, 5, ' S/.'.number_format($item->precio_venta, 2) , 0, 0, 'C');
  $pdf->SetXY(60, $yInicio);
  $pdf->SetXY(60, $yInicio);
  $pdf->Cell(20, 5, ' S/.'.number_format($importe, 2) , 0, 1, 'C');
  $pdf->SetY($yFin);
 //
}
$pdf->Ln(2);
$pdf->Cell(70, 0, str_repeat('--', 40), 0, 1, 'C');
$pdf->Ln(2);

// Total
$totalGrabada=$venta["total_venta"]/1.18;
$igv=$venta["total_venta"]-$totalGrabada;
if($venta["idtipo_doc"]==1 || $venta["idtipo_doc"]==3){
    $pdf->Cell(50, 5, 'GRAVADA:', 0, 0, 'R');
    $pdf->Cell(20, 5, ' S/.'.number_format($totalGrabada, 2)  , 0, 1, 'R');
    $pdf->Cell(50, 5, 'IGV:', 0, 0, 'R');
    $pdf->Cell(20, 5,' S/.'. number_format($igv, 2) , 0, 1, 'R');
    $pdf->Cell(50, 5, 'TOTAL:', 0, 0, 'R');
    $pdf->Cell(20, 5, ' S/.'. number_format($total, 2) , 0, 1, 'R');
}else{
  $pdf->Cell(50, 5, 'TOTAL:', 0, 0, 'R');
    $pdf->Cell(20, 5, ' S/.'.number_format($total, 2) , 0, 1, 'R');
}


/*
$html = '<table  cellspacing="2" cellpadding="2" style="width:100%;">';
$html .= '<tr style="font-weight:bold; text-align:center;">
            <td style="text-align:left;">Cant.</td>
            <td>Descr.</td>
            <td>Precio</td>
            <td>Importe</td>
          </tr>';
     
while ($item = $detalle->fetch_object()) {
    $importe = $item->cantidad * $item->precio_venta;
    $html .= '<tr>
                <td style="text-align:left;">' . $item->cantidad . '</td>
                <td style="text-align:left;">' .$item->nombre_producto. '</td>
                <td style="text-align:center;">S/.' .$item->precio_venta. '</td>
                <td style="text-align:center;">S/.' .$importe. '</td>
                
              </tr>';
   $total += $importe;
}
$html .= '</table>';
//print_r($html);
$pdf->writeHTML($html, true, false, false, false, '');
*/
// Total de la venta
//$pdf->Cell(0, 5, '--------------------------------------', 0, 1, 'C');


// Código de barras


// Pie de página
$pdf->Ln(5);
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(0, 5, 'Gracias por su compra', 0, 1, 'C');

$nombre_pdf=$venta["razon_social"]."-".$venta["serie"]."-".$venta["numero"];
$pdf->Output($nombre_pdf.".pdf","I");  
//$pdf->Output("comprobantes/'".$nombre_pdf.".pdf","F"); 

}

 function GetImgQr($venta, $empresa)  {
        $textoQR = '';
        $textoQR .= $empresa['ruc']."|";//RUC EMPRESA
        
        $textoQR .= $venta['nombre_tipo_doc']."|";//TIPO DE DOCUMENTO 
        $textoQR .= $venta['serie']."|";//SERIE
        $textoQR .= $venta['numero']."|";//NUMERO
        $textoQR .= $venta['total_igv']."|";//MTO TOTAL IGV
        $textoQR .= $venta['total_venta']."|";//MTO TOTAL DEL COMPROBANTE
        $textoQR .= $venta['fecha_emision']."|";//FECHA DE EMISION 
        //tipo de cliente
     
        $textoQR .= $venta['cod_tipo_doc']."|";//TIPO DE DOCUMENTO ADQUIRENTE 
        $textoQR .= $venta['num_documento']."|";//NUMERO DE DOCUMENTO ADQUIRENTE 
        
        $nombreQR = $venta['idtipo_doc'].'-'.$venta['serie'].'-'.$venta['numero'];
        QRcode::png($textoQR, "../files/qr/".$nombreQR.".png", QR_ECLEVEL_L, 10, 2);
        
        return "../files/qr/{$nombreQR}.png";
    }



function imprimir_pdf($empresa,$sede,$venta, $detalle,$variables_diversas_model){
       $pdf = new fpdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        //$pdf->SetMargins(5,5,0,0);
        $pdf->Cell(100,6,$empresa["nombre_comercial"],"0",True);
        $pdf->Ln(2);
        $pdf->SetFont('Arial','',9);
        $pdf->Cell(100,6,$empresa["ruc"],"0","C");
        $pdf->SetFont('Arial','',9);
        $pdf->Ln(4);
        $pdf->Cell(100,6,mb_convert_encoding($empresa["domicilio_fiscal"],'ISO-8859-1', 'UTF-8'),"0","C");
        $pdf->SetFont('Arial','',9);
        $pdf->Ln(4);
        $pdf->Cell(100,6,"TEL/CEL: ".$empresa["telefono_fijo"]."-".$empresa["telefono_movil"],"0","C");
        $pdf->Ln(5);
        $pdf->SetFont('Arial','B',9);
       
        $pdf->Cell(100,6,"DATOS DEL CLIENTE","L,T,R","0","L");
         switch ($venta['cod_tipo_doc']) {
        case '1':
            $tipo_documento_cliente = 'DNI';
            break;        
        case '6':
            $tipo_documento_cliente = 'RUC';
            break;        
    }   
    $pdf->Ln(4);
    $pdf->SetFont('Arial','',9); 
    $pdf->Cell(100,6,$tipo_documento_cliente." : ".$venta["num_documento"],'L,R',"0","L");
    $pdf->SetFont('Arial','',9);
    $pdf->Ln(4);
    $pdf->Cell(100,6,"RAZON SOCIAL"." : ".$venta["razon_social"],'L,R',"0","L");
    $pdf->SetFont('Arial','',9);
    $pdf->Ln(4);
    $pdf->Cell(100,6,mb_convert_encoding("DIRECCIÓN"." : ".$venta["direccion"],'ISO-8859-1', 'UTF-8'),'L,R',"0","L");
    $pdf->SetFont('Arial','',9);
    $pdf->Ln(4);
    $pdf->Cell(100,6,"MONEDA"." : ".strtoupper($venta["moneda"]),'L,R',"0","L");
    $pdf->SetFont('Arial','',9);
    $pdf->Ln(4);
    $pdf->Cell(100,6,"MODO DE PAGO"." : ".strtoupper($venta["forma_pago"]),'L,B,R',"0","L");
    // detalles de la venta
    // cabecera de la tabla
  $pdf->Ln(10);
//$pdf->Cell(70, 2, '-------------------------------------------------------------------------', 0, 1, 'L');
$pdf->SetDrawColor(0, 32, 96);
$pdf->SetFillColor( 0, 32, 96 );
$pdf->SetTextColor(255,255,255);
$pdf->Cell(20, 5, 'CANT.', 1, 0, 'C',True);
$pdf->Cell(120, 5, mb_convert_encoding('DESCRIPCION', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C',True);
$pdf->Cell(20, 5, 'P. UNIT', 1, 0, 'C',True);
$pdf->Cell(25, 5, 'IMPORTE', 1, 1, 'C',True);
//$pdf->Cell(70, 2, '-------------------------------------------------------------------------', 0, 1, 'L');
// recorremos el 

    // recorremos el array de  datos
$data_=Array();
$pdf->SetTextColor(0,0,0);
while($item=$detalle->fetch_object()){
  $pdf->Cell(20, 5, $item->cantidad, 1, 0, 'C');
  $yInicio = $pdf->GetY();
    $pdf->MultiCell(120, 5, mb_convert_encoding($item->nombre_producto, 'ISO-8859-1', 'UTF-8'), 1, 'L');
    $yFin = $pdf->GetY();
      $pdf->SetXY(150, $yInicio);
    $pdf->Cell(20, 5,round($item->precio_venta*(1.18),2,PHP_ROUND_HALF_UP), 1, '.', ',', 0, 0, 'C');
    $pdf->SetXY(170, $yInicio);

  //  $pdf->SetXY(60, $yInicio);
    $pdf->Cell(25, 5,($item->cantidad)*round($item->precio_venta*(1.18),2), 1, 1, 'C');
    $pdf->SetY($yFin);
    $nombre = $venta['serie'].'-'.$venta['numero'];
    $data_[]=$item;
}

 $fijo = 233 + 10;
        $ancho = 8.4;
        $numero_filas = count($data_);        
        $total_y = $fijo + $ancho * $numero_filas; 
// calculo de total grabada
$totalGrabada=$venta["total_venta"]/1.18;
$igv=$venta["total_venta"]-$totalGrabada;
//----------
$pdf->Ln(1);
    //$pdf->Cell(74,1,"-----------------------------------------------------------------------------",0,1,'C');
    $pdf->SetFont('Arial', 'B', 8);
   // $pdf->Cell(140, 7, "", 0, 0, 'R');
    $pdf->Cell(330, 7, "Gravada"."  S/ ".number_format($totalGrabada,2,".","") , 0, 0, 'C');
   // $pdf->Cell(20, 7, "S/. " .number_format($totalGrabada,2,".",""), 0, 0, 'R');
   $pdf->Ln(4);
    $pdf->Cell(330,7,"IGV: 18% "."  S/ ".number_format($igv,2,".",""),0,0,'C');
    //$pdf->Cell(20,7,"S/. ".number_format($igv,2,".",""),0,0,'R');
   $pdf->Ln(4);
    $pdf->Cell(330,7,"Total:"."  S/ ".$venta["total_venta"],0,0,'C');
   // $pdf->Cell(20,7,"S/. ".$venta["total_venta"],0,1,'R');

 $totalVenta = explode(".",  $venta['total_venta']);
 $pdf->Ln(4);
 $pdf->Cell(140,7,mb_convert_encoding(" N° ARTICULOS ",'ISO-8859-1', 'UTF-8').$numero_filas,0,0,'L');
 $pdf->Ln(4);
 $pdf->Cell(180, 2, '_______________________________________________________________________________________________________________________', 0, 1, 'L');
      // $venta['total_letras'] = $totalLetras.' con '.$totalVenta[1].'/100 '.$venta['moneda'];
     $pdf->Ln(1);
    	$totalVenta = explode(".",  $venta['total_venta']);
      // $venta['total_letras'] = $totalLetras.' con '.$totalVenta[1].'/100 '.$venta['moneda'];
      $total =$venta['total_venta'];  
      $letras='SON'.': '.strtoupper(NumeroALetras::convertir($total , 'con '.  $totalVenta[1].'/100 '.$venta['moneda'], mb_convert_encoding("céntimos",'ISO-8859-1', 'UTF-8')));
       $pdf->MultiCell(100,6,$letras,"0","L");
        
        $pdf->MultiCell(150,5, mb_convert_encoding("REPRESENTACIÓN IMPRESA DE LA ".$venta["nombre_tipo_doc"]." ELECTRÓNICA PARA CONSULTAR EL DOCUMENTO VISITA",'ISO-8859-1', 'UTF-8'),"0","C");
       
        $pdf->Cell(100, 1, $empresa["link_sistema"], 0, 1, 'C');
        $nombre=$empresa['ruc']."-".$venta['codigo_documento']."-".$venta['serie']."-".$venta['numero'];
	 $pdf->Ln(3);
	 if($venta["estado"]=="Aceptado"){
	 	$respuesta  = getFirma($nombre);
	 	$pdf->Cell(200, 1, $respuesta, 0, 1, 'L');
	 }
	 
		

     
        $rutaqr=GetImgQr($venta,$empresa);
        $tamano_x = 25;
        $tamano_y = $variables_diversas_model->dimension_proporcion($rutaqr, $tamano_x);
      $pdf->Ln(1);
   
    		  $pdf->Image($rutaqr, 160,$total_y - $tamano_y - 135,$tamano_x,$tamano_y);
    		
    
      
      //  $pdf->Cell(85,7,"",0,0,'R');
       // $pdf->Cell(100, 0,"Emitido desde ". $empresa["link_sistema"], 0, 1, 'R');






     // cabecera a la derecha
     $pdf->Image('../files/logos/'.$empresa['logo'], 130, -10,50,50);
  
     $pdf->SetXY(120,32);
     $pdf->SetDrawColor(0, 32, 96);
    $pdf->MultiCell(80,6,"RUC"." : ".$empresa["ruc"],"1","C");
    switch ($venta['idtipo_doc']) {
        case '01':
            $tipo_documento = 'FACTURA';
            break;
        case '02':
            $tipo_documento='PROFORMA' ;
            break;       
        case '03':
            $tipo_documento = 'BOLETA';
            break;        
    } 
    $pdf->SetXY(120,38);
   
    $pdf->SetTextColor(255,255,255);
    $pdf->SetFillColor( 0, 32, 96 );
    $pdf->SetDrawColor(0, 32, 96);
    $pdf->Cell(80, 6, $tipo_documento." "."ELECTRONICA", 1, 0, 'C', True);
    //$pdf->Cell(80,6,$tipo_documento." DE VENTA ELECTRONICA","1","C",True);
     $pdf->SetXY(120,44);
     $pdf->SetDrawColor(0, 32, 96);
     $pdf->SetTextColor(0,0,0);
    $pdf->MultiCell(80,6,$venta["serie"]."-".$venta["numero"],"1","C");
    
    $pdf->SetXY(120,50);
    $pdf->Cell(80,6,utf8_decode("FECHA EMISION").": ".$venta["fecha_emision"],"0","L");
    $pdf->SetXY(120,54);
    $pdf->Cell(80,6,utf8_decode("FECHA DE VENC").": ".$venta["fecha_vencimiento"],"0","L");
   // detalle de la venta

     $nombre_pdf=$venta["razon_social"]."-".$venta["serie"]."-".$venta["numero"];
    $pdf->Output("I",$nombre_pdf.".pdf");
    
    }
    function getFirma($NomArch){
    $ruta   = 'https://apis.sichasoft.com/DEMO_API_SUNAT/files/facturacion_electronica/FIRMA/';
    $xml    = simplexml_load_file($ruta. $NomArch . '.xml');
    foreach ($xml->xpath('//ds:DigestValue') as $response) {

    }
    return $response;
}
?>