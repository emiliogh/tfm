<?php
SESSION_START();
require('../fpdf/fpdf.php');
include_once("../conexion/class.conexion.php");
ob_end_clean(); 
//header('Content-Type: text/html; charset=utf-8');

/*
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
	
	function Header()
	{	
		$this->AddFont('Calibri');
		// Información Visual
		$this->Image('../images/electronico/logoRide.jpg',3,0,100);
		$this->SetFillColor(214,214,214);
		$this->SetY(41.5); $this->SetX(5);	
		$this->Cell(116,54.5,'',0,1,'I',true);
		$this->SetY(98); $this->SetX(5);	
		$this->Cell(197,20.5,'',0,1,'I',true);
		
		$this->SetY(120.5); $this->SetX(5);
		$this->SetFillColor(31, 119, 147);
		$this->Cell(197,10,'',0,1,'I',true);
		
		$this->SetFillColor(256,256,256);
		$this->SetDrawColor(31, 119, 147);
		$this->RoundedRect(121, 10, 81, 86, 5, '13', 'DF');
		
		$this->SetDrawColor(255,255,255); $this->SetFillColor(255,255,255); 
		$this->SetFont('helvetica','b',10);
		$this->SetY(12); $this->SetX(124);	
		$this->Cell(0,5,utf8_decode('R.U.C.: '),1,1,'I',true);
		$this->SetY(24); $this->SetX(124);
		$this->Cell(0,5,utf8_decode('FACTURA'),1,1,'I',true);
		$this->SetY(36); $this->SetX(124);
		$this->Cell(0,5,utf8_decode('NÚMERO DE AUTORIZACIÓN'),1,1,'I',true);
		$this->SetY(48); $this->SetX(124);
		$this->Cell(0,5,utf8_decode('FECHA Y HORA DE AUTORIZACIÓN'),1,1,'I',true);
		$this->SetY(60); $this->SetX(124);
		$this->Cell(0,5,utf8_decode('AMBIENTE:'),1,1,'I',true);
		$this->SetY(66); $this->SetX(124);
		$this->Cell(0,5,utf8_decode('EMISIÓN:'),1,1,'I',true);
		$this->SetY(72); $this->SetX(124);
		$this->Cell(0,5,utf8_decode('CLAVE DE ACCESO'),1,1,'I',true);
		
		
		$this->SetTextColor(0, 0, 0);
		$this->SetY(60); $this->SetX(8);$this->SetFont('helvetica','b',10);
		$this->Cell(40,4,utf8_decode('Dirección Matriz:'),0,1,'I',false);
		$this->SetY(73); $this->SetX(8);
		$this->Cell(40,4,utf8_decode('Dirección Sucursal:'),0,1,'I',false);
		$this->SetY(85); $this->SetX(8);
		$this->Cell(40,4,utf8_decode('Contribuyente especial N° :'),0,1,'I',false);
		$this->SetY(90); $this->SetX(8);
		$this->Cell(40,4,utf8_decode('Obligado a llevar contabilidad:'),0,1,'I',false);
		
		$this->SetY(100); $this->SetX(8);
		$this->SetFont('helvetica','b',10);
		$this->Cell(40,4,utf8_decode('Razón Social/Nombre y Apellidos:'),0,1,'I',false);
		$this->SetY(113); $this->SetX(8);
		$this->Cell(40,4,utf8_decode('Fecha Emisión:'),0,1,'I',false);
		$this->SetY(113); $this->SetX(150);
		$this->Cell(40,4,utf8_decode('Identificación:'),0,1,'I',false);
		
		$this->SetFont('helvetica','b',6);
		$this->SetY(123.5); $this->SetX(8);
		$this->SetTextColor(214, 214, 214);
		$this->Cell(40,4,utf8_decode('CÓDIGO'),0,1,'I',false);
		$this->SetY(123.5); $this->SetX(18);
		$this->Cell(40,4,'CANTIDAD',0,1,'I',false);
		$this->SetY(123.5); $this->SetX(31);
		$this->Cell(40,4,utf8_decode('DESCRIPCIÓN'),0,1,'I',false);
		$this->SetY(122.5); $this->SetX(91);
		$this->MultiCell(15,3,'DETALLE ADICIONAL',0,'C');
		$this->SetY(122.5); $this->SetX(108);
		$this->MultiCell(15,3,'DETALLE ADICIONAL',0,'C');
		$this->SetY(122.5); $this->SetX(125);
		$this->MultiCell(15,3,'DETALLE ADICIONAL',0,'C');
		$this->SetY(121.8); $this->SetX(145);
		$this->MultiCell(15,2.5,'PRECIO UNITARIO USD',0,'C');
		$this->SetY(122.5); $this->SetX(165);
		$this->MultiCell(16,3,'DESCUENTO USD',0,'C');
		$this->SetY(121.8); $this->SetX(185);
		$this->MultiCell(14,2.5,'PRECIO TOTAL USD',0,'C');
		
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
				  "WHERE p.id_factura 		  	 = '".$_GET["idfactura"]."' ".
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
			 	$this->SetTextColor(31, 119, 147);
				$this->SetFont('Calibri','',14);
				$this->SetY(16); $this->SetX(124);	
				$this->Cell(0,5,$resultados[0],1,1,'I',0);
				$this->SetY(28); $this->SetX(124);	
				$this->Cell(0,5,$resultados[6],1,1,'I',0);
				$this->SetFont('Calibri','',8.5);
				$this->SetY(40); $this->SetX(124);	
				$this->Cell(0,5,$resultados[22],1,1,'I',0);//AUTORIZACIÓN
				$this->SetFont('Calibri','',14);
				$this->SetY(52); $this->SetX(124);	
				$this->Cell(0,5,$resultados[23],1,1,'I',0);//FECHA AUTORIZACION
				$this->SetY(60); $this->SetX(154);	
				$this->Cell(0,5,utf8_decode($resultados[24]),1,1,'I',0);//AMBIENTE
				$this->SetY(66); $this->SetX(154);	
				$this->MultiCell(0,5,utf8_decode($resultados[25]),0,'J');//EMISION
				
				$this->SetFont('Calibri','',8.5);
				$this->SetY(86); $this->SetX(154);	
				$this->Code39(124,78,$resultados[22],.28,12);
				
				$this->SetY(45); $this->SetX(8);
				$this->SetFont('Calibri','',12);
				$this->MultiCell(110,3.5,utf8_decode($resultados[1]),0,'C');
				$this->SetY(53); $this->SetX(8);$this->SetFont('helvetica','b',18);
				$this->Cell(110,4,utf8_decode($resultados[2]),0,1,'C',false);
				
				$this->SetY(65); $this->SetX(8);$this->SetFont('Calibri','',10);
				$this->MultiCell(110,3,$resultados[4],0,'J');
				$this->SetY(77); $this->SetX(8);
				$this->MultiCell(110,3,$resultados[5],0,'J');
				
				$this->SetY(85); $this->SetX(68);
				$this->Cell(40,4,utf8_decode($resultados[26]),0,1,'I',false);
				$this->SetY(90); $this->SetX(68);
				$this->Cell(40,4,utf8_decode($resultados[27]),0,1,'I',false);

				$this->SetY(113); $this->SetX(175);$this->SetFont('Calibri','',10);
				$this->Cell(40,4,utf8_decode($resultados[16]),0,1,'I',false);
				$this->SetY(105); $this->SetX(12);
				$this->MultiCell(185,3,utf8_decode($resultados[17]),0,'J');
				$this->SetY(113.5); $this->SetX(36);
				$this->MultiCell(80,3,utf8_decode($resultados[8]),2,'J');
				
				// ***** 
				$subTotal0 		= $resultados[11];
				$subTotal12 	= $resultados[12];
				$porcentaje 	= $resultados[13];
				$iva 			= $resultados[14];
				$total 			= $resultados[15];
				
				$direccion 	= $resultados[19];
				$telefono 	= $resultados[20];
				$email 		= $resultados[21];
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
				  "WHERE p.id_factura 		  	 = '".$_GET["idfactura"]."' ";
		
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		$fila = 131;
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){
				  	$this->SetFont('Calibri','',7);
					$this->SetY($fila); $this->SetX(31);
				    $alto = $this->GetMultiCellHeight(60,2.5, utf8_decode($resultados[2]),0,'J');
				    //$this->SetY($fila); $this->SetX(31);
					//$this->MultiCell(60,2.5,$alto.utf8_decode($resultados[2]),0,'J');
				
					$this->SetY($fila); $this->SetX(8);
				    $this->Cell(10,$alto,$resultados[0],0,1,'R',false);
					$this->SetY($fila); $this->SetX(18);
					$this->Cell(10,$alto,utf8_decode($resultados[1]),0,1,'R',false);
					$this->SetY($fila); $this->SetX(31);
					$this->MultiCell(60,2.5,utf8_decode($resultados[2]),0,'J');
					$this->SetY($fila); $this->SetX(145);
					$this->MultiCell(13,$alto,number_format($resultados[6],2),0,'R');
					$this->SetY($fila); $this->SetX(165);
					$this->MultiCell(13,$alto,number_format($resultados[7],2),0,'R');
					$this->SetY($fila); $this->SetX(184);
					$this->MultiCell(13,$alto,number_format($resultados[8],2),0,'R');

					$fila = $fila+$alto+1;
					$this->SetDrawColor(130,167,195);
					$this->line(6,$fila-.5,201,$fila-.5);
			}
		}
			
		// DATOS CONTACTO
		$fila = $fila - 0.5;
		$this->SetFillColor(214,214,214);
		$this->SetY($fila); $this->SetX(5);	
		$this->Cell(120,48,'',0,1,'I',true);
		
		$this->SetTextColor(0, 0, 0);
		$this->SetY($fila+2); $this->SetX(8);$this->SetFont('helvetica','',10);
		$this->Cell(40,4,utf8_decode('Dirección:'),0,1,'I',false);
		$this->SetY($fila+12); $this->SetX(8);
		$this->Cell(40,4,utf8_decode('Teléfono:'),0,1,'I',false);
		$this->SetY($fila+22); $this->SetX(8);
		$this->Cell(40,4,utf8_decode('Email:'),0,1,'I',false);
		$this->SetY($fila+32); $this->SetX(8);
		$this->Cell(40,4,utf8_decode('Forma de pago:'),0,1,'I',false);
		
		$this->SetTextColor(31, 119, 147);
		$this->SetFont('Calibri','',10);
		$this->SetY($fila+5); $this->SetX(8);	
		$this->Cell(40,5,$direccion,0,1,'I',0);
		$this->SetY($fila+15); $this->SetX(8);	
		$this->Cell(40,5,$telefono,0,1,'I',0);
		$this->SetY($fila+25); $this->SetX(8);	
		$this->Cell(40,5,$email,0,1,'I',0);
		$this->SetY($fila+35); $this->SetX(8);	
		$this->Cell(40,5,utf8_decode('OTROS CON UTILIZACION DEL SISTEMA FINANCIERO'),0,1,'I',0);
		
		// DEUDA
		$this->SetY($fila); $this->SetX(124);	
		$this->Cell(78,48,'',0,1,'I',true);
		$this->SetFont('calibri','',9);
		$this->SetFillColor(31, 119, 147);
		$this->SetTextColor(214, 214, 214);

		$this->SetY($fila); $this->SetX(124); $this->SetFont('calibri','',9);	
		$this->Cell(78,6,'',1,1,'I',true);
		$this->SetY($fila); $this->SetX(126);	
		$this->Cell(78,6,'SUBTOTAL 12% ',0,1,'I',false);
		$this->SetY($fila); $this->SetX(168); $this->SetFont('Calibri','',10);	
		$this->Cell(30,6,number_format($subTotal12,2),0,1,'R',false);


		$this->SetY($fila+6); $this->SetX(124);	$this->SetFont('calibri','',9);
		$this->Cell(78,6,'',1,1,'I',true);
		$this->SetY($fila+6); $this->SetX(126);	
		$this->Cell(78,6,'SUBTOTAL 0% ',0,1,'I',false);
		$this->SetY($fila+6); $this->SetX(168);	$this->SetFont('Calibri','',10);
		$this->Cell(30,6,number_format($subTotal0,2),0,1,'R',false);

		$this->SetY($fila+12); $this->SetX(124); $this->SetFont('calibri','',9);	
		$this->Cell(78,6,'',1,1,'I',true);
		$this->SetY($fila+12); $this->SetX(126);	
		$this->Cell(78,6,'SUBTOTAL NO OBJETO DE IVA',0,1,'I',false);
		$this->SetY($fila+12); $this->SetX(168); $this->SetFont('Calibri','',10);	
		$this->Cell(30,6,'0.00',0,1,'R',false);

		$this->SetY($fila+18); $this->SetX(124); $this->SetFont('calibri','',9);	
		$this->Cell(78,6,'',1,1,'I',true);
		$this->SetY($fila+18); $this->SetX(126);	
		$this->Cell(78,6,'SUBTOTAL EXENTO DE IVA ',0,1,'I',false);
		$this->SetY($fila+18); $this->SetX(168); $this->SetFont('Calibri','',10);
		$this->Cell(30,6,'0.00',0,1,'R',false);

		$this->SetY($fila+24); $this->SetX(124); $this->SetFont('calibri','',9);	
		$this->Cell(78,6,'',1,1,'I',true);
		$this->SetY($fila+24); $this->SetX(126);	
		$this->Cell(78,6,'SUBTOTAL SIN IMPUESTOS ',0,1,'I',false);
		$this->SetY($fila+24); $this->SetX(168); $this->SetFont('Calibri','',10);	
		$this->Cell(30,6,'0.00',0,1,'R',false);

		$this->SetY($fila+30); $this->SetX(124); $this->SetFont('calibri','',9);	
		$this->Cell(78,6,'',1,1,'I',true);
		$this->SetY($fila+30); $this->SetX(126);	
		$this->Cell(78,6,'TOTAL DESCUENTO ',0,1,'I',false);
		$this->SetY($fila+30); $this->SetX(168); $this->SetFont('Calibri','',10);	
		$this->Cell(30,6,number_format($descuento,2),0,1,'R',false);

		$this->SetY($fila+36); $this->SetX(124); $this->SetFont('calibri','',9);	
		$this->Cell(78,6,'',1,1,'I',true);
		$this->SetY($fila+36); $this->SetX(126);	
		$this->Cell(78,6,'IVA '.$porcentaje.'%',0,1,'I',false);
		$this->SetY($fila+36); $this->SetX(168); $this->SetFont('Calibri','',10);	
		$this->Cell(30,6,$iva,0,1,'R',false);

		$this->SetY($fila+42); $this->SetX(124); $this->SetFont('calibri','',9);	
		$this->Cell(78,6,'',1,1,'I',true);
		$this->SetY($fila+42); $this->SetX(126);	
		$this->Cell(78,6,'VALOR TOTAL  ',0,1,'I',false);
		$this->SetY($fila+42); $this->SetX(168); $this->SetFont('Calibri','',10);	
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

		$this->SetFont('Calibri','',8.6);
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
	?>*/

	$db = new MySQL();
	$query = "select e.numero_identificacion, ".
					"e.razon_social, ". 
					"e.abreviatura, ".
					"s.direccion, ".
					"p.numero_factura, ".
					"DATE_FORMAT(p.fecha_factura,'%d/%m/%Y'), ".
		            "c.numero_identificacion, ".
					"c.nombre_cliente, ".
					"(p.monto_subtotal+p.monto_subtotal0), ".
		            "p.monto_subtotal, ".
					"p.monto_subtotal0, ".
		            "p.monto_subtotal_impuesto, ".
					"p.porcentaje_impuesto, ".
					"p.monto_impuesto, ".
					"p.monto_total, ".
					
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
		           "and s.id_tipo_establecimiento = 1 ".
				"inner join tgn_empresas em ".
					"on em.estado = 'A' ".
				"inner join tgn_empresas_info_tributaria i ".
					"on i.estado = 'A' ".
					"and i.id_empresa = em.id_empresa ".
				"WHERE p.id_factura 		  	 = '".$_GET["idfactura"]."' ".
					"AND p.estado				 != 'A' ";


	echo '<style>@media print { @page { margin: 0; } body { margin: 2cm; }}</style>';
    echo '<script type="text/javascript">window.onload = function() { window.print(); } </script>';
 
	$consulta = $db->consulta($query);
	$numResul = $db->num_rows($consulta);
	if($numResul>0){
		while($resultados = $db->fetch_array($consulta)){ 
			  echo '<table style="font-family:verdana">'.
				          '<tr><td colspan="2" style="text-align: center; font-size: 16px">'.$resultados[1].'</td></tr>'.
			  		      '<tr><td colspan="2" style="text-align: center; font-size: 10px">'.$resultados[0].'</td></tr>'.
				          '<tr><td colspan="2" style="text-align: center; font-size: 7px">'.$resultados[3].'</td></tr>'.
				          '<tr><td colspan="2" style="height: 15px; font-size: 10px"></td></tr>'. 
				          '<tr><td style="font-size: 8px"><b>N° Factura:</b></td><td style="font-size: 8px">'.$resultados[4].'</td></tr>'.
				          '<tr><td style="font-size: 8px"><b>Fecha Emisión:</b></td><td style="font-size: 8px">'.$resultados[5].'</td></tr>'.
				          '<tr><td style="font-size: 8px"><b>Identificación:</b></td><td style="font-size: 8px">'.$resultados[6].'</td></tr>'.
				          '<tr><td style="font-size: 8px"><b>Nombre:</b></td><td style="font-size: 8px">'.$resultados[7].'</td></tr>'.
				          '<tr><td colspan="2" style="height: 15px; font-size: 10px"></td></tr>'. 
				  		  '<tr><td colspan="2">'.
				  			'<table style="width: 100%">'.
				  				'<tr><td style="font-size: 8px; text-align: left;"><b>Cod</b>'.
				                '</td><td style="font-size: 8px; text-align: left;"><b>Cant</b>'.
				  				'</td><td style="font-size: 8px; text-align: left;"><b>Descripción</b>'.
				  				'</td><td style="font-size: 8px; text-align: right;"><b>P.Unit</b></td>'.
				                '</td><td style="font-size: 8px; text-align: right;"><b>Valor</b></td></tr>';
			
				$querySQ="select LPAD(df.id_producto,4,'0'), ".
								"df.cantidad, ". 
								"df.descripcion_rubro, ".
								"df.precio_venta, ".
								"df.descuento, ".
								"df.total ".
						   "from tsc_facturas p ".
						  "inner join tsc_detalles_factura df ".
							 "on p.id_factura = df.id_factura ".
						  "WHERE p.id_factura 		  	 = '".$_GET["idfactura"]."' ";

							$consultaSQ = $db->consulta($querySQ);
							$numResulSQ = $db->num_rows($consultaSQ);
							if($numResulSQ>0){
								while($resultadosSQ = $db->fetch_array($consultaSQ)){
									  echo '<tr><td style="font-size: 8px">'.$resultadosSQ[0].
										   '</td><td style="font-size: 8px">'.$resultadosSQ[1].
										   '</td><td style="font-size: 8px">'.$resultadosSQ[2].
										   '</td><td style="font-size: 8px;  text-align: right;">'.$resultadosSQ[3].
										   '</td><td style="font-size: 8px;  text-align: right;">'.$resultadosSQ[5].'</td></tr>';	
								}
							}
			
					echo '</table></td></tr>'.
					 	'<tr><td style="font-size: 8px; text-align: right;"><b>Subtotal:</b>'.
						   '</td><td style="font-size: 8px; text-align: right;">'.$resultados[9].'</td></tr>'.
				     	'<tr><td style="font-size: 8px;text-align: right;"><b>Base 0%:</b>'.
						   '</td><td style="font-size: 8px; text-align: right;">'.$resultados[10].'</td></tr>'.
				        '<tr><td style="font-size: 8px;text-align: right;"><b>Base '.$resultados[12].'%:</b>'.
						   '</td><td style="font-size: 8px;text-align: right;">'.$resultados[11].'</td></tr>'.
				        '<tr><td style="font-size: 8px; text-align: right;"><b>IVA:</b>'.
						   '</td><td style="font-size: 8px;text-align: right;">'.$resultados[13].'</td></tr>'.
						'<tr><td style="font-size: 8px;text-align: right;"><b>Total:</b>'.
						   '</td><td style="font-size: 8px; text-align: right;">'.$resultados[14].'</td></tr>';
			}
		}

	
