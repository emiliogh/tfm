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
								 ->setCategory("ListadoFacturas");

	$db = new MySQL();		
		//Detalle de la Información
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,1,('Número'));
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,1,'Fecha');
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,1,'Identificación');
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,1,'Nombre');
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(70);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,1,'Subtotal');
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,1,'Descuento');
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,1,'Subtotal 0%');
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,1,'Subtotal IVA');
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,1,'IVA %');
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,1,'IVA Valor');
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,1,'Total');
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFill()->getStartColor()->setARGB('0B3861');
		$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFont()->getColor()->setRGB('F2F2F2');
		$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->setAutoFilter('A1:K1');
		
		
		$var = $_GET['fechaDesde'];
			$date = str_replace('/', '-', $var);
				$fechaDesde = date('Y-m-d', strtotime($date));
	  
		$var = $_GET['fechaHasta'];
			$date = str_replace('/', '-', $var);
				$fechaHasta = date('Y-m-d', strtotime($date));
		$consultaR = $db->consulta("select numero_factura,
										   date_format(f.fecha_registro,'%d/%m/%Y'), 
										   c.numero_identificacion,
										   c.nombre_cliente,
										   monto_subtotal,
										   ifnull(monto_descuento,0),
										   monto_subtotal0,
										   monto_subtotal_impuesto,
										   porcentaje_impuesto,
										   monto_impuesto,
										   monto_total,
										   monto_retenciones
									  from tsc_facturas f
									 inner join tsc_detalles_factura d
										on f.id_factura = d.id_factura
									 inner join tcu_clientes c
										on c.id_cliente = f.id_cliente
									 where f.fecha_factura between '".$fechaDesde."' and '".$fechaHasta."'
									   -- and f.estado_electronico = 'A'
									 group by f.fecha_factura, c.numero_identificacion,c.nombre_cliente,numero_factura, monto_subtotal, monto_descuento, monto_subtotal0, monto_subtotal_impuesto,porcentaje_impuesto,monto_impuesto,monto_total,monto_retenciones
									 order by 1");
		
		$i=2;
		if($db->num_rows($consultaR)>=0){
			while($resultados = $db->fetch_array($consultaR)){ 
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(0,$i,$resultados[0], PHPExcel_Cell_DataType::TYPE_STRING); //numero_factura
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(1,$i,$resultados[1], PHPExcel_Cell_DataType::TYPE_STRING); //fecha
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(2,$i,$resultados[2], PHPExcel_Cell_DataType::TYPE_STRING); //cedula
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow(3,$i,$resultados[3], PHPExcel_Cell_DataType::TYPE_STRING); //nombre
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4,$i,utf8_encode($resultados[4])); //subtotal
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$i,utf8_encode($resultados[5])); //desc
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$i,utf8_encode($resultados[6])); //0
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$i,utf8_encode($resultados[7])); //12
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$i,utf8_encode($resultados[8])); //%
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$i,utf8_encode($resultados[9])); //Iva
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$i,utf8_encode($resultados[10])); //total
				//$objPHPExcel->getActiveSheet()->getStyle('E'.$i.':K'.$i)->getNumberFormat()->setFormatCode('0.00');
				$i++;
			}
		}
		
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, '=SUM(E2:E'.($i-1).')');
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, '=SUM(F2:F'.($i-1).')');
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, '=SUM(G2:G'.($i-1).')');
	$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, '=SUM(H2:H'.($i-1).')');
	$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, '=SUM(J2:J'.($i-1).')');
	$objPHPExcel->getActiveSheet()->setCellValue('K'.$i, '=SUM(K2:K'.($i-1).')');
	
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, '=COUNT(E2:E'.($i-1).')');	
	$objPHPExcel->getActiveSheet()->getStyle('E2:K'.$i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$i,'Registros:');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3,$i,'Total:');	
	$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':K'.$i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':K'.$i)->getFill()->getStartColor()->setARGB('0B3861');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':K'.$i)->getFont()->getColor()->setRGB('F2F2F2');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$i.':K'.$i)->getFont()->setBold(true);

	
	$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(1,2);
	//Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('ListaFacturas');
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