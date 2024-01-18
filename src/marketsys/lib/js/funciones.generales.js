function verificaConexionUsuario(){ 
  var stack_bar_bottom = {"dir1": "up", "dir2": "right", "spacing1": 0, "spacing2": 0};  
	if (document.getElementById('usuario').value == '' &&  document.getElementById('pass').value == ''){
		return 0;
	}
	url = 'lib/php/loginUsuario.php';
	usuario = window.btoa(document.getElementById('usuario').value);
	clave = window.btoa(document.getElementById('pass').value);
	
	$.ajax({
		type:'POST',
		url:url,
		data: 'usuario='+usuario+'&clave='+clave,
		success:function(data){
			 var array = eval(data);
			 if (array >=0)
			    {location.href = "principal.php";}
			 if (array ==-1)
			    {document.getElementById('usuario').value = '';
				 document.getElementById('pass').value  = '';
				 var notice = new PNotify({
					 title:'Error Acceso',
					 text: 'Los Permisos Asignados no son válidos. Comuniquese con el Administrador.',
					 type: 'error',
					 addclass: 'stack-bar-bottom',
					 stack: stack_bar_bottom,
					 width: "70%"
				 });
				}
			 if (array ==-2)
			    {document.getElementById('usuario').value = '';
				 document.getElementById('pass').value  = '';
				 var notice = new PNotify({
					 title:'Error Acceso',
					 text: 'La Clave ingresada no es correcta. Verifique e intente nuevamente.',
					 type: 'error',
					 addclass: 'stack-bar-bottom',
					 stack: stack_bar_bottom,
					 width: "70%"
				 });
				}
			 if (array ==-3)
			    {document.getElementById('usuario').value = '';
				 document.getElementById('pass').value  = '';
				 var notice = new PNotify({
					 title:'Error Acceso',
					 text: 'El Usuario ingresado no se encuentra disponible. Verifique e intente nuevamente.',
					 type: 'error',
					 addclass: 'stack-bar-bottom',
					 stack: stack_bar_bottom,
					 width: "70%"
				 });
				}
			 if (array ==-4)
			    {document.getElementById('usuario').value = '';
				 document.getElementById('pass').value  = '';
				 var notice = new PNotify({
					 title:'Error Configuración',
					 text: 'Los Permisos registrados en el Sistema presentan inconsistencias. Comuniquese con el Administrador.',
					 type: 'error',
					 addclass: 'stack-bar-bottom',
					 stack: stack_bar_bottom,
					 width: "70%"
				 });
				}
			}
		});
		
	}

function desbloquearUsuario(){ 
  var stack_bar_bottom = {"dir1": "up", "dir2": "right", "spacing1": 0, "spacing2": 0};  
	
	if (document.getElementById('pass').value == ''){
		var notice = new PNotify({
			title:'Error Acceso',
			text: 'La Clave es Obligatoria. Verifique e intente nuevamente.',
			type: 'error',
			addclass: 'stack-bar-bottom',
			stack: stack_bar_bottom,
			width: "70%"
		});
	}else{
		url = 'lib/php/loginUsuarioM.php';
		clave = window.btoa(document.getElementById('pass').value);
		
		$.ajax({
			type:'POST',
			url:url,
			data: 'clave='+clave,
			success:function(data){
				 var array = eval(data);
				 if (array >=0)
					{location.href = "principal.php";}
				 if (array ==-1)
					{document.getElementById('pass').value  = '';
					 var notice = new PNotify({
						 title:'Error Acceso',
						 text: 'Los Permisos Asignados no son válidos. Comuniquese con el Administrador.',
						 type: 'error',
						 addclass: 'stack-bar-bottom',
						 stack: stack_bar_bottom,
						 width: "70%"
					 });
					}
				 if (array ==-2)
					{document.getElementById('pass').value  = '';
					 var notice = new PNotify({
						 title:'Error Acceso',
						 text: 'La Clave ingresada no es correcta. Verifique e intente nuevamente.',
						 type: 'error',
						 addclass: 'stack-bar-bottom',
						 stack: stack_bar_bottom,
						 width: "70%"
					 });
					}
				 if (array ==-3)
					{document.getElementById('pass').value  = '';
					 var notice = new PNotify({
						 title:'Error Acceso',
						 text: 'El Usuario ingresado no se encuentra disponible. Verifique e intente nuevamente.',
						 type: 'error',
						 addclass: 'stack-bar-bottom',
						 stack: stack_bar_bottom,
						 width: "70%"
					 });
					}
				 if (array ==-4)
					{document.getElementById('pass').value  = '';
					 var notice = new PNotify({
						 title:'Error Configuración',
						 text: 'Los Permisos registrados en el Sistema presentan inconsistencias. Comuniquese con el Administrador.',
						 type: 'error',
						 addclass: 'stack-bar-bottom',
						 stack: stack_bar_bottom,
						 width: "70%"
					 });
					}
				}
			});
		}
}

