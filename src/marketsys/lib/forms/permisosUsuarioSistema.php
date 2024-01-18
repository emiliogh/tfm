<html>
<head>
	<title>Módulo Control</title>
	<script type="text/javascript" src="../../lib/jquery/jquery.js"></script>
	<script type="text/javascript" src="../../lib/js/componentes.js"></script>
	<link rel="stylesheet" type="text/css" href="../../lib/css/dashBoardStyle.css"/>
	<link rel="stylesheet" type="text/css" href="../../lib/css/switchOnOff.css"/>
	<link rel="stylesheet" type="text/css" href="../../lib/css/jquery.datetimepicker.css"/>
	<link rel="stylesheet" type="text/css" href="../css/really-simple-jquery-dialog.css">
	<script src="../../lib/js/jquery.tabSlideOut.js"></script>
	<script src="../../lib/js/jquery.datetimepicker.full.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style>
		.button { background-color: #4CAF50; /* Green */
				  border: none;
				  color: white;
				  padding: 15px 32px;
				  text-align: center;
				  text-decoration: none;
				  display: inline-block;
			      font-size: 14px;}
		      	.button2 {background-color: #008CBA;} /* Blue */
 				.button3 {background-color: #f44336;} /* Red */ 
		        .button4 {background-color: #D4AC0D;} /* Red */ 
		
				.circulo {
					  background-image: url(../images/avatar/0001.png);
					  height: 50px;
					  width: 50px;
					  background-repeat: no-repeat;
					}
					.triangulo{
					  background-image: url(../images/avatar/0002.png);
					  height: 50px;
					  width: 50px;
					  background-repeat: no-repeat;
					}
					.cuadrado{
					  background-image: url(../images/avatar/0003.png);
					  height: 50px;
					  width: 50px;
					  background-repeat: no-repeat;
					}
		</style>
</head>
<body style="overflow: hidden;" onLoad="parent.document.getElementById('divLoadding').style.display = 'none';">
	<table class="tablePrincipal" style="overflow: hidden; background:#4CB3DC; width: 100%; height: 495px; font-size: 14px; font-family: Arial, Helvetica, sans-serif;">
		<tr style="background:#DADEDF; color: #0F75A1; font-size: 15px; font-weight: bold;">
			<td style="width: 300px; height:20px;">
				Selección
			</td>
			<td style="width: 750px; height:20px;">
				Detalles del Usuario del Sistema
			</td>
		</tr>
		<tr style="background:#fff; width: 300px; height:15px; text-align: center;">
			<td>
				<table>
					<tr>
						<td style="text-align: left; font-size: 12px;">
							Selección Personal: 
						</td>
					</tr>
					<tr>
						<td style="font-size: 10px; vertical-align: bottom;">
							<select id="usuarioSistema" style="width: 350px;" onChange="usuarioSeleccion();"></select>
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
			<td style="background:#fff; width: 200px; height:15px; text-align: center; vertical-align: top;">
				<table>
					<tr>
						<td colspan="2">
							<div id="rsmTabla" style="width: 350px; height: 440px;">
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<div id="testAlert"></div>
	<script type="text/javascript" src="../js/really-simple-jquery-dialog.js"></script>
	<script>
	  var cmbUs=new componente.cmb
		cmbUs.ini('usuarioSistema')			
		cmbUs.loadFromUrl('../../lib/cmb/cmbPersonal.php');
	  
	  function enviarAjax(tipo,url_, data_, funcion_){
		$.ajax({
			type:tipo,
			dataType: 'json',
			url: url_,
			data: data_,
			success:funcion_
		})
	  }	
	  
	  function usuarioSeleccion(){
		parent.document.getElementById('divLoadding').style.display = 'block';  
		var idUsuario = document.getElementById("usuarioSistema").value;
			
		    $('#rsmTabla').html('');
			$('#rsmMenuTabla').html('');
		  
		    if (idUsuario != 0){
				enviarAjax("POST","../../lib/php/retornaInformacionUsuarioP.php", {id: idUsuario},mostrarInformacionUsuario);}
		    	else{parent.document.getElementById('divLoadding').style.display = 'none';  }
	  }	
	  
	  function mostrarInformacionUsuario(e){
		var resp=eval(e)
			$('#rsmTabla').html(resp[0]);
		    $('#rsmMenuTabla').html(resp[1]);
			parent.document.getElementById('divLoadding').style.display = 'none';
	  }
	  
	 	  
	  function nuevosPermisos(){
		  idUsua = document.getElementById('idUsuarioPrl').value;
		  idPerf = document.getElementById('idPerfilUsuario').value;
		  idHast = document.getElementById('fechaHasta').value;
		  
		  if (idUsua == -1){
			  $('#testAlert').simpleAlert({
				  message:"No se puede realizar la asignación de permisos, el personal seleccionado no cuenta con un usuario registrado en el Sistema."
			  });
			  return;
		     }
		  
		  if (idPerf == 0){
			  $('#testAlert').simpleAlert({
				  message:"Si desea asignar nuevos permisos, debe seleccionar el perfil que utilizará el sistema."
			  });
		     }else{url = '../php/guardaPermisosNuevos.php';
				   $.ajax({
					   type:'POST',
					   data: 'idusua='+idUsua+'&idperf='+idPerf+'&idhast='+idHast,
					   url:url,
					   success:function(data){
						   datos = eval(data);
						   $('#testAlert').simpleAlert({
							   message: datos[1]
						   });
						   if (datos[0] == 0){
							   document.getElementById("usuarioSistema").value = 0;
								$('#rsmTabla').html('');
								$('#rsmMenuTabla').html('');
						       }
						   }
				   });
				}		
	  
	  }
		
	  function desactivarPermisos(){
		  idUsua = document.getElementById('idUsuarioPrl').value;
		  
		  if (idUsua == -1){
			  $('#testAlert').simpleAlert({
				  message:"No se puede realizar la asignación de permisos, el personal seleccionado no cuenta con un usuario registrado en el Sistema."
			  });
			  return;
		     }
		  
		  url = '../php/desactivarPermisoSistema.php';
		  $.ajax({
			  type:'POST',
			  data: 'idusua='+idUsua,
			  url:url,
			  success:function(data){
				  datos = eval(data);
				  $('#testAlert').simpleAlert({
					  message: datos[1]
				  });
				  if (datos[0] == 0){
					  document.getElementById("usuarioSistema").value = 0;
					  $('#rsmTabla').html('');
					  $('#rsmMenuTabla').html('');
				  }
			  }
		  });
	
	  }
		
	  function desactivarUPermisos(){
		  
		  idUsua = document.getElementById('idUsuarioPrl').value;
		  
		  if (idUsua == -1){
			  $('#testAlert').simpleAlert({
				  message:"No se puede realizar la asignación de permisos, el personal seleccionado no cuenta con un usuario registrado en el Sistema."
			  });
			  return;
		     }
		  
		  url = '../php/desactivarUsuarioPermisoSistema.php';
		  $.ajax({
			  type:'POST',
			  data: 'idusua='+idUsua,
			  url:url,
			  success:function(data){
				  datos = eval(data);
				  $('#testAlert').simpleAlert({
					  message: datos[1]
				  });
				  if (datos[0] == 0){
					  document.getElementById("usuarioSistema").value = 0;
					  $('#rsmTabla').html('');
					  $('#rsmMenuTabla').html('');
				  }
			  }
		  });
		  
	  }
	  
	  
		
	</script>	
</body>	
</html>