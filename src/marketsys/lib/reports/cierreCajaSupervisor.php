<?php
SESSION_START();
require('../../lib/fpdf/fpdf.php');
include_once("../../lib/conexion/class.conexion.php");
ob_end_clean(); header('Content-Type: text/html; charset=utf-8');
class PDF extends FPDF
{
	//Cabecera de p?gina
	function Header()
	{	
		$db = new MySQL();
 		$consulta = $db->consulta("select ap.id_apertura id_apertura,
										  concat('[',es.codigo_establecimiento,'] ',es.definicion) establecimiento,	
										  concat('[',e.codigo_punto,'] ',e.definicion) punto_emision,
										  concat('[',pr.numero_identificacion,'] ',ifnull(pr.nombre,'')) cajero,
										  ap.total_apertura, case when ap.estado = 'A' then 'ABIERTO' when ap.estado = 'C' then 'CERRADO' end,
										  ap.fecha_apertura
								     from tsc_pagos p
								    INNER JOIN tsc_establecimientos es
									   ON es.id_establecimiento = p.id_establecimiento
								    INNER JOIN tsc_puntos_emision e
									   ON e.id_punto_emision = p.id_punto_emision
								    INNER JOIN tsc_aperturas_caja ap
									   ON ap.id_establecimiento = p.id_establecimiento
									  AND ap.id_punto_emision = p.id_punto_emision
									  AND ap.id_personal = p.id_personal
									INNER JOIN tgn_personal pr
									   ON pr.id_personal = p.id_personal
									  AND pr.id_personal = ap.id_personal
								    where ap.id_apertura = ".$_GET["id"]."
									  and ap.id_personal = ".$_GET["cajero"]."
								    group by ap.id_apertura,
										     concat('[',es.codigo_establecimiento,'] ',es.definicion),	
									   		 concat('[',e.codigo_punto,'] ',e.definicion),
									   		 concat('[',pr.numero_identificacion,'] ',ifnull(pr.nombre,'')),
									   		 ap.total_apertura, ap.estado, ap.fecha_apertura
								   order by p.fecha_pago limit 1 offset 0");
		
		$this->Image('../images/electronico/logoReporte.jpg',14,16,36);
		$this->Cell(1);
		$this->SetDrawColor(130,167,195);
		$this->SetFillColor(130,167,195);
		$this->SetTextColor(255,255,255);
		$this->SetFont('helvetica','B',10);
		$this->Cell(0,5,'Reporte de Cierre de Caja',1,1,'C',true);
		// $this->Image('../../../../../images/SisComLogoPDF.png',165,25,33);

		$this->SetDrawColor(255,255,255);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(11,33,97);
		$this->SetFont('Arial','B',8);
		$this->SetY(18);$this->SetX(55);
		$this->Cell(25,4,utf8_decode('Establecimiento'),0,0,'I',0);
		$this->SetY(18);$this->SetX(150);
		$this->Cell(30,4,utf8_decode('N° Apertura'),0,0,'I',0);
		$this->SetY(23);$this->SetX(55);
		$this->Cell(25,4,utf8_decode('Punto Emisión'),0,0,'I',0);
		$this->SetY(23);$this->SetX(150);
		$this->Cell(30,4,utf8_decode('Estado'),0,0,'I',0);
		$this->SetY(28);$this->SetX(55);
		$this->Cell(25,4,utf8_decode('Fecha Apertura'),0,0,'I',0);
		$this->SetY(28);$this->SetX(150);
		$this->Cell(30,4,utf8_decode('Monto Apertura'),0,0,'I',0);
		$this->SetY(33);$this->SetX(55);
		$this->Cell(25,4,'Cajero',1,1,'I',true);
		
		
    	$numResul = $db->num_rows($consulta);
		if($numResul>0){
			while($row = $db->fetch_array($consulta)){ 
					
						$this->SetFont('Arial','',8);
						$this->SetY(18);$this->SetX(78);
						$this->Cell(25,4,$row[1],1,1,'I',true);
						$this->SetY(18);$this->SetX(172);
						$this->Cell(25,4,$row[0],1,1,'I',true);
						$this->SetY(23);$this->SetX(78);
						$this->Cell(25,4,$row[2],1,1,'I',true);
						$this->SetY(23);$this->SetX(173);
						$this->Cell(25,4,$row[5],1,1,'I',true);
						$this->SetY(28);$this->SetX(78);
						$this->Cell(25,4,$row[6],1,1,'I',true);
						$this->SetY(28);$this->SetX(173);
						$this->Cell(25,4,$row[4],1,1,'I',true);
						$this->SetY(33);$this->SetX(78);
						$this->Cell(95,4,$row[3],1,1,'I',true);
							$this->SetY(38);$this->SetX(12);
							$this->SetDrawColor(130,167,195);
							$this->SetFillColor(130,167,195);
							$this->SetTextColor(255,255,255);
							$this->SetFont('helvetica','B',8);
							$this->Cell(0,5,'Detalle de las facturas emitidas correctamente',1,1,'I',true);
				
			}
		}	
	 }

	//Pie de página
	function Footer()
	{
		//Posici?n: a 1,5 cm del final
		$this->SetY(-15);
		//Arial italic 8
		$this->SetFont('Arial','B',8);
		//N?mero de p?gina
		$this->Cell(0,10,'Pagina '.$this->PageNo().' de {nb}',0,0,'R');
	}
	}