function cargarOpcion(nmbMenu){
/*Evaluación de Opción*/
switch (nmbMenu) {
  case 'Perfil':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/perfilPersonal.php';
    break;
  case 'CambioClave':
	document.getElementById("divLoadding").style.display = 'block';
    contentTab = 'lib/forms/cambioContrasena.php';
    break;
  case 'CambioPerfil':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/upload/viewPerfilUsuario.php';
    break;
  //Módulo 0 Control de Caja		
  case 'MN0001':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/aperturaCaja.php';
    break;
  case 'MN0002':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/cierreCaja.php';
    break;
  case 'MN0003':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/jtables/view_tscEstablecimientos.php';
    break;
  case 'MN0004':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/jtables/view_tscPuntosEmision.php';
    break;
  case 'MN0005':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/jtables/view_tscCajeros.php';
    break;
  case 'MN0006':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/jtables/view_tscPuntosEmisionSec.php';
    break;	
  case 'MN0008':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/reimpresionCierreCajaSupervisor.php';
    break;			
  //Módulo 1 Ventas
  case 'MN0101':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/proformas.php';
    break;
  case 'MN0102':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/jtables/view_tbProvincia.php';
    break;
  case 'MN0103':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/facturas.php';
    break;
  case 'MN0104':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/jtables/view_tbParroquias.php';
    break;
  case 'MN0105':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/reimpresionFacturas.php';
    break;	
  //Módulo 2 Compras		
  case 'MN0201':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/compras.php';
    break;	
  case 'MN0202':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/comprasManual.php';
    break;	
  //Módulo 3 Inventario
  case 'MN0301':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/consultaStockProductos.php';
    break;
  case 'MN0302':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/consultaKardexProductos.php';
    break;	
  /*case 'MN0303':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/listaEstudiantes.php';
    break;
  case 'MN0304':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/compras.php';
    break;*/
  case 'MN0306':
	document.getElementById("divLoadding").style.display = 'block';	/*domainconnect.plesk.com/host/server.eeuu-hostdom.com/port/8443 emerge.com.ec.		MX (10)	mail.emerge.com.ec.*/
    contentTab = 'lib/jtables/view_tivProductos.php';
    break;
  case 'MN0307':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/jtables/view_tivItems.php';
    break;		
  //Módulo 4 Banco
  case 'MN0401':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/jtables/view_tscCuentasBancarias.php';
    break;
  case 'MN0402':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/jtables/view_tscInstitucionesFinancieras.php';
    break;	
  case 'MN0403':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/devengadoBancario.php';
    break;
  case 'MN0404':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/devengadoTarjetaCredito.php';
    break;		
  case 'MN0406':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/balanceBancario.php';
    break;
  //Módulo 6 Contabilidad
  case 'MN0601':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/jtables/view_tfnPeriodos.php';
    break;
  case 'MN0602':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/asignacionCuentasPeriodo.php';
    break;
  case 'MN0603':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/jtables/view_tfnTiposAsientos.php';
    break;
  case 'MN0604':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/jtables/view_tfnTiposCuentas.php';
    break;
  case 'MN0605':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/jtables/view_tfnNivelesCuentas.php';
    break;
  case 'MN0606':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/jtables/view_tfnCatalogoCuentas.php';
    break;	
  case 'MN0607':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/consultaAsientosContablesNC.php';
    break;	
  case 'MN0608':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/asientoContableManual.php';
    break;	
  case 'MN0609':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/consultaAsientosContablesContabilizados.php';
    break;  
  //Módulo 8 Cuentas por Pagar
  case 'MN0801':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/jtables/view_tgnTiposProveedores.php';
    break;
  case 'MN0802':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/jtables/view_tcuCategoriasProveedores.php';
    break;
  case 'MN0803':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/jtables/view_tscProveedores.php';
    break;	
  //Módulo 9 Cuentas por Cobrar
  case 'MN0901':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/jtables/view_tgnTiposClientes.php';
    break;
  case 'MN0902':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/jtables/view_tcuCategoriasClientes.php';
    break;
  case 'MN0903':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/jtables/view_tcuClientes.php';
    break;
  case 'MN0904':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/busquedaClientes.php';
    break;
  //Módulo 10 configuración		
  case 'MN1001':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/jtables/view_tivTiposProductos.php';
    break;
  case 'MN1002':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/jtables/view_tivClasificacionProductos.php';
    break;
  case 'MN1003':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/jtables/view_tgnTiposClientes.php';
    break;
  case 'MN1004':
	contentTab = 'lib/jtables/view_tfnConfiguracionRetenciones.php';
    break;		
  case 'MN1005':
	contentTab = 'lib/jtables/view_tscRetencionesCompras.php';
    break;
  case 'MN1008':
	contentTab = 'lib/jtables/view_tscFormasPago.php';
    break;		
 case 'MN1011':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/jtables/view_tgnTiposIdentificacion.php';
    break;
  //Módulo 11 Administración
  case 'MN1101':
    document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/jtables/view_tgnPersonal.php';
    break;
 case 'MN1102':
    document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/jtables/view_tgnDepartamentos.php';
    break;
 case 'MN1103':
    document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/jtables/view_tgnCargos.php';
    break;
  case 'MN1104':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/usuariosSistema.php';
    break;
  case 'MN1105':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/permisosUsuarioSistema.php';
    break;
  case 'MN1106':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/jtables/view_tbPerfiles.php';
    break;
  case 'MN1107':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/permisosSistema.php';
    break;		
  //Módulo 13 Factura Electrónica
  case 'MN1301':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/configuracionFE.php';
    break;
  case 'MN1302':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/gestionDocumentosElectronicos.php';
    break;		
 //Módulo 15 Reportes
  case 'MN1402':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/reports/dashBoardVentas.php';
    break;
  case 'MN1403':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/consultaCompras.php';
    break;	
  case 'MN1404':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/facturasSRI.php';
    break;	
  case 'MN1405':
	document.getElementById("divLoadding").style.display = 'block';	
    contentTab = 'lib/forms/comprasSRI.php';
    break;			
 

  //Default o Return menú		
  case 'MN0000':
	document.getElementById("divLoadding").style.display = 'none';	
    contentTab = 'lib/forms/principal.php';
    break;		
  default:
	contentTab = 'lib/forms/principal.php';
	document.getElementById("divLoadding").style.display = 'none';	
    console.log('Lo lamentamos, por el momento no disponemos de ' + nmbMenu + '.');
}
	
	var alto = window.innerHeight - 65;	
	document.getElementById("principal").innerHTML='<object type="text/html" style="width: 100%; height: '+alto+'px;" data="'+contentTab+'" ></object>';
	//$('#myTab').html(contentTab)
} 

