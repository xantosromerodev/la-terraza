<?php

require_once '../models/Datos_Comprobante.php';
require_once('../libs/tcpdf/tcpdf_include.php');


// llamada de la clase y sus metodos
$datos_comprobante = new Datos_Comprobante();
$empresa = $datos_comprobante->obtener_empresa();
// Crear un nuevo PDF con tamaño de ticket (por ejemplo, 80mm x 297mm)
$pdf = new TCPDF('P', 'mm', array(80, 400), true, 'UTF-8', false);

// Establecer información del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tu Nombre');
$pdf->SetTitle('Ticket de Venta');
$pdf->SetSubject('Ticket');
$pdf->SetKeywords('TCPDF, PDF, ticket, venta');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
// Eliminar los márgenes
$pdf->SetMargins(2, 2, 2);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

// Añadir una página
$pdf->AddPage();

// Establecer fuente
$pdf->SetFont('courier', '', 10);

// Título del ticket
$image_file = '../images/logo/'.$empresa['logo'];
// Insertar una imagen centrado
$img_width = 40; // Ancho de la imagen
$page_width = $pdf->getPageWidth();
$x = ($page_width - $img_width) / 2; 

$pdf->Image($image_file, $x, 5,$img_width , '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
//$pdf->Image('../images/logo/'.$empresa['logo'], 15, 140, 75, 113, 'PNG', '', true, 150, '', false, false, 1, false, false, false);
$pdf->Ln(25);
$pdf->Cell(0, 0, $empresa["nempresa"], 0, 1, 'C');
$pdf->Ln(1);
$pdf->Cell(0, 0,'RUC:' .$empresa["ruc"], 0, 1, 'C');
$pdf->Ln(1);
$pdf->MultiCell(55, 5, $empresa['domicilio'], 0, 'C', 0, 0, '', '', true);
$pdf->Ln(10);

// Información del ticket
$pdf->Cell(0, 0, 'Número de Ticket: 001', 0, 1);
$pdf->Cell(0, 0, 'Fecha: ' . date('d-m-Y H:i:s'), 0, 1);
$pdf->Ln(2);

// Línea de separación
$pdf->Cell(0, 0, str_repeat('-', 48), 0, 1, 'C');
$pdf->Ln(2);

// Tabla de productos
$products = [
    ['Producto 1', 1, 10.00],
    ['Producto 2', 2, 5.00],
    ['Producto 3', 1, 20.00],
];

$total = 0;
foreach ($products as $product) {
    list($name, $quantity, $price) = $product;
    $pdf->Cell(50, 0, $name, 0);
    $pdf->Cell(15, 0, $quantity, 0, 0, 'C');
    $pdf->Cell(15, 0, '$' . number_format($price, 2), 0, 1, 'R');
    $total += $quantity * $price;
}

// Línea de separación
$pdf->Ln(2);
$pdf->Cell(0, 0, str_repeat('-', 48), 0, 1, 'C');
$pdf->Ln(2);

// Total
$pdf->Cell(50, 0, 'Total', 0);
$pdf->Cell(15, 0, '', 0, 0, 'C');
$pdf->Cell(15, 0, '$' . number_format($total, 2), 0, 1, 'R');

// Agradecimiento
$pdf->Ln(2);
$pdf->Cell(0, 0, '¡Gracias por su compra!', 0, 1, 'C');

// Salida del PDF
$pdf->Output('ticket_venta.pdf', 'I');
