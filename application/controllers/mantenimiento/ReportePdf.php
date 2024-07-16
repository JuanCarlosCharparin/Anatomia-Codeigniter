<?php
// application/controllers/ReportePdf.php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/fpdf/fpdf.php'; // Ruta a la librería FPDF

class ReportePdf extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Cargar el modelo necesario si es necesario
        $this->load->model('Estudio_model');
        $this->load->model('Biopsia_model');
    }

    public function generar_pdf() {
        // Inicializar FPDF
        $pdf = new FPDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();

        // Agregar el encabezado
        $this->Header($pdf);

        // Agregar contenido al PDF
        $pdf->SetFont('Arial', '', 12);
        
        // Definir el contenido con celdas y líneas
        $this->ficha_contenido($pdf);

        // Generar salida del PDF (descargar o mostrar en el navegador)
        $pdf->Output('I'); // 'I' para ver el PDF en el navegador

        exit; // Detener la ejecución del script después de enviar el PDF
    }

    function Header($pdf) {
        // Logo
        $pdf->Image('assets/images/Logo-HU.png', 15, 12, 90); // Aumentar el tamaño del logo
        $pdf->Ln(25); // Añadir espacio debajo del logo
    }

    // Ficha contenido
    function ficha_contenido($pdf) {
        // Títulos de columnas
        $pdf->SetFont('Arial', 'B', 10);

        // Definir el contenido con celdas y líneas
        $pdf->SetFillColor(200, 220, 255);

        $x = $pdf->GetX();
        $y = $pdf->GetY();
        
        $pdf->Cell(35, 10, 'Mail', 1, 0);
        $pdf->Line($x + 10, $y, $x + 10, $y + 10); 

        $pdf->Cell(65, 10, 'Fecha de recepcion', 1);
        $pdf->Line($x + 75, $y, $x + 75, $y + 10); 

        $pdf->SetX($x + 100);

        $pdf->Cell(80, 10, utf8_decode('Nº Protocolo'), 1, 1);
        $pdf->Line($x + 125, $y, $x + 125, $y + 10); 
       

        // Líneas verticales
        
        $pdf->Line($x + 35, $y, $x + 35, $y + 210);// Línea vertical en la segunda posición
       

        $pdf->Cell(180, 10, 'Nombre', 1, 1);



        $pdf->Cell(100, 10, 'DNI', 1, 0);

        $pdf->Cell(80, 10, 'Edad', 1, 1);
        $pdf->Line($x + 115, $y + 30, $x + 115, $y + 20); 

        $pdf->Cell(180, 10, 'Obra Social', 1, 1);

        $pdf->Cell(180, 15, utf8_decode('Médico solicitante'), 1, 1);
        
        $pdf->Cell(180, 25, utf8_decode('Material remitido'), 1, 1);

        $pdf->Cell(180, 10, utf8_decode('Antecedentes'), 1, 1);

        $pdf->Cell(130, 40, 'MACROSCOPiA', 1, 0);
        
        $pdf->Cell(50, 40, 'Fecha:', 1, 1);

        $pdf->Cell(130, 40, 'MICROSCOPIA', 1, 0);

        /*$pdf->Cell(50, 40, utf8_decode('Fecha inclusión:'), 1, 0);

        $pdf->Cell(25, 40, utf8_decode('Fecha corte:'), 0, 0);*/

        $contenido_celda = "
        Fecha inclusion:  
        Fecha corte:  
        Fecha entrega:
        ";

        $pdf->MultiCell(50, 8, $contenido_celda, 1, 1);
        

        $pdf->Cell(130, 40, utf8_decode('Diagnóstico'), 1, 0);

        $pdf->Cell(50, 40, 'Fecha:', 1, 1);
    }
}

// Crear una instancia del controlador y llamar al método para generar el PDF
$pdf = new ReportePdf();
$pdf->generar_pdf();
