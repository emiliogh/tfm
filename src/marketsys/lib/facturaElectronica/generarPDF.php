<?php

require_once('../../fpdf/fpdf.php');
require_once('../../barcode/class/BCGcode128.barcode.php');
require_once('../../barcode/class/BCGColor.php');
require_once('../../barcode/class/BCGDrawing.php');
require_once('../../barcode/class/BCGFontFile.php');
include_once("../../conexion/class.conexion.php");
require_once('enviarMailFactura.php');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of generarPDF
 *
 * @author UESR
 */
class generarPDF extends FPDF {
	
	function Code39($xpos, $ypos, $code, $baseline=0.5, $height=5){

		$wide = $baseline;
		$narrow = $baseline / 3 ; 
		$gap = $narrow;

		$barChar['0'] = 'nnnwwnwnn';
		$barChar['1'] = 'wnnwnnnnw';
		$barChar['2'] = 'nnwwnnnnw';
		$barChar['3'] = 'wnwwnnnnn';
		$barChar['4'] = 'nnnwwnnnw';
		$barChar['5'] = 'wnnwwnnnn';
		$barChar['6'] = 'nnwwwnnnn';
		$barChar['7'] = 'nnnwnnwnw';
		$barChar['8'] = 'wnnwnnwnn';
		$barChar['9'] = 'nnwwnnwnn';
		$barChar['A'] = 'wnnnnwnnw';
		$barChar[''] = 'nnwnnwnnw';
		$barChar['C'] = 'wnwnnwnnn';
		$barChar['D'] = 'nnnnwwnnw';
		$barChar['E'] = 'wnnnwwnnn';
		$barChar['F'] = 'nnwnwwnnn';
		$barChar['G'] = 'nnnnnwwnw';
		$barChar['H'] = 'wnnnnwwnn';
		$barChar['I'] = 'nnwnnwwnn';
		$barChar['J'] = 'nnnnwwwnn';
		$barChar['K'] = 'wnnnnnnww';
		$barChar['L'] = 'nnwnnnnww';
		$barChar['M'] = 'wnwnnnnwn';
		$barChar['N'] = 'nnnnwnnww';
		$barChar['O'] = 'wnnnwnnwn'; 
		$barChar['P'] = 'nnwnwnnwn';
		$barChar['Q'] = 'nnnnnnwww';
		$barChar['R'] = 'wnnnnnwwn';
		$barChar['S'] = 'nnwnnnwwn';
		$barChar['T'] = 'nnnnwnwwn';
		$barChar['U'] = 'wwnnnnnnw';
		$barChar['V'] = 'nwwnnnnnw';
		$barChar['W'] = 'wwwnnnnnn';
		$barChar['X'] = 'nwnnwnnnw';
		$barChar['Y'] = 'wwnnwnnnn';
		$barChar['Z'] = 'nwwnwnnnn';
		$barChar['-'] = 'nwnnnnwnw';
		$barChar['.'] = 'wwnnnnwnn';
		$barChar[' '] = 'nwwnnnwnn';
		$barChar['*'] = 'nwnnwnwnn';
		$barChar['$'] = 'nwnwnwnnn';
		$barChar['/'] = 'nwnwnnnwn';
		$barChar['+'] = 'nwnnnwnwn';
		$barChar['%'] = 'nnnwnwnwn';

		$this->SetFont('Arial','',8.6);
		$this->Text($xpos, $ypos + $height + 4, $code);
		$this->SetFillColor(0);

		$code = '*'.strtoupper($code).'*';
		for($i=0; $i<strlen($code); $i++){
			$char = $code[$i];
			if(!isset($barChar[$char])){
				$this->Error('Invalid character in barcode: '.$char);
			}
			$seq = $barChar[$char];
			for($bar=0; $bar<9; $bar++){
				if($seq[$bar] == 'n'){
					$lineWidth = $narrow;
				}else{
					$lineWidth = $wide;
				}
				if($bar % 2 == 0){
					$this->Rect($xpos, $ypos, $lineWidth, $height, 'F');
				}
				$xpos += $lineWidth;
			}
			$xpos += $gap;
		}
	  }
	
