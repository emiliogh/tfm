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
		$this->Cell(116,28.5,'',0,1,'I',true);
		$this->SetY(72); $this->SetX(5);	
		$this->Cell(197,20.5,'',0,1,'I',true);
		
		$this->SetY(94.5); $this->SetX(5);
		$this->SetFillColor(0, 106, 46);
		$this->Cell(197,10,'',0,1,'I',true);
		
		$this->SetFillColor(256,256,256);
		$this->SetDrawColor(0, 106, 46);
		$this->RoundedRect(121, 10, 81, 60, 5, '13', 'DF');
		
		$this->SetDrawColor(255,255,255); $this->SetFillColor(255,255,255); 
		$this->SetFont('helvetica','b',10);
		$this->SetY(12); $this->SetX(124);	
		$this->Cell(0,5,utf8_decode('R.U.C. '),1,1,'I',true);
		$this->SetY(24); $this->SetX(124);
		$this->Cell(0,5,utf8_decode('ASIENTO'),1,1,'I',true);
		$this->SetY(36); $this->SetX(124);
		$this->Cell(0,5,utf8_decode('FECHA Y HORA DE EMISIÓN'),1,1,'I',true);
		$this->SetY(48); $this->SetX(124);
		$this->Cell(0,5,utf8_decode('FECHA Y HORA DE AUTORIZACIÓN'),1,1,'I',true);
		$this->SetY(60); $this->SetX(124);
		$this->Cell(0,5,utf8_decode('ESTADO'),1,1,'I',true);
		
		$this->SetTextColor(0, 0, 0);
		$this->SetY(65); $this->SetX(8);$this->SetFont('helvetica','b',10);
		$this->Cell(40,4,utf8_decode('Descripción: '),0,1,'I',false);

		$this->SetY(76); $this->SetX(8);
		$this->SetFont('helvetica','b',10);
		$this->Cell(40,4,utf8_decode('Glosa'),0,1,'I',false);
		
		$this->SetFont('helvetica','b',8);
		$this->SetY(98); $this->SetX(8);
		$this->SetTextColor(214, 214, 214);
		$this->Cell(40,4,utf8_decode('LÍNEA'),0,1,'I',false);
		$this->SetY(98); $this->SetX(25);
		$this->Cell(40,4,utf8_decode('CUENTA'),0,1,'I',false);
		$this->SetY(98); $this->SetX(55);
		$this->Cell(40,4,utf8_decode('DESCRIPCIÓN'),0,1,'I',false);
		$this->SetY(98); $this->SetX(160);
		$this->MultiCell(15,3,'DEBE',0,'C');
		$this->SetY(98); $this->SetX(180);
		$this->MultiCell(15,3,'HABER',0,'C');
		
		
		/** Diario **/
		$db = new MySQL();
		$query = "select e.numero_identificacion, ".
						"e.razon_social, ". 
						"e.abreviatura, ".
					    "LPAD(a.id_asiento,6,'0'), ".
					    "date_format(a.fecha_asiento,'%d-%m-%Y %h:%i'), ".
						"case when a.estado_autorizacion = 0 then '-' else date_format(a.fecha_autorizacion,'%d-%m-%Y %h:%i') end, ".
						"case when a.estado_autorizacion = 0 then 'NO CONTABILIZADO' else 'CONTABILIZADO' end, ".
					    "a.descripcion, ".
					    "a.glosa, ".
					    "a.id_tipo_asiento, ".
					    "LPAD(a.numero_documento,8,'0'), ".
					    "a.monto_debe, ".
					    "a.monto_haber ".
				   "from tfn_asiento_contable a ".
				  "inner join tgn_empresas e ".
					"on e.estado = 'A' ".
				  "where a.id_asiento 		  = '".$_GET["id"]."' ";
		
		
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
			 	$this->SetTextColor(0, 106, 46);
				$this->SetFont('Calibri','',12);
				$this->SetY(16); $this->SetX(124);	
				$this->Cell(0,5,$resultados[0],1,1,'I',0);
				$this->SetY(28); $this->SetX(124);	
				$this->Cell(0,5,$resultados[3],1,1,'I',0);
				$this->SetY(40); $this->SetX(124);	
				$this->Cell(0,5,$resultados[4],1,1,'I',0);
				$this->SetY(52); $this->SetX(124);	
				$this->Cell(0,5,$resultados[5],1,1,'I',0);
				$this->SetY(60); $this->SetX(144);	
				$this->Cell(0,5,$resultados[6],1,1,'I',0);
				
				$this->SetY(45); $this->SetX(8);
				$this->SetFont('Calibri','',12);
				$this->MultiCell(110,3.5,utf8_decode($resultados[1]),0,'C');
				$this->SetY(53); $this->SetX(8);$this->SetFont('helvetica','b',18);
				$this->Cell(110,4,utf8_decode($resultados[2]),0,1,'C',false);
				
				$this->SetFont('Calibri','',10);
				$this->SetY(65.5); $this->SetX(30);
				$this->Cell(110,3,utf8_decode($resultados[7]),0,1,'L',false);
				$this->SetY(80); $this->SetX(8);
				$this->MultiCell(189,3,utf8_decode($resultados[8]),0,'J');
				
				$montoDebe 		= $resultados[11];
				$montoHaber 	= $resultados[12];

			}
		}	
		
		
		$query = "select LPAD(da.linea_asiento,3,'0'), ".
						"ct.codigo, ".
						"ct.descripcion, ".
						"da.monto_debe, ".
						"da.monto_haber ".
				   "from tfn_asiento_contable a ".
				  "inner join tfn_detalle_asiento_contable da ".
					 "on a.id_asiento = da.id_asiento ".
			        "and da.estado = 'A' ".
				  "inner join tfn_cuentas_contables ct ".
				     "on ct.id_cuenta = da.id_cuenta ".
				  "inner join tfn_cuentas_periodo pr ".
				     "on pr.id_cuenta_contable = ct.id_cuenta ".
				  "inner join tfn_parametros rt ".
				     "on pr.id_periodo = rt.id_periodo_vigente ".
				  "where a.id_asiento	 = '".$_GET["id"]."' ".
			      "order by 1";
		
		$consulta = $db->consulta($query);
		$numResul = $db->num_rows($consulta);
		$fila = 105;
		if($numResul>0){
			while($resultados = $db->fetch_array($consulta)){
				  	$this->SetY($fila); $this->SetX(8);$this->SetFont('Calibri','',7);
					$this->Cell(10,3,$resultados[0],0,1,'R',false);
					$this->SetY($fila); $this->SetX(25);
					$this->Cell(10,3,$resultados[1],0,1,'L',false);
					$this->SetY($fila); $this->SetX(55);
					$this->MultiCell(100,2.5,utf8_decode($resultados[2]),0,'J');
					$this->SetY($fila); $this->SetX(160);
					$this->MultiCell(13,5,number_format($resultados[3],2),0,'R');
					$this->SetY($fila); $this->SetX(180);
					$this->MultiCell(13,5,number_format($resultados[4],2),0,'R');

					$fila = $fila+6;
					$this->SetDrawColor(130,167,195);
					$this->line(6,$fila-.5,201,$fila-.5);
			}
		}
		
		$this->SetY($fila-1); $this->SetX(5);
		$this->SetFillColor(0, 106, 46);
		$this->Cell(197,6,'',0,1,'I',true);
		
		$this->SetTextColor(214, 214, 214);
		$this->SetFont('helvetica','b',8);
		$this->SetY($fila); $this->SetX(55);
		$this->MultiCell(100,5,utf8_decode('SUMAN ---->    '),0,'R');
		$this->SetY($fila); $this->SetX(160);
		$this->MultiCell(13,5,number_format($montoDebe,2),0,'R');
		$this->SetY($fila); $this->SetX(180);
		$this->MultiCell(13,5,number_format($montoHaber,2),0,'R');
	
	  }
	}

  $pdf=new PDF();
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetAutoPageBreak(false);
	
	
		
			
	$pdf->Output();
	?>