function removeTab(liElem) { // Function remove tab with the <li> number
	var titulo = $('#spanTitulo' + liElem).html();
	modalAlertPrincipal(2, 'MarketSys','¿Esta seguro de Querer cerrar la pestaña '+titulo.toUpperCase()+'?',1,'No, deseo continuar','Si, deseo salir')
	$('#controlTabD').html(liElem);
	
}


function removeTabF() { // Function remove tab with the <li> number
	var liElem = $('#controlTabD').html();
	
	$('ul.wizard-steps li').removeClass('active');
	$('ul.wizard-steps li#li' + liElem).addClass('active');
	$('ul#myTab > li#li' + liElem).fadeOut(1000, function () { 
		$('#liPrincipal').addClass('active');
		$(this).remove(); // Remove the <li></li> with a fadeout effect
		$('#messagesAlert').text(''); // Empty the <div id="messagesAlert"></div>
	});
	
	
	$('div.tab-content iframe#tab' + liElem).remove(); // Also remove the correct <div> inside <div class="tab-content">
	
	var elemento=document.getElementById('aPrincipal');
		elemento.click()
	//$('#aPrincipal').trigger('click');
	
	$('#modal').css('display','none'); //modal.close();

}

function removeTabNombre(nombreTab) { // Function remove tab with the <li> number
	
	/*var id = parseInt($('#controlTab').html())+1;
	
	var encontro = 0;
	for (var i= 1; i<= id; i++){
		if ($('#spanTitulo' + i).html() == nombreTab){
			$('ul.wizard-steps li').removeClass('active');
			
			encontro = i;
			
			//return;
		}
	}
	
	var liElem = 0;
	if (encontro != 0){
		liElem = encontro;
		$('ul.wizard-steps li').removeClass('active');
		$('ul.wizard-steps li#li' + liElem).addClass('active');
		$('ul#myTab > li#li' + liElem).fadeOut(1000, function () { 
			$('#liPrincipal').addClass('active');
			$(this).remove(); // Remove the <li></li> with a fadeout effect
			$('#messagesAlert').text(''); // Empty the <div id="messagesAlert"></div>
		});
		
		
		$('div.tab-content iframe#tab' + liElem).remove(); // Also remove the correct <div> inside <div class="tab-content">
		
		var elemento=document.getElementById('aPrincipal');
			elemento.click()
		//$('#aPrincipal').trigger('click');
		
	}*/

}

