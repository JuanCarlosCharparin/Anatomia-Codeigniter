<?php
// application/controllers/ReportePdf.php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/fpdf/fpdf.php'; // Ruta a la librería FPDF

class ReportePdf extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Biopsia_model');
    }

    public function generar_pdf($nro_servicio) {
        // Obtener datos del estudio
        $estudio = $this->Biopsia_model->obtener_datos_ficha($nro_servicio);
        
        if (!$estudio) {
            show_404();
            return;
        }

        // Inicializar FPDF
        $pdf = new FPDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();

        // Header
        $this->Header($pdf);

        // Agregar contenido de la ficha
        $this->ficha_contenido($pdf, $estudio);

        // Salida del PDF
        $pdf->Output('I');

        exit;
    }

    function Header($pdf) {
        $pdf->Image('assets/images/Logo-HU.png', 15, 12, 90); // Aumentar el tamaño del logo
        $pdf->Ln(25);
    }

    function ficha_contenido($pdf, $estudio) {
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(200, 220, 255);
    
        // Inicializar coordenadas X e Y
        $x = $pdf->GetX();
        $y = $pdf->GetY();
    
        // Datos del Estudio
        $pdf->Cell(35, 10, 'Mail:', 1, 0);
        $pdf->SetX($x + 35);
        $pdf->Cell(65, 10, utf8_decode('Fecha de recepción: ' . $estudio['fecha']), 1);
        $pdf->SetX($x + 100);
        $pdf->Cell(80, 10, utf8_decode('Nº Protocolo: ' . $estudio['n_servicio']), 1, 1);
    
        // Líneas verticales
        $pdf->SetX($x);
        $pdf->Line($x + 35, $y, $x + 35, $y + 210); // Línea vertical en la segunda posición
    
        // Datos del Estudio
        $pdf->SetX($x);
        $pdf->Cell(180, 10, 'Nombre:                     ' . $estudio['paciente'], 1, 1);
    
        $pdf->SetX($x);
        $pdf->Cell(100, 10, 'DNI:                             ' . $estudio['documento'], 1, 0);
        $pdf->SetX($x + 100);
        $pdf->Cell(80, 10, 'Edad: ' . $estudio['edad'], 1, 1);
    
        $pdf->SetX($x);
        $pdf->Cell(180, 10, 'Obra Social:               ' . $estudio['obra_social'], 1, 1);
    
        $pdf->SetX($x);
        $pdf->Cell(180, 15, utf8_decode('Médico solicitante:    ' . $estudio['medico_solicitante']), 1, 1);
    
        $pdf->SetX($x);
        $pdf->Cell(180, 25, utf8_decode('Material remitido:      ' . $estudio['material']), 1, 1);
    
        $pdf->SetX($x);
        $pdf->Cell(180, 10, utf8_decode('Antecedentes:           ' . $estudio['antecedentes']), 1, 1);
    
        $pdf->SetX($x);
        $pdf->Cell(130, 40, utf8_decode('MACROSCOPÍA:        ' . $estudio['macro']), 1, 0);
        $pdf->SetX($x + 130);
        $pdf->Cell(50, 40, 'Fecha:', 1, 1);
    
        $pdf->SetX($x);
        $pdf->Cell(130, 40, utf8_decode('MICROSCOPÍA:         ' . $estudio['micro']), 1, 0);
        $pdf->SetX($x + 130);
        $contenido_celda = "
            Fecha inclusion:  
            Fecha corte:  
            Fecha entrega:
        ";
        $pdf->MultiCell(50, 8, $contenido_celda, 1, 1);
    
        $pdf->SetX($x);
        $pdf->Cell(130, 40, utf8_decode('Diagnóstico:               ' . $estudio['diagnostico']), 1, 0);
        $pdf->SetX($x + 130);
        $pdf->Cell(50, 40, 'Fecha:', 1, 1);
    }
}

