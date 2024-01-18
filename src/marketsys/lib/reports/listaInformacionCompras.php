<?php
SESSION_START();

require_once '../xls/PHPExcel.php';
include_once '../conexion/class.conexion.php';
	date_default_timezone_set('America/Guayaquil');

/** Error reporting */
//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
	$objPHPExcel = new PHPExcel();
	// Set document properties
	$objPHPExcel->getProperties()->setCreator("MarketSys")
								 ->setLastModifiedBy("MarketSys")
								 ->setTitle("Office 2007 XLSX")
								 ->setSubject("Office 2007 XLSX Test Document")
								 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
								 ->setKeywords("office 2007 openxml php")
								 ->setCategory("ListadoCompras");

	$db = new MySQL();		
		//Detalle de la Información
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,1,('Nro. Factura'));
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,1,'Autorización Factura');
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,1,'Fecha');
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,1,'Identificación');
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,1,'Proveedor');
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,1,'Subtotal 0%');
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,1,'Subtotal IVA');
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,1,'IVA %');
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,1,'IVA Valor');
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,1,'Total');
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,1,'Nro. Retención');
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,1,'Autorización Retención');
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(50);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,1,'Monto');
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,1,'IVA 30%');
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,1,'IVA 70%');
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,1,'IVA 100%');
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16,1,'IR 303');
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17,1,'IR 304B');
		$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(10);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18,1,'IR 309');
		$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(10);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19,1,'IR 310');
		$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(10);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20,1,'IR 312');
		$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(10);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21,1,'IR 319');
		$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(10);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22,1,'IR 320');
		$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(10);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23,1,'IR 322');
		$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(10);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24,1,'IR 346');
		$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(10);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(25,1,'IR 3120');
		$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(10);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(26,1,'IR 3440');
		$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(10);
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:AA1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('A1:AA1')->getFill()->getStartColor()->setARGB('0B3861');
		$objPHPExcel->getActiveSheet()->getStyle('A1:AA1')->getFont()->getColor()->setRGB('F2F2F2');
		$objPHPExcel->getActiveSheet()->getStyle('A1:AA1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->setAutoFilter('A1:AA1');
		
		
		$var = $_GET['fechaDesde'];
			$date = str_replace('/', '-', $var);
				$fechaDesde = date('Y-m-d', strtotime($date));
	  
		$var = $_GET['fechaHasta'];
			$date = str_replace('/', '-', $var);
				$fechaHasta = date('Y-m-d', strtotime($date));
				
		$consultaR = $db->consulta("select c.fecha_compra fecha,
										   p.numero_identificacion,
										   p.nombre_proveedor,
										   concat(c.establecimiento,'-',c.punto_emision,'-',c.numero_factura) factura,
										   c.autorizacion_sri,
										   c.monto_subtotal0,
										   monto_subtotal_impuesto,
										   c.porcentaje_impuesto,
										   c.monto_impuesto,
										   c.monto_total,
										   r.codigo_retencion,
										   r.autorizacion,
										   c.monto_retencion,
										   sum(case when t.id_tipo_retencion = 2 then
												    case when tr.codigo_ats = '1' then valor_retencion else 0 end else 0 end) IVA_30,
										   sum(case when t.id_tipo_retencion = 2 then
													case when tr.codigo_ats = '2' then valor_retencion else 0 end else 0 end) IVA_70,
										   sum(case when t.id_tipo_retencion = 2 then
													case when tr.codigo_ats = '3' then valor_retencion else 0 end else 0 end) IVA_100,
										   sum(case when t.id_tipo_retencion = 1 then
													case when tr.codigo_ats IN('303') then valor_retencion else 0 end else 0 end) IR_303,
										   sum(case when t.id_tipo_retencion = 1 then
													case when tr.codigo_ats IN('304B') then valor_retencion else 0 end else 0 end) IR_304B,
										   sum(case when t.id_tipo_retencion = 1 then
													case when tr.codigo_ats IN('309') then valor_retencion else 0 end else 0 end) IR_309,
										   sum(case when t.id_tipo_retencion = 1 then
													case when tr.codigo_ats IN('310') then valor_retencion else 0 end else 0 end) IR_310,
										   sum(case when t.id_tipo_retencion = 1 then
													case when tr.codigo_ats IN('312') then valor_retencion else 0 end else 0 end) IR_312,
										   sum(case when t.id_tipo_retencion = 1 then
													case when tr.codigo_ats IN('319') then valor_retencion else 0 end else 0 end) IR_319,
										   sum(case when t.id_tipo_retencion = 1 then
													case when tr.codigo_ats IN('320') then valor_retencion else 0 end else 0 end) IR_320,
										   sum(case when t.id_tipo_retencion = 1 then
													case when tr.codigo_ats IN('322') then valor_retencion else 0 end else 0 end) IR_322,
										   sum(case when t.id_tipo_retencion = 1 then
													case when tr.codigo_ats IN('346') then valor_retencion else 0 end else 0 end) IR_346,
										  sum(case when t.id_tipo_retencion = 1 then
													case when tr.codigo_ats IN('3120') then valor_retencion else 0 end else 0 end) IR_3120,			
										   sum(case when t.id_tipo_retencion = 1 then
													case when tr.codigo_ats IN('3440') then valor_retencion else 0 end else 0 end) IR_3440		
									  from tsc_compras c
									  left join tsc_retenciones_compras r
										on r.id_compra = c.id_compra
									  left join tsc_proveedores p
										on c.id_proveedor = p.id_proveedor
									  left join tsc_detalle_retenciones_compras t
										on t.codigo_retencion = r.secuencia
								      left join tsc_tipos_retenciones_compras tr
 									    on tr.id_retencion = t.id_codigo_retencion
									   and tr.estado = 'A'	
									 where STR_TO_DATE(c.fecha_compra,'%d/%m/%Y') between '".$fechaDesde."' and '".$fechaHasta."'
									 group by c.id_compra, p.numero_identificacion, p.nombre_proveedor
									 order by c.fecha_compra");
		
		$i=2;
		if($db->num_rows($consultaR)>=0){
			while($resultados = $db->fetch_array($consultaR)){ 
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(0,$i,$resultados[3], PHPExcel_Cell_DataType::TYPE_STRING); //numero_factura
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(1,$i,$resultados[4], PHPExcel_Cell_DataType::TYPE_STRING); //fecha
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(2,$i,$resultados[0], PHPExcel_Cell_DataType::TYPE_STRING); //cedula
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(3,$i,$resultados[1], PHPExcel_Cell_DataType::TYPE_STRING); //nombre
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(4,$i,$resultados[2], PHPExcel_Cell_DataType::TYPE_STRING); //nombre
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,utf8_encode($resultados[5])); //desc
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,utf8_encode($resultados[6])); //0
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,utf8_encode($resultados[7])); //12
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$i,utf8_encode($resultados[8])); //%
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$i,utf8_encode($resultados[9])); //Iva
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(10,$i,$resultados[10], PHPExcel_Cell_DataType::TYPE_STRING); //nombre
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(11,$i,$resultados[11], PHPExcel_Cell_DataType::TYPE_STRING); //nombre
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$i,utf8_encode($resultados[12])); //total
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$i,utf8_encode($resultados[13])); //total
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14,$i,utf8_encode($resultados[14])); //total
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$i,utf8_encode($resultados[15])); //total
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16,$i,utf8_encode($resultados[16])); //total
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17,$i,utf8_encode($resultados[17])); //total
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18,$i,utf8_encode($resultados[18])); //total
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19,$i,utf8_encode($resultados[19])); //total
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20,$i,utf8_encode($resultados[20])); //total
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21,$i,utf8_encode($resultados[21])); //total
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22,$i,utf8_encode($resultados[22])); //total
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23,$i,utf8_encode($resultados[23])); //total
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24,$i,utf8_encode($resultados[24])); //total
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(25,$i,utf8_encode($resultados[25])); //total
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(26,$i,utf8_encode($resultados[26])); //total
				$i++;
			}
		}
		
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, '=SUM(F2:F'.($i-1).')');
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, '=SUM(G2:G'.($i-1).')');
	$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, '=SUM(I2:I'.($i-1).')');
	$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, '=SUM(J2:J'.($i-1).')');
	
	$objPHPExcel->getActiveSheet()->setCellValue('M'.$i, '=SUM(M2:M'.($i-1).')');
	$objPHPExcel->getActiveSheet()->setCellValue('N'.$i, '=SUM(N2:N'.($i-1).')');
	$objPHPExcel->getActiveSheet()->setCellValue('O'.$i, '=SUM(O2:O'.($i-1).')');
	$objPHPExcel->getActiveSheet()->setCellValue('P'.$i, '=SUM(P2:P'.($i-1).')');
	$objPHPExcel->getActiveSheet()->setCellValue('Q'.$i, '=SUM(Q2:Q'.($i-1).')');
	$objPHPExcel->getActiveSheet()->setCellValue('R'.$i, '=SUM(R2:R'.($i-1).')');
	$objPHPExcel->getActiveSheet()->setCellValue('S'.$i, '=SUM(S2:S'.($i-1).')');
	$objPHPExcel->getActiveSheet()->setCellValue('T'.$i, '=SUM(T2:T'.($i-1).')');
	$objPHPExcel->getActiveSheet()->setCellValue('U'.$i, '=SUM(U2:U'.($i-1).')');
	$objPHPExcel->getActiveSheet()->setCellValue('V'.$i, '=SUM(V2:V'.($i-1).')');
	$objPHPExcel->getActiveSheet()->setCellValue('W'.$i, '=SUM(W2:W'.($i-1).')');
	$objPHPExcel->getActiveSheet()->setCellValue('X'.$i, '=SUM(X2:X'.($i-1).')');
	$objPHPExcel->getActiveSheet()->setCellValue('Y'.$i, '=SUM(Y2:Y'.($i-1).')');
	$objPHPExcel->getActiveSheet()->setCellValue('Z'.$i, '=SUM(Z2:Z'.($i-1).')');
	$objPHPExcel->getActiveSheet()->setCellValue('AA'.$i, '=SUM(AA2:AA'.($i-1).')');
	
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, '=COUNT(E2:E'.($i-1).')');	
	
	$objPHPExcel->getActiveSheet()->getStyle('F2:J'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
	$objPHPExcel->getActiveSheet()->getStyle('M2:AA'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,'Registros:');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,'Total:');	
	$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':AA'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':AA'.$i)->getFill()->getStartColor()->setARGB('0B3861');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':AA'.$i)->getFont()->getColor()->setRGB('F2F2F2');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':AA'.$i)->getFont()->setBold(true);

	
	$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(1,1);
	//Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('ListaCompras');
	//Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);
	//Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="ListaFacturas.xlsx"');
	header('Cache-Control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

	ob_start();
	$objWriter->save('php://output');
	$xlsData = ob_get_contents();
	ob_end_clean();

	$response =  array(
		'op' => 'ok',
		'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
	);

	echo json_encode($response); 
			
?>