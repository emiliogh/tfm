<?php
SESSION_START();
require('../fpdf/fpdf.php');
include_once("../conexion/class.conexion.php");
ob_end_clean(); 
header('Content-Type: text/html; charset=utf-8');

class PDF extends FPDF
{
	//Cabecera de página
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
	
	function Header()
	{	
		$this->AddFont('Calibri');
		/*Información Visual*/
		$this->Image('../images/electronico/logoRide.jpg',3,0,100);
		$this->SetFillColor(214,214,214);
		$this->SetY(41.5); $this->SetX(5);	
		$this->Cell(116,44.5,'',0,1,'I',true);
		$this->SetY(88); $this->SetX(5);	
		$this->Cell(197,20.5,'',0,1,'I',true);
		$this->SetY(110.5); $this->SetX(5);
		
		$this->SetFillColor(0, 106, 46);
		$this->Cell(197,10,'',0,1,'I',true);
		
		$this->SetFillColor(256,256,256);
		$this->SetDrawColor(0, 106, 46);
		$this->RoundedRect(121, 10, 81, 76, 5, '13', 'DF');
		
		$this->SetDrawColor(255,255,255); $this->SetFillColor(255,255,255); 
		$this->SetFont('helvetica','b',10);
		$this->SetY(15); $this->SetX(124);	
		$this->Cell(0,5,'R.U.C.: '.$row[0],1,1,'I',true);
		$this->SetY(30); $this->SetX(124);
		$this->Cell(0,5,'PROFORMA',1,1,'I',true);
		$this->SetY(42); $this->SetX(124);
		$this->Cell(0,5,utf8_decode('FECHA EMISIÓN'),1,1,'I',true);
		$this->SetY(52); $this->SetX(124);
		$this->Cell(0,5,utf8_decode('FECHA VALIDEZ'),1,1,'I',true);
		
		$this->SetTextColor(0, 0, 0);
		$this->SetY(60); $this->SetX(8);$this->SetFont('helvetica','b',10);
		$this->Cell(40,4,utf8_decode('Dirección Matriz:'),0,1,'I',false);
		$this->SetY(73); $this->SetX(8);
		$this->Cell(40,4,utf8_decode('Dirección Sucursal:'),0,1,'I',false);
		
		$this->SetY(90); $this->SetX(8);
		$this->SetFont('helvetica','b',10);
		$this->Cell(40,4,utf8_decode('Razón Social/Nombre y Apellidos:'),0,1,'I',false);
		$this->SetY(103); $this->SetX(8);
		$this->Cell(40,4,utf8_decode('Fecha Emisión:'),0,1,'I',false);
		$this->SetY(90); $this->SetX(150);
		$this->Cell(40,4,utf8_decode('Identificación:'),0,1,'I',false);
		
		$this->SetFont('helvetica','b',6);
		$this->SetY(113.5); $this->SetX(8);
		$this->SetTextColor(214, 214, 214);
		$this->Cell(40,4,utf8_decode('CÓDIGO'),0,1,'I',false);
		$this->SetY(113.5); $this->SetX(18);
		$this->Cell(40,4,'CANTIDAD',0,1,'I',false);
		$this->SetY(113.5); $this->SetX(31);
		$this->Cell(40,4,utf8_decode('DESCRIPCIÓN'),0,1,'I',false);
		$this->SetY(112.5); $this->SetX(91);
		$this->MultiCell(15,3,'DETALLE ADICIONAL',0,'C');
		$this->SetY(112.5); $this->SetX(108);
		$this->MultiCell(15,3,'DETALLE ADICIONAL',0,'C');
		$this->SetY(112.5); $this->SetX(125);
		$this->MultiCell(15,3,'DETALLE ADICIONAL',0,'C');
		$this->SetY(111.8); $this->SetX(145);
		$this->MultiCell(15,2.5,'PRECIO UNITARIO USD',0,'C');
		$this->SetY(112.5); $this->SetX(165);
		$this->MultiCell(16,3,'DESCUENTO USD',0,'C');
		$this->SetY(111.8); $this->SetX(185);
		$this->MultiCell(14,2.5,'PRECIO TOTAL USD',0,'C');
		
		$db = new MySQL();
		$query = "select e.numero_identificacion, ".
						"e.razon_social, ". 
						"e.abreviatura, ".
			            "s.direccion, ".
						"s.direccion, ".
						"s.direccion, ".
						"concat(DATE_FORMAT(p.fecha_proforma,'%Y'),'-',LPAD(p.id_proforma,8,'0')), ".
						"p.descripcion, ".
			            "DATE_FORMAT(p.fecha_proforma,'%d/%m/%Y'), ".
						"DATE_FORMAT(p.fecha_validez,'%d/%m/%Y'), ".
						"p.monto_subtotal, ".
						"p.monto_iva_0, ".
						"p.monto_iva_12, ".
						"p.porcentaje_iva, ".
						"p.monto_iva, ".
						"p.monto_total, ".
						"c.numero_identificacion, ".
						"c.nombre_cliente, ".
						"c.direccion, ".
						"c.direccion, ".
						"c.correo_electronico, ".
						"c.telefono ".
			       "from tsc_proformas p ".
				  "inner join tcu_clientes c ".
			         "on c.id_cliente = p.id_cliente ".
				  "inner join tgn_empresas e ".
			         "on e.estado = 'A' ". 
			      "inner join tsc_establecimientos s ".
				     "on s.identificador_matriz  = 'S' ".
			      "inner join tsc_puntos_emision pt ".
				     "on pt.id_establecimiento 	 = s.id_establecimiento ".
				  "WHERE p.id_proforma 		  	 = '".$_GET["idproforma"]."' ".
			        "AND p.estado				 = 'A' ";
		
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		$subTotal0 = 0;
		$subTotal12 = 0;
		$porcentaje = 0;
		$iva = 0;
		$descuento = 0;
		$total = 0;
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){ 
			 	$this->SetTextColor(0, 106, 46);
				$this->SetFont('Calibri','',14);
				$this->SetY(20); $this->SetX(124);	
				$this->Cell(0,5,$resultados[0],1,1,'I',true);
				$this->SetY(35); $this->SetX(124);	
				$this->Cell(0,5,$resultados[6],1,1,'I',true);
				$this->SetY(47); $this->SetX(124);	
				$this->Cell(0,5,$resultados[8],1,1,'I',true);
				$this->SetY(57); $this->SetX(124);	
				$this->Cell(0,5,$resultados[9],1,1,'I',true);
				$this->SetY(65); $this->SetX(124);	
				$this->MultiCell(0,5,$resultados[7],0,'J');
				
				$this->SetY(45); $this->SetX(8);
				$this->SetFont('Calibri','',12);
				$this->MultiCell(110,3.5,utf8_decode($resultados[1]),0,'C');
				$this->SetY(53); $this->SetX(8);$this->SetFont('helvetica','b',18);
				$this->Cell(110,4,utf8_decode($resultados[2]),0,1,'C',false);
				
				$this->SetY(65); $this->SetX(8);$this->SetFont('Calibri','',10);
				$this->MultiCell(110,3,$resultados[4],0,'J');
				$this->SetY(77); $this->SetX(8);
				$this->MultiCell(110,3,$resultados[5],0,'J');

				$this->SetY(90); $this->SetX(175);$this->SetFont('Calibri','',10);
				$this->Cell(40,4,utf8_decode($resultados[16]),0,1,'I',false);
				$this->SetY(95); $this->SetX(12);
				$this->MultiCell(185,3,utf8_decode($resultados[17]),0,'J');
				$this->SetY(103.5); $this->SetX(36);
				$this->MultiCell(80,3,utf8_decode($resultados[8]),2,'J');
				
				//******//
				$subTotal0 		= $resultados[11];
				$subTotal12 	= $resultados[12];
				$porcentaje 	= $resultados[13];
				$iva 			= $resultados[14];
				$total 			= $resultados[15];
			}
		}	
		
		sleep(5);
		$query = "select LPAD(dp.id_producto,4,'0'), ".
						"dp.cantidad, ". 
						"dp.descripcion_rubro, ".
			            "'', ".
						"'', ".
						"'', ".
						"dp.precio_venta, ".
						"dp.descuento, ".
						"dp.total ".
			       "from tsc_proformas p ".
				  "inner join tsc_detalle_proforma dp ".
			         "on p.id_proforma = dp.id_proforma ".
				  "WHERE p.id_proforma 		  	 = '".$_GET["idproforma"]."' ";
		
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		$fila = 121;
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){
				  	$this->SetY($fila); $this->SetX(8);$this->SetFont('Calibri','',7);
					$this->Cell(10,3,$resultados[0],0,1,'R',false);
					$this->SetY($fila); $this->SetX(18);
					$this->Cell(10,3,$resultados[1],0,1,'R',false);
					$this->SetY($fila); $this->SetX(31);
					$this->MultiCell(60,2.5,utf8_decode($resultados[2]),0,'J');
					$this->SetY($fila); $this->SetX(145);
					$this->MultiCell(13,5,number_format($resultados[6],2),0,'R');
					$this->SetY($fila); $this->SetX(165);
					$this->MultiCell(13,5,number_format($resultados[7],2),0,'R');
					$this->SetY($fila); $this->SetX(184);
					$this->MultiCell(13,5,number_format($resultados[8],2),0,'R');

					$fila = $fila+6;
					$this->SetDrawColor(130,167,195);
					$this->line(6,$fila-.5,201,$fila-.5);
			}
		}
			
		/*RESUMEN*/
		$this->SetY($fila); $this->SetX(124);	
		$this->Cell(78,48,'',0,1,'I',true);
		$this->SetFont('calibri','',9);
		$this->SetFillColor(0, 106, 46);
		$this->SetTextColor(214, 214, 214);

		$this->SetY($fila); $this->SetX(124); $this->SetFont('calibri','',9);	
		$this->Cell(78,6,'',1,1,'I',true);
		$this->SetY($fila); $this->SetX(126);	
		$this->Cell(78,6,'SUBTOTAL 12% ',0,1,'I',false);
		$this->SetY($fila); $this->SetX(170); $this->SetFont('Calibri','',10);	
		$this->Cell(30,6,number_format($subTotal12,2),0,1,'R',false);


		$this->SetY($fila+6); $this->SetX(124);	$this->SetFont('calibri','',9);
		$this->Cell(78,6,'',1,1,'I',true);
		$this->SetY($fila+6); $this->SetX(126);	
		$this->Cell(78,6,'SUBTOTAL 0% ',0,1,'I',false);
		$this->SetY($fila+6); $this->SetX(170);	$this->SetFont('Calibri','',10);
		$this->Cell(30,6,number_format($subTotal0,2),0,1,'R',false);

		$this->SetY($fila+12); $this->SetX(124); $this->SetFont('calibri','',9);	
		$this->Cell(78,6,'',1,1,'I',true);
		$this->SetY($fila+12); $this->SetX(126);	
		$this->Cell(78,6,'SUBTOTAL NO OBJETO DE IVA',0,1,'I',false);
		$this->SetY($fila+12); $this->SetX(170); $this->SetFont('Calibri','',10);	
		$this->Cell(30,6,'0.00',0,1,'R',false);

		$this->SetY($fila+18); $this->SetX(124); $this->SetFont('calibri','',9);	
		$this->Cell(78,6,'',1,1,'I',true);
		$this->SetY($fila+18); $this->SetX(126);	
		$this->Cell(78,6,'SUBTOTAL EXENTO DE IVA ',0,1,'I',false);
		$this->SetY($fila+18); $this->SetX(170); $this->SetFont('Calibri','',10);
		$this->Cell(30,6,'0.00',0,1,'R',false);

		$this->SetY($fila+24); $this->SetX(124); $this->SetFont('calibri','',9);	
		$this->Cell(78,6,'',1,1,'I',true);
		$this->SetY($fila+24); $this->SetX(126);	
		$this->Cell(78,6,'SUBTOTAL SIN IMPUESTOS ',0,1,'I',false);
		$this->SetY($fila+24); $this->SetX(170); $this->SetFont('Calibri','',10);	
		$this->Cell(30,6,'0.00',0,1,'R',false);

		$this->SetY($fila+30); $this->SetX(124); $this->SetFont('calibri','',9);	
		$this->Cell(78,6,'',1,1,'I',true);
		$this->SetY($fila+30); $this->SetX(126);	
		$this->Cell(78,6,'TOTAL DESCUENTO ',0,1,'I',false);
		$this->SetY($fila+30); $this->SetX(170); $this->SetFont('Calibri','',10);	
		$this->Cell(30,6,number_format($descuento,2),0,1,'R',false);

		$this->SetY($fila+36); $this->SetX(124); $this->SetFont('calibri','',9);	
		$this->Cell(78,6,'',1,1,'I',true);
		$this->SetY($fila+36); $this->SetX(126);	
		$this->Cell(78,6,'IVA '.$porcentaje.'%',0,1,'I',false);
		$this->SetY($fila+36); $this->SetX(170); $this->SetFont('Calibri','',10);	
		$this->Cell(30,6,$iva,0,1,'R',false);

		$this->SetY($fila+42); $this->SetX(124); $this->SetFont('calibri','',9);	
		$this->Cell(78,6,'',1,1,'I',true);
		$this->SetY($fila+42); $this->SetX(126);	
		$this->Cell(78,6,'VALOR TOTAL  ',0,1,'I',false);
		$this->SetY($fila+42); $this->SetX(170); $this->SetFont('Calibri','',10);	
		$this->Cell(30,6,number_format($total,2),0,1,'R',false);
		
			
		}
		
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

		$this->SetFont('Arial','',10);
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
	}

  $pdf=new PDF();
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetAutoPageBreak(false);
	
	
		
			
	$pdf->Output();
	?>