function cambiarContrasena(){
	var stack_bar_bottom = {"dir1": "up", "dir2": "right", "spacing1": 0, "spacing2": 0}; 
	url = '../../lib/php/realizaCambioContrasena.php';
	ca = document.getElementById("txtContrasenaActual").value;
	nc = document.getElementById("txtNuevaContrasena").value;
	cc = document.getElementById("txtContrasenaConfirmar").value;
	if (ca == ''){
		$('#testAlert').simpleAlert({
		   message:"La clave actual no se encuentra ingresada, por favor verifique."
	      });
		  return;
	    }
	if (nc == ''){
		$('#testAlert').simpleAlert({
	       message:"La nueva clave no se encuentra ingresada, por favor verifique."
		});
		return;
	  }
	if (cc == ''){
		$('#testAlert').simpleAlert({
	      message:"La confirmacion de la clave no se encuentra ingresada, por favor verifique."
		  });
	     return;}
	if (cc != nc){
		$('#testAlert').simpleAlert({
	       message:"La nueva clave y la confirmacion de la clave no son iguales, por favor verifique."
		   });
		   document.getElementById("txtNuevaContrasena").value = '';
		   document.getElementById("txtContrasenaConfirmar").value = '';
	       return;}
	$.ajax({
		type:'POST',
		data: 'ca='+ca+'&nc='+nc+'&cc='+cc,
		url:url,
		success:function(data){
			  datos = eval(data);
			  if (datos[0] == 0)
			     {$('#testAlert').simpleAlert({
				     message:"Se ha realizado el cambio de contraseña de manera satisfactoria."
			         });
						var delayInMilliseconds = 1500; //1 second
						setTimeout(function() {
						  //your code to be executed after 1 second
						  parent.location.reload(false);
						}, delayInMilliseconds);}
						else{$('#testAlert').simpleAlert({
								 message:"La clave actual no es correcta, por favor verifique e intente nuevamente."
								 });
								 document.getElementById("txtContrasenaActual").value = '';
							} 
			}
		});
	}

function cancelarCambio(){
	parent.location.reload(false); 
	}

function modalAlertPrincipal(tipo, titulo, contenido, botonAlternativo, LabelBoton1, LabelBoton2){
	
	$('#titleModal').html(titulo);
	$('#bodyModal').html(contenido);
	
	$('#btn1-modal').css('display','none');
	$('#btn2-modal').css('display','none');
	$('#btn3-modal').css('display','none');
	$('#btnf-modal').html(LabelBoton1);
	
	if (botonAlternativo == 1){$('#btn1-modal').css('display','initial'); $('#btn1-modal').html(LabelBoton2);}
	if (botonAlternativo == 2){$('#btn2-modal').css('display','initial'); $('#btn2-modal').html(LabelBoton2);}
	if (botonAlternativo == 3){$('#btn3-modal').css('display','initial'); $('#btn3-modal').html(LabelBoton2);}
	
	if (tipo == 1){
		$('.modal-header').css("background",'#E74C3C');
		$('.modal-header').css("border", "13px solid #E74C3C");
		$('.modal-header').css("color", "#FFFFFF");
		$('.modal-header').css("font-size", "18px");
	}else if (tipo == 2){
			  $('.modal-header').css("background",'#3498DB');
			  $('.modal-header').css("border", "13px solid #3498DB");
			  $('.modal-header').css("color", "#FFFFFF");
			  $('.modal-header').css("font-size", "18px");
			 }else if (tipo == 3){
					   $('.modal-header').css("background",'#2ECC71');
					   $('.modal-header').css("border", "13px solid #2ECC71");
					   $('.modal-header').css("color", "#FFFFFF");
					   $('.modal-header').css("font-size", "18px");
					}else{$('.modal-header').css("background",'#FFFFFF');
						  $('.modal-header').css("border", "13px solid #FFFFFF");
						  $('.modal-header').css("color", "#000000");
						  $('.modal-header').css("font-size", "18px");
						}
	
	$('#modal').css('display','block');
	
}

function showModal() {
	/*$('body').loadingModal({text: 'Showing loader animations...'});

	var delay = function(ms){ return new Promise(function(r) { setTimeout(r, ms) }) };
	var time = 2000;

	delay(time)
			.then(function() { $('body').loadingModal('animation', 'rotatingPlane').loadingModal('backgroundColor', 'red'); return delay(time);})
			.then(function() { $('body').loadingModal('hide'); return delay(time); } )
			.then(function() { $('body').loadingModal('destroy') ;} );*/
}