	function RoundedRect($x, $y, $w, $h, $r, $corners = '1234', $style = '')
    {
        $k = $this->k;
        $hp = $this->h;
        if($style=='F')
            $op='f';
        elseif($style=='FD' || $style=='DF')
            $op='B';
        else
            $op='S';
        $MyArc = 4/3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));

        $xc = $x+$w-$r;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));
        if (strpos($corners, '2')===false)
            $this->_out(sprintf('%.2F %.2F l', ($x+$w)*$k,($hp-$y)*$k ));
        else
            $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);

        $xc = $x+$w-$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
        if (strpos($corners, '3')===false)
            $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-($y+$h))*$k));
        else
            $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);

        $xc = $x+$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
        if (strpos($corners, '4')===false)
            $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-($y+$h))*$k));
        else
            $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);

        $xc = $x+$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
        if (strpos($corners, '1')===false)
        {
            $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$y)*$k ));
            $this->_out(sprintf('%.2F %.2F l',($x+$r)*$k,($hp-$y)*$k ));
        }
        else
            $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
            $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
    }
	
	function GetMultiCellHeight($w, $h, $txt, $border=null, $align='J') {
		// Calculate MultiCell with automatic or explicit line breaks height
		// $border is un-used, but I kept it in the parameters to keep the call
		//   to this function consistent with MultiCell()
		$cw = &$this->CurrentFont['cw'];
		if($w==0)
			$w = $this->w-$this->rMargin-$this->x;
		$wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
		$s = str_replace("\r",'',$txt);
		$nb = strlen($s);
		if($nb>0 && $s[$nb-1]=="\n")
			$nb--;
		$sep = -1;
		$i = 0;
		$j = 0;
		$l = 0;
		$ns = 0;
		$height = 0;
		while($i<$nb)
		{
			// Get next character
			$c = $s[$i];
			if($c=="\n")
			{
				// Explicit line break
				if($this->ws>0)
				{
					$this->ws = 0;
					$this->_out('0 Tw');
				}
				//Increase Height
				$height += $h;
				$i++;
				$sep = -1;
				$j = $i;
				$l = 0;
				$ns = 0;
				continue;
			}
			if($c==' ')
			{
				$sep = $i;
				$ls = $l;
				$ns++;
			}
			$l += $cw[$c];
			if($l>$wmax)
			{
				// Automatic line break
				if($sep==-1)
				{
					if($i==$j)
						$i++;
					if($this->ws>0)
					{
						$this->ws = 0;
						$this->_out('0 Tw');
					}
					//Increase Height
					$height += $h;
				}
				else
				{
					if($align=='J')
					{
						$this->ws = ($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
						$this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
					}
					//Increase Height
					$height += $h;
					$i = $sep+1;
				}
				$sep = -1;
				$j = $i;
				$l = 0;
				$ns = 0;
			}
			else
				$i++;
		}
		// Last chunk
		if($this->ws>0)
		{
			$this->ws = 0;
			$this->_out('0 Tw');
		}
		//Increase Height
		$height += $h;

		return $height;
	}
	
    public function facturaPDF($document, $claveAcceso,$idFactura) {
        $pdf = new FPDF();
        $pdf->AddPage();
		$db = new MySQL();
		/*
        $pdf->SetFont('Arial', 'B', 8);
//$pdf->Cell(40, 10, 'Hello World!');
        if ($document->infoFactura->obligadoContabilidad == 'SI') {

            $contabilidad = "Obligado a llevar contabilidad : SI";
        } else {
            $contabilidad = "Obligado a llevar contabilidad : NO";
        }
        $pdf->SetXY(10, 0);
        $pdf->image('uploads/logo.jpg', null, null, 80, 30);

        $pdf->SetXY(110, 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->MultiCell(100, 10, "RUC: " . $document->infoTributaria->ruc, 0, 'J', true);
        $pdf->SetXY(110, 15);
        $pdf->MultiCell(100, 10, "Factura Nro: " . $document->infoTributaria->estab . $document->infoTributaria->ptoEmi . $document->infoTributaria->secuencial, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(110, 20);
        $pdf->MultiCell(100, 10, 'Nro Autorizacion: ', 0);
        $pdf->SetXY(110, 25);
        $pdf->MultiCell(100, 10, $claveAcceso, 0);
        $pdf->SetXY(110, 30);
        if ($document->infoTributaria->ambiente == 2) {
            $ambiente = 'PRODUCCION';
        } else {
            $ambiente = 'PRUEBAS';
        }
        $pdf->MultiCell(100, 10, 'Ambiente: ' . $ambiente, 0);
        $pdf->SetXY(110, 35);
        if ($document->infoTributaria->tipoEmision == 1) {
            $emision = 'NORMAL';
        } else {
            $emision = 'NORMAL';
        }
        $pdf->MultiCell(100, 10, 'Emision: ' . $emision, 0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetXY(10, 20);
        $pdf->MultiCell(100, 10, $document->infoTributaria->razonSocial, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(10, 25);
        $pdf->MultiCell(100, 10, $document->infoTributaria->dirMatriz, 0);
        $pdf->SetXY(10, 30);
        $pdf->MultiCell(100, 10, $contabilidad, 0);
        //Codigo de barras

        $pdf->SetXY(110, 60);
        $this->generarCodigoBarras($claveAcceso);
        $pdf->image('uploads/codigo_mod.png', null, null, 100, 20);
        $pdf->SetXY(110, 78);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(100, 10, $claveAcceso, 0, 0, "C", true);

        //informacion del cliente
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);

        $pdf->SetXY(10, 35);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->MultiCell(100, 10, "INFORMACION DEL CLIENTE", 0);

        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(10, 40);
        $pdf->MultiCell(100, 10, "RUC/CI: " . $document->infoFactura->identificacionComprador, 0);
        $pdf->SetXY(10, 45);
        $pdf->MultiCell(100, 10, "Razon Social/Nombre: " . $document->infoFactura->razonSocialComprador, 0);
        $pdf->SetXY(10, 50);
        $pdf->MultiCell(100, 10, "Direccion: " . $document->infoFactura->direccionComprador, 0);
        $pdf->SetXY(10, 55);
        $pdf->MultiCell(100, 10, "Fecha Emision: " . $document->infoFactura->fechaEmision, 0);

        $ejeX = 65;

        $pdf->SetXY(10, $ejeX);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->MultiCell(100, 10, "FORMAS DE PAGO", 0);
        $pdf->SetFont('Arial', '', 8);
        $ejeX = $ejeX + 10;
        $pdf->SetXY(10, $ejeX);
        foreach ($document->infoFactura->pagos->pago as $e => $f) {
            if ($f->formaPago == '01') {
                $pdf->SetXY(22, $ejeX);
                $pdf->Cell(30, 10, 'Sin utilizacion del sistema financiero', 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(4, $ejeX);
                $pdf->Cell(30, 10, 'Total: ' . $f->total, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(0, $ejeX);
                $pdf->Cell(30, 10, 'Plazo: ' . $f->plazo, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(10, $ejeX);
                $pdf->Cell(30, 10, 'Unidad de tiempo: ' . $f->unidadTiempo, 0, 0, "C", true);
            }
            if ($f->formaPago == '15') {
                $pdf->SetXY(22, $ejeX);
                $pdf->Cell(30, 10, 'Compensacion de deudas', 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(4, $ejeX);
                $pdf->Cell(30, 10, 'Total: ' . $f->total, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(0, $ejeX);
                $pdf->Cell(30, 10, 'Plazo: ' . $f->plazo, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(10, $ejeX);
                $pdf->Cell(30, 10, 'Unidad de tiempo: ' . $f->unidadTiempo, 0, 0, "C", true);
            }
            if ($f->formaPago == '16') {
                $pdf->SetXY(22, $ejeX);
                $pdf->Cell(30, 10, 'Tarjeta debito', 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(4, $ejeX);
                $pdf->Cell(30, 10, 'Total: ' . $f->total, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(0, $ejeX);
                $pdf->Cell(30, 10, 'Plazo: ' . $f->plazo, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(10, $ejeX);
                $pdf->Cell(30, 10, 'Unidad de tiempo: ' . $f->unidadTiempo, 0, 0, "C", true);
            }
            if ($f->formaPago == '17') {
                $pdf->SetXY(22, $ejeX);
                $pdf->Cell(30, 10, 'Dinero Electronico', 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(4, $ejeX);
                $pdf->Cell(30, 10, 'Total: ' . $f->total, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(0, $ejeX);
                $pdf->Cell(30, 10, 'Plazo: ' . $f->plazo, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(10, $ejeX);
                $pdf->Cell(30, 10, 'Unidad de tiempo: ' . $f->unidadTiempo, 0, 0, "C", true);
            }
            if ($f->formaPago == '18') {
                $pdf->SetXY(22, $ejeX);
                $pdf->Cell(30, 10, 'Tarjeta Prepago', 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(4, $ejeX);
                $pdf->Cell(30, 10, 'Total: ' . $f->total, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(0, $ejeX);
                $pdf->Cell(30, 10, 'Plazo: ' . $f->plazo, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(10, $ejeX);
                $pdf->Cell(30, 10, 'Unidad de tiempo: ' . $f->unidadTiempo, 0, 0, "C", true);
            }
            if ($f->formaPago == '19') {
                $pdf->SetXY(10, $ejeX);
                $pdf->Cell(20, 10, 'Tarjeta de credito', 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(4, $ejeX);
                $pdf->Cell(30, 10, 'Total: ' . $f->total, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(1, $ejeX);
                $pdf->Cell(30, 10, 'Plazo: ' . $f->plazo, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(10, $ejeX);
                $pdf->Cell(30, 10, 'Unidad de tiempo: ' . $f->unidadTiempo, 0, 0, "C", true);
            }
            if ($f->formaPago == '20') {
                $pdf->SetXY(22, $ejeX);
                $pdf->Cell(30, 10, 'Otros con utilizacion del sistema financiero', 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(4, $ejeX);
                $pdf->Cell(30, 10, 'Total: ' . $f->total, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(0, $ejeX);
                $pdf->Cell(30, 10, 'Plazo: ' . $f->plazo, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(10, $ejeX);
                $pdf->Cell(30, 10, 'Unidad de tiempo: ' . $f->unidadTiempo, 0, 0, "C", true);
            }
            if ($f->formaPago == '21') {
                $pdf->SetXY(22, $ejeX);
                $pdf->Cell(30, 10, 'Endoso de titulos', 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(4, $ejeX);
                $pdf->Cell(30, 10, 'Total: ' . $f->total, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(0, $ejeX);
                $pdf->Cell(30, 10, 'Plazo: ' . $f->plazo, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(10, $ejeX);
                $pdf->Cell(30, 10, 'Unidad de tiempo: ' . $f->unidadTiempo, 0, 0, "C", true);
            }

            $ejeX = $ejeX + 10;
            $pdf->SetX($ejeX);
        }





        //detalle de la factura
        $pdf->SetXY(10, $ejeX + 10);
        $pdf->SetFillColor(255, 0, 0);
        $pdf->SetTextColor(0, 255, 255);
        $pdf->Cell(30, 10, "Codigo", 1, 0, "C", true);
        $pdf->Cell(25, 10, "Cod. Aux", 1, 0, "C", true);
        $pdf->Cell(45, 10, "Descripcion", 1, 0, "C", true);
        $pdf->Cell(25, 10, "Cantidad", 1, 0, "C", true);
        $pdf->Cell(25, 10, "Precio", 1, 0, "C", true);
        $pdf->Cell(25, 10, "% Desc", 1, 0, "C", true);
        $pdf->Cell(25, 10, "Total", 1, 0, "C", true);

        $ejeX = $ejeX + 20;
        $pdf->SetXY(10, $ejeX);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);

        foreach ($document->detalles->detalle as $a => $b) {
            $pdf->Cell(30, 10, $b->codigoPrincipal, 1, 0, "C", true);
            $pdf->Cell(25, 10, $b->codigoAuxiliar, 1, 0, "C", true);
            $pdf->Cell(45, 10, $b->descripcion, 1, 0, "C", true);
            $pdf->Cell(25, 10, $b->cantidad, 1, 0, "C", true);
            $pdf->Cell(25, 10, number_format(floatval($b->precioUnitario), 2), 1, 0, "C", true);
            $pdf->Cell(25, 10, $b->descuento, 1, 0, "C", true);
            $pdf->Cell(25, 10, $b->precioTotalSinImpuesto, 1, 0, "C", true);
            $ejeX = $ejeX + 10;
            $pdf->SetXY(10, $ejeX);
        }

        //Total de la factura



        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);
        $iva = 0;
        $ice = 0;
        $IRBPNR = 0;
        $subtotal12 = 0;
        $subtotal0 = 0;
        $subtotal_no_impuesto = 0;
        $subtotal_no_iva = 0;
        foreach ($document->infoFactura->totalConImpuestos->totalImpuesto as $a => $b) {
            if ($b->codigo == 2) {
                $iva = $b->valor;
                if ($b->codigoPorcentaje == 0) {
                    $subtotal0 = $b->baseImponible;
                }
                if ($b->codigoPorcentaje == 2) {
                    $subtotal12 = $b->baseImponible;
                    //    $iva = $b->valor;
                }
                if ($b->codigoPorcentaje == 6) {
                    $subtotal_no_impuesto = $b->baseImponible;
                }
                if ($b->codigoPorcentaje == 7) {
                    $subtotal_no_iva = $b->baseImponible;
                }
            }
            if ($b->codigo == 3) {
                $ice = $b->valor;
            }
            if ($b->codigo == 5) {
                $IRBPNR = $b->valor;
            }
        }
        $pdf->SetXY(130, $ejeX + 10);
        $pdf->Cell(25, 10, "Subtotal 12%: ", 0, 0, "L", true);
        $pdf->SetXY(180, $ejeX + 10);
        $pdf->Cell(25, 10, " $subtotal12 ", 0, 0, "R", true);
        $pdf->SetXY(130, $ejeX + 16);
        $pdf->Cell(25, 10, "SubTotal 0%: ", 0, 0, "L", true);
        $pdf->SetXY(180, $ejeX + 16);
        $pdf->Cell(25, 10, $subtotal0, 0, 0, "R", true);
        $pdf->SetXY(130, $ejeX + 22);
        $pdf->Cell(25, 10, "SubTotal no sujeto de IVA: ", 0, 0, "L", true);
        $pdf->SetXY(180, $ejeX + 22);
        $pdf->Cell(25, 10, $subtotal_no_impuesto, 0, 0, "R", true);
        $pdf->SetXY(130, $ejeX + 28);
        $pdf->Cell(25, 10, "SubTotal exento de IVA: ", 0, 0, "L", true);
        $pdf->SetXY(180, $ejeX + 28);
        $pdf->Cell(25, 10, $subtotal_no_iva, 0, 0, "R", true);
        $pdf->SetXY(130, $ejeX + 34);
        $pdf->Cell(25, 10, "SubTotal sin Impuestos: ", 0, 0, "L", true);
        $pdf->SetXY(180, $ejeX + 34);
        $pdf->Cell(25, 10, $document->infoFactura->totalDescuento, 0, 0, "R", true);
        $pdf->SetXY(130, $ejeX + 40);
        $pdf->Cell(25, 10, "Descuento: ", 0, 0, "L", true);
        $pdf->SetXY(180, $ejeX + 40);
        $pdf->Cell(25, 10, $document->infoFactura->totalDescuento, 0, 0, "R", true);
        $pdf->SetXY(130, $ejeX + 46);
        $pdf->Cell(25, 10, "IVA 12%: ", 0, 0, "L");
        $pdf->SetXY(180, $ejeX + 46);
        $pdf->Cell(25, 10, $iva, 0, 0, "R");
        $pdf->SetXY(130, $ejeX + 52);
        $pdf->Cell(25, 10, "ICE: ", 0, 0, "L");
        $pdf->SetXY(180, $ejeX + 52);
        $pdf->Cell(25, 10, $ice, 0, 0, "R");
        $pdf->SetXY(130, $ejeX + 58);
        $pdf->Cell(25, 10, "IRBPNR: ", 0, 0, "L");
        $pdf->SetXY(180, $ejeX + 58);
        $pdf->Cell(25, 10, $IRBPNR, 0, 0, "R");
        $pdf->SetXY(130, $ejeX + 64);
        $pdf->Cell(25, 10, "Valor Total: ", 0, 0, "L");
        $pdf->SetXY(180, $ejeX + 64);
        $pdf->Cell(25, 10, $document->infoFactura->importeTotal, 0, 0, "R");

        $infoAdicional = "";
        $correo = "";

        foreach ($document->infoAdicional->campoAdicional as $a) {
            foreach ($a->attributes() as $b) {
                if ($b == 'Email' || $b == 'email' || $b == '=correo' || $b == 'Correo') {
                    $correo = $a;
                    $infoAdicional .= $b . ': ' . $a . "\n";
                } else {
                    $infoAdicional .= $b . ': ' . $a . "\n";
                }
            }
        }

        $pdf->SetXY(10, $ejeX + 10);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->MultiCell(100, 10, "Informacion Adicional", 0);
        $pdf->SetXY(10, $ejeX + 30);
        $pdf->SetFont('Arial', '', 7);
        $pdf->MultiCell(100, 5, "" . $infoAdicional . "", 0);
        // Pie de pagina
        //$pdf->SetXY(110, $ejeX + 80);
        //$pdf->MultiCell(100, 5, "EXIJA AL VENDEDOR EL RECIBO DE PAGO CUANDO ABONE O \nCANCELE UNA FACTURA UNICO DOCUMENTO VALIDO PARA RESPALDAR SU PAGO", 0, 'C');*/
		
		$pdf->SetFont('Arial', 'B', 8);
		/*Información Visual*/
		$pdf->Image('../../images/electronico/logoRide.jpg',3,0,100);
		$pdf->SetFillColor(214,214,214);
		$pdf->SetY(41.5); $pdf->SetX(5);	
		$pdf->Cell(116,54.5,'',0,1,'I',true);
		$pdf->SetY(98); $pdf->SetX(5);	
		$pdf->Cell(197,20.5,'',0,1,'I',true);
		
		$pdf->SetY(120.5); $pdf->SetX(5);
		$pdf->SetFillColor(0, 106, 46);
		$pdf->Cell(197,10,'',0,1,'I',true);
		
		$pdf->SetFillColor(256,256,256);
		$pdf->SetDrawColor(0, 106, 46);
		$this->RoundedRect(121, 10, 81, 86, 5, '13', 'DF');
		
		$pdf->SetDrawColor(255,255,255); $pdf->SetFillColor(255,255,255); 
		$pdf->SetFont('Arial','b',10);
		$pdf->SetY(12); $pdf->SetX(124);	
		$pdf->Cell(0,5,utf8_decode('R.U.C.: '),1,1,'I',true);
		$pdf->SetY(24); $pdf->SetX(124);
		$pdf->Cell(0,5,utf8_decode('FACTURA'),1,1,'I',true);
		$pdf->SetY(36); $pdf->SetX(124);
		$pdf->Cell(0,5,utf8_decode('NÚMERO DE AUTORIZACIÓN'),1,1,'I',true);
		$pdf->SetY(48); $pdf->SetX(124);
		$pdf->Cell(0,5,utf8_decode('FECHA Y HORA DE AUTORIZACIÓN'),1,1,'I',true);
		$pdf->SetY(60); $pdf->SetX(124);
		$pdf->Cell(0,5,utf8_decode('AMBIENTE:'),1,1,'I',true);
		$pdf->SetY(66); $pdf->SetX(124);
		$pdf->Cell(0,5,utf8_decode('EMISIÓN:'),1,1,'I',true);
		$pdf->SetY(72); $pdf->SetX(124);
		$pdf->Cell(0,5,utf8_decode('CLAVE DE ACCESO'),1,1,'I',true);
		
		
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetY(60); $pdf->SetX(8);$pdf->SetFont('helvetica','b',10);
		$pdf->Cell(40,4,utf8_decode('Dirección Matriz:'),0,1,'I',false);
		$pdf->SetY(73); $pdf->SetX(8);
		$pdf->Cell(40,4,utf8_decode('Dirección Sucursal:'),0,1,'I',false);
		$pdf->SetY(85); $pdf->SetX(8);
		$pdf->Cell(40,4,utf8_decode('Contribuyente especial N° :'),0,1,'I',false);
		$pdf->SetY(90); $pdf->SetX(8);
		$pdf->Cell(40,4,utf8_decode('Obligado a llevar contabilidad:'),0,1,'I',false);
		
		$pdf->SetY(100); $pdf->SetX(8);
		$pdf->SetFont('Arial','b',10);
		$pdf->Cell(40,4,utf8_decode('Razón Social/Nombre y Apellidos:'),0,1,'I',false);
		$pdf->SetY(113); $pdf->SetX(8);
		$pdf->Cell(40,4,utf8_decode('Fecha Emisión:'),0,1,'I',false);
		$pdf->SetY(113); $pdf->SetX(150);
		$pdf->Cell(40,4,utf8_decode('Identificación:'),0,1,'I',false);
		
		$pdf->SetFont('Arial','b',6);
		$pdf->SetY(123.5); $pdf->SetX(8);
		$pdf->SetTextColor(214, 214, 214);
		$pdf->Cell(40,4,utf8_decode('CÓDIGO'),0,1,'I',false);
		$pdf->SetY(123.5); $pdf->SetX(18);
		$pdf->Cell(40,4,'CANTIDAD',0,1,'I',false);
		$pdf->SetY(123.5); $pdf->SetX(31);
		$pdf->Cell(40,4,utf8_decode('DESCRIPCIÓN'),0,1,'I',false);
		$pdf->SetY(122.5); $pdf->SetX(91);
		$pdf->MultiCell(15,3,'DETALLE ADICIONAL',0,'C');
		$pdf->SetY(122.5); $pdf->SetX(108);
		$pdf->MultiCell(15,3,'DETALLE ADICIONAL',0,'C');
		$pdf->SetY(122.5); $pdf->SetX(125);
		$pdf->MultiCell(15,3,'DETALLE ADICIONAL',0,'C');
		$pdf->SetY(121.8); $pdf->SetX(145);
		$pdf->MultiCell(15,2.5,'PRECIO UNITARIO USD',0,'C');
		$pdf->SetY(122.5); $pdf->SetX(165);
		$pdf->MultiCell(16,3,'DESCUENTO USD',0,'C');
		$pdf->SetY(121.8); $pdf->SetX(185);
		$pdf->MultiCell(14,2.5,'PRECIO TOTAL USD',0,'C');
		
		$db = new MySQL();
		$query = "select e.numero_identificacion, ".
						"e.razon_social, ". 
						"e.abreviatura, ".
			            "s.direccion, ".
						"s.direccion, ".
						"s.direccion, ".
						"p.numero_factura, ".
						"'', ".
			            "DATE_FORMAT(p.fecha_factura,'%d/%m/%Y'), ".
						"DATE_FORMAT(p.fecha_maxima_pago,'%d/%m/%Y'), ".
						"p.monto_subtotal, ".
						"p.monto_subtotal0, ".
						"p.monto_subtotal_impuesto, ".
						"p.porcentaje_impuesto, ".
						"p.monto_impuesto, ".
						"p.monto_total, ".
						"c.numero_identificacion, ".
						"c.nombre_cliente, ".
						"c.direccion, ".
						"c.direccion, ".
						"c.correo_electronico, ".
						"c.telefono, ".
			            "p.numero_autorizacion, ".
			            "p.fecha_autorizacion_electronico, ".
			            "case when p.id_ambiente = 1 then 'PRUEBAS' when p.id_ambiente = 2 then 'PRODUCCIÓN' end, ". 
			            "case when p.id_ambiente = 1 then 'EMISIÓN NORMAL' else 'NORMAL' end ,  ".
			            "ifnull(i.id_contribuyente_especial,0) contribuyente, ".
				        "case when i.obligado_contabilidad= 'S' then 'SI' when i.obligado_contabilidad = 'N' then 'NO' end contabilidad ".
			       "from tsc_facturas p ".
				  "inner join tcu_clientes c ".
			         "on c.id_cliente = p.id_cliente ".
				  "inner join tgn_empresas e ".
			         "on e.estado = 'A' ". 
			      "inner join tsc_establecimientos s ".
				     "on s.identificador_matriz  = 'S' ".
			      "inner join tsc_puntos_emision pt ".
				     "on pt.id_establecimiento 	 = s.id_establecimiento ".
			      "inner join tgn_empresas em ".
					 "on em.estado = 'A' ".
				  "inner join tgn_empresas_info_tributaria i ".
					 "on i.estado = 'A' ".
					"and i.id_empresa = em.id_empresa ".
				  "WHERE p.id_factura 		  	 = '".$idFactura."' ".
			        "AND p.estado				 != 'A' ";
		
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		$subTotal0 = 0;
		$subTotal12 = 0;
		$porcentaje = 0;
		$iva = 0;
		$descuento = 0;
		$total = 0;
		$direccion = '';
		$telefono = '';
		$email = '';
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){ 
			 	$pdf->SetTextColor(0, 106, 46);
				$pdf->SetFont('Arial','',14);
				$pdf->SetY(16); $pdf->SetX(124);	
				$pdf->Cell(0,5,$resultados[0],1,1,'I',0);
				$pdf->SetY(28); $pdf->SetX(124);	
				$pdf->Cell(0,5,$resultados[6],1,1,'I',0);
				$pdf->SetFont('Arial','',8.5);
				$pdf->SetY(40); $pdf->SetX(124);	
				$pdf->Cell(0,5,$resultados[22],1,1,'I',0);//AUTORIZACIÓN
				$pdf->SetFont('Arial','',14);
				$pdf->SetY(52); $pdf->SetX(124);	
				$pdf->Cell(0,5,$resultados[23],1,1,'I',0);//FECHA AUTORIZACION
				$pdf->SetFont('Arial','',10);
				$pdf->SetY(60); $pdf->SetX(154);	
				$pdf->Cell(0,5,utf8_decode($resultados[24]),1,1,'I',0);//AMBIENTE
				$pdf->SetY(66); $pdf->SetX(154);	
				$pdf->MultiCell(0,5,utf8_decode($resultados[25]),0,'J');//EMISION
				
				$pdf->SetFont('Arial','',8.5);
				$pdf->SetY(86); $pdf->SetX(154);	
				$this->Code39(124,78,$resultados[22],.28,12);
				
				$pdf->SetY(45); $pdf->SetX(8);
				$pdf->SetFont('Arial','',12);
				$pdf->MultiCell(110,3.5,utf8_decode($resultados[1]),0,'C');
				$pdf->SetY(53); $pdf->SetX(8);$pdf->SetFont('helvetica','b',18);
				$pdf->Cell(110,4,utf8_decode($resultados[2]),0,1,'C',false);
				
				$pdf->SetY(65); $pdf->SetX(8);$pdf->SetFont('Arial','',10);
				$pdf->MultiCell(110,3,$resultados[4],0,'J');
				$pdf->SetY(77); $pdf->SetX(8);
				$pdf->MultiCell(110,3,$resultados[5],0,'J');
				
				$this->SetY(85); $this->SetX(68);
				$this->Cell(40,4,utf8_decode($resultados[26]),0,1,'I',false);
				$this->SetY(90); $this->SetX(68);
				$this->Cell(40,4,utf8_decode($resultados[27]),0,1,'I',false);

				$pdf->SetY(113); $pdf->SetX(175);$pdf->SetFont('Arial','',10);
				$pdf->Cell(40,4,utf8_decode($resultados[16]),0,1,'I',false);
				$pdf->SetY(105); $pdf->SetX(12);
				$pdf->MultiCell(185,3,utf8_decode($resultados[17]),0,'J');
				$pdf->SetY(113.5); $pdf->SetX(36);
				$pdf->MultiCell(80,3,utf8_decode($resultados[8]),2,'J');
				
				//******//
				$subTotal0 		= $resultados[11];
				$subTotal12 	= $resultados[12];
				$porcentaje 	= $resultados[13];
				$iva 			= $resultados[14];
				$total 			= $resultados[15];
				
				$direccion 	= $resultados[19];
				$telefono 	= $resultados[21];
				$email 		= $resultados[20];
			}
		}	
		
		///sleep(5);
		$query = "select LPAD(df.id_producto,4,'0'), ".
						"df.cantidad, ". 
						"df.descripcion_rubro, ".
			            "'', ".
						"'', ".
						"'', ".
						"df.precio_venta, ".
						"df.descuento, ".
						"df.total ".
			       "from tsc_facturas p ".
				  "inner join tsc_detalles_factura df ".
			         "on p.id_factura = df.id_factura ".
				  "WHERE p.id_factura 		  	 = '".$idFactura."' ";
		
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		$fila = 131;
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){
				  	$pdf->SetFont('Arial','',7);
					$pdf->SetY($fila); $pdf->SetX(31);
				    $alto = $this->GetMultiCellHeight(60,2.5, utf8_decode($resultados[2]),0,'J');
				    //$pdf->SetY($fila); $pdf->SetX(31);
					//$pdf->MultiCell(60,2.5,$alto.utf8_decode($resultados[2]),0,'J');
				
					$pdf->SetY($fila); $pdf->SetX(8);
				    $pdf->Cell(10,$alto,$resultados[0],0,1,'R',false);
					$pdf->SetY($fila); $pdf->SetX(18);
					$pdf->Cell(10,$alto,utf8_decode($resultados[1]),0,1,'R',false);
					$pdf->SetY($fila); $pdf->SetX(31);
					$pdf->MultiCell(60,2.5,utf8_decode($resultados[2]),0,'J');
					$pdf->SetY($fila); $pdf->SetX(145);
					$pdf->MultiCell(13,$alto,number_format($resultados[6],2),0,'R');
					$pdf->SetY($fila); $pdf->SetX(165);
					$pdf->MultiCell(13,$alto,number_format($resultados[7],2),0,'R');
					$pdf->SetY($fila); $pdf->SetX(184);
					$pdf->MultiCell(13,$alto,number_format($resultados[8],2),0,'R');

					$fila = $fila+$alto+1;
					$pdf->SetDrawColor(130,167,195);
					$pdf->line(6,$fila-.5,201,$fila-.5);
			}
		}
			
		/*DATOS CONTACTO*/
		$fila = $fila - 0.5;
		$pdf->SetFillColor(214,214,214);
		$pdf->SetY($fila); $pdf->SetX(5);	
		$pdf->Cell(120,48,'',0,1,'I',true);
		
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetY($fila+2); $pdf->SetX(8);$pdf->SetFont('helvetica','',10);
		$pdf->Cell(40,4,utf8_decode('Dirección:'),0,1,'I',false);
		$pdf->SetY($fila+12); $pdf->SetX(8);
		$pdf->Cell(40,4,utf8_decode('Teléfono:'),0,1,'I',false);
		$pdf->SetY($fila+22); $pdf->SetX(8);
		$pdf->Cell(40,4,utf8_decode('Email:'),0,1,'I',false);
		$pdf->SetY($fila+32); $pdf->SetX(8);
		$pdf->Cell(40,4,utf8_decode('Forma de pago:'),0,1,'I',false);
		
		$pdf->SetTextColor(0, 106, 46);
		$pdf->SetFont('Arial','',10);
		$pdf->SetY($fila+5); $pdf->SetX(8);	
		$pdf->Cell(40,5,$direccion,0,1,'I',0);
		$pdf->SetY($fila+15); $pdf->SetX(8);	
		$pdf->Cell(40,5,$telefono,0,1,'I',0);
		$pdf->SetY($fila+25); $pdf->SetX(8);	
		$pdf->Cell(40,5,$email,0,1,'I',0);
		$pdf->SetY($fila+35); $pdf->SetX(8);	
		$pdf->Cell(40,5,utf8_decode('OTROS CON UTILIZACION DEL SISTEMA FINANCIERO'),0,1,'I',0);
		
		/*DEUDA*/
		$pdf->SetY($fila); $pdf->SetX(124);	
		$pdf->Cell(78,48,'',0,1,'I',true);
		$pdf->SetFont('Arial','',9);
		$pdf->SetFillColor(0, 106, 46);
		$pdf->SetTextColor(214, 214, 214);

		$pdf->SetY($fila); $pdf->SetX(124); $pdf->SetFont('Arial','',9);	
		$pdf->Cell(78,6,'',1,1,'I',true);
		$pdf->SetY($fila); $pdf->SetX(126);	
		$pdf->Cell(78,6,'SUBTOTAL 12% ',0,1,'I',false);
		$pdf->SetY($fila); $pdf->SetX(168); $pdf->SetFont('Arial','',10);	
		$pdf->Cell(30,6,number_format($subTotal12,2),0,1,'R',false);


		$pdf->SetY($fila+6); $pdf->SetX(124);	$pdf->SetFont('Arial','',9);
		$pdf->Cell(78,6,'',1,1,'I',true);
		$pdf->SetY($fila+6); $pdf->SetX(126);	
		$pdf->Cell(78,6,'SUBTOTAL 0% ',0,1,'I',false);
		$pdf->SetY($fila+6); $pdf->SetX(168);	$pdf->SetFont('Arial','',10);
		$pdf->Cell(30,6,number_format($subTotal0,2),0,1,'R',false);

		$pdf->SetY($fila+12); $pdf->SetX(124); $pdf->SetFont('Arial','',9);	
		$pdf->Cell(78,6,'',1,1,'I',true);
		$pdf->SetY($fila+12); $pdf->SetX(126);	
		$pdf->Cell(78,6,'SUBTOTAL NO OBJETO DE IVA',0,1,'I',false);
		$pdf->SetY($fila+12); $pdf->SetX(168); $pdf->SetFont('Arial','',10);	
		$pdf->Cell(30,6,'0.00',0,1,'R',false);

		$pdf->SetY($fila+18); $pdf->SetX(124); $pdf->SetFont('Arial','',9);	
		$pdf->Cell(78,6,'',1,1,'I',true);
		$pdf->SetY($fila+18); $pdf->SetX(126);	
		$pdf->Cell(78,6,'SUBTOTAL EXENTO DE IVA ',0,1,'I',false);
		$pdf->SetY($fila+18); $pdf->SetX(168); $pdf->SetFont('Arial','',10);
		$pdf->Cell(30,6,'0.00',0,1,'R',false);

		$pdf->SetY($fila+24); $pdf->SetX(124); $pdf->SetFont('Arial','',9);	
		$pdf->Cell(78,6,'',1,1,'I',true);
		$pdf->SetY($fila+24); $pdf->SetX(126);	
		$pdf->Cell(78,6,'SUBTOTAL SIN IMPUESTOS ',0,1,'I',false);
		$pdf->SetY($fila+24); $pdf->SetX(168); $pdf->SetFont('Arial','',10);	
		$pdf->Cell(30,6,'0.00',0,1,'R',false);

		$pdf->SetY($fila+30); $pdf->SetX(124); $pdf->SetFont('Arial','',9);	
		$pdf->Cell(78,6,'',1,1,'I',true);
		$pdf->SetY($fila+30); $pdf->SetX(126);	
		$pdf->Cell(78,6,'TOTAL DESCUENTO ',0,1,'I',false);
		$pdf->SetY($fila+30); $pdf->SetX(168); $pdf->SetFont('Arial','',10);	
		$pdf->Cell(30,6,number_format($descuento,2),0,1,'R',false);

		$pdf->SetY($fila+36); $pdf->SetX(124); $pdf->SetFont('Arial','',9);	
		$pdf->Cell(78,6,'',1,1,'I',true);
		$pdf->SetY($fila+36); $pdf->SetX(126);	
		$pdf->Cell(78,6,'IVA '.$porcentaje.'%',0,1,'I',false);
		$pdf->SetY($fila+36); $pdf->SetX(168); $pdf->SetFont('Arial','',10);	
		$pdf->Cell(30,6,$iva,0,1,'R',false);

		$pdf->SetY($fila+42); $pdf->SetX(124); $pdf->SetFont('Arial','',9);	
		$pdf->Cell(78,6,'',1,1,'I',true);
		$pdf->SetY($fila+42); $pdf->SetX(126);	
		$pdf->Cell(78,6,'VALOR TOTAL  ',0,1,'I',false);
		$pdf->SetY($fila+42); $pdf->SetX(168); $pdf->SetFont('Arial','',10);	
		$pdf->Cell(30,6,number_format($total,2),0,1,'R',false);
        
        $pdf->Output('../autorizados/'.$claveAcceso.'.pdf', 'F');
        //$email = new sendEmail();
		//$sendMail = multi_attach_mail($correo, $document->infoFactura->razonSocialComprador, $claveAcceso);
		//echo $sendMail?"<h1>Mail Sent</h1>":"<h1>Mail sending failed.</h1>";
        //$email->enviarCorreo('Factura', $document->infoFactura->razonSocialComprador, $claveAcceso, $correo);
    }

    public function notaDebitoPDF($document, $claveAcceso) {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 8);
