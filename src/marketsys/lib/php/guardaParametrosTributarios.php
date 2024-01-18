<?php
   SESSION_START();
	include_once("../../lib/conexion/class.conexion.php");

	$db = new MySQL();
	$query = "update tgn_empresas_info_tributaria ".
				"set estado = 'I', fecha_inactivacion = now() ".
			  "where estado = 'A'; ";

		$consulta = $db->consulta($query);
	
	$query = "insert into tgn_empresas_info_tributaria ".
			 	   "(id_empresa,id_ambiente,id_tipo_emision,id_contribuyente_especial,obligado_contabilidad,id_moneda,codigo_facturacion,".
					"url_firma_electronica,nombre_firma_electronica,fecha_firma_electronica,contrasena_firma,url_documentos_generados,".
					"url_documentos_firmados,url_documentos_enviados,url_documentos_rechazados,url_documentos_autorizados,".
					"url_documentos_no_autorizados,web_url_autorizacion,web_url_aprobacion,fecha_registro,estado,id_usuario,validez_firma) ".
		      "values('".$_POST['idEmpresa']."','".$_POST['ambiente']."','".$_POST['tipoEmision']."','".$_POST['contribuyente']."','".
			  			 $_POST['contabilidad']."','".$_POST['moneda']."','".$_POST['codigoNumerico']."','".$_POST['archivoFirma']."','".
						 $_POST['nombreFirma']."','".$_POST['fechaVigencia']."','".$_POST['claveFirma']."','".$_POST['xmlGenerados']."','".
						 $_POST['xmlFirmados']."','".$_POST['xmlEnviados']."','".$_POST['xmlRechazados']."','".$_POST['xmlAutorizados']."','".
		  				 $_POST['xmlNoAutorizados']."','".$_POST['urlRecepcion']."','".$_POST['urlAutorizacion']."',now(),'A','".
						 $_SESSION["idUsuario"]."','".$_POST['validezFirma']."');";

		$consulta = $db->consulta($query);


	   
?>
