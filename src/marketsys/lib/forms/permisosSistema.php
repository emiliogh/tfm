<html>
<head>
	<title>Módulo Control</title>
	<script type="text/javascript" src="../../lib/jquery/jquery.js"></script>
	<script type="text/javascript" src="../../lib/js/componentes.js"></script>
	<link rel="stylesheet" type="text/css" href="../../lib/css/dashBoardStyle.css"/>
	<link rel="stylesheet" type="text/css" href="../../lib/css/switchOnOff.css"/>
	<script src="../../lib/js/jquery.tabSlideOut.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body style="overflow: hidden;" onLoad="parent.document.getElementById('divLoadding').style.display = 'none';">
	<table class="tablePrincipal" style="overflow: hidden; background:#4CB3DC; width: 100%; height: 495px; font-size: 14px; font-family: Arial, Helvetica, sans-serif;">
		<tr style="background:#DADEDF; color: #0F75A1; font-size: 15px; font-weight: bold;">
			<td style="width: 300px; height:20px;">
				Selección
			</td>
			<td style="width: 750px; height:20px;">
				Permisos Menú
			</td>
		</tr>
		<tr style="background:#fff; width: 300px; height:15px; text-align: center;">
			<td>
				<table>
					<tr>
						<td style="text-align: left; font-size: 12px;">
							Selección Perfil: 
						</td>
					</tr>
					<tr>
						<td style="font-size: 10px; vertical-align: bottom;">
							<select id="procesosSiscom" style="width: 350px;" onChange="cambiarPerfil();"></select>
						</td>
					</tr>
				</table>	
			</td>
			<td rowspan="3" style="vertical-align: top; width: 100%;">
				<table class="tablePrincipal" style="width: 100%; vertical-align: top; padding-left: 0px; padding-top: 0px;">
					<tr>
						<td style="width: 100%; height: 110px; text-align: left; vertical-align: top; padding: 0; margin: 0;">
							<table style="width: 100%;">
								<tr>
									<td colspan="5" style="text-align: left; font-size: 12px;">
										Opciones del Sistema
									</td>
								</tr>
								<tr>
									<td colspan="5">
										<select id="gruposMenu" style="width: 100%;" onChange="cambiarMenuPerfil();"></select>
									</td>
								</tr>
								<tr>
									<td colspan="5">
										<div id="rsmMenuTabla" style="width: 100%; height: 425px; overflow-x:hidden;">
										</div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>	
		</tr>
		<tr>
			<td style="background:#fff; width: 200px; height:15px; text-align: center; vertical-align: top; overflow-y: scroll;">
				<table>
					<tr>
						<td colspan="2">
							<div id="rsmTabla" style="width: 350px; height: 440px; ">
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<script>
	  var cmbUs=new componente.cmb
		cmbUs.ini('procesosSiscom')			
		cmbUs.loadFromUrl('../../lib/cmb/cmbPerfiles.php');
	  
	  var cmbUs=new componente.cmb
		cmbUs.ini('gruposMenu')			
		cmbUs.loadFromUrl('../../lib/cmb/cmbOpcionesMenu.php');
	  
	  function enviarAjax(tipo,url_, data_, funcion_){
		$.ajax({
			type:tipo,
			dataType: 'json',
			url: url_,
			data: data_,
			success:funcion_
		})
	  }	
	  
	  function cambiarPerfil(){
		parent.document.getElementById('divLoadding').style.display = 'block';  
		var idProceso = document.getElementById("procesosSiscom").value;
			document.getElementById("gruposMenu").value = 0; 
			$('#rsmMenuTabla').html('');
			
			enviarAjax("POST","../../lib/php/retornaInformacionPerfiles.php", {id: idProceso},mostrarInformacionProceso);
	  }	
	  
	  
	    
	  function cambiarMenuPerfil(){
		parent.document.getElementById('divLoadding').style.display = 'block';
		var idPerfil = document.getElementById("procesosSiscom").value;
		var idMenu = document.getElementById("gruposMenu").value;
			
			enviarAjax("POST","../../lib/php/retornaInformacionMenuPerfiles.php", {idp: idPerfil, idm: idMenu},mostrarInformacionMenu);  
	  }
	  
	  function mostrarInformacionProceso(e){
		var resp=eval(e)
			$('#rsmTabla').html(resp[0]);
			parent.document.getElementById('divLoadding').style.display = 'none'; 
	  }
	  
	  function mostrarInformacionMenu(e){
		  var resp=eval(e)
		  $('#rsmMenuTabla').html(resp[0]);
		  parent.document.getElementById('divLoadding').style.display = 'none';
	  }
	  
	  function guardaMenuPerfil(perfil,menu,estado,codigo){
		  var estad = document.getElementById(estado).checked;
			  if (estad == true){estd = 'A'}else{estd = 'I'}
		  enviarAjax("POST","../../lib/php/actualizaMenuPerfiles.php", {idp: perfil, idm: menu, estd: estd, codigo: codigo});
	  }
	  
	</script>	
</body>	
</html>
