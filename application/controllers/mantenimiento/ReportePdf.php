<?php
// application/controllers/ReportePdf.php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/fpdf/fpdf.php'; // Ruta a la librería FPDF

/*require_once APPPATH . 'libraries/html2pdf/vendor/autoload.php';*/


class ReportePdf extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Biopsia_model');
    }

    public function generar_pdf($nro_servicio) {
        // Inicializar FPDF
        $pdf = new FPDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();

        // Header
        $this->Header($pdf);

        // Obtener datos del estudio
        $estudio = $this->Biopsia_model->obtener_datos_ficha($nro_servicio);
        $estudio_pap = $this->Biopsia_model->obtener_datos_pap($nro_servicio);
        $tipo_estudio = $this->Biopsia_model->tipo_estudio($nro_servicio);

        if ($tipo_estudio['tipo_estudio_id'] == 3){
            $this->contenido_pap($pdf, $estudio_pap);
        } else {
            $this->ficha_contenido($pdf, $estudio);
        }
        
    
        // Salida del PDF
        $pdf->Output('I');
        exit;

        /*$html2pdf = new \Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'es');
        $html = $this->contenido_html($nro_servicio);
        // Cargar contenido HTML
        
        $html2pdf->writeHTML($html);

        // Generar y mostrar el PDF
        $html2pdf->Output('Reporte.pdf', 'I');
        exit;*/

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









    function contenido_pap($pdf, $estudio_pap) {
       $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(200, 220, 255);
    
        // Inicializar coordenadas X e Y
        $x = $pdf->GetX();
        $y = $pdf->GetY();
    
        // Líneas verticales
        $pdf->SetX($x);
        $pdf->Line($x + 35, $y, $x + 35, $y + 210); // Línea vertical en la segunda posición
    
        // Datos del Estudio
        $pdf->Cell(35, 10, 'Mail:', 1, 0);
        $pdf->SetX($x + 35);
        $pdf->Cell(65, 10, utf8_decode('Fecha de recepción: ' . $estudio_pap['fecha']), 1);
        $pdf->SetX($x + 100);
        $pdf->Cell(80, 10, utf8_decode('Nº Protocolo: ' . $estudio_pap['n_servicio']), 1, 1);
    
        // Líneas verticales
        $pdf->SetX($x);
        $pdf->Line($x + 35, $y, $x + 35, $y + 240); // Línea vertical en la segunda posición
    
        // Datos del Estudio
        $pdf->SetX($x);
        $pdf->Cell(180, 10, 'Nombre:                     ' . $estudio_pap['paciente'], 1, 1);
    
        $pdf->SetX($x);
        $pdf->Cell(100, 10, 'DNI:                             ' . $estudio_pap['documento'], 1, 0);
        $pdf->SetX($x + 100);
        $pdf->Cell(80, 10, 'Edad: ' . $estudio_pap['edad'], 1, 1);
    
        $pdf->SetX($x);
        $pdf->Cell(180, 10, 'Obra Social:               ' . $estudio_pap['obra_social'], 1, 1);
    
        $pdf->SetX($x);
        $pdf->Cell(180, 15, utf8_decode('Médico solicitante:    ' . $estudio_pap['medico_solicitante']), 1, 1);
    
        $pdf->SetX($x);
        $pdf->Cell(180, 25, utf8_decode('Material remitido:      ' . $estudio_pap['material']), 1, 1);
    
        $pdf->SetX($x);
        $pdf->Cell(180, 10, utf8_decode('Antecedentes:           ' . $estudio_pap['antecedentes']), 1, 1);

        // Datos específicos para PAP
        $pdf->SetX($x);
        $pdf->Cell(180, 10, utf8_decode('Estado Espécimen:   ' . $estudio_pap['estado_especimen']), 1, 1);

        $pdf->SetX($x);
        $pdf->Cell(180, 10, utf8_decode('Cél. Pavimentosas:   ' . $estudio_pap['celulas_pavimentosas']), 1, 1);

        $pdf->SetX($x);
        $pdf->Cell(180, 10, utf8_decode('Cél. Cilíndricas:         ' . $estudio_pap['celulas_cilindricas']), 1, 1);

        $pdf->SetX($x);
        $pdf->Cell(180, 10, 'Valor Hormonal:        ' . $estudio_pap['valor_hormonal'], 1, 1);

        $pdf->SetX($x);
        $pdf->Cell(180, 10, 'Valor Hormonal HC:  ' . $estudio_pap['valor_hormonal_HC'], 1, 1);

        $pdf->SetX($x);
        $pdf->Cell(180, 10, 'Fecha de Lectura:     ' . $estudio_pap['fecha_lectura'], 1, 1);

        $pdf->SetX($x);
        $pdf->Cell(180, 10, 'Cambios Reactivos:  ' . $estudio_pap['cambios_reactivos'], 1, 1);

        $pdf->SetX($x);
        $pdf->Cell(180, 10, utf8_decode('C.Cél. Pavimentosa:  ' . $estudio_pap['cambios_asoc_celula_pavimentosa']), 1, 1);

        $pdf->SetX($x);
        $pdf->Cell(180, 10, utf8_decode('C.Cél. Glandulares:   ' . $estudio_pap['cambios_celula_glandulares']), 1, 1);

        $pdf->SetX($x);
        $pdf->Cell(180, 10, utf8_decode('Cél. Metaplástica:     ' . $estudio_pap['celula_metaplastica']), 1, 1);

        $pdf->SetX($x);
        $pdf->Cell(180, 10, 'Otras Neo Malignas: ' . $estudio_pap['otras_neo_malignas'], 1, 1);

        $pdf->SetX($x);
        $pdf->Cell(180, 10, 'Toma:                         ' . $estudio_pap['toma'], 1, 1);

        $pdf->SetX($x);
        $pdf->Cell(180, 10, 'Recomendaciones:   ' . $estudio_pap['recomendaciones'], 1, 1);

        $pdf->SetX($x);
        $pdf->Cell(180, 10, 'Microorganismos:     ' . $estudio_pap['microorganismos'], 1, 1);

        $pdf->SetX($x);
        $pdf->Cell(180, 10, 'Resultado:                  ' . $estudio_pap['resultado'], 1, 1);
    }
}