//$pdf->Cell(40, 10, 'Hello World!');
        if ($document->infoNotaDebito->obligadoContabilidad == 'SI') {

            $contabilidad = "Obligado a llevar contabilidad : SI";
        } else {
            $contabilidad = "Obligado a llevar contabilidad : NO";
        }
        $pdf->SetXY(10, 0);
        $pdf->image('uploads/logo.jpg', null, null, 80, 30);

        $pdf->SetXY(110, 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->MultiCell(100, 10, "RUC: " . $document->infoTributaria->ruc, 0, 'J', true);
        $pdf->SetXY(110, 15);
        $pdf->MultiCell(100, 10, "Nota Debito Nro: " . $document->infoTributaria->estab . $document->infoTributaria->ptoEmi . $document->infoTributaria->secuencial, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(110, 20);
        $pdf->MultiCell(100, 10, 'Nro Autorizacion: ', 0);
        $pdf->SetXY(110, 25);
        $pdf->MultiCell(100, 10, $claveAcceso, 0);
        $pdf->SetXY(110, 30);
        if ($document->infoTributaria->ambiente == 2) {
            $ambiente = 'PRODUCCION';
        } else {
            $ambiente = 'PRUEBAS';
        }
        $pdf->MultiCell(100, 10, 'Ambiente: ' . $ambiente, 0);
        $pdf->SetXY(110, 35);
        if ($document->infoTributaria->tipoEmision == 1) {
            $emision = 'NORMAL';
        } else {
            $emision = 'NORMAL';
        }
        $pdf->MultiCell(100, 10, 'Emision: ' . $emision, 0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetXY(10, 20);
        $pdf->MultiCell(100, 10, $document->infoTributaria->razonSocial, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(10, 25);
        $pdf->MultiCell(100, 10, $document->infoTributaria->dirMatriz, 0);
        $pdf->SetXY(10, 30);
        $pdf->MultiCell(100, 10, $contabilidad, 0);
        //Codigo de barras

        $pdf->SetXY(110, 45);
        $this->generarCodigoBarras($claveAcceso);
        $pdf->image('uploads/codigo_mod.png', null, null, 100, 20);
        $pdf->SetXY(110, 63);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(100, 10, $claveAcceso, 0, 0, "C", true);
        //informacion del cliente
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);

        $pdf->SetXY(10, 35);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->MultiCell(100, 10, "INFORMACION DEL CLIENTE", 0);

        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(10, 40);
        $pdf->MultiCell(100, 10, "RUC/CI: " . $document->infoNotaDebito->identificacionComprador, 0);
        $pdf->SetXY(10, 45);
        $pdf->MultiCell(100, 10, "Razon Social/Nombre: " . $document->infoNotaDebito->razonSocialComprador, 0);
        $pdf->SetXY(10, 50);
        $pdf->MultiCell(100, 10, "Direccion: " . $document->infoNotaDebito->dirEstablecimiento, 0);
        $pdf->SetXY(10, 70);
        $pdf->MultiCell(100, 10, "Fecha Emision: " . $document->infoNotaDebito->fechaEmision, 0);

        $ejeX = 80;

        $pdf->SetXY(10, $ejeX);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->MultiCell(100, 10, "FORMAS DE PAGO", 0);
        $pdf->SetFont('Arial', '', 8);
        $ejeX = $ejeX + 10;
        $pdf->SetXY(10, $ejeX);
        foreach ($document->infoNotaDebito->pagos->pago as $e => $f) {
            if ($f->formaPago == '01') {
                $pdf->SetXY(22, $ejeX);
                $pdf->Cell(30, 10, 'Sin utilizacion del sistema financiero', 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(5, $ejeX);
                $pdf->Cell(30, 10, 'Total: ' . $f->total, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(5, $ejeX);
                $pdf->Cell(30, 10, 'Plazo: ' . $f->plazo, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(13, $ejeX);
                $pdf->Cell(30, 10, 'Unidad de tiempo: ' . $f->unidadTiempo, 0, 0, "C", true);
            }
            if ($f->formaPago == '15') {
                $pdf->SetXY(22, $ejeX);
                $pdf->Cell(30, 10, 'Compensacion de deudas', 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(4, $ejeX);
                $pdf->Cell(30, 10, 'Total: ' . $f->total, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(0, $ejeX);
                $pdf->Cell(30, 10, 'Plazo: ' . $f->plazo, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(10, $ejeX);
                $pdf->Cell(30, 10, 'Unidad de tiempo: ' . $f->unidadTiempo, 0, 0, "C", true);
            }
            if ($f->formaPago == '16') {
                $pdf->SetXY(22, $ejeX);
                $pdf->Cell(30, 10, 'Tarjeta debito', 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(4, $ejeX);
                $pdf->Cell(30, 10, 'Total: ' . $f->total, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(0, $ejeX);
                $pdf->Cell(30, 10, 'Plazo: ' . $f->plazo, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(10, $ejeX);
                $pdf->Cell(30, 10, 'Unidad de tiempo: ' . $f->unidadTiempo, 0, 0, "C", true);
            }
            if ($f->formaPago == '17') {
                $pdf->SetXY(22, $ejeX);
                $pdf->Cell(30, 10, 'Dinero Electronico', 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(4, $ejeX);
                $pdf->Cell(30, 10, 'Total: ' . $f->total, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(0, $ejeX);
                $pdf->Cell(30, 10, 'Plazo: ' . $f->plazo, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(10, $ejeX);
                $pdf->Cell(30, 10, 'Unidad de tiempo: ' . $f->unidadTiempo, 0, 0, "C", true);
            }
            if ($f->formaPago == '18') {
                $pdf->SetXY(22, $ejeX);
                $pdf->Cell(30, 10, 'Tarjeta Prepago', 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(4, $ejeX);
                $pdf->Cell(30, 10, 'Total: ' . $f->total, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(0, $ejeX);
                $pdf->Cell(30, 10, 'Plazo: ' . $f->plazo, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(10, $ejeX);
                $pdf->Cell(30, 10, 'Unidad de tiempo: ' . $f->unidadTiempo, 0, 0, "C", true);
            }
            if ($f->formaPago == '19') {
                $pdf->SetXY(10, $ejeX);
                $pdf->Cell(20, 10, 'Tarjeta de credito', 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(4, $ejeX);
                $pdf->Cell(30, 10, 'Total: ' . $f->total, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(1, $ejeX);
                $pdf->Cell(30, 10, 'Plazo: ' . $f->plazo, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(10, $ejeX);
                $pdf->Cell(30, 10, 'Unidad de tiempo: ' . $f->unidadTiempo, 0, 0, "C", true);
            }
            if ($f->formaPago == '20') {
                $pdf->SetXY(22, $ejeX);
                $pdf->Cell(30, 10, 'Otros con utilizacion del sistema financiero', 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(4, $ejeX);
                $pdf->Cell(30, 10, 'Total: ' . $f->total, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(0, $ejeX);
                $pdf->Cell(30, 10, 'Plazo: ' . $f->plazo, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(10, $ejeX);
                $pdf->Cell(30, 10, 'Unidad de tiempo: ' . $f->unidadTiempo, 0, 0, "C", true);
            }
            if ($f->formaPago == '21') {
                $pdf->SetXY(22, $ejeX);
                $pdf->Cell(30, 10, 'Endoso de titulos', 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(4, $ejeX);
                $pdf->Cell(30, 10, 'Total: ' . $f->total, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(0, $ejeX);
                $pdf->Cell(30, 10, 'Plazo: ' . $f->plazo, 0, 0, "C", true);
                $ejeX = $ejeX + 6;
                $pdf->SetXY(10, $ejeX);
                $pdf->Cell(30, 10, 'Unidad de tiempo: ' . $f->unidadTiempo, 0, 0, "C", true);
            }

            $ejeX = $ejeX + 10;
            $pdf->SetX($ejeX);
        }

        //detalle de la factura
        $ejeX = $ejeX + 10;

        $pdf->SetXY(10, $ejeX);
        $pdf->SetFillColor(255, 0, 0);
        $pdf->SetTextColor(0, 255, 255);

        $pdf->Cell(50, 10, "Comprobante que se modifica", 1, 0, "C", true);
        $pdf->Cell(50, 10, "Numero documento modific", 1, 0, "C", true);
        $pdf->Cell(50, 10, "Fecha Emision (Comprobante a", 1, 0, "C", true);
        $pdf->Cell(50, 10, "Razon de la modifi", 1, 0, "C", true);


        $ejeX = $ejeX + 10;
        $pdf->SetXY(10, $ejeX);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);

        if ($document->infoNotaDebito->codDocModificado == "01") {
            $pdf->Cell(50, 10, "FACTURA", 1, 0, "L");
        } else {
            $pdf->Cell(50, 10, $document->infoNotaDebito->codDocModificado, 1, 0, "L");
        }

        $pdf->Cell(50, 10, $document->infoNotaDebito->numDocModificado, 1, 0, "L");
        $pdf->Cell(50, 10, $document->infoNotaDebito->fechaEmisionDocSustento, 1, 0, "L");

        foreach ($document->motivos->motivo as $a => $b) {
            $pdf->Cell(50, 10, $b->razon, 1, 0, "C", true);
            $ejeX = $ejeX + 10;
            $pdf->SetXY(10, $ejeX);
        }


        $pdf->SetXY(150, $ejeX);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);
        $iva = 0;
        $ice = 0;
        $IRBPNR = 0;
        $subtotal12 = 0;
        $subtotal0 = 0;
        $subtotal_no_impuesto = 0;
        $subtotal_no_iva = 0;
        foreach ($document->infoNotaDebito->impuestos->impuesto as $a => $b) {
            if ($b->codigo == 2) {
                $iva = number_format(floatval($b->valor), 2);
                if ($b->codigoPorcentaje == 0) {
                    $subtotal0 = number_format(floatval($b->baseImponible), 2);
                }
                if ($b->codigoPorcentaje == 2) {
                    $subtotal12 = number_format(floatval($b->baseImponible), 2);
                }
                if ($b->codigoPorcentaje == 6) {
                    $subtotal_no_impuesto = number_format(floatval($b->baseImponible), 2);
                }
                if ($b->codigoPorcentaje == 7) {
                    $subtotal_no_iva = number_format(floatval($b->baseImponible), 2);
                }
            }
            if ($b->codigo == 3) {
                $ice = number_format(floatval($b->valor), 2);
            }
            if ($b->codigo == 5) {
                $IRBPNR = number_format(floatval($b->valor), 2);
            }
        }
        $pdf->SetXY(130, $ejeX + 10);
        $pdf->Cell(25, 10, "Subtotal 12%: ", 0, 0, "L", true);
        $pdf->SetXY(180, $ejeX + 10);
        $pdf->Cell(25, 10, " $subtotal12 ", 0, 0, "R", true);
        $pdf->SetXY(130, $ejeX + 16);
        $pdf->Cell(25, 10, "SubTotal 0%: ", 0, 0, "L", true);
        $pdf->SetXY(180, $ejeX + 16);
        $pdf->Cell(25, 10, $subtotal0, 0, 0, "R", true);
        $pdf->SetXY(130, $ejeX + 22);
        $pdf->Cell(25, 10, "SubTotal no sujeto de IVA: ", 0, 0, "L", true);
        $pdf->SetXY(180, $ejeX + 22);
        $pdf->Cell(25, 10, $subtotal_no_impuesto, 0, 0, "R", true);
        $pdf->SetXY(130, $ejeX + 28);
        $pdf->Cell(25, 10, "SubTotal exento de IVA: ", 0, 0, "L", true);
        $pdf->SetXY(180, $ejeX + 28);
        $pdf->Cell(25, 10, $subtotal_no_iva, 0, 0, "R", true);
        $pdf->SetXY(130, $ejeX + 34);
        $pdf->Cell(25, 10, "SubTotal sin Impuestos: ", 0, 0, "L", true);
        $pdf->SetXY(180, $ejeX + 34);
        $pdf->Cell(25, 10, number_format(floatval($document->infoNotaDebito->totalSinImpuestos), 2), 0, 0, "R", true);
        $pdf->SetXY(130, $ejeX + 40);
        $pdf->Cell(25, 10, "IVA 12%: ", 0, 0, "L");
        $pdf->SetXY(180, $ejeX + 40);
        $pdf->Cell(25, 10, $iva, 0, 0, "R");
        $pdf->SetXY(130, $ejeX + 46);
        $pdf->Cell(25, 10, "ICE: ", 0, 0, "L");
        $pdf->SetXY(180, $ejeX + 46);
        $pdf->Cell(25, 10, $ice, 0, 0, "R");
        $pdf->SetXY(130, $ejeX + 52);
        $pdf->Cell(25, 10, "IRBPNR: ", 0, 0, "L");
        $pdf->SetXY(180, $ejeX + 52);
        $pdf->Cell(25, 10, $IRBPNR, 0, 0, "R");
        $pdf->SetXY(130, $ejeX + 58);
        $pdf->Cell(25, 10, "Valor Total: ", 0, 0, "L");
        $pdf->SetXY(180, $ejeX + 58);
        $pdf->Cell(25, 10, number_format(floatval($document->infoNotaDebito->valorTotal), 2), 0, 0, "R");
        $infoAdicional = "";
        $correo = "";

        foreach ($document->infoAdicional->campoAdicional as $a) {
            foreach ($a->attributes() as $b) {
                if ($b == 'Email' || $b == 'email' || $b == '=correo' || $b == 'Correo') {
                    $correo = $a;
                    $infoAdicional .= $b . ': ' . $a . "\n";
                } else {
                    $infoAdicional .= $b . ': ' . $a . "\n";
                }
            }
        }
        $pdf->SetXY(10, $ejeX + 30);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->MultiCell(100, 10, "Informacion Adicional", 0);
        $pdf->SetXY(10, $ejeX + 40);
        $pdf->SetFont('Arial', '', 7);
        $pdf->MultiCell(100, 5, "" . $infoAdicional . "", 0);
		
		
		
        $email = new sendEmail();
        
        $pdf->Output('../../comprobantes/' . $claveAcceso . '.pdf', 'F');
        $email->enviarCorreo('Nota Debito', $document->infoNotaDebito->razonSocialComprador, $claveAcceso, $correo);
    }

    public function guiaRemisionPDF($document, $claveAcceso) {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 8);
//$pdf->Cell(40, 10, 'Hello World!');
        if ($document->infoGuiaRemision->obligadoContabilidad == 'SI') {

            $contabilidad = "Obligado a llevar contabilidad : SI";
        } else {
            $contabilidad = "Obligado a llevar contabilidad : NO";
        }

        $pdf->SetXY(10, 0);
        $pdf->image('uploads/logo.jpg', null, null, 80, 30);
        $pdf->SetXY(110, 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->MultiCell(100, 10, "RUC: " . $document->infoTributaria->ruc, 0, 'J', true);
        $pdf->SetXY(110, 15);
        $pdf->MultiCell(100, 10, "Guia Remision Nro: " . $document->infoTributaria->estab . $document->infoTributaria->ptoEmi . $document->infoTributaria->secuencial, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(110, 20);
        $pdf->MultiCell(100, 10, 'Nro Autorizacion: ', 0);
        $pdf->SetXY(110, 25);
        $pdf->MultiCell(100, 10, $claveAcceso, 0);
        $pdf->SetXY(110, 30);
        if ($document->infoTributaria->ambiente == 2) {
            $ambiente = 'PRODUCCION';
        } else {
            $ambiente = 'PRUEBAS';
        }
        $pdf->MultiCell(100, 10, 'Ambiente: ' . $ambiente, 0);
        $pdf->SetXY(110, 35);
        if ($document->infoTributaria->tipoEmision == 1) {
            $emision = 'NORMAL';
        } else {
            $emision = 'NORMAL';
        }
        $pdf->MultiCell(100, 10, 'Emision: ' . $emision, 0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetXY(10, 20);
        $pdf->MultiCell(100, 10, $document->infoTributaria->razonSocial, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(10, 25);
        $pdf->MultiCell(100, 10, $document->infoTributaria->dirMatriz, 0);
        $pdf->SetXY(10, 30);
        $pdf->MultiCell(100, 10, $contabilidad, 0);
        //Codigo de barras

        $pdf->SetXY(110, 45);
        $this->generarCodigoBarras($claveAcceso);
        $pdf->image('uploads/codigo_mod.png', null, null, 100, 20);
        $pdf->SetXY(110, 63);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(100, 10, $claveAcceso, 0, 0, "C", true);

        //informacion del cliente
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);

        $pdf->SetXY(10, 35);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->MultiCell(100, 10, "INFORMACION DEL TRASPORTISTA", 0);

        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(10, 40);
        $pdf->MultiCell(100, 10, "RUC/CI: " . $document->infoGuiaRemision->rucTransportista, 0);
        $pdf->SetXY(10, 45);
        $pdf->MultiCell(100, 10, "Razon Social/Nombre: " . $document->infoGuiaRemision->razonSocialTransportista, 0);
        $pdf->SetXY(10, 50);
        $pdf->MultiCell(100, 10, "Direccion: " . $document->infoGuiaRemision->dirEstablecimiento, 0);
        $pdf->SetXY(10, 55);
        $pdf->MultiCell(100, 10, "Placa: " . $document->infoGuiaRemision->placa, 0);



        //Fin Encabezado

        $pdf->SetXY(10, 75);
        $pdf->SetFillColor(255, 0, 0);
        $pdf->SetTextColor(0, 255, 255);

        $pdf->Cell(50, 10, "Punto de Partida", 1, 0, "C", true);
        $pdf->Cell(50, 10, "Fecha Inicio", 1, 0, "C", true);
        $pdf->Cell(50, 10, "Fecha Fin", 1, 0, "C", true);

        $pdf->SetXY(10, 85);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);
        $codigo = rand(1000, 9999);

        $pdf->Cell(50, 10, $document->infoGuiaRemision->dirPartida, 1, 0, "L");
        $pdf->Cell(50, 10, $document->infoGuiaRemision->fechaIniTransporte, 1, 0, "L");
        $pdf->Cell(50, 10, $document->infoGuiaRemision->fechaFinTransporte, 1, 0, "L");



        $pdf->SetXY(10, 100);
        $pdf->SetFillColor(255, 0, 0);
        $pdf->SetTextColor(0, 255, 255);
        $pdf->SetFont('Arial', 'B', 6);

        $pdf->Cell(30, 10, "NIT/CI Destinatario", 1, 0, "C", true);
        $pdf->Cell(40, 10, "Destinatario", 1, 0, "C", true);
        $pdf->Cell(50, 10, "Direccion", 1, 0, "C", true);
        $pdf->Cell(30, 10, "Nro Sustento", 1, 0, "C", true);
        $pdf->Cell(20, 10, "Motivo", 1, 0, "C", true);
        $pdf->Cell(20, 10, "Fecha Emision", 1, 0, "C", true);

        $pdf->SetFont('Arial', '', 6);
        $pdf->SetXY(10, 110);
        $ejeX = 110;
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);
        foreach ($document->destinatarios->destinatario as $a => $b) {
            $pdf->Cell(30, 10, $b->identificacionDestinatario, 1);
            $pdf->Cell(40, 10, $b->razonSocialDestinatario, 1);
            $pdf->Cell(50, 10, $b->dirDestinatario, 1);
            $pdf->Cell(30, 10, $b->numDocSustento, 1);
            $pdf->Cell(20, 10, $b->motivoTraslado, 1);
            $pdf->Cell(20, 10, $b->fechaEmisionDocSustento, 1);
            $ejeX = $ejeX + 10;
            $pdf->SetX($ejeX);
        }
        //detalle de la factura
        $ejeX = $ejeX + 10;
        $pdf->SetXY(10, $ejeX);
        $pdf->SetFillColor(255, 0, 0);
        $pdf->SetTextColor(0, 255, 255);
        $pdf->Cell(25, 10, "Codigo", 1, 0, "C", true);
        $pdf->Cell(50, 10, "Descripcion", 1, 0, "C", true);
        $pdf->Cell(25, 10, "Cantidad", 1, 0, "C", true);


        $ejeX = $ejeX + 10;
        $pdf->SetXY(10, $ejeX);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);
        foreach ($document->destinatarios->destinatario as $a => $b) {
            foreach ($b->detalles->detalle as $c => $d) {
                $pdf->Cell(25, 10, $d->codigoInterno, 1, 0, "C", true);
                $pdf->Cell(50, 10, $d->descripcion, 1, 0, "C", true);
                $pdf->Cell(25, 10, $d->cantidad, 1, 0, "C", true);
                $ejeX = $ejeX + 10;
                $pdf->SetXY(10, $ejeX);
            }
        }

        $infoAdicional = "";
        $correo = "";
        foreach ($document->infoAdicional->campoAdicional as $a) {
            foreach ($a->attributes() as $b) {
                if ($b == 'Email' || $b == 'email' || $b == '=correo' || $b == 'Correo') {
                    $correo = $a;
                    $infoAdicional .= $b . ': ' . $a . "\n";
                } else {
                    $infoAdicional .= $b . ': ' . $a . "\n";
                }
            }
        }
        $pdf->SetXY(10, $ejeX + 30);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->MultiCell(100, 10, "Informacion Adicional", 0);
        $pdf->SetXY(10, $ejeX + 40);
        $pdf->SetFont('Arial', '', 7);
        $pdf->MultiCell(100, 5, "" . $infoAdicional . "", 0);

        

        // Pie de pagina


        $pdf->Output('../../comprobantes/' . $claveAcceso . '.pdf', 'F');
        $email = new sendEmail();
        $email->enviarCorreo('Guia Remision', $document->infoGuiaRemision->razonSocialTransportista, $claveAcceso, $correo);
    }

    public function comprobanteRetencionPDF($document, $claveAcceso) {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 8);
//$pdf->Cell(40, 10, 'Hello World!');
        if ($document->infoCompRetencion->obligadoContabilidad == 'SI') {

            $contabilidad = "Obligado a llevar contabilidad : SI";
        } else {
            $contabilidad = "Obligado a llevar contabilidad : NO";
        }
        $pdf->SetXY(10, 0);
        $pdf->image('uploads/logo.jpg', null, null, 80, 30);
        $pdf->SetXY(110, 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->MultiCell(100, 10, "RUC: " . $document->infoTributaria->ruc, 0, 'J', true);
        $pdf->SetXY(110, 15);
        $pdf->MultiCell(100, 10, "Comprobante Retencion Nro: " . $document->infoTributaria->estab . $document->infoTributaria->ptoEmi . $document->infoTributaria->secuencial, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(110, 20);
        $pdf->MultiCell(100, 10, 'Nro Autorizacion: ', 0);
        $pdf->SetXY(110, 25);
        $pdf->MultiCell(100, 10, $claveAcceso, 0);
        $pdf->SetXY(110, 30);
        if ($document->infoTributaria->ambiente == 2) {
            $ambiente = 'PRODUCCION';
        } else {
            $ambiente = 'PRUEBAS';
        }
        $pdf->MultiCell(100, 10, 'Ambiente: ' . $ambiente, 0);
        $pdf->SetXY(110, 35);
        if ($document->infoTributaria->tipoEmision == 1) {
            $emision = 'NORMAL';
        } else {
            $emision = 'NORMAL';
        }
        $pdf->MultiCell(100, 10, 'Emision: ' . $emision, 0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetXY(10, 20);
        $pdf->MultiCell(100, 10, $document->infoTributaria->razonSocial, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(10, 25);
        $pdf->MultiCell(100, 10, $document->infoTributaria->dirMatriz, 0);
        $pdf->SetXY(10, 30);
        $pdf->MultiCell(100, 10, $contabilidad, 0);
        //Codigo de barras

        $pdf->SetXY(110, 45);
        $this->generarCodigoBarras($claveAcceso);
        $pdf->image('uploads/codigo_mod.png', null, null, 100, 20);
        $pdf->SetXY(110, 63);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(100, 10, $claveAcceso, 0, 0, "C", true);
        //informacion del cliente
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);

        $pdf->SetXY(10, 35);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->MultiCell(100, 10, "INFORMACION DEL SUJETO RETENIDO", 0);

        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(10, 40);
        $pdf->MultiCell(100, 10, "RUC/CI: " . $document->infoCompRetencion->identificacionSujetoRetenido, 0);
        $pdf->SetXY(10, 45);
        $pdf->MultiCell(100, 10, "Razon Social/Nombre: " . $document->infoCompRetencion->razonSocialSujetoRetenido, 0);
        $pdf->SetXY(10, 50);
        $pdf->MultiCell(100, 10, "Direccion: " . $document->infoCompRetencion->dirEstablecimiento, 0);
        $pdf->SetXY(10, 55);
        $pdf->MultiCell(100, 10, "Fecha Emision: " . $document->infoCompRetencion->fechaEmision, 0);




        //detalle de la factura
        $pdf->SetXY(10, 70);
        $pdf->SetFillColor(255, 0, 0);
        $pdf->SetTextColor(0, 255, 255);
        $pdf->Cell(20, 10, "Impuesto", 1, 0, "C", true);
        $pdf->Cell(20, 10, "Cod. Retenci", 1, 0, "C", true);
        $pdf->Cell(21, 10, "Base Imponible", 1, 0, "C", true);
        $pdf->Cell(20, 10, "Porcentaje", 1, 0, "C", true);
        $pdf->Cell(20, 10, "Sustento", 1, 0, "C", true);
        $pdf->Cell(30, 10, "Documento", 1, 0, "C", true);
        $pdf->Cell(20, 10, "Ejercicio", 1, 0, "C", true);
        $pdf->Cell(20, 10, "Fecha", 1, 0, "C", true);
        $pdf->Cell(20, 10, "Valor Retenido", 1, 0, "C", true);

        $ejeX = 80;
        $pdf->SetXY(10, $ejeX);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);
        $total = 0;
        foreach ($document->impuestos->impuesto as $a => $b) {
            if ($b->codigo == 1) {
                $pdf->Cell(20, 10, "IVA", 1, 0, "C", true);
            } else if ($b->codigo == 2) {
                $pdf->Cell(20, 10, "Renta", 1, 0, "C", true);
            } else {
                $pdf->Cell(20, 10, $b->codigo, 1, 0, "C", true);
            }

            $pdf->Cell(20, 10, $b->codigoRetencion, 1, 0, "C", true);
            $pdf->Cell(21, 10, $b->baseImponible, 1, 0, "C", true);
            $pdf->Cell(20, 10, $b->porcentajeRetener . "%", 1, 0, "C", true);
            if ($b->codDocSustento = '01') {
                $pdf->Cell(20, 10, 'Factura', 1, 0, "C", true);
            } else {
                $pdf->Cell(20, 10, $b->codDocSustento, 1, 0, "C", true);
            }
            $pdf->Cell(30, 10, $b->numDocSustento, 1, 0, "C", true);
            $pdf->Cell(20, 10, date("Y"), 1, 0, "C", true);
            $pdf->Cell(20, 10, $b->fechaEmisionDocSustento, 1, 0, "C", true);
            $pdf->Cell(20, 10, $b->valorRetenido, 1, 0, "C", true);
            $ejeX = $ejeX + 10;
            $pdf->SetXY(10, $ejeX);
            $total += floatval($b->valorRetenido);
        }

        //Total de la factura
        $ejeX = $ejeX + 5;
        $pdf->SetXY(155, $ejeX);
        $pdf->SetFillColor(255, 0, 0);
        $pdf->SetTextColor(0, 255, 255);

        $pdf->Cell(25, 10, "Total", 1, 0, "C", true);

        $pdf->SetXY(180, $ejeX);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);

        $pdf->Cell(20, 10, number_format(floatval($total),2), 1, 0, "C");
        // Pie de pagina
        $infoAdicional = "";
        $correo = "";
        foreach ($document->infoAdicional->campoAdicional as $a) {
            foreach ($a->attributes() as $b) {
                if ($b == 'Email' || $b == 'email' || $b == '=correo' || $b == 'Correo') {
                    $correo = $a;
                    $infoAdicional .= $b . ': ' . $a . "\n";
                } else {
                    $infoAdicional .= $b . ': ' . $a . "\n";
                }
            }
        }
        $pdf->SetXY(10, $ejeX + 30);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->MultiCell(100, 10, "Informacion Adicional", 0);
        $pdf->SetXY(10, $ejeX + 50);
        $pdf->SetFont('Arial', '', 7);
        $pdf->MultiCell(100, 5, "" . $infoAdicional . "", 0);

        
        $pdf->Output('../../comprobantes/' . $claveAcceso . '.pdf', 'F');
        $email = new sendEmail();
        $email->enviarCorreo('Comprobante de Retencion', $document->infoCompRetencion->razonSocialSujetoRetenido, $claveAcceso, $correo);
    }

    public function notaCreditoPDF($document, $claveAcceso) {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 8);
//$pdf->Cell(40, 10, 'Hello World!');
        if ($document->infoNotaCredito->obligadoContabilidad == 'SI') {

            $contabilidad = "Obligado a llevar contabilidad : SI";
        } else {
            $contabilidad = "Obligado a llevar contabilidad : NO";
        }

        $pdf->SetXY(10, 0);
        $pdf->image('uploads/logo.jpg', null, null, 80, 30);
        $pdf->SetXY(110, 10);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->MultiCell(100, 10, "RUC: " . $document->infoTributaria->ruc, 0, 'J', true);
        $pdf->SetXY(110, 15);
        $pdf->MultiCell(100, 10, "Nota Credito Nro: " . $document->infoTributaria->estab . $document->infoTributaria->ptoEmi . $document->infoTributaria->secuencial, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(110, 20);
        $pdf->MultiCell(100, 10, 'Nro Autorizacion: ', 0);
        $pdf->SetXY(110, 25);
        $pdf->MultiCell(100, 10, $claveAcceso, 0);
        $pdf->SetXY(110, 30);
        if ($document->infoTributaria->ambiente == 2) {
            $ambiente = 'PRODUCCION';
        } else {
            $ambiente = 'PRUEBAS';
        }
        $pdf->MultiCell(100, 10, 'Ambiente: ' . $ambiente, 0);
        $pdf->SetXY(110, 35);
        if ($document->infoTributaria->tipoEmision == 1) {
            $emision = 'NORMAL';
        } else {
            $emision = 'NORMAL';
        }
        $pdf->MultiCell(100, 10, 'Emision: ' . $emision, 0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetXY(10, 20);
        $pdf->MultiCell(100, 10, $document->infoTributaria->razonSocial, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(10, 25);
        $pdf->MultiCell(100, 10, $document->infoTributaria->dirMatriz, 0);
        $pdf->SetXY(10, 30);
        $pdf->MultiCell(100, 10, $contabilidad, 0);
        //Codigo de barras

        $pdf->SetXY(110, 45);
        $this->generarCodigoBarras($claveAcceso);
        $pdf->image('uploads/codigo_mod.png', null, null, 100, 20);
        $pdf->SetXY(110, 63);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(100, 10, $claveAcceso, 0, 0, "C", true);
        //informacion del cliente
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);

        $pdf->SetXY(10, 35);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->MultiCell(100, 10, "INFORMACION DEL COMPRADOR", 0);

        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(10, 40);
        $pdf->MultiCell(100, 10, "RUC/CI: " . $document->infoNotaCredito->identificacionComprador, 0);
        $pdf->SetXY(10, 45);
        $pdf->MultiCell(100, 10, "Razon Social/Nombre: " . $document->infoNotaCredito->razonSocialComprador, 0);
        $pdf->SetXY(10, 50);
        $pdf->MultiCell(100, 10, "Direccion: " . $document->infoNotaCredito->dirEstablecimiento, 0);
        $pdf->SetXY(10, 55);
        $pdf->MultiCell(100, 10, "Fecha Emision: " . $document->infoNotaCredito->fechaEmision, 0);



        //Fin Encabezado
        //informacion de la factura
        $pdf->SetXY(10, 70);
        $pdf->SetFillColor(255, 0, 0);
        $pdf->SetTextColor(0, 255, 255);

        $pdf->Cell(30, 10, "Doc. Modif.", 1, 0, "C", true);
        $pdf->Cell(50, 10, "Nro Documento", 1, 0, "C", true);
        $pdf->Cell(50, 10, "Fecha Emision", 1, 0, "C", true);
        $pdf->Cell(30, 10, "Motivo", 1, 0, "C", true);

        $pdf->SetXY(10, 80);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(30, 10, "FACTURA", 1, 0, "C", true);
        $pdf->Cell(50, 10, $document->infoNotaCredito->numDocModificado, 1, 0, "C", true);
        $pdf->Cell(50, 10, $document->infoNotaCredito->fechaEmisionDocSustento, 1, 0, "C", true);
        $pdf->Cell(30, 10, $document->infoNotaCredito->motivo, 1, 0, "C", true);


        //detalle de la factura
        $pdf->SetXY(10, 100);
        $pdf->SetFillColor(255, 0, 0);
        $pdf->SetTextColor(0, 255, 255);
        $pdf->Cell(35, 10, "Codigo", 1, 0, "C", true);
        $pdf->Cell(50, 10, "Descripcion", 1, 0, "C", true);
        $pdf->Cell(25, 10, "Cantidad", 1, 0, "C", true);
        $pdf->Cell(25, 10, "Precio", 1, 0, "C", true);
        $pdf->Cell(25, 10, "% Desc", 1, 0, "C", true);
        $pdf->Cell(25, 10, "Total", 1, 0, "C", true);

        $ejeX = 110;
        $pdf->SetXY(10, $ejeX);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);
        $descuento = 0;
        foreach ($document->detalles->detalle as $a => $b) {
            $descuento = $b->descuento;
            $pdf->Cell(35, 10, $b->codigoInterno, 1, 0, "C", true);
            $pdf->Cell(50, 10, $b->descripcion, 1, 0, "C", true);
            $pdf->Cell(25, 10, $b->cantidad, 1, 0, "C", true);
            $pdf->Cell(25, 10, number_format(floatval($b->precioUnitario), 2), 1, 0, "C", true);
            $pdf->Cell(25, 10, $b->descuento, 1, 0, "C", true);
            $pdf->Cell(25, 10, $b->precioTotalSinImpuesto, 1, 0, "C", true);
            $ejeX = $ejeX + 10;
            $pdf->SetXY(10, $ejeX);
        }

        //Total de la factura
        $pdf->SetXY(150, $ejeX);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(255, 255, 255);
        $iva = 0;
        $ice = 0;
        $IRBPNR = 0;
        $subtotal12 = 0;
        $subtotal0 = 0;
        $subtotal_no_impuesto = 0;
        $subtotal_no_iva = 0;
        foreach ($document->infoNotaCredito->totalConImpuestos->totalImpuesto as $a => $b) {
            if ($b->codigo == 2) {

                if ($b->codigoPorcentaje == 0) {
                    $subtotal0 = number_format(floatval($b->baseImponible), 2);
                }
                if ($b->codigoPorcentaje == 2) {
                    $subtotal12 = number_format(floatval($b->baseImponible), 2);
                    $iva = $b->valor;
                }
                if ($b->codigoPorcentaje == 6) {
                    $subtotal_no_impuesto = number_format(floatval($b->baseImponible), 2);
                }
                if ($b->codigoPorcentaje == 7) {
                    $subtotal_no_iva = number_format(floatval($b->baseImponible), 2);
                }
            }
            if ($b->codigo == 3) {
                $ice = number_format(floatval($b->valor), 2);
            }
            if ($b->codigo == 5) {
                $IRBPNR = number_format(floatval($b->valor), 2);
            }
        }
        $pdf->SetXY(130, $ejeX + 10);
        $pdf->Cell(25, 10, "Subtotal 12%: ", 0, 0, "L", true);
        $pdf->SetXY(170, $ejeX + 10);
        $pdf->Cell(25, 10, " $subtotal12 ", 0, 0, "R", true);
        $pdf->SetXY(130, $ejeX + 16);
        $pdf->Cell(25, 10, "SubTotal 0%: ", 0, 0, "L", true);
        $pdf->SetXY(170, $ejeX + 16);
        $pdf->Cell(25, 10, $subtotal0, 0, 0, "R", true);
        $pdf->SetXY(130, $ejeX + 22);
        $pdf->Cell(25, 10, "SubTotal no sujeto de IVA: ", 0, 0, "L", true);
        $pdf->SetXY(170, $ejeX + 22);
        $pdf->Cell(25, 10, $subtotal_no_impuesto, 0, 0, "R", true);
        $pdf->SetXY(130, $ejeX + 28);
        $pdf->Cell(25, 10, "SubTotal exento de IVA: ", 0, 0, "L", true);
        $pdf->SetXY(170, $ejeX + 28);
        $pdf->Cell(25, 10, $subtotal_no_iva, 0, 0, "R", true);
        $pdf->SetXY(130, $ejeX + 34);
        $pdf->Cell(25, 10, "SubTotal sin Impuestos: ", 0, 0, "L", true);
        $pdf->SetXY(170, $ejeX + 34);
        $pdf->Cell(25, 10, number_format(floatval($document->infoNotaCredito->totalSinImpuestos), 2), 0, 0, "R", true);
        $pdf->SetXY(130, $ejeX + 40);
        $pdf->Cell(25, 10, "IVA 12%: ", 0, 0, "L");
        $pdf->SetXY(170, $ejeX + 40);
        $pdf->Cell(25, 10, $iva, 0, 0, "R");
        $pdf->SetXY(130, $ejeX + 46);
        $pdf->Cell(25, 10, "ICE: ", 0, 0, "L");
        $pdf->SetXY(170, $ejeX + 46);
        $pdf->Cell(25, 10, $ice, 0, 0, "R");
        $pdf->SetXY(130, $ejeX + 52);
        $pdf->Cell(25, 10, "IRBPNR: ", 0, 0, "L");
        $pdf->SetXY(170, $ejeX + 52);
        $pdf->Cell(25, 10, $IRBPNR, 0, 0, "R");
        $pdf->SetXY(130, $ejeX + 58);
        $pdf->Cell(25, 10, "Valor Total: ", 0, 0, "L");
        $pdf->SetXY(170, $ejeX + 58);
        $pdf->Cell(25, 10, number_format(floatval($document->infoNotaCredito->valorModificacion), 2), 0, 0, "R");
        // Pie de pagina
        $infoAdicional = "";
        $correo = "";
        foreach ($document->infoAdicional->campoAdicional as $a) {
            foreach ($a->attributes() as $b) {
                if ($b == 'Email' || $b == 'email' || $b == '=correo' || $b == 'Correo') {
                    $correo = $a;
                    $infoAdicional .= $b . ': ' . $a . "\n";
                } else {
                    $infoAdicional .= $b . ': ' . $a . "\n";
                }
            }
        }
        $pdf->SetXY(10, $ejeX + 30);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->MultiCell(100, 10, "Informacion Adicional", 0);
        $pdf->SetXY(10, $ejeX + 50);
        $pdf->SetFont('Arial', '', 7);
        $pdf->MultiCell(100, 5, "" . $infoAdicional . "", 0);

        $email = new sendEmail();
        
        $pdf->Output('../../comprobantes/' . $claveAcceso . '.pdf', 'F');
        $email->enviarCorreo('Nota Credito', $document->infoNotaCredito->razonSocialComprador, $claveAcceso, $correo);
    }

    public function generarCodigoBarras($claveAcceso) {
        $colorFront = new BCGColor(0, 0, 0);
        $colorBack = new BCGColor(255, 255, 255);

        $code = new BCGcode128();
        $code->setScale(4);
        $code->setThickness(30);
        $code->setForegroundColor($colorFront);
        $code->setBackgroundColor($colorBack);
        $code->parse($claveAcceso);

        $drawing = new BCGDrawing('uploads/codigo.png', $colorBack);
        $drawing->setBarcode($code);

        $drawing->draw();
        $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
        $this->redim('uploads/codigo.png', 'uploads/codigo_mod.png', 1000, 200);
    }

    public function redim($ruta1, $ruta2, $ancho, $alto) {
        # se obtene la dimension y tipo de imagen 
        $datos = getimagesize($ruta1);

        $ancho_orig = $datos[0]; # Anchura de la imagen original 
        $alto_orig = $datos[1];    # Altura de la imagen original 
        $tipo = $datos[2];

        if ($tipo == 1) { # GIF 
            if (function_exists("imagecreatefromgif"))
                $img = imagecreatefromgif($ruta1);
            else
                return false;
        }
        else if ($tipo == 2) { # JPG 
            if (function_exists("imagecreatefromjpeg"))
                $img = imagecreatefromjpeg($ruta1);
            else
                return false;
        }
        else if ($tipo == 3) { # PNG 
            if (function_exists("imagecreatefrompng"))
                $img = imagecreatefrompng($ruta1);
            else
                return false;
        }

        # Se calculan las nuevas dimensiones de la imagen 
        if ($ancho_orig > $alto_orig) {
            $ancho_dest = $ancho;
            $alto_dest = ($ancho_dest / $ancho_orig) * $alto_orig;
        } else {
            $alto_dest = $alto;
            $ancho_dest = ($alto_dest / $alto_orig) * $ancho_orig;
        }

        // imagecreatetruecolor, solo estan en G.D. 2.0.1 con PHP 4.0.6+ 
        $img2 = @imagecreatetruecolor($ancho_dest, $alto_dest) or $img2 = imagecreate($ancho_dest, $alto_dest);

        // Redimensionar 
        // imagecopyresampled, solo estan en G.D. 2.0.1 con PHP 4.0.6+ 
        @imagecopyresampled($img2, $img, 0, 0, 0, 0, $ancho_dest, $alto_dest, $ancho_orig, $alto_orig) or imagecopyresized($img2, $img, 0, 0, 0, 0, $ancho_dest, $alto_dest, $ancho_orig, $alto_orig);

        // Crear fichero nuevo, según extensión. 
        if ($tipo == 1) // GIF 
            if (function_exists("imagegif"))
                imagegif($img2, $ruta2);
            else
                return false;

        if ($tipo == 2) // JPG 
            if (function_exists("imagejpeg"))
                imagejpeg($img2, $ruta2);
            else
                return false;

        if ($tipo == 3)  // PNG 
            if (function_exists("imagepng"))
                imagepng($img2, $ruta2);
            else
                return false;

        return true;
    }
	
	
	
}