	//Creaci?n del objeto de la clase heredada
	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',7);
		$db = new MySQL();
 		$consulta = $db->consulta("select f.numero_factura,	
										  DATE_FORMAT(f.fecha_registro,'%d-%m-%Y') fecha_pago,
										  DATE_FORMAT(f.fecha_registro,'%H-%i') hora_pago,
										  cl.numero_identificacion,
										  cl.nombre_cliente,
										  fp.descripcion,
										  f.monto_total monto_pago,
										  ap.total_apertura,
										  ap.estado
									 from tsc_facturas f
									INNER JOIN tcu_clientes cl
									   ON cl.id_cliente = f.id_cliente
									INNER JOIN tsc_pagos p
									   ON p.id_factura = f.id_factura 
									INNER JOIN tsc_formas_pago fp
									   ON fp.id_forma_pago = p.id_forma_pago	
									INNER JOIN tsc_aperturas_caja ap
									   ON ap.id_establecimiento = f.id_establecimiento
									  AND ap.id_punto_emision = f.id_puntos_venta
									  AND ap.id_personal = f.id_cajero
									  -- AND ap.estado = 'A' 
									  AND DATE_FORMAT(f.fecha_registro,'%d%m%Y') between DATE_FORMAT(ap.fecha_apertura,'%d%m%Y')
									      and DATE_FORMAT(ap.fecha_cierre,'%d%m%Y')
									INNER JOIN tgn_personal pr
									   ON pr.id_personal = f.id_cajero
									  AND pr.id_personal = ap.id_personal 
									where ap.id_apertura = ".$_GET["id"]."
									  and ap.id_personal = ".$_GET["cajero"]."
									  -- and f.estado_electronico = 'A'
									  -- and ap.fecha_apertura <= f.fecha_registro
									order by f.fecha_registro");

						$pdf->SetDrawColor(255,255,255);
						$pdf->SetFillColor(47,92,155);
						$pdf->SetTextColor(255,255,255);
						$pdf->SetY(43);$pdf->SetX(11.7);
						$pdf->Cell(25.5,4,utf8_decode('Número'),1,0,'C',true);
						$pdf->SetY(43);$pdf->SetX(37);
						$pdf->Cell(15,4,'Fecha',1,0,'C',true);
						$pdf->SetY(43);$pdf->SetX(52);
						$pdf->Cell(8,4,'Hora',1,0,'C',true);
						$pdf->SetY(43);$pdf->SetX(60);
						$pdf->Cell(20,4,utf8_decode('Identificación'),1,0,'C',true);
						$pdf->SetY(43);$pdf->SetX(80);
						$pdf->Cell(70,4,'Nombres Cliente',1,0,'I',true);
						$pdf->SetY(43);$pdf->SetX(150);
						$pdf->Cell(35,4,'Forma Pago',1,0,'I',true);
						$pdf->SetY(43);$pdf->SetX(185);
						$pdf->Cell(15.2,4,'Valor',1,0,'C',true);

						//$stmtd->execute();
						$fila = 47;
						$ctrlpage = 0;
						$idf = 0;
						$acp = 0;
						while($row2 = $db->fetch_array($consulta)){					
							if ($idf%2==0)
								{	$pdf->SetFillColor(255,255,255);
									$pdf->SetDrawColor(47,92,155);
									$pdf->SetTextColor(0,0,0);
									$pdf->SetY($fila);$pdf->SetX(12);
									$pdf->Cell(25,4,$row2["0"],1,1,'R',true);
									$pdf->SetY($fila);$pdf->SetX(37);
									$pdf->Cell(15,4,$row2["1"],1,1,'C',true);
									$pdf->SetY($fila);$pdf->SetX(52);
									$pdf->Cell(8,4,$row2["2"],1,1,'C',true);
									$pdf->SetY($fila);$pdf->SetX(60);
									$pdf->Cell(20,4,$row2["3"],1,1,'R',true);
									$pdf->SetY($fila);$pdf->SetX(80);
									$pdf->Cell(70,4,$row2["4"],1,1,'I',true);
									$pdf->SetY($fila);$pdf->SetX(150);
									$pdf->Cell(35,4,$row2["5"],0,1,'I',0);
									$pdf->SetY($fila);$pdf->SetX(185);
									$pdf->Cell(15,4,$row2["6"],1,1,'R',1);
								}else{
									$pdf->SetFillColor(219,233,254);
									$pdf->SetDrawColor(47,92,155);
									$pdf->SetTextColor(0,0,0);
									$pdf->SetY($fila);$pdf->SetX(12);
									$pdf->Cell(25,4,$row2["0"],1,1,'R',true);
									$pdf->SetY($fila);$pdf->SetX(37);
									$pdf->Cell(15,4,$row2["1"],1,1,'C',true);
									$pdf->SetY($fila);$pdf->SetX(52);
									$pdf->Cell(8,4,$row2["2"],1,1,'C',true);
									$pdf->SetY($fila);$pdf->SetX(60);
									$pdf->Cell(20,4,$row2["3"],1,1,'C',true);
									$pdf->SetY($fila);$pdf->SetX(80);
									$pdf->Cell(70,4,$row2["4"],1,1,'I',true);
									$pdf->SetY($fila);$pdf->SetX(150);
									$pdf->Cell(35,4,$row2["5"],1,1,'I',true);
									$pdf->SetY($fila);$pdf->SetX(185);
									$pdf->Cell(15,4,$row2["6"],1,1,'R',true);
								}	
							$acp = $acp + $row2["6"];
							$idf = $idf +1;
							$fila = $fila +4;
							$ctrlpage = $ctrlpage +1;
							if ($ctrlpage==57)
								{
									$pdf->AddPage();
									$pdf->SetDrawColor(255,255,255);
									$pdf->SetFillColor(47,92,155);
									$pdf->SetTextColor(255,255,255);
									$pdf->SetY(43);$pdf->SetX(12);
									$pdf->Cell(15,4,utf8_decode('Número'),1,0,'C',true);
									$pdf->SetY(43);$pdf->SetX(27);
									$pdf->Cell(9,4,'Hora',1,0,'C',true);
									$pdf->SetY(43);$pdf->SetX(36);
									$pdf->Cell(17,4,'Cta. Servicio',1,0,'C',true);
									$pdf->SetY(43);$pdf->SetX(53);
									$pdf->Cell(22,4,utf8_decode('Identificación'),1,0,'C',true);
									$pdf->SetY(43);$pdf->SetX(75);
									$pdf->Cell(77,4,'Nombres Cliente',1,0,'I',true);
									$pdf->SetY(43);$pdf->SetX(152);
									$pdf->Cell(35,4,'Forma Pago',1,0,'C',true);
									$pdf->SetY(43);$pdf->SetX(185);
									$pdf->Cell(15,4,'Valor',1,0,'C',true);
									$fila = 47;
									$ctrlpage = 0;
								}
							
						}
						$pdf->SetDrawColor(47,92,155);
						$pdf->SetFillColor(47,92,155);
						$pdf->SetTextColor(255,255,255);
						$pdf->SetFont('Arial','',10);
						$pdf->SetY($fila);$pdf->SetX(50);
						$pdf->Cell(150,4,'Monto Recaudado: '.number_format($acp,2),1,1,'R',true);
						$pdf->SetY($fila);$pdf->SetX(12);
						$pdf->Cell(90,4,'Numero de Registros: '.$idf,1,1,'R',true);
						$filag = $fila+6;

			$consulta = $db->consulta("select fp.id_forma_pago, fp.descripcion, sum(f.monto_total)
										 from tsc_facturas f
										INNER JOIN tsc_pagos p
										   ON p.id_factura = f.id_factura 
										INNER JOIN tsc_formas_pago fp
										   ON fp.id_forma_pago = p.id_forma_pago	
										INNER JOIN tsc_aperturas_caja ap
										   ON ap.id_establecimiento = f.id_establecimiento
										  AND ap.id_punto_emision = f.id_puntos_venta
										  AND ap.id_personal = f.id_cajero
										  -- AND ap.estado = 'A' 
										  AND DATE_FORMAT(f.fecha_registro,'%d%m%Y') between DATE_FORMAT(ap.fecha_apertura,'%d%m%Y')
									          and DATE_FORMAT(ap.fecha_cierre,'%d%m%Y')
										INNER JOIN tgn_personal pr
										   ON pr.id_personal = f.id_cajero
										  AND pr.id_personal = ap.id_personal 
									    where ap.id_apertura = ".$_GET["id"]."
										  and ap.id_personal = ".$_GET["cajero"]."
										 -- and f.estado_electronico = 'A'
										 -- and ap.fecha_apertura <= f.fecha_registro
										group by fp.id_forma_pago, fp.descripcion
										order by 1");
		
		$filag = $fila+25;
		$pdf->SetY($filag);$pdf->SetX(12);
		$pdf->Cell(35,4,'Forma de Pago.',1,1,'C',true);
		$pdf->SetY($filag);$pdf->SetX(47);
		$pdf->Cell(15,4,'Monto',1,1,'C',true);
		$filag = $filag+4;

		$numResul = $db->num_rows($consulta);
		if($numResul>0){
			while($row = $db->fetch_array($consulta)){ 
					$pdf->SetFillColor(255,255,255);
					$pdf->SetDrawColor(47,92,155);
					$pdf->SetTextColor(0,0,0);

					$pdf->SetY($filag);$pdf->SetX(12);
					$pdf->Cell(35,4,$row["1"],1,1,'I',true);
					$pdf->SetY($filag);$pdf->SetX(47);
					$pdf->Cell(15,4,$row["2"],1,1,'R',true);

					$filag = $filag+4;
				}
		}
		/*$stmtd = $var_conexion->prepare("select  fp.definicion forma_pago,
												 to_char(sum(p.monto_pago),'99999.00') monto 
											from tsc_pago p
										   INNER JOIN tsc_detalle_pago dp
											  ON dp.id_pago = p.id_pago
										   INNER JOIN tsc_formas_pago fp
											  ON fp.id_forma_pago = dp.id_forma_pago	
										   INNER JOIN tsc_aperturas_caja ap
											  ON ap.id_personal = p.id_personal
											 AND ap.estado = 'ACT'
											 AND p.fecha_pago = ap.fecha
										   where p.id_personal = ".$_GET["id_personal"]." 										   
										     and ap.registro <= p.hora
											 and p.estado = 'ACT'
										   group by fp.definicion
										   order by fp.definicion;");
			$stmtd->execute();
			
			while($row2 = $stmtd->fetch()){					
				$pdf->SetFillColor(255,255,255);
				$pdf->SetDrawColor(47,92,155);
				$pdf->SetTextColor(0,0,0);
				
				$pdf->SetY($filag);$pdf->SetX(12);
				$pdf->Cell(35,4,$row2["forma_pago"],1,1,'I',true);
				$pdf->SetY($filag);$pdf->SetX(47);
				$pdf->Cell(15,4,$row2["monto"],1,1,'R',true);
				
				$filag = $filag+4;
			}
			
			/*	
			$pdf->Image('../../../../reports/charts/fpFormasPagoPie.png',80,$fila+5,80);*/
			$fila = $fila +62;
	
	$pdf->Output();
	?>
