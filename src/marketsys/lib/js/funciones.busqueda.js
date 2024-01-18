	/*FUNCIONES BASE DE DATOS*/ 
	function enviarAjax(tipo,url_, data_, funcion_){
		$.ajax({
			type:tipo,
			dataType: 'json',
			url: url_,
			data: data_,
			success:funcion_
		})
	}
	
	function restablecerClaveAcceso(){
		var url = '../../../../lib/php/restablecerClave.php';
		var id = document.getElementById('identificacion').innerHTML;
		var idc = document.getElementById('id_cliente').innerHTML;
		$.ajax({
				type:'POST',
				url:url,
				data: 'id='+id+'&idc='+idc,
				success:function(data){
					var array = eval(data);
						if (array[0] == '0'){
							parent.successAlert('Cambio Exitoso de Clave','Su contraseña ha sido restablecida <br>  Su nueva claves es su número de Identificación.');
							}
						else{parent.errorAlert(array[1]);}	
				}
			});
	}
		
	function informacionBusqueda(id){
		parent.document.getElementById("divLoadding").style.display = 'block';
		limpiarTabla(); 
		enviarAjax("POST","../php/informacionCliente.php", {id:id}, llenarInformacionBusqueda);
		enviarAjax("POST","../php/informacionClienteFacturas.php", {id:id}, mostrarInformacionHistorialFactura);
		enviarAjax("POST","../php/informacionClientePagos.php", {id:id}, mostrarInformacionHistorialPagos);
	}
	
	function generarReporte(e){
		if(document.getElementById('numeroCuenta').innerHTML != ''){
		   window.top.document.getElementById('load').style.display = 'block';
		   window.open('../../../reports/pdf/atencionCliente/busquedaUsuarios/pdfReporteBusqueda.php?idcuenta='+document.getElementById('numeroCuenta').innerHTML);
		   window.top.document.getElementById('load').style.display = 'none';
		}else{
			parent.errorAlert('Para Generar la Ficha de la Cuenta debe seleccionar una cuenta.');
		}
		
	}
	
	function reimpresionPagoIndividual(idpago){
		window.open('../../../reports//pdf/comercial/recaudacion/facturaPagoCopia.php?cuentaservicio='+document.getElementById('numeroCuenta').innerHTML+'&idpago='+idpago);
	}
	
	function rideFacturaIndividual(idfactura, tipo){
		if (tipo == 'NO'){
			window.open('../../../reports/pdf/comercial/facturacionFinal/rideFacturaIndividualNA.php?idfactura='+idfactura);
		}else{
			window.open('../../../reports/pdf/comercial/facturacionFinal/rideFacturaIndividual.php?idfactura='+idfactura);
		}
		
	}
	
	function informacionFacturaIndividual (id_factura){
		enviarAjax("POST","../php/informacionDeudaXRubrosIndividual.php", {idFactura:id_factura}, llenarInformacionRubrosFactura);
	}
	
	function informacionPagoIndividual (id_pago){
		enviarAjax("POST","../../../../lib/php/informacionAfectacionPagoIndividual.php", {idPago:id_pago}, llenarInformacionAfectacionFactura);
	}
	
	function informacionNCIndividual (id_pago){
		enviarAjax("POST","../../../../lib/php/informacionAfectacionNCIndividual.php", {idNC:id_pago}, llenarInformacionAfectacionFacturaNC);
	}
	
	function informacionPagoAnticipo (){
		cuenta_servicio=document.getElementById('numeroCuenta').innerHTML;
		id_pago=document.getElementById('nroPagoConvenio').value;
		enviarAjax("POST","../../../../lib/php/informacionPagoCliente.php", {idpago:id_pago, cuentaservicio: cuenta_servicio}, llenarInformacionAnticipoConvenio);
		enviarAjax("POST","../../../../lib/php/informacionConvenioDeudaXRubros.php", {cuentaservicio: cuenta_servicio}, llenarInformacionDeudaRubrosConvenio);
	}
	
	function informacionSPagoAnticipo (){
		cuenta_servicio=document.getElementById('numeroCuenta').innerHTML;
		monto_pago=document.getElementById('montoPagoSimulador').value;
		interes_mora=document.getElementById('anticipoPorcentajeConvenioS').innerHTML;
		enviarAjax("POST","../../../../lib/php/informacionPreliminarSimulador.php", {cuentaservicio: cuenta_servicio, montopago: monto_pago, mora: interes_mora}, llenarInformacionSConvenio);
	}
	
	function llenarInformacionSConvenio(e){
		var informacionBusqueda = e;
		  document.getElementById('anticipoPorcentajeConvenioS').innerHTML= informacionBusqueda[2];
		  document.getElementById('capitalConvenioS').innerHTML= informacionBusqueda[0];
		  document.getElementById('interesConvenioS').innerHTML= informacionBusqueda[1];
		  document.getElementById('interesGeneradoS').innerHTML= informacionBusqueda[3];
		  document.getElementById('simuladorTablaConvenio').innerHTML= informacionBusqueda[4];
		  document.getElementById('porcentajeInteresSConvenio').innerHTML= informacionBusqueda[5];
		  document.getElementById('deudaPendienteS').innerHTML= informacionBusqueda[6];
				   
	}
	
	function calculaValorCuotaSConvenio(){
		cuenta_servicio=document.getElementById('numeroCuenta').innerHTML;
		monto_pago=document.getElementById('montoPagoSimulador').value;
		_capital=document.getElementById('capitalConvenioS').innerHTML;
		_interes=document.getElementById('interesConvenioS').innerHTML;
		_pmora=document.getElementById('porcentajeInteresSConvenio').innerHTML;
		_cuotas=document.getElementById('numCuotasConvenioS').value;
		enviarAjax("POST","../../../../lib/php/informacionPreliminarSimuladorCuota.php", 
		          {cuentaservicio: cuenta_servicio, 
				   capital: _capital,
				   interes: _interes,
				   pmora: _pmora,
				   cuotas: _cuotas}, llenarInformacionSConvenioCuota);
	}
	
	function llenarInformacionSConvenioCuota(e){
		var informacionBusqueda = e;
		  document.getElementById('interesGeneradoS').innerHTML= informacionBusqueda[1];
		  document.getElementById('simuladorTablaConvenio').innerHTML= informacionBusqueda[0];
				   
	}
	
	function llenarInformacionDeudaRubrosConvenio(e){	
		var informacionBusqueda = e;
		totalRegT = document.getElementById("tableRubrosConvenios").rows.length;
		for (var i=0;i < totalRegT; i++) {
		   document.getElementById("tableRubrosConvenios").deleteRow(0);
		}
		X=0;
		capital = 0;
		interes = 0;
		var table = document.getElementById("tableRubrosConvenios").getElementsByTagName('tbody')[0];
		for(var i in informacionBusqueda)
			{				
				var row = table.insertRow(0);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				if (i%2==0)
					{cell1.className = "estiloTI";
					 cell2.className = "estiloTD";}
				else
					{cell1.className = "estiloTI2";
					 cell2.className = "estiloTD2";}
				cell1.style = "padding-left: 10px;";
				cell2.style = "padding-right: 10px;";				
				cell1.style.width = '280px';
				cell2.style.width = '60px';
				cell1.innerHTML = informacionBusqueda[i].rubro;
				cell2.innerHTML = informacionBusqueda[i].total;
				capital = capital + parseFloat(informacionBusqueda[i].capital.replace(',', '.'));
				interes = interes + parseFloat(informacionBusqueda[i].interes.replace(',', '.'));
				X=1;
			}
			document.getElementById('capitalConvenioDeuda').innerHTML=capital.toFixed(2);
			document.getElementById('interesConvenioDeuda').innerHTML=interes.toFixed(2);
			total = capital+interes;
			document.getElementById('totalConvenioDeuda').innerHTML=total.toFixed(2);
			document.getElementById('totalConvenioDeuda2').innerHTML=total.toFixed(2);
			var row = table.insertRow(0);
			row.className = "estilo2";
			var cell1 = row.insertCell(0);
			var cell2 = row.insertCell(1);
			cell1.innerHTML = '<span style="width: 60px; text-align: center;"> Rubros </span>';
			cell2.innerHTML = '<span style="width: 200px; text-align: center;"> Valor </span>';
			porceAnticipo = parseFloat(document.getElementById('montoPagoConvenio').innerHTML)/(parseFloat(document.getElementById('montoPagoConvenio').innerHTML)+parseFloat(document.getElementById('capitalConvenioDeuda').innerHTML))*100;
			document.getElementById('anticipoPorcentajeConvenio').innerHTML = porceAnticipo.toFixed(2);
			
			enviarAjax("POST","../../../../lib/php/informacionParametrosConvenio.php", {id: 1}, llenarInformacionConvenioParametros);
			
	}
		
	function buscarInformacion(e){
			//parent.document.getElementById('load').style.display = 'block';
			limpiarTabla();
			if (document.getElementById('busqueda').value=='')
				{parent.infoAlert('Por digite los parametros para sus búsqueda.');
				 window.top.document.getElementById('load').style.display = 'none';}
				else{enviarAjax("GET","../php/busquedaClientes.php", {idBusqueda:e}, mostrarInformacionBusqueda);}
	}
	
	function insertaTramiteConvenio(idFlujo,cuentaServicio){
		if (document.getElementById('fechaPagoConvenio').innerHTML == ''){
			parent.errorAlert('Por favor ingrese el código de pago.');
		}else {
			window.top.document.getElementById('load').style.display = 'block';
			enviarAjax("GET","../../../../lib/php/insertaTramitesNuevos.php", {idflujo:idFlujo,cuentaservicio:cuentaServicio},registraConvenio);
		}	
	}
	
	function registraConvenio(e){
		var resp=eval(e);
		if (resp[0].id != -1){
			enviarAjax("GET",
					   "../../../../lib/php/insertaConvenioPago.php", 
					   {idtramite: resp[0].id,
						cuentaservicio: resp[0].cuenta,
						numerocuotas: document.getElementById('numCuotasConvenio').value,
						procentajeinteres: document.getElementById('porcentajeInteresConvenio').innerHTML,
						idpagoanticipo: document.getElementById('nroPagoConvenio').value,
						porcentajepago: document.getElementById('anticipoPorcentajeConvenio').innerHTML,
						montopago: document.getElementById('montoPagoConvenio').innerHTML,
						montodeuda: document.getElementById('totalConvenioDeuda').innerHTML},retornaConvenioPago);
			}else{parent.errorAlert('Su sessión activa, ha caducado. Por favor ingrese nuevamente.');
			      window.top.document.getElementById('load').style.display = 'none';}
		}
	
	function retornaConvenioPago(e){
		var resp=eval(e);
		window.open('../../../reports/pdf/atencionCliente/convenioPago/pdfReporteConvenio.php?idcuenta='+resp[0].cuenta+'&idconvenio='+resp[0].id);
		document.getElementById('idconvenio').innerHTML = resp[0].id;
		document.getElementById('myPopupConvenio').style.display = 'none';
		window.top.document.getElementById('load').style.display = 'none';
		informacionBusqueda(resp[0].cuenta);
		
		var dataObject = { idConvenio: resp[0].id,
		                   idFlujo: document.getElementById('idFlujoConvenio').innerHTML};
		enviarAjax("GET",
				   "../../../../lib/php/procesaEnviaRegistroConvenio.php", 
				   {idConvenio: resp[0].id,
		            idFlujo: document.getElementById('idFlujoConvenio').innerHTML});
		
		parent.successAlert('Transacción Éxitosa','Se ha generado correctamente el convenio de pago. Los valores se mantendrán pendientes hasta que los valores sean regulados.');
	}
	
	function insertaTramiteReclamo(idFlujo,cuentaServicio){
			if (document.getElementById('textReclamo').value == ''){
				parent.errorAlert('Por favor realice el ingreso del detalle de reclamo.');
			}else {
				window.top.document.getElementById('load').style.display = 'block';
				enviarAjax("GET","../../../../lib/php/insertaTramitesNuevos.php", {idflujo:idFlujo,cuentaservicio:cuentaServicio},registraCamposTramiteReclamo);
			}	
		}	
	
	function informacionConsultaB(){
		tipoIden = document.getElementById('tipoIdentificacionBeneficiario').value;
		numeIden = document.getElementById('numeroIdentificacionBeneficiario').value;
		urlWS = '../../../../lib/webServices/webServicesInformacionClientes.php';
		$.ajax({
			type:'POST',
			url:urlWS,
			data: 'num='+numeIden+'&tipo='+tipoIden,
			success:function(data){
					var array = eval(data);
					document.getElementById('textNombrebeneficiario').value = array[2];
					document.getElementById('fechaNacimientoBen').value = array[4];
					var str = array[3];
					var res = str.substr(0, 1);
					document.getElementById('generoBeneficiario').value = res;
			}
		});	
	}
	
	function insertaTramiteSolicitud(idFlujo,cuentaServicio){
		if (document.getElementById('tipoSolicitud').value == 0){
			parent.errorAlert('Por favor realice la selección del tipo de Solicitud.');
			return;}
			
		if (document.getElementById('ttotal').innerHTML > 0 && (document.getElementById('tipoSolicitud').value == 3 || document.getElementById('tipoSolicitud').value == 4 || document.getElementById('tipoSolicitud').value == 5 || document.getElementById('tipoSolicitud').value == 9 || document.getElementById('tipoSolicitud').value == 10)){
			parent.errorAlert('Para procesar este tipo de solicitud el usuario no debe tener valores pendientes con la Empresa.');
			return;}
		
		if (document.getElementById('estado').innerHTML == 'BAJA'){
			parent.errorAlert('Su solicitud no puede ser procesada. La cuenta seleccionada se encuentra en estado de conexión: BAJA');
			return;}
		
		if (document.getElementById('estado').innerHTML == 'ACTIVO' && document.getElementById('tipoSolicitud').value == 4){
			parent.errorAlert('Su solicitud no puede ser procesada. La cuenta seleccionada se encuentra en estado de conexión: ACTIVO');
			return;}
		
		if (document.getElementById('estado').innerHTML == 'CIERRE TEMPORAL' && document.getElementById('tipoSolicitud').value == 3){
			parent.errorAlert('Su solicitud no puede ser procesada. La cuenta seleccionada se encuentra actualmente tiene un estado de conexión: CIERRE TEMPORAL');
			return;}
		
		if (document.getElementById('textSolicitud').value == ''){
			parent.errorAlert('Por favor realice el ingreso del detalle de su Solicitud.');
			return;}
		
		if(document.getElementById('tipoSolicitud').value == 1){
		   msj = '';
		   if(document.getElementById('objImageSolicitud1').contentWindow.document.getElementById('tituloImage').innerHTML == 'No Disponible')
			 {msj = msj+'<br> -Información Digital Solicitud';}  
			if(document.getElementById('objImageSolicitud2').contentWindow.document.getElementById('tituloImage').innerHTML == 'No Disponible')
			  {msj = msj+'<br> -Información Digital Solicitante';} 
			
			if (msj != ''){
				parent.errorAlert('Por favor verificar la siguiente información:<br>'+msj);
			    return;}
			}
			
		if(document.getElementById('tipoSolicitud').value == 2){
		   msj = '';
		   if(document.getElementById('tipoIdentificacionBeneficiario').value == 0)
		     {msj = msj+'<br> -Tipo Identificación';}
		   if(document.getElementById('numeroIdentificacionBeneficiario').value == '')
			 {msj = msj+'<br> -Número Identificación';}  
		   if(document.getElementById('textNombrebeneficiario').value == '')
			 {msj = msj+'<br> -Número Identificación';}
		   if(document.getElementById('fechaNacimientoBen').value == '')
			 {msj = msj+'<br> -Fecha de Nacimiento';}  
		   if(document.getElementById('generoBeneficiario').value == 0)
			 {msj = msj+'<br> -Género Beneficiario';}  
		   if(document.getElementById('tipoDiscapacidadBeneficiario').value == 0)
			 {msj = msj+'<br> -Tipo Discapacidad';}  
		   if(document.getElementById('porcentajeDiscapacidad').value == '')
			 {msj = msj+'<br> -Porcentaje Discapacidad';}  
		   if(document.getElementById('carnetCONADIS').value == '')
			 {msj = msj+'<br> -Carnet CONADIS';}
		   if(document.getElementById('parentescoDiscapacidad').value == 0)
			 {msj = msj+'<br> -Parentesco con el Propietario';}
		   if(document.getElementById('objImageSolicitud1').contentWindow.document.getElementById('tituloImage').innerHTML == 'No Disponible')
			 {msj = msj+'<br> -Información Digital Solicitud';}  
		   if(document.getElementById('objImageSolicitud2').contentWindow.document.getElementById('tituloImage').innerHTML == 'No Disponible')
			  {msj = msj+'<br> -Información Digital Solicitante';}
		   if(document.getElementById('objImageSolicitud3').contentWindow.document.getElementById('tituloImage').innerHTML == 'No Disponible')
			 {msj = msj+'<br> -Información Digital Beneficiario';}  
		 
		   if (msj != ''){
				parent.errorAlert('Por favor verificar la siguiente información del beneficiario:<br>'+msj);
			    return;}
			}
			
		if(document.getElementById('tipoSolicitud').value > 2){
		   msj = '';
		   if(document.getElementById('objImageSolicitud1').contentWindow.document.getElementById('tituloImage').innerHTML == 'No Disponible')
			 {msj = msj+'<br> -Información Digital Solicitud';}  
			if(document.getElementById('objImageSolicitud2').contentWindow.document.getElementById('tituloImage').innerHTML == 'No Disponible')
			  {msj = msj+'<br> -Información Digital Solicitante';} 
			
			if (msj != ''){
				parent.errorAlert('Por favor verificar la siguiente información:<br>'+msj);
			    return;}
			}
			
		window.top.document.getElementById('load').style.display = 'block';
		enviarAjax("GET","../../../../lib/php/insertaTramitesNuevos.php", {idflujo:idFlujo,cuentaservicio:cuentaServicio},registraCamposTramiteSolicitud);
	}
	
	function actualizaContactosClientes(){
		var url = '../../../../lib/php/actualizarContactosClientes.php';
			$.ajax({
				type:'POST',
				url:url,
				data:'cuentaServicio='+document.getElementById('numeroCuenta').innerHTML+'&t1='+document.getElementById('telefonoPrincipal').value+'&t2='+document.getElementById('telefonoAlternativo').value+'&e1='+document.getElementById('emailPrincipal').value+'&e2='+document.getElementById('emailAlternativo').value+'&ref='+document.getElementById('referenciaPredio').value,
				success:function(data){
					var resp = eval(data);
						 if (resp[0] == 'OK'){
							parent.successAlert('Transacción Éxitosa','Los Datos han sido Actualizados Correctamente.'); 
							document.getElementById('telefonoPrincipal').value = '';
							document.getElementById('telefonoAlternativo').value = '';
							document.getElementById('emailPrincipal').value = '';
							document.getElementById('emailAlternativo').value = '';
							document.getElementById('myContactoCliente').style.display = 'none';
						 }
				}
		});
	}
	
	function registraCamposTramiteReclamo(e){
		var resp=eval(e);
		if (resp[0].id != -1){	
			enviarAjax("GET",
					   "../../../../lib/php/insertaCamposReclamo.php", 
					   {idtramite: resp[0].id,
						idflujo: 3,
						iddetalle: 2,
						reclamoConsumoElevado: document.getElementById('reclamoConsumoElevado').checked,
						reclamoConsumoEstimado: document.getElementById('reclamoConsumoEstimado').checked,
						reclamoCategoriaErrada: document.getElementById('reclamoCategoriaErrada').checked,
						reclamoCuentaErrada: document.getElementById('reclamoCuentaErrada').checked,
						reclamoFacturaErrada: document.getElementById('reclamoFacturaErrada').checked,
						reclamoRubroErrado: document.getElementById('reclamoRubroErrado').checked,
						reclamoTerceraEdad: document.getElementById('reclamoTerceraEdad').checked,
						reclamoDiscapacidad: document.getElementById('reclamoDiscapacidad').checked,
						textReclamo: document.getElementById('textReclamo').value});
			
			document.getElementById('myPopupReclamo').style.display = 'none';
			parent.successAlert('Transacción Éxitosa','Su reclamo ha sido generado satisfactoriamente. Sú número de reclamo es: '+resp[0].id);
			window.open('../../../reports/pdf/atencionCliente/reclamosAdministrativos/pdfSolicitudReclamo.php?idcuenta='+resp[0].cuenta+'&idtramite='+resp[0].id);
			informacionBusqueda(resp[0].cuenta);
			window.top.document.getElementById('load').style.display = 'none';
		}else{parent.errorAlert('Su sessión activa, ha caducado. Por favor ingrese nuevamente.');
		      window.top.document.getElementById('load').style.display = 'none';}
	}
	
	function reportePreliminarSolicitud(tipo, id){
		window.top.document.getElementById('load').style.display = 'block';
		if (tipo == 0){parent.errorAlert('Por favor seleccione un tipo de solicitud.');}
			else{window.open('../../../reports/pdf/atencionCliente/solicitudes/solicitudAtencionCliente.php?id='+id+'&tipo='+tipo);}
		window.top.document.getElementById('load').style.display = 'none';
	}
	
	function registraCamposTramiteSolicitud(e){
		resp = eval(e);
		if (resp[0].id != -1){	
			var resp=eval(e);
			if (document.getElementById('tipoSolicitud').value == 1){
				$.ajax({
					type:'GET',
					url: "../../../../lib/php/insertaCamposReclamo.php",
					data:'idtramite='+resp[0].id+
						 '&idflujo='+4+
						 '&iddetalle='+2+
						 '&tipoSolicitud='+document.getElementById('tipoSolicitud').value+
						 '&textSolicitud='+document.getElementById('textSolicitud').value+
						 '&objImageSolicitud1='+document.getElementById('objImageSolicitud1').contentWindow.document.getElementById('tituloImage').innerHTML+
						 '&objImageSolicitud2='+document.getElementById('objImageSolicitud2').contentWindow.document.getElementById('tituloImage').innerHTML+
						 '&objImageSolicitud3=x'+
						 '&tipoIdentificacionBeneficiario=0'+
						 '&numeroIdentificacionBeneficiario=0'+
						 '&textNombrebeneficiario=x'+
						 '&fechaNacimientoBen=x'+
						 '&generoBeneficiario=x'+
						 '&tipoDiscapacidadBeneficiario=x'+
						 '&porcentajeDiscapacidad=0'+
						 '&carnetCONADIS=x'+
						 '&parentescoDiscapacidad=0'+
						 '&verificacionCamino=3&caminoSocial=13',
					success:function(data){
							enviarAjax("GET",
									   "../../../../lib/php/guardarSolicitudBeneficio.php", 
									  {tipoSolicitud: document.getElementById('tipoSolicitud').value,
									   textSolicitud: document.getElementById('textSolicitud').value,
									   cuentaServicio: resp[0].cuenta,
									   idtramite: resp[0].id});
						}	
				});	
			}
			if (document.getElementById('tipoSolicitud').value == 2){
				$.ajax({
					type:'GET',
					url: "../../../../lib/php/insertaCamposReclamo.php",
					data:'idtramite='+resp[0].id+
						 '&idflujo='+4+
						 '&iddetalle='+2+
						 '&tipoSolicitud='+document.getElementById('tipoSolicitud').value+
						 '&textSolicitud='+document.getElementById('textSolicitud').value+
						 '&objImageSolicitud1='+document.getElementById('objImageSolicitud1').contentWindow.document.getElementById('tituloImage').innerHTML+
						 '&objImageSolicitud2='+document.getElementById('objImageSolicitud2').contentWindow.document.getElementById('tituloImage').innerHTML+
						 '&objImageSolicitud3='+document.getElementById('objImageSolicitud3').contentWindow.document.getElementById('tituloImage').innerHTML+
						 '&tipoIdentificacionBeneficiario='+document.getElementById('tipoIdentificacionBeneficiario').value+
						 '&numeroIdentificacionBeneficiario='+document.getElementById('numeroIdentificacionBeneficiario').value+
						 '&textNombrebeneficiario='+document.getElementById('textNombrebeneficiario').value+
						 '&fechaNacimientoBen='+document.getElementById('fechaNacimientoBen').value+
						 '&generoBeneficiario='+document.getElementById('generoBeneficiario').value+
						 '&tipoDiscapacidadBeneficiario='+document.getElementById('tipoDiscapacidadBeneficiario').value+
						 '&porcentajeDiscapacidad='+document.getElementById('porcentajeDiscapacidad').value+
						 '&carnetCONADIS='+document.getElementById('carnetCONADIS').value+
						 '&parentescoDiscapacidad='+document.getElementById('parentescoDiscapacidad').value+
						 '&verificacionCamino=3&caminoSocial=13',
					success:function(data){
							enviarAjax("GET",
									   "../../../../lib/php/guardarSolicitudBeneficio.php", 
									   {tipoSolicitud: document.getElementById('tipoSolicitud').value,
										textSolicitud: document.getElementById('textSolicitud').value,
										cuentaServicio: resp[0].cuenta,
										idtramite: resp[0].id});
												
										enviarAjax("GET",
												   "../../../../lib/php/guardarDatosBeneficioDiscapacidad.php", 
												   {cuentaServicio: resp[0].cuenta,
													objImageSolicitud3: document.getElementById('objImageSolicitud3').contentWindow.document.getElementById('tituloImage').innerHTML,
													tipoIdentificacionBeneficiario: document.getElementById('tipoIdentificacionBeneficiario').value,
													numeroIdentificacionBeneficiario: document.getElementById('numeroIdentificacionBeneficiario').value,
													textNombrebeneficiario: document.getElementById('textNombrebeneficiario').value,
													fechaNacimientoBen: document.getElementById('fechaNacimientoBen').value,
													generoBeneficiario: document.getElementById('generoBeneficiario').value,
													tipoDiscapacidadBeneficiario: document.getElementById('tipoDiscapacidadBeneficiario').value,
													porcentajeDiscapacidad: document.getElementById('porcentajeDiscapacidad').value,
													carnetCONADIS: document.getElementById('carnetCONADIS').value,
													parentescoDiscapacidad: document.getElementById('parentescoDiscapacidad').value});
							}	
					});	
				}
			
			if ((document.getElementById('tipoSolicitud').value > 2 && document.getElementById('tipoSolicitud').value <= 5) || (document.getElementById('tipoSolicitud').value > 8 && document.getElementById('tipoSolicitud').value <= 11) || document.getElementById('tipoSolicitud').value == 15){
				$.ajax({
					type:'GET',
					url: "../../../../lib/php/insertaCamposReclamo.php",
					data:'idtramite='+resp[0].id+
						 '&idflujo='+4+
						 '&iddetalle='+2+
						 '&tipoSolicitud='+document.getElementById('tipoSolicitud').value+
						 '&textSolicitud='+document.getElementById('textSolicitud').value+
						 '&objImageSolicitud1='+document.getElementById('objImageSolicitud1').contentWindow.document.getElementById('tituloImage').innerHTML+
						 '&objImageSolicitud2='+document.getElementById('objImageSolicitud2').contentWindow.document.getElementById('tituloImage').innerHTML+
						 '&objImageSolicitud3=x'+
						 '&tipoIdentificacionBeneficiario=0'+
						 '&numeroIdentificacionBeneficiario=0'+
						 '&textNombrebeneficiario=x'+
						 '&fechaNacimientoBen=x'+
						 '&generoBeneficiario=x'+
						 '&tipoDiscapacidadBeneficiario=x'+
						 '&porcentajeDiscapacidad=0'+
						 '&carnetCONADIS=x'+
						 '&parentescoDiscapacidad=0'+
						 '&verificacionCamino=1&caminoSocial=13',
					success:function(data){}	
				});	
			}
			
			if ((document.getElementById('tipoSolicitud').value >= 5 && document.getElementById('tipoSolicitud').value <= 8) || document.getElementById('tipoSolicitud').value == 14){
				$.ajax({
					type:'GET',
					url: "../../../../lib/php/insertaCamposReclamo.php",
					data:'idtramite='+resp[0].id+
						 '&idflujo='+4+
						 '&iddetalle='+2+
						 '&tipoSolicitud='+document.getElementById('tipoSolicitud').value+
						 '&textSolicitud='+document.getElementById('textSolicitud').value+
						 '&objImageSolicitud1='+document.getElementById('objImageSolicitud1').contentWindow.document.getElementById('tituloImage').innerHTML+
						 '&objImageSolicitud2='+document.getElementById('objImageSolicitud2').contentWindow.document.getElementById('tituloImage').innerHTML+
						 '&objImageSolicitud3=x'+
						 '&tipoIdentificacionBeneficiario=0'+
						 '&numeroIdentificacionBeneficiario=0'+
						 '&textNombrebeneficiario=x'+
						 '&fechaNacimientoBen=x'+
						 '&generoBeneficiario=x'+
						 '&tipoDiscapacidadBeneficiario=x'+
						 '&porcentajeDiscapacidad=0'+
						 '&carnetCONADIS=x'+
						 '&parentescoDiscapacidad=0'+
						 '&verificacionCamino='+document.getElementById('tipoSolicitud').value+'&caminoSocial=13',
					success:function(data){}	
				});	
			}
			
			if (document.getElementById('tipoSolicitud').value == 13){
				$.ajax({
					type:'GET',
					url: "../../../../lib/php/insertaCamposReclamo.php",
					data:'idtramite='+resp[0].id+
						 '&idflujo='+4+
						 '&iddetalle='+2+
						 '&tipoSolicitud='+document.getElementById('tipoSolicitud').value+
						 '&textSolicitud='+document.getElementById('textSolicitud').value+
						 '&objImageSolicitud1='+document.getElementById('objImageSolicitud1').contentWindow.document.getElementById('tituloImage').innerHTML+
						 '&objImageSolicitud2='+document.getElementById('objImageSolicitud2').contentWindow.document.getElementById('tituloImage').innerHTML+
						 '&objImageSolicitud3=x'+
						 '&tipoIdentificacionBeneficiario=0'+
						 '&numeroIdentificacionBeneficiario=0'+
						 '&textNombrebeneficiario=x'+
						 '&fechaNacimientoBen=x'+
						 '&generoBeneficiario=x'+
						 '&tipoDiscapacidadBeneficiario=x'+
						 '&porcentajeDiscapacidad=0'+
						 '&carnetCONADIS=x'+
						 '&parentescoDiscapacidad=0'+
						 '&verificacionCamino=12&caminoSocial=13',
					success:function(data){}	
				});	
			}
			
		enviarAjax("GET",
				   "../../../../lib/php/actualizarIdentificacionCliente.php", 
				   {cuentaServicio: resp[0].cuenta,
					objImageSolicitud2: document.getElementById('objImageSolicitud2').contentWindow.document.getElementById('tituloImage').innerHTML});
							   
			document.getElementById('myPopupSolicitud').style.display = 'none';
			parent.successAlert('Transacción Éxitosa','Su Solicitud ha sido generada satisfactoriamente. \n Su número de trámite es: '+resp[0].id);
			informacionBusqueda(resp[0].cuenta);
			window.top.document.getElementById('load').style.display = 'none';	
		}else{parent.errorAlert('Su sessión activa, ha caducado. Por favor ingrese nuevamente.');
			  window.top.document.getElementById('load').style.display = 'none';}	
	}
	
	function verificaMarca(num){
		if (num ==1){
			if (document.getElementById('reclamoConsumoElevado').checked==false){
			document.getElementById('reclamoConsumoElevado').checked = false;}
			else{
				document.getElementById('reclamoConsumoElevado').checked = true;
				document.getElementById('reclamoConsumoEstimado').checked = false;
				document.getElementById('reclamoCategoriaErrada').checked = false;
				document.getElementById('reclamoCuentaErrada').checked = false;
				document.getElementById('reclamoFacturaErrada').checked = false;
				document.getElementById('reclamoRubroErrado').checked = false;
				document.getElementById('reclamoTerceraEdad').checked = false;
				document.getElementById('reclamoDiscapacidad').checked = false;
			}
		}
		if (num ==2){
			if (document.getElementById('reclamoConsumoEstimado').checked==false){
			document.getElementById('reclamoConsumoEstimado').checked = false;}
			else{
				document.getElementById('reclamoConsumoEstimado').checked = true;
				document.getElementById('reclamoConsumoElevado').checked = false;
				document.getElementById('reclamoCategoriaErrada').checked = false;
				document.getElementById('reclamoCuentaErrada').checked = false;
				document.getElementById('reclamoFacturaErrada').checked = false;
				document.getElementById('reclamoRubroErrado').checked = false;
				document.getElementById('reclamoTerceraEdad').checked = false;
				document.getElementById('reclamoDiscapacidad').checked = false;
			}
		}
		if (num ==3){
			if (document.getElementById('reclamoCategoriaErrada').checked==false){
			document.getElementById('reclamoCategoriaErrada').checked = false;}
			else{
				document.getElementById('reclamoCategoriaErrada').checked = true;
				document.getElementById('reclamoConsumoElevado').checked = false;
				document.getElementById('reclamoConsumoEstimado').checked = false;
				document.getElementById('reclamoCuentaErrada').checked = false;
				document.getElementById('reclamoFacturaErrada').checked = false;
				document.getElementById('reclamoRubroErrado').checked = false;
				document.getElementById('reclamoTerceraEdad').checked = false;
				document.getElementById('reclamoDiscapacidad').checked = false;
			}
		}
		if (num ==4){
			if (document.getElementById('reclamoCuentaErrada').checked==false){
			document.getElementById('reclamoCuentaErrada').checked = false;}
			else{
				document.getElementById('reclamoCuentaErrada').checked = true;
				document.getElementById('reclamoConsumoElevado').checked = false;
				document.getElementById('reclamoConsumoEstimado').checked = false;
				document.getElementById('reclamoCategoriaErrada').checked = false;
				document.getElementById('reclamoFacturaErrada').checked = false;
				document.getElementById('reclamoRubroErrado').checked = false;
				document.getElementById('reclamoTerceraEdad').checked = false;
				document.getElementById('reclamoDiscapacidad').checked = false;
			}
		}
		if (num ==5){
			if (document.getElementById('reclamoFacturaErrada').checked==false){
			document.getElementById('reclamoFacturaErrada').checked = false;}
			else{
				document.getElementById('reclamoFacturaErrada').checked = true;
				document.getElementById('reclamoConsumoElevado').checked = false;
				document.getElementById('reclamoConsumoEstimado').checked = false;
				document.getElementById('reclamoCategoriaErrada').checked = false;
				document.getElementById('reclamoCuentaErrada').checked = false;
				document.getElementById('reclamoRubroErrado').checked = false;
				document.getElementById('reclamoTerceraEdad').checked = false;
				document.getElementById('reclamoDiscapacidad').checked = false;
			}
		}
		if (num ==6){
			if (document.getElementById('reclamoRubroErrado').checked==false){
			document.getElementById('reclamoRubroErrado').checked = false;}
			else{
				document.getElementById('reclamoRubroErrado').checked = true;
				document.getElementById('reclamoConsumoElevado').checked = false;
				document.getElementById('reclamoConsumoEstimado').checked = false;
				document.getElementById('reclamoCategoriaErrada').checked = false;
				document.getElementById('reclamoCuentaErrada').checked = false;
				document.getElementById('reclamoFacturaErrada').checked = false;
				document.getElementById('reclamoTerceraEdad').checked = false;
				document.getElementById('reclamoDiscapacidad').checked = false;
			}
		}
		if (num ==7){
			if (document.getElementById('reclamoTerceraEdad').checked==false){
			document.getElementById('reclamoTerceraEdad').checked = false;}
			else{
				document.getElementById('reclamoTerceraEdad').checked = true;
				document.getElementById('reclamoConsumoElevado').checked = false;
				document.getElementById('reclamoConsumoEstimado').checked = false;
				document.getElementById('reclamoCategoriaErrada').checked = false;
				document.getElementById('reclamoCuentaErrada').checked = false;
				document.getElementById('reclamoFacturaErrada').checked = false;
				document.getElementById('reclamoRubroErrado').checked = false;
				document.getElementById('reclamoDiscapacidad').checked = false;
			}
		}
		if (num ==8){
			if (document.getElementById('reclamoDiscapacidad').checked==false){
			document.getElementById('reclamoDiscapacidad').checked = false;}
			else{
				document.getElementById('reclamoDiscapacidad').checked = true;
				document.getElementById('reclamoConsumoElevado').checked = false;
				document.getElementById('reclamoConsumoEstimado').checked = false;
				document.getElementById('reclamoCategoriaErrada').checked = false;
				document.getElementById('reclamoCuentaErrada').checked = false;
				document.getElementById('reclamoFacturaErrada').checked = false;
				document.getElementById('reclamoRubroErrado').checked = false;
				document.getElementById('reclamoTerceraEdad').checked = false;
			}
		}
	}

	/*FUNCIONES LLENADO*/
	function Padder(len, pad) {
	  if (len === undefined) {
		len = 1;
	  } else if (pad === undefined) {
		pad = '0';
	  }

	  var pads = '';
	  while (pads.length < len) {
		pads += pad;
	  }

	  this.pad = function (what) {
		var s = what.toString();
		return pads.substring(0, pads.length - s.length) + s;
	  };
	}
	
	function habilitaCampos(){
		if (document.getElementById('tipoSolicitud').value == 1)
		   {if (document.getElementById('beneficio').innerHTML != '')
			   {parent.infoAlert('La cuenta seleccionada cuenta una solicitud activa: '+document.getElementById('beneficio').innerHTML+'. Al ingresar una nueva solicitud se inactivará la anterior.');}
		   }
		if (document.getElementById('tipoSolicitud').value == 2)
		   {if (document.getElementById('beneficio').innerHTML != '')
			   {parent.infoAlert('La cuenta seleccionada cuenta una solicitud activa: '+document.getElementById('beneficio').innerHTML+'. Al ingresar una nueva solicitud se inactivará la anterior.');}
			var cmbTipoIdentificacion=new componente.cmb
			cmbTipoIdentificacion.ini('tipoIdentificacionBeneficiario')			
			cmbTipoIdentificacion.loadFromUrl('../../../../lib/cmb/cmbTipoIdentificacion.php');
			$.datetimepicker.setLocale('es');
			$('#fechaNacimientoBen').datetimepicker({
				dayOfWeekStart : 1,
				timepicker:false,
				format:'d/m/Y',
				formatDate:'Y/mm/d'
			});
			
			
			document.getElementById('benefOBJ').style.display = 'block';
	        document.getElementById('benefTXT').style.display = 'block';
			document.getElementById('tableInformacionDiscp').style.display = 'block';
			document.getElementById('divPopUpSolicitud').style.width = '1000px';
			document.getElementById('divPopUpSolicitud').style.height = '495px';
			document.getElementById('divPopUpSolicitud').style.backgroundSize = '1000px 495px';
			}
		else
		   {document.getElementById('benefOBJ').style.display = 'none';
	        document.getElementById('benefTXT').style.display = 'none';
			document.getElementById('tableInformacionDiscp').style.display = 'none';
			document.getElementById('divPopUpSolicitud').style.width = '830px';
			document.getElementById('divPopUpSolicitud').style.height = '440px';
			document.getElementById('divPopUpSolicitud').style.backgroundSize = '830px 440px';}
	}
	
	function cerrarVentanaFactura(){
			document.getElementById('myPopupFactura').style.display = 'none';
		}
	
	function cerrarVentanaPago(){
			document.getElementById('myPopupPago').style.display = 'none';
		}
	
	function cerrarVentanaNC(){
			document.getElementById('myPopupNC').style.display = 'none';
		}
	
	function abrirVentanaConvenio(){
			if(document.getElementById('numeroCuenta').innerHTML != '')
			  {if(document.getElementById('idconvenio').innerHTML == '')
			     {document.getElementById('fechaPagoConvenio').innerHTML= '';
				  document.getElementById('montoPagoConvenio').innerHTML= 0.00;
				  document.getElementById('formaPagoConvenio').innerHTML= '';
				  document.getElementById('nroPagoConvenio').value= '';
				  document.getElementById('anticipoPorcentajeConvenio').value= '';
				  document.getElementById('porcentajeInteresConvenio').value= '';
				  document.getElementById('capitalConvenioDeuda').value= '';
				  document.getElementById('porcentajeLimiteAnticipo').value= '';
				  document.getElementById('cuotaLimiteConvenio').value= '';
				  document.getElementById('interesConvenioDeuda').value= '';
				  document.getElementById('totalConvenioDeuda').value= '';
				  document.getElementById('totalConvenioDeuda2').value= '';
				  document.getElementById('valorInteresConvenio').value= '';
                  document.getElementById('montoConvenioFinal').value= '';
				  document.getElementById('montoCuotaConvenioFinal').value= '';
					totalRegT = document.getElementById("tableRubrosConvenios").rows.length;
					for (var i=0;i < totalRegT; i++) {
					   document.getElementById("tableRubrosConvenios").deleteRow(0);
					}
				  document.getElementById('myPopupConvenio').style.display = 'block';}
			  }
		}
	
	function abrirVentanaSConvenio(){
			if(document.getElementById('numeroCuenta').innerHTML != '')
			  {if(document.getElementById('idconvenio').innerHTML == '')
			     {document.getElementById('montoPagoSimulador').value= '';
			      document.getElementById('anticipoPorcentajeConvenioS').innerHTML= '0.00';
				  document.getElementById('porcentajeInteresConvenio').innerHTML= '0.00';
				  document.getElementById('capitalConvenioS').innerHTML= '0.00';
				  document.getElementById('interesConvenioS').innerHTML= '0.00';
				  document.getElementById('interesGeneradoS').innerHTML= '0.00';
				  document.getElementById('deudaPendienteS').innerHTML='0.00';
				  document.getElementById('simuladorTablaConvenio').innerHTML= '';
				  enviarAjax("POST","../../../../lib/php/informacionParametrosConvenio.php", {id: 1}, llenarInformacionSConvenioParametros);
				  document.getElementById('myPopupSConvenio').style.display = 'block';}
			  }
		}
	
	function cerrarVentanaConvenio(){
			document.getElementById('myPopupConvenio').style.display = 'none';
		}
	
	function cerrarVentanaSConvenio(){
			document.getElementById('myPopupSConvenio').style.display = 'none';
		}
	
	function abrirVentanaServicios(){
		if(document.getElementById('numeroCuenta').innerHTML != '')
		  {
			document.getElementById('tipoServicio').value = 0;
			document.getElementById('costoServicio').innerHTML = '0.00 USD.';
			parent.infoAlert('Recuerde que estos servicios son facturados al abonado y deberá cancelarlos en la ventanilla de recaudación para poder obtenerlo.')
			document.getElementById('myPopupServicios').style.display = 'block';
		  }
	}
	
	function cerrarVentanaServicios(){
		document.getElementById('myPopupServicios').style.display = 'none';
	}
	
	function abrirVentanaReclamos(){
			if(document.getElementById('numeroCuenta').innerHTML != '')
			  {
				if (document.getElementById('idcobranza').innerHTML == 'ATP' ||
				    document.getElementById('idcobranza').innerHTML == 'MDC' ||
					document.getElementById('idcobranza').innerHTML == 'LIQ'){
						parent.errorAlert('La cuenta seleccionada no puede registrar un reclamo administrativo, debido a que la etapa de gestión coactiva se encuentra avanzada. Por favor acercarse al módulo de coactiva para solucionar el inconveniente.');
						
					}else{  document.getElementById('reclamoConsumoElevado').checked = false;
							document.getElementById('reclamoConsumoEstimado').checked = false;
							document.getElementById('reclamoCategoriaErrada').checked = false;
							document.getElementById('reclamoCuentaErrada').checked = false;
							document.getElementById('reclamoFacturaErrada').checked = false;
							document.getElementById('reclamoRubroErrado').checked = false;
							document.getElementById('reclamoTerceraEdad').checked = false;
							document.getElementById('reclamoDiscapacidad').checked = false;
							document.getElementById('textReclamo').value = '';
							document.getElementById('myPopupReclamo').style.display = 'block';
					}		
			  }
		}
	
	function consultarTarifa(){
		cuenta = document.getElementById('numeroCuenta').innerHTML;
		servicio = document.getElementById('tipoServicio').value;
		url = '../../../../lib/php/consultaTarifaFijaRubro.php';
		$.ajax({
			type:'POST',
			url:url,
			data:'cuenta='+cuenta+'&servicio='+servicio,
			success:function(data){
				var array = eval(data);
				if (array[0] == '1'){
				    document.getElementById('costoServicio').innerHTML = array[1]+ ' USD.';}
				else{parent.errorAlert('Se ha presentado un inconveniente con la Tarifa del Servicio. Por favor cominiquese con el Administrador.');}
				  
			}
		});
	} 
	
	function abrirContacto(){
		if(document.getElementById('numeroCuenta').innerHTML != ''){
			var url = '../../../../lib/php/retornaContactosCliente.php';
			$.ajax({
				type:'POST',
				url:url,
				data:'cuentaServicio='+document.getElementById('numeroCuenta').innerHTML,
				success:function(data){
					var resp = eval(data);
						document.getElementById('telefonoPrincipal').value = resp[0].t1;
						document.getElementById('telefonoAlternativo').value = resp[0].t2;
						document.getElementById('emailPrincipal').value = resp[0].e1;
						document.getElementById('emailAlternativo').value = resp[0].e2;
				}
			});
			document.getElementById('myContactoCliente').style.display = 'block';
		   }	
	}
	
	function abrirFacturaExtraOrdinaria(){
		document.getElementById('myFacturaExtraOrdinaria').style.display = 'block';
	}
	
	
	function abrirVentanaSolicitud(){
			if(document.getElementById('numeroCuenta').innerHTML != '')
			  {
				document.getElementById('tipoSolicitud').value = 0;
				document.getElementById('benefOBJ').style.display = 'none';
			    document.getElementById('benefTXT').style.display = 'none';
				document.getElementById('tableInformacionDiscp').style.display = 'none';
				document.getElementById('divPopUpSolicitud').style.width = '830px';
				document.getElementById('divPopUpSolicitud').style.height = '435px';
				document.getElementById('divPopUpSolicitud').style.backgroundSize = '830px 435px';
				document.getElementById('textSolicitud').value = '';
				document.getElementById('tipoIdentificacionBeneficiario').value = 0;
				document.getElementById('tipoDiscapacidadBeneficiario').value = 0;
				document.getElementById('parentescoDiscapacidad').value = 0;
				document.getElementById('numeroIdentificacionBeneficiario').value = '';
				document.getElementById('textNombrebeneficiario').value = '';
				document.getElementById('porcentajeDiscapacidad').value = '';
				document.getElementById('carnetCONADIS').value = '';
				document.getElementById('generoBeneficiario').value = 0;
				document.getElementById('fechaNacimientoBen').value = '';
				
				document.getElementById('myPopupSolicitud').style.display = 'block';
			  }
		}	
	
	function cerrarVentanaReclamo(){
			document.getElementById('myPopupReclamo').style.display = 'none';
		}
	
	function cerrarVentanaSolicitud(){
			document.getElementById('myPopupSolicitud').style.display = 'none';
		}
		
	function cerrarVentanaContacto(){
			document.getElementById('myContactoCliente').style.display = 'none';
		}	
	
	function cerrarVentanaFacturacion(){
			document.getElementById('myFacturaExtraOrdinaria').style.display = 'none';
		}
	
	function registraSolicitudServicio(e){
		if (resp[0].id != -1){	
			var resp=eval(e);
			var date = new Date();
			var servicio = document.getElementById('tipoServicio').value;
			var costo = document.getElementById('costoServicio').innerHTML;
			var identificacion = document.getElementById('identificacion').innerHTML;
			var nombreC = document.getElementById('nombreC').innerHTML;
			enviarAjax("GET",
					   "../../../../lib/php/insertasServicioCliente.php", 
					   {idtramite: resp[0].id,
						cuentaservicio: resp[0].cuenta,
						numeroIdentificacion: identificacion,
						nombreCliente: nombreC,
						tipoServicio: servicio,
						descripcionServicio: 'Servicio Administrativo Generada Correctamente. '+"\n\n"+'Fecha Generación: '+date.toLocaleString()+"\n"+'Costo Emisión: '+costo});
			
			document.getElementById('tipoServicio').value = 0;
			document.getElementById('costoServicio').innerHTML = '0.00 USD';			
		}else{parent.errorAlert('Su sessión activa, ha caducado. Por favor ingrese nuevamente.');
		      window.top.document.getElementById('load').style.display = 'none';}
	}
	
	function ejecutaFacturacionServicio(){
		window.top.document.getElementById('load').style.display = 'block';
		
		var url = "../../../../lib/php/ejecutarFacturacionIndividual.php";
		var cuenta = document.getElementById('numeroCuenta').innerHTML;
		var servicio = document.getElementById('tipoServicio').value;
		var numIdent = document.getElementById('identificacion').innerHTML;
		
		if (servicio == 12){
			if (document.getElementById('ttotal').innerHTML > 0){
				parent.errorAlert('Para emitir un certificado de no adeudar el abonado no debe tener valores pendientes con la Empresa.');
				window.top.document.getElementById('load').style.display = 'none';
				document.getElementById('myPopupServicios').style.display = 'none';
				return;
			}
		}
		$.ajax({
			type:'POST',
			url:url,
			data:'cuenta='+cuenta+'&servicio='+servicio+'&identificacion='+numIdent,
			success:function(data){
				var array = eval(data);
				if (array[0] == 0){
					parent.successAlert('Servicio Administrativo',array[1]);
					informacionBusqueda(cuenta);
					idFlujo = 9;
					enviarAjax("GET","../../../../lib/php/insertaTramitesNuevos.php", {idflujo:idFlujo,cuentaservicio:cuenta},registraSolicitudServicio); 
					document.getElementById('myPopupServicios').style.display = 'none';
					window.top.document.getElementById('load').style.display = 'none';
				}else{parent.errorAlert(array[1]);
				      window.top.document.getElementById('load').style.display = 'none';}
			}
		});
	}
	
	function mostrarInformacionBusqueda(e){	
		var informacionBusqueda = e;
		totalRegT = document.getElementById("tableBusqueda").rows.length;
		for (var i=0;i < totalRegT; i++) {
		   document.getElementById("tableBusqueda").deleteRow(0);
		}
		X=0;
		var table = document.getElementById("tableBusqueda").getElementsByTagName('tbody')[0];
		for(var i in informacionBusqueda)
			{				
				var row = table.insertRow(0);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				var cell3 = row.insertCell(2);
				
				cell1.innerHTML = informacionBusqueda[i].numero_identificacion;
				if (i%2==0)
					{cell1.className = "estiloTI";
					 cell2.className = "estiloTI";
					 cell3.className = "estiloTI";}
				else
					{cell1.className = "estiloTI2";
					 cell2.className = "estiloTI2";
					 cell3.className = "estiloTI2";}
				cell1.innerHTML = informacionBusqueda[i].numero_identificacion;
				cell2.innerHTML = informacionBusqueda[i].nombre_ciudadano;
				X=1;
				cell3.innerHTML = '<img src="../images/icons/anadirICON.png" '+ 
								    'onClick="informacionBusqueda('+informacionBusqueda[i].id_cliente+');" '+
									  'width="25px" alt=""/>';	
			}
				if (X==0)
					{parent.errorAlert('Lamentamos que tenga inconvenientes, la información solicitada no está disponible. '+
									    'Verifique y vuela a intentar.');
					 
			    //window.top.document.getElementById('load').style.display = 'none';
				}
				var row = table.insertRow(0);
				row.className = "estilo2";
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
		        //var cell3 = row.insertCell(2); 
				cell2.setAttribute( 'colspan', '2' );
				cell1.innerHTML = '<span style="width: 20%; text-align: center;"> CI/RUC </span>';
				cell2.innerHTML = '<span style="width: 80%; text-align: left;"> Nombres </span>';
				
				//window.top.document.getElementById('load').style.display = 'none';
		}
	
	function llenarEvolucionC (e){
		var informacionCliente = e;
		var informacionCliente2 = e;
		j=1;
		maxC=0;
		for(var i in informacionCliente)
			{
				document.getElementById('etiqueta'+j+'g').innerHTML = informacionCliente[i].consumo_facturado;
				document.getElementById('etiquetaT'+j+'g').innerHTML = informacionCliente[i].tipo_consumo_facturado;
				document.getElementById('etiquetaS'+j+'g').innerHTML = informacionCliente[i].periodo;
				if (maxC < parseInt(informacionCliente[i].consumo_facturado))
					{maxC = informacionCliente[i].consumo_facturado;}
				j++;
			}
		j=1;
		for(var i in informacionCliente2)
			{
				document.getElementById('barrra'+j+'g').style.height = informacionCliente[i].consumo_facturado/maxC*100+'px';
				j++;
			}	
	}
	
	function llenarInformacionRubrosFactura (e){
		var informacionCliente = e;
		document.getElementById('myPopupFactura').style.display = 'block';
		totalRegT = document.getElementById("tableRubrosFactura").rows.length;
		for (var i=0;i < totalRegT; i++) {
		   document.getElementById("tableRubrosFactura").deleteRow(0);
			}
		subtotal	= 0;
		descuento	= 0;
		total		= 0;
		var table = document.getElementById("tableRubrosFactura").getElementsByTagName('tbody')[0];
		for(var i in informacionCliente)
			{   var row = table.insertRow(0);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				var cell3 = row.insertCell(2);
				var cell4 = row.insertCell(3);
				var cell5 = row.insertCell(4);
				var cell6 = row.insertCell(5);
				
				if (i%2!=0)
					{cell1.style.width = '170px'; cell1.style.height='15px'; cell1.style.background = '#CEE3F6'; cell1.style.textAlign = 'left';
					 cell2.style.width = '50px';  cell2.style.height='15px'; cell2.style.background = '#CEE3F6'; cell2.style.textAlign = 'right';
					 cell3.style.width = '50px';  cell3.style.height='15px'; cell3.style.background = '#CEE3F6'; cell3.style.textAlign = 'right';
					 cell4.style.width = '60px';  cell4.style.height='15px'; cell4.style.background = '#CEE3F6'; cell4.style.textAlign = 'right';
					 cell5.style.width = '50px';  cell5.style.height='15px'; cell5.style.background = '#CEE3F6'; cell5.style.textAlign = 'right';
					 cell6.style.width = '50px';  cell6.style.height='15px'; cell6.style.background = '#CEE3F6'; cell6.style.textAlign = 'right';}
				else
					{cell1.style.width = '170px';cell1.style.height='15px'; cell1.style.background = '#FFF'; cell1.style.textAlign = 'left';
					 cell2.style.width = '50px'; cell2.style.height='15px'; cell2.style.background = '#FFF'; cell2.style.textAlign = 'right';
					 cell3.style.width = '50px'; cell3.style.height='15px'; cell3.style.background = '#FFF'; cell3.style.textAlign = 'right';
					 cell4.style.width = '60px'; cell4.style.height='15px'; cell4.style.background = '#FFF'; cell4.style.textAlign = 'right';
					 cell5.style.width = '50px'; cell5.style.height='15px'; cell5.style.background = '#FFF'; cell5.style.textAlign = 'right';
					 cell6.style.width = '50px'; cell6.style.height='15px'; cell6.style.background = '#FFF'; cell6.style.textAlign = 'right';}
				
				cell1.innerHTML = informacionCliente[i].rubro;
				cell2.innerHTML = parseFloat(informacionCliente[i].precio_venta).toFixed(2);
				cell3.innerHTML = parseFloat(informacionCliente[i].cantidad).toFixed(2);
				cell4.innerHTML = parseFloat(informacionCliente[i].subtotal).toFixed(2);
				cell5.innerHTML = parseFloat(informacionCliente[i].descuento).toFixed(2);
				cell6.innerHTML = parseFloat(informacionCliente[i].total).toFixed(2);
				
				subtotal	= parseFloat(subtotal)  + parseFloat(informacionCliente[i].subtotal);
				descuento	= parseFloat(descuento) + parseFloat(informacionCliente[i].descuento.replace(',', '.'));
				total		= parseFloat(total)		+ parseFloat(informacionCliente[i].total.replace(',', '.'));
				
				var row = table.insertRow(0);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				var cell3 = row.insertCell(2);
				var cell4 = row.insertCell(3);
				var cell5 = row.insertCell(4);
				var cell6 = row.insertCell(5);
				
				document.getElementById('nroFacturaIndividual').innerHTML = informacionCliente[i].numero_factura;
				document.getElementById('emisionFacturaIndividual').innerHTML = informacionCliente[i].fecha;	
			}
			
			document.getElementById('tfSubtotal').innerHTML		= parseFloat(subtotal).toFixed(2);
			document.getElementById('tfDescuento').innerHTML	= parseFloat(descuento).toFixed(2);
			document.getElementById('tfTotal').innerHTML		= parseFloat(total).toFixed(2);
			
		}
		
	function formularioPago(id,numero,fecha,monto,saldo){
		document.getElementById('myPopupPago').style.display = 'block';
		
		document.getElementById('idFacturaPago').innerHTML 			= id;
		document.getElementById('nroFacturaPago').innerHTML 		= numero;
		document.getElementById('fechaEmisionFactura').innerHTML 	= fecha;
		document.getElementById('montoEmisionFactura').innerHTML 	= monto;
		document.getElementById('saldoPendienteFactura').innerHTML 	= saldo;
		
		var cmbFormasPago = new componente.cmb; 
			cmbFormasPago.ini('formasPagoFactura');
			cmbFormasPago.loadFromUrlAd('../cmb/cmbTscFormasPago.php');
		
		document.getElementById('valorPagoFactura').value = '0.00';
	}	
	
	function guardarPagoFactura(){
		idFac = document.getElementById('idFacturaPago').innerHTML;
		saldo = document.getElementById('saldoPendienteFactura').innerHTML;
		monto = document.getElementById('montoEmisionFactura').innerHTML;
		pago  = document.getElementById('valorPagoFactura').value;
		fpago = document.getElementById('formasPagoFactura').value;
		if (pago > saldo){
			parent.modalAlertPrincipal(1,'MarketSys [Error]', 
										 'El monto de pago no puede ser mayor que el saldo disponible de la factura.', 0, 
										 'Aceptar', '');
			return;
		}
		if (fpago == 0){
			parent.modalAlertPrincipal(1,'MarketSys [Error]', 
										 'Debe seleccionar una forma de pago, por favor elija una opción.', 0, 
										 'Aceptar', '');
			return;
		}
		
		var url = '../php/registraPagoFactura.php';
			$.ajax({
				type:'POST',
				url:url,
				async: false,
				data:'idfactura='+idFac+'&pago='+pago+'&fpago='+fpago+'&saldo='+saldo+'&monto='+monto,
				success:function(data){
					document.getElementById('myPopupPago').style.display = 'none';
					informacionBusqueda(document.getElementById('idCliente').innerHTML);
					parent.modalAlertPrincipal(3, 'MarketSys [Transacción Éxitosa]', 
												   'Su factura ha sido registrada de manera correcta.', 0, 
												   'Aceptar', '');

				}
			});
		
		
		
	}
	
	function formatearCampo(item){
		var num = item.value;
			num = parseFloat(num);
			item.value = num.toFixed(2);
	}
	
	function filterFloat(evt,input){
		// Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
		var key = window.Event ? evt.which : evt.keyCode;    
		var chark = String.fromCharCode(key);
		var tempValue = input.value+chark;
		if(key >= 48 && key <= 57){
			if(filter(tempValue)=== false){
				return false;
			}else{       
				return true;
			}
		}else{
			  if(key == 8 || key == 13 || key == 0) {     
				  return true;              
			  }else if(key == 46){
					if(filter(tempValue)=== false){
						return false;
					}else{       
						return true;
					}
			  }else{
				  return false;
			  }
		}
	}
	function filter(__val__){
		var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
		if(preg.test(__val__) === true){
			return true;
		}else{
		   return false;
		}

	}
	
	function llenarInformacionAfectacionFactura (e){
		var informacionCliente = e;
		document.getElementById('myPopupPago').style.display = 'block';
		totalRegT = document.getElementById("tableAfectacionFactura").rows.length;
		for (var i=0;i < totalRegT; i++) {
		   document.getElementById("tableAfectacionFactura").deleteRow(0);
			}
		emision=0;
		vencido=0;
		var table = document.getElementById("tableAfectacionFactura").getElementsByTagName('tbody')[0];
		for(var i in informacionCliente)
			{   var row = table.insertRow(0);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				var cell3 = row.insertCell(2);
				var cell4 = row.insertCell(3);
				var cell5 = row.insertCell(4);
				
				if (i%2!=0)
					{cell1.style.width = '60px'; cell1.style.height='15px'; cell1.style.background = '#CEE3F6'; cell1.style.textAlign = 'left';
					 cell2.style.width = '80px';  cell2.style.height='15px'; cell2.style.background = '#CEE3F6'; cell2.style.textAlign = 'right';
					 cell3.style.width = '55px';  cell3.style.height='15px'; cell3.style.background = '#CEE3F6'; cell3.style.textAlign = 'right';
					 cell4.style.width = '70px';  cell4.style.height='15px'; cell4.style.background = '#CEE3F6'; cell4.style.textAlign = 'right';
					 cell5.style.width = '85px';  cell5.style.height='15px'; cell5.style.background = '#CEE3F6'; cell5.style.textAlign = 'right';}
				else
					{cell1.style.width = '60px';cell1.style.height='15px'; cell1.style.background = '#FFF'; cell1.style.textAlign = 'left';
					 cell2.style.width = '80px'; cell2.style.height='15px'; cell2.style.background = '#FFF'; cell2.style.textAlign = 'right';
					 cell3.style.width = '55px'; cell3.style.height='15px'; cell3.style.background = '#FFF'; cell3.style.textAlign = 'right';
					 cell4.style.width = '70px'; cell4.style.height='15px'; cell4.style.background = '#FFF'; cell4.style.textAlign = 'right';
					 cell5.style.width = '85px'; cell5.style.height='15px'; cell5.style.background = '#FFF'; cell5.style.textAlign = 'right';}
					 
				cell1.innerHTML = informacionCliente[i].id_factura;
				cell2.innerHTML = informacionCliente[i].fecha_emision;
				cell3.innerHTML = informacionCliente[i].monto_total;
				cell4.innerHTML = informacionCliente[i].sum;
				cell5.innerHTML = informacionCliente[i].fecha_afectacion;
				
				emision = emision + parseFloat(informacionCliente[i].monto_total.replace(',', '.'));
				vencido = vencido + parseFloat(informacionCliente[i].sum.replace(',', '.'));
				
				var row = table.insertRow(0);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				var cell3 = row.insertCell(2);
				var cell4 = row.insertCell(2);
				var cell5 = row.insertCell(2);
				
				document.getElementById('nroPagoIndividual').innerHTML = informacionCliente[i].id_pago;
				document.getElementById('fechaPagoIndividual').innerHTML = informacionCliente[i].fecha_afectacion;	
			}
			document.getElementById('tfacemision').innerHTML=emision.toFixed(2);
			document.getElementById('tafecFactura').innerHTML=vencido.toFixed(2);
	}
	
	
	function llenarInformacionAfectacionFacturaNC (e){
		var informacionCliente = e;
		document.getElementById('myPopupNC').style.display = 'block';
		totalRegT = document.getElementById("tableAfectacionFacturaNC").rows.length;
		for (var i=0;i < totalRegT; i++) {
		   document.getElementById("tableAfectacionFacturaNC").deleteRow(0);
			}
		emision=0;
		vencido=0;
		var table = document.getElementById("tableAfectacionFacturaNC").getElementsByTagName('tbody')[0];
		for(var i in informacionCliente)
			{   var row = table.insertRow(0);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				var cell3 = row.insertCell(2);
				var cell4 = row.insertCell(3);
				var cell5 = row.insertCell(4);
				
				if (i%2!=0)
					{cell1.style.width = '60px'; cell1.style.height='15px'; cell1.style.background = '#CEE3F6'; cell1.style.textAlign = 'left';
					 cell2.style.width = '80px';  cell2.style.height='15px'; cell2.style.background = '#CEE3F6'; cell2.style.textAlign = 'right';
					 cell3.style.width = '55px';  cell3.style.height='15px'; cell3.style.background = '#CEE3F6'; cell3.style.textAlign = 'right';
					 cell4.style.width = '70px';  cell4.style.height='15px'; cell4.style.background = '#CEE3F6'; cell4.style.textAlign = 'right';
					 cell5.style.width = '85px';  cell5.style.height='15px'; cell5.style.background = '#CEE3F6'; cell5.style.textAlign = 'right';}
				else
					{cell1.style.width = '60px';cell1.style.height='15px'; cell1.style.background = '#FFF'; cell1.style.textAlign = 'left';
					 cell2.style.width = '80px'; cell2.style.height='15px'; cell2.style.background = '#FFF'; cell2.style.textAlign = 'right';
					 cell3.style.width = '55px'; cell3.style.height='15px'; cell3.style.background = '#FFF'; cell3.style.textAlign = 'right';
					 cell4.style.width = '70px'; cell4.style.height='15px'; cell4.style.background = '#FFF'; cell4.style.textAlign = 'right';
					 cell5.style.width = '85px'; cell5.style.height='15px'; cell5.style.background = '#FFF'; cell5.style.textAlign = 'right';}
					 
				cell1.innerHTML = informacionCliente[i].id_factura;
				cell2.innerHTML = informacionCliente[i].fecha_emision;
				cell3.innerHTML = informacionCliente[i].monto_total;
				cell4.innerHTML = informacionCliente[i].sum;
				cell5.innerHTML = informacionCliente[i].fecha_afectacion;
				
				emision = emision + parseFloat(informacionCliente[i].monto_total.replace(',', '.'));
				vencido = vencido + parseFloat(informacionCliente[i].sum.replace(',', '.'));
				
				var row = table.insertRow(0);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				var cell3 = row.insertCell(2);
				var cell4 = row.insertCell(2);
				var cell5 = row.insertCell(2);
				
				document.getElementById('nroNCIndividual').innerHTML = informacionCliente[i].id_nota_credito;
				document.getElementById('fechaNCIndividual').innerHTML = informacionCliente[i].fnc;	
			}
			document.getElementById('tfacemisionNC').innerHTML=emision.toFixed(2);
			document.getElementById('tafecFacturaNC').innerHTML=vencido.toFixed(2);
	}
	
	function llenarInformacionDeuda (e){
		var informacionCliente = e;
		totalRegT = document.getElementById("tableRubros").rows.length;
		for (var i=0;i < totalRegT; i++) {
		   document.getElementById("tableRubros").deleteRow(0);
			}
		emision=0;
		vencido=0;
		total=0;
		var table = document.getElementById("tableRubros").getElementsByTagName('tbody')[0];
		for(var i in informacionCliente)
			{   var row = table.insertRow(0);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				var cell3 = row.insertCell(2);
				var cell4 = row.insertCell(3);
				
				if (i%2!=1)
					{cell1.style.width = '275px'; cell1.style.height='15px'; cell1.style.background = '#CEE3F6'; cell1.style.textAlign = 'left';
					 cell2.style.width = '62px';  cell2.style.height='15px'; cell2.style.background = '#CEE3F6'; cell2.style.textAlign = 'right';
					 cell3.style.width = '62px';  cell3.style.height='15px'; cell3.style.background = '#CEE3F6'; cell3.style.textAlign = 'right';
					 cell4.style.width = '62px';  cell4.style.height='15px'; cell4.style.background = '#CEE3F6'; cell4.style.textAlign = 'right';}
				else
					{cell1.style.width = '275px'; cell1.style.height='15px'; cell1.style.background = '#FFF'; cell1.style.textAlign = 'left';
					 cell2.style.width = '62px';  cell2.style.height='15px'; cell2.style.background = '#FFF'; cell2.style.textAlign = 'right';
					 cell3.style.width = '62px';  cell3.style.height='15px'; cell3.style.background = '#FFF'; cell3.style.textAlign = 'right';
					 cell4.style.width = '62px';  cell4.style.height='15px'; cell4.style.background = '#FFF'; cell4.style.textAlign = 'right';}
				cell1.innerHTML = informacionCliente[i].rubro;
				cell2.innerHTML = informacionCliente[i].vigente;
				emision = emision + parseFloat(informacionCliente[i].vigente.replace(',', '.'));
				cell3.innerHTML = informacionCliente[i].vencida;
				vencido = vencido + parseFloat(informacionCliente[i].vencida.replace(',', '.'));
				cell4.innerHTML = informacionCliente[i].total;
				total = total + parseFloat(informacionCliente[i].total.replace(',', '.'));
				
				var row = table.insertRow(0);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				var cell3 = row.insertCell(2);
				var cell4 = row.insertCell(3);
			}
			document.getElementById('temision').innerHTML=emision.toFixed(2);
			document.getElementById('tvencido').innerHTML=vencido.toFixed(2);
			document.getElementById('ttotal').innerHTML=total.toFixed(2);
	}
		
	function llenarInformacionConvenioPago (e){
		var informacionCliente = e;
		document.getElementById('idconvenio').innerHTML = '';
		totalRegT = document.getElementById("tableDetalleCuotas").rows.length;
		for (var i=0;i < totalRegT; i++) {
		   document.getElementById("tableDetalleCuotas").deleteRow(0);
			}
		X=0;
		var table = document.getElementById("tableDetalleCuotas").getElementsByTagName('tbody')[0];
		for(var i in informacionCliente)
			{   var row = table.insertRow(0);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				var cell3 = row.insertCell(2);
				var cell4 = row.insertCell(3);
				var cell5 = row.insertCell(4);
				
				if (i%2!=0)
					{cell1.style.width = '35px'; cell1.style.height='15px'; cell1.style.background = '#CEE3F6'; cell1.style.textAlign = 'right';
					 cell2.style.width = '70px';  cell2.style.height='15px'; cell2.style.background = '#CEE3F6'; cell2.style.textAlign = 'right';
					 cell3.style.width = '78px';  cell3.style.height='15px'; cell3.style.background = '#CEE3F6'; cell3.style.textAlign = 'right';
					 cell4.style.width = '63px';  cell4.style.height='15px'; cell4.style.background = '#CEE3F6'; cell4.style.textAlign = 'right';
					 cell5.style.width = '63px';  cell5.style.height='15px'; cell5.style.background = '#CEE3F6'; cell5.style.textAlign = 'right';}
				else
					{cell1.style.height='15px'; cell1.style.background = '#FFF'; cell1.style.textAlign = 'right';
					 cell2.style.height='15px'; cell2.style.background = '#FFF'; cell2.style.textAlign = 'right';
					 cell3.style.height='15px'; cell3.style.background = '#FFF'; cell3.style.textAlign = 'right';
					 cell4.style.height='15px'; cell4.style.background = '#FFF'; cell4.style.textAlign = 'right';
					 cell5.style.height='15px'; cell5.style.background = '#FFF'; cell5.style.textAlign = 'right';}
				
				if(X==0){
					document.getElementById('idconvenio').innerHTML=informacionCliente[i].convenio;
					document.getElementById('fechaconvenio').innerHTML=informacionCliente[i].fecha_convenio;
					document.getElementById('cuotasconvenio').innerHTML=informacionCliente[i].cuotas_convenio;
					document.getElementById('cuotasfconvenio').innerHTML=informacionCliente[i].cuotas_procesadas;
					document.getElementById('montoconvenio').innerHTML=informacionCliente[i].valor_total_convenio;
					document.getElementById('facturadoconvenio').innerHTML=informacionCliente[i].valor_facturado_convenio;
					document.getElementById('pendienteconvenio').innerHTML=informacionCliente[i].valor_pendiente_facturado;
					X=1;
				}
				
				cell1.innerHTML = informacionCliente[i].id_cuota;
				cell2.innerHTML = informacionCliente[i].valor_cuota;
				cell3.innerHTML = informacionCliente[i].fecha;
				cell4.innerHTML = informacionCliente[i].factura;
				cell5.innerHTML = informacionCliente[i].pendiente;
				
				var row = table.insertRow(0);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				var cell3 = row.insertCell(2);
				var cell4 = row.insertCell(3);
				var cell5 = row.insertCell(4);
			}
		if (X==1){
			document.getElementById('tituloDetConvenios').style.display = 'block';
		}else{
			document.getElementById('tituloDetConvenios').style.display = 'none';
		}
	}	
	
	function llenarInformacionConvenioPagoC (e){
		var informacionCliente = e;
		document.getElementById('idconvenioC').innerHTML = '';
		totalRegT = document.getElementById("tableDetalleCuotasC").rows.length;
		for (var i=0;i < totalRegT; i++) {
		   document.getElementById("tableDetalleCuotasC").deleteRow(0);
			}
		X=0;
		var table = document.getElementById("tableDetalleCuotasC").getElementsByTagName('tbody')[0];
		for(var i in informacionCliente)
			{   var row = table.insertRow(0);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				var cell3 = row.insertCell(2);
				var cell4 = row.insertCell(3);
				var cell5 = row.insertCell(4);
				var cell6 = row.insertCell(5);
				var cell7 = row.insertCell(6);
				
				if (i%2!=0)
					{cell1.style.width = '35px'; cell1.style.height='15px'; cell1.style.background = '#CEE3F6'; cell1.style.textAlign = 'right';
					 cell2.style.width = '70px';  cell2.style.height='15px'; cell2.style.background = '#CEE3F6'; cell2.style.textAlign = 'right';
					 cell3.style.width = '78px';  cell3.style.height='15px'; cell3.style.background = '#CEE3F6'; cell3.style.textAlign = 'right';
					 cell4.style.width = '63px';  cell4.style.height='15px'; cell4.style.background = '#CEE3F6'; cell4.style.textAlign = 'right';
					 cell5.style.width = '63px';  cell5.style.height='15px'; cell5.style.background = '#CEE3F6'; cell5.style.textAlign = 'right';
					 cell6.style.width = '63px';  cell6.style.height='15px'; cell6.style.background = '#CEE3F6'; cell6.style.textAlign = 'right';
					 cell7.style.width = '63px';  cell7.style.height='15px'; cell7.style.background = '#CEE3F6'; cell7.style.textAlign = 'right';}
				else
					{cell1.style.height='15px'; cell1.style.background = '#FFF'; cell1.style.textAlign = 'right';
					 cell2.style.height='15px'; cell2.style.background = '#FFF'; cell2.style.textAlign = 'right';
					 cell3.style.height='15px'; cell3.style.background = '#FFF'; cell3.style.textAlign = 'right';
					 cell4.style.height='15px'; cell4.style.background = '#FFF'; cell4.style.textAlign = 'right';
					 cell5.style.height='15px'; cell5.style.background = '#FFF'; cell5.style.textAlign = 'right';
					 cell6.style.height='15px'; cell6.style.background = '#FFF'; cell6.style.textAlign = 'right';
					 cell7.style.height='15px'; cell7.style.background = '#FFF'; cell7.style.textAlign = 'right';}
				
				if(X==0){
					document.getElementById('idconvenioC').innerHTML=informacionCliente[i].convenio;
					document.getElementById('fechaconvenioC').innerHTML=informacionCliente[i].fecha_convenio;
					document.getElementById('cuotasconvenioC').innerHTML=informacionCliente[i].cuotas_convenio;
					document.getElementById('cuotasfconvenioC').innerHTML=informacionCliente[i].cuotas_procesadas;
					document.getElementById('montoconvenioC').innerHTML=informacionCliente[i].valor_total_convenio;
					document.getElementById('facturadoconvenioC').innerHTML=informacionCliente[i].valor_facturado_convenio;
					document.getElementById('pendienteconvenioC').innerHTML=informacionCliente[i].valor_pendiente_facturado;
					document.getElementById('gestionCoactiva').innerHTML=informacionCliente[i].tgesioncoactiva;
					X=1;
				}
				
				cell1.innerHTML = informacionCliente[i].id_cuota;
				cell2.innerHTML = informacionCliente[i].valor_cuota;
				cell3.innerHTML = informacionCliente[i].cuota_sin_gestion;
				cell4.innerHTML = informacionCliente[i].cgestioncoactiva;
				cell5.innerHTML = informacionCliente[i].fecha;
				cell6.innerHTML = informacionCliente[i].factura;
				cell7.innerHTML = informacionCliente[i].pendiente;
				
				var row = table.insertRow(0);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				var cell3 = row.insertCell(2);
				var cell4 = row.insertCell(3);
				var cell5 = row.insertCell(4);
				var cell6 = row.insertCell(4);
				var cell7 = row.insertCell(4);
			}
		if (X==1){
			document.getElementById('tituloDetConveniosC').style.display = 'block';
		}else{
			document.getElementById('tituloDetConveniosC').style.display = 'none';
		}
	}
	
	function llenarInformacionTramitesVigentes(e){
		var informacionCliente = e;
		totalRegT = document.getElementById("tableTramitesVigentes").rows.length;
		for (var i=0;i < totalRegT; i++) {
		   document.getElementById("tableTramitesVigentes").deleteRow(0);
			}
		X=0;
		var table = document.getElementById("tableTramitesVigentes").getElementsByTagName('tbody')[0];
			var row = table.insertRow(0);
			var cell1 = row.insertCell(0);
			var cell2 = row.insertCell(1);
			var cell3 = row.insertCell(2);
			var cell4 = row.insertCell(3);
			var cell5 = row.insertCell(4);
			var cell6 = row.insertCell(5);
			var cell7 = row.insertCell(6);
				
				cell1.innerHTML = 'Trámite';
				cell2.innerHTML = 'Proceso';
				cell3.innerHTML = 'Tarea';
				cell4.innerHTML = 'Inicio';
				cell5.innerHTML = 'Días';
				cell6.innerHTML = 'Estado';
				cell7.innerHTML = '';
				
					cell1.className  = "estilo3";
					cell2.className  = "estilo3";
					cell3.className  = "estilo3";
					cell4.className  = "estilo3";
					cell5.className  = "estilo3";
					cell6.className  = "estilo3";
					cell7.className  = "estilo3";
					
			var n = 1;
			
		for(var i in informacionCliente)
			{   
				row = table.insertRow(n);
				cell1 = row.insertCell(0);
				cell2 = row.insertCell(1);
				cell3 = row.insertCell(2);
				cell4 = row.insertCell(3);
				cell5 = row.insertCell(4);
				cell6 = row.insertCell(5);
				cell7 = row.insertCell(6);
				
				if (i%2!=1)
					{cell1.style.background = '#CEE3F6'; cell1.style.textAlign = 'left';
					 cell2.style.background = '#CEE3F6'; cell2.style.textAlign = 'left';
					 cell3.style.background = '#CEE3F6'; cell3.style.textAlign = 'left';
					 cell4.style.background = '#CEE3F6'; cell4.style.textAlign = 'left';
					 cell5.style.background = '#CEE3F6'; cell5.style.textAlign = 'right';
					 cell6.style.background = '#CEE3F6'; cell6.style.textAlign = 'left';
					 cell7.style.background = '#CEE3F6'; cell7.style.textAlign = 'left';}
				else
					{cell1.style.background = '#FFF'; cell1.style.textAlign = 'left';
					 cell2.style.background = '#FFF'; cell2.style.textAlign = 'left';
					 cell3.style.background = '#FFF'; cell3.style.textAlign = 'left';
					 cell4.style.background = '#FFF'; cell4.style.textAlign = 'left';
					 cell5.style.background = '#FFF'; cell5.style.textAlign = 'right';
					 cell6.style.background = '#FFF'; cell6.style.textAlign = 'left';
					 cell7.style.background = '#FFF'; cell7.style.textAlign = 'left';}
				
				cell1.style.width = '60px';
				cell2.style.width = '200px';
				cell3.style.width = '200px';
				cell4.style.width = '100px';
				cell5.style.width = '20px';
				cell6.style.width = '40px';
				cell7.style.width = '20px';
				
				cell1.style.height='15px';
				cell2.style.height='15px';
				cell3.style.height='15px';
				cell4.style.height='15px';
				cell5.style.height='15px';
				cell6.style.height='15px';
				cell7.style.height='15px';
				
				cell1.innerHTML = informacionCliente[i].tramite;
				cell2.innerHTML = informacionCliente[i].proceso;
				cell3.innerHTML = informacionCliente[i].tarea;
				cell4.innerHTML = informacionCliente[i].fecha_asignacion;
				cell5.innerHTML = informacionCliente[i].dias;
				cell6.innerHTML = informacionCliente[i].estado;
				cell7.innerHTML = '<img src="../images/icons/workFlowICON.png" onClick="consultaProceso('+informacionCliente[i].id_tramite+')" width="20px"/>';
				
				n=n+1;
				X = 1;
			}
		if (X==1){
			document.getElementById('tituloDetTramitesVigentes').style.display = 'flex';
		}else{
			document.getElementById('tituloDetTramitesVigentes').style.display = 'none';
		}
	}
	
	function llenarInformacionTramitesFinalizados(e){
		var informacionCliente = e;
		totalRegT = document.getElementById("tableTramitesFinalizados").rows.length;
		for (var i=0;i < totalRegT; i++) {
		   document.getElementById("tableTramitesFinalizados").deleteRow(0);
			}
		X=0;
		var table = document.getElementById("tableTramitesFinalizados").getElementsByTagName('tbody')[0];
			var row = table.insertRow(0);
			var cell1 = row.insertCell(0);
			var cell2 = row.insertCell(1);
			var cell3 = row.insertCell(2);
			var cell4 = row.insertCell(3);
			var cell5 = row.insertCell(4);
			var cell6 = row.insertCell(5);
			var cell7 = row.insertCell(6);
				
				cell1.innerHTML = 'Trámite';
				cell2.innerHTML = 'Proceso';
				cell3.innerHTML = 'Inicio';
				cell4.innerHTML = 'Finalización';
				cell5.innerHTML = 'Días';
				cell6.innerHTML = 'Estado';
				cell7.innerHTML = '';
				
					cell1.className  = "estilo3";
					cell2.className  = "estilo3";
					cell3.className  = "estilo3";
					cell4.className  = "estilo3";
					cell5.className  = "estilo3";
					cell6.className  = "estilo3";
					cell7.className  = "estilo3";
					
			var n = 1;
			
		for(var i in informacionCliente)
			{   
				row = table.insertRow(n);
				cell1 = row.insertCell(0);
				cell2 = row.insertCell(1);
				cell3 = row.insertCell(2);
				cell4 = row.insertCell(3);
				cell5 = row.insertCell(4);
				cell6 = row.insertCell(5);
				cell7 = row.insertCell(6);
				
				if (i%2!=1)
					{cell1.style.background = '#CEE3F6'; cell1.style.textAlign = 'left';
					 cell2.style.background = '#CEE3F6'; cell2.style.textAlign = 'left';
					 cell3.style.background = '#CEE3F6'; cell3.style.textAlign = 'left';
					 cell4.style.background = '#CEE3F6'; cell4.style.textAlign = 'left';
					 cell5.style.background = '#CEE3F6'; cell5.style.textAlign = 'right';
					 cell6.style.background = '#CEE3F6'; cell6.style.textAlign = 'left';
					 cell7.style.background = '#CEE3F6'; cell7.style.textAlign = 'left';}
				else
					{cell1.style.background = '#FFF'; cell1.style.textAlign = 'left';
					 cell2.style.background = '#FFF'; cell2.style.textAlign = 'left';
					 cell3.style.background = '#FFF'; cell3.style.textAlign = 'left';
					 cell4.style.background = '#FFF'; cell4.style.textAlign = 'left';
					 cell5.style.background = '#FFF'; cell5.style.textAlign = 'right';
					 cell6.style.background = '#FFF'; cell6.style.textAlign = 'left';
					 cell7.style.background = '#FFF'; cell7.style.textAlign = 'left';}
				
				cell1.style.width = '60px';
				cell2.style.width = '200px';
				cell3.style.width = '200px';
				cell4.style.width = '100px';
				cell5.style.width = '20px';
				cell6.style.width = '40px';
				cell7.style.width = '20px';
				
				cell1.style.height='15px';
				cell2.style.height='15px';
				cell3.style.height='15px';
				cell4.style.height='15px';
				cell5.style.height='15px';
				cell6.style.height='15px';
				cell7.style.height='15px';
				
				cell1.innerHTML = informacionCliente[i].tramite;
				cell2.innerHTML = informacionCliente[i].proceso;
				cell3.innerHTML = informacionCliente[i].fecha_asignacion;
				cell4.innerHTML = informacionCliente[i].fecha_finalizacion;
				cell5.innerHTML = informacionCliente[i].dias;
				cell6.innerHTML = informacionCliente[i].estado;
				cell7.innerHTML = '<img src="../images/icons/workFlowICON.png" onClick="consultaProceso('+informacionCliente[i].id_tramite+')" width="20px"/>';
				
				n=n+1;
				X = 1;
			}
		if (X==1){
			document.getElementById('tituloDetTramitesProcesados').style.display = 'block';
		}else{
			document.getElementById('tituloDetTramitesProcesados').style.display = 'none';
		}
	}	
	
	function llenarInformacionServiciosAdministrativos(e){
		var informacionCliente = e;
		totalRegT = document.getElementById("tableServiciosAdministrativos").rows.length;
		for (var i=0;i < totalRegT; i++) {
		   document.getElementById("tableServiciosAdministrativos").deleteRow(0);
			}
		X=0;
		var table = document.getElementById("tableServiciosAdministrativos").getElementsByTagName('tbody')[0];
			var row = table.insertRow(0);
			var cell1 = row.insertCell(0);
			var cell2 = row.insertCell(1);
			var cell3 = row.insertCell(2);
			var cell4 = row.insertCell(3);
			var cell5 = row.insertCell(4);
			var cell6 = row.insertCell(5);
				
				cell1.innerHTML = 'Identificador';
				cell2.innerHTML = 'Servicio Administrativo';
				cell3.innerHTML = 'Fecha Atención';
				cell4.innerHTML = 'Usuario Atención';
				cell5.innerHTML = 'Estado';
				cell5.colSpan = 2;
				
					cell1.className  = "estilo3";
					cell2.className  = "estilo3";
					cell3.className  = "estilo3";
					cell4.className  = "estilo3";
					cell5.className  = "estilo3";
					
			var n = 1;
			
		for(var i in informacionCliente)
			{   
				row = table.insertRow(n);
				cell1 = row.insertCell(0);
				cell2 = row.insertCell(1);
				cell3 = row.insertCell(2);
				cell4 = row.insertCell(3);
				cell5 = row.insertCell(4);
				cell6 = row.insertCell(5);
				
				if (i%2!=1)
					{cell1.style.background = '#CEE3F6'; cell1.style.textAlign = 'left';
					 cell2.style.background = '#CEE3F6'; cell2.style.textAlign = 'left';
					 cell3.style.background = '#CEE3F6'; cell3.style.textAlign = 'left';
					 cell4.style.background = '#CEE3F6'; cell4.style.textAlign = 'left';
					 cell5.style.background = '#CEE3F6'; cell5.style.textAlign = 'left';
					 cell6.style.background = '#CEE3F6'; cell6.style.textAlign = 'center';}
				else
					{cell1.style.background = '#FFF'; cell1.style.textAlign = 'left';
					 cell2.style.background = '#FFF'; cell2.style.textAlign = 'left';
					 cell3.style.background = '#FFF'; cell3.style.textAlign = 'left';
					 cell4.style.background = '#FFF'; cell4.style.textAlign = 'left';
					 cell5.style.background = '#FFF'; cell5.style.textAlign = 'left';
					 cell6.style.background = '#FFF'; cell6.style.textAlign = 'center';}
				
				cell1.style.width = '60px';
				cell2.style.width = '200px';
				cell3.style.width = '140px';
				cell4.style.width = '120px';
				cell5.style.width = '140px';
				cell6.style.width = '40px';
				
				cell1.style.height='15px';
				cell2.style.height='15px';
				cell3.style.height='15px';
				cell4.style.height='15px';
				cell5.style.height='15px';
				cell6.style.height='15px';
				
				cell1.innerHTML = informacionCliente[i].nro_servicio;
				cell2.innerHTML = informacionCliente[i].servicio;
				cell3.innerHTML = informacionCliente[i].fecha;
				cell4.innerHTML = informacionCliente[i].usuario;
				cell5.innerHTML = informacionCliente[i].estado;
				cell6.innerHTML = '<img src="../../../../images/iconos/imprimirIcono.png" onClick="imprimirServicio('+informacionCliente[i].id_servicio+','+informacionCliente[i].tipo_servicio+','+informacionCliente[i].cuenta_servicio+')" width="20px"/>';
				
				n=n+1;
				X = 1;
			}
		if (X==1){
			document.getElementById('tituloServiciosAdministrativos').style.display = 'block';
		}else{
			document.getElementById('tituloServiciosAdministrativos').style.display = 'none';
		}
	}
	
	function imprimirServicio(id,tipo,cuenta){
		window.top.document.getElementById('load').style.display = 'block';
		if (document.getElementById('ttotal').innerHTML > 0 && tipo == 12){
			parent.errorAlert('Para imprimir el certificado de no adeudar el abonado no debe tener valores pendientes con la Empresa. <br>Si ha cancelado los valores pendientes por favor actualizar.');
			}else{
				window.open('../../../reports/pdf/atencionCliente/serviciosAdministrativos/pdfCertificadoServiciosAdministrativos.php?id='+id+'&tipo='+tipo+'&cuenta='+cuenta);
				informacionBusqueda (cuenta);}
		window.top.document.getElementById('load').style.display = 'none';
	}
	
	function mostrarInformacionHistorialFactura(e){	
		var informacionBusqueda = e;
		totalRegT = document.getElementById("tableFacturas").rows.length;
		for (var i=0;i < totalRegT; i++) {
			 document.getElementById("tableFacturas").deleteRow(0);
			}X=0;
		document.getElementById("tableFacturas").style.width= '100%';
		var table = document.getElementById("tableFacturas").getElementsByTagName('tbody')[0];
		var j = informacionBusqueda.length;
		var saldo = 0;
		for(var i in informacionBusqueda)
			{var row    = table.insertRow(0);
			 var cell1  = row.insertCell(0);
			 var cell2  = row.insertCell(1);
			 var cell3  = row.insertCell(2);
			 var cell4  = row.insertCell(3);
			 var cell5  = row.insertCell(4);
			 //var cell6  = row.insertCell(5);
			 var cell7  = row.insertCell(5);
			 var cell8  = row.insertCell(6);
			 var cell9  = row.insertCell(7);
			 var cell10 = row.insertCell(8);
			 var cell11 = row.insertCell(9);
			 var cell12 = row.insertCell(10);
			 var cell13 = row.insertCell(11);
			 var cell14 = row.insertCell(12);
			 var cell15 = row.insertCell(13);
			 var cell16 = row.insertCell(14);
			 
				cell1.innerHTML  = j;
				cell2.innerHTML  = informacionBusqueda[i].fecha;
				cell3.innerHTML  = informacionBusqueda[i].hora;
				cell4.innerHTML  = informacionBusqueda[i].numero_factura;
				cell5.innerHTML  = informacionBusqueda[i].estado_electronico;
				//cell6.innerHTML  = informacionBusqueda[i].descripcion;
				cell7.innerHTML  = informacionBusqueda[i].monto_subtotal;
				cell8.innerHTML  = informacionBusqueda[i].monto_descuento;
				cell9.innerHTML  = informacionBusqueda[i].monto_impuesto;
				cell10.innerHTML = informacionBusqueda[i].monto_total;
				cell11.innerHTML = informacionBusqueda[i].saldo_pendiente;
				saldo = saldo + parseFloat(informacionBusqueda[i].saldo_pendiente);
				cell12.innerHTML = informacionBusqueda[i].estado;
				cell13.innerHTML = '<img src="../images/svg/ver.svg" style="width: 20px; margin: 0px; padding: 0px;" alt="ver detalle|"/>';
				cell13.setAttribute('onclick', "informacionFacturaIndividual('"+informacionBusqueda[i].id_factura+"');")
				cell14.innerHTML = '<img src="../images/svg/xml.svg" style="width: 20px; margin: 0px; padding: 0px;" alt="descargar xml"/>';
				cell14.setAttribute('onclick', "window.open('../facturaElectronica/generados/"+informacionBusqueda[i].xml_nombre+"', '_blank');")
				cell15.innerHTML = '<img src="../images/svg/pdf.svg" style="width: 20px; margin: 0px; padding: 0px;" alt="descargar pdf"/>';
				cell15.setAttribute('onclick', "window.open('../reports/facturaPDF.php?idfactura="+informacionBusqueda[i].id_factura+"','_blank');")
				cell16.innerHTML = '<img src="../images/svg/pago.svg" style="width: 20px; margin: 0px; padding: 0px;"/ alt="pagar factura">';
				cell16.setAttribute('onclick', "formularioPago("+informacionBusqueda[i].id_factura+",'"+informacionBusqueda[i].numero_factura+"','"+informacionBusqueda[i].fecha+"','"+informacionBusqueda[i].monto_total+"','"+informacionBusqueda[i].saldo_pendiente+"');");
				j = j - 1;
				
				if(informacionBusqueda[i].estado == 'EMITIDA'){
					cell1.className  = "estiloTIM";
					cell2.className  = "estiloTIM";
					cell3.className  = "estiloTIM";
					cell4.className  = "estiloTIM";
					cell5.className  = "estiloTIM";
					//cell6.className  = "estiloTIM";
					cell7.className  = "estiloTDM";
					cell8.className  = "estiloTDM";
					cell9.className  = "estiloTDM";
					cell10.className = "estiloTDM";
					cell11.className = "estiloTDM";
					cell12.className = "estiloTIM";
					cell13.className = "estiloTDM";
					cell14.className = "estiloTDM";
					cell15.className = "estiloTDM";
					cell16.className = "estiloTDM";}
				if(informacionBusqueda[i].estado == 'ANULADA'){
					cell1.className  = "estiloTIV";
					cell2.className  = "estiloTIV";
					cell3.className  = "estiloTIV";
					cell4.className  = "estiloTIV";
					cell5.className  = "estiloTIV";
					//cell6.className  = "estiloTIV";
					cell7.className  = "estiloTDV";
					cell8.className  = "estiloTDV";
					cell9.className  = "estiloTDV";
					cell10.className = "estiloTDV";
					cell11.className = "estiloTDV";
					cell12.className = "estiloTIV";
					cell13.className = "estiloTDV";
					cell14.className = "estiloTDV";
					cell15.className = "estiloTDV";
					cell16.className = "estiloTDM";}
				if(informacionBusqueda[i].estado =='PAGADA'){
					cell1.className  = "estiloTIP";
					cell2.className  = "estiloTIP";
					cell3.className  = "estiloTIP";
					cell4.className  = "estiloTIP";
					cell5.className  = "estiloTIP";
					//cell6.className  = "estiloTIP";
					cell7.className  = "estiloTDP";
					cell8.className  = "estiloTDP";
					cell9.className  = "estiloTDP";
					cell10.className  = "estiloTDP";
					cell11.className  = "estiloTDP";
					cell12.className = "estiloTIP";
					cell13.className = "estiloTDP";
					cell14.className = "estiloTDP";
					cell15.className = "estiloTDP";
					cell16.className = "estiloTDM";}
				if(informacionBusqueda[i].estado =='ABONADA'){
					cell1.className  = "estiloTIC";
					cell2.className  = "estiloTIC";
					cell3.className  = "estiloTIC";
					cell4.className  = "estiloTIC";
					cell5.className  = "estiloTIC";
					//cell6.className  = "estiloTIC";
					cell7.className  = "estiloTDC";
					cell8.className  = "estiloTDC";
					cell9.className  = "estiloTDC";
					cell10.className = "estiloTDC";
					cell11.className = "estiloTDC";
					cell12.className = "estiloTIC";
					cell13.className = "estiloTDC";
					cell14.className = "estiloTDC";
					cell15.className = "estiloTDC";
					cell16.className = "estiloTDM";}
				if(informacionBusqueda[i].estado == 'CONVENIO'){
					cell1.className  = "estiloTIC";
					cell2.className  = "estiloTDC";
					cell3.className  = "estiloTDC";
					cell4.className  = "estiloTDC";
					cell5.className  = "estiloTDC";
					//cell6.className  = "estiloTDC";
					cell7.className  = "estiloTDC";
					cell8.className  = "estiloTDC";
					cell9.className  = "estiloTDC";
					cell10.className = "estiloTDC";
					cell11.className = "estiloTDC";
					cell12.className = "estiloTIC";
					cell13.className = "estiloTDC";
					cell14.className = "estiloTDC";
					cell15.className = "estiloTDC";
					cell16.className = "estiloTDM";}
			//row.setAttribute('onclick', "(function(){ informacionFacturaIndividual("+cell2.innerHTML+"); })()");
			X=1;
			}
		if (X==1){ 
			 var row = table.insertRow(0);
			 row.className = "estilo2";
			 var cell1  = row.insertCell(0);
			 var cell2  = row.insertCell(1);
			 var cell3  = row.insertCell(2);
			 var cell4  = row.insertCell(3);
			 //var cell5  = row.insertCell(4);
			 var cell6  = row.insertCell(4);
			 var cell7  = row.insertCell(5);
			 var cell8  = row.insertCell(6);
			 var cell9  = row.insertCell(7);
			 var cell10 = row.insertCell(8);
			 var cell11 = row.insertCell(9);
			 var cell12 = row.insertCell(10);
				
				cell1.innerHTML  = '<span style="width: 1%; text-align: center; font-size: 11px;">N </span>';
				cell2.innerHTML  = '<span style="width: 9%; text-align: center; font-size: 11px;">Emisión</span>';
				cell2.colSpan 	 = 2;
				cell3.innerHTML  = '<span style="width: 15%; text-align: center; font-size: 11px;">Factura</span>';
				cell4.innerHTML  = '<span style="width: 10%; text-align: center; font-size: 11px;">Electrónica</span>';
				//cell5.innerHTML  = '<span style="width: 15%; text-align: center; font-size: 11px;">Forma Pago</span>';
				cell6.innerHTML  = '<span style="width: 7%;  text-align: center; font-size: 11px;">Subtotal</span>';
				cell7.innerHTML  = '<span style="width: 7%;  text-align: center; font-size: 11px;">Desc</span>';
				cell8.innerHTML  = '<span style="width: 7%;  text-align: center; font-size: 11px;">IVA </span>';
				cell9.innerHTML  = '<span style="width: 7%;  text-align: center; font-size: 11px;">Total</span>';
				cell10.innerHTML = '<span style="width: 7%;  text-align: center; font-size: 11px;">Saldo</span>';
				cell11.innerHTML = '<span style="width: 5%;  text-align: center; font-size: 11px;">Estado</span>';
				cell12.innerHTML = '<span style="width: 10%; text-align: center; font-size: 11px;">Opciones</span>';
				cell12.colSpan 	 = 4;
				
				document.getElementById('saldoDeudaCliente').innerHTML = parseFloat(saldo).toFixed(2);
				document.getElementById('tituloDetFactura').style.display = 'table-row';
				document.getElementById('trFacturas').style.display = 'none';
		}else{
			document.getElementById('tituloDetFactura').style.display = 'none';
			document.getElementById('trFacturas').style.display = 'none';
		}
			
		//window.top.document.getElementById('load').style.display = 'none';
	}
		
	function mostrarInformacionHistorialPagos(e){	
		var informacionBusqueda = e;
		totalRegT = document.getElementById("tablePagos").rows.length;
		for (var i=0;i < totalRegT; i++) {
			 document.getElementById("tablePagos").deleteRow(0);
			}
		X=0;
		document.getElementById("tablePagos").style.width= '100%';
		var table = document.getElementById("tablePagos").getElementsByTagName('tbody')[0];
		
		j = informacionBusqueda.length;
		for(var i in informacionBusqueda)
			{	var row   = table.insertRow(0);
				var cell1  = row.insertCell(0);
				var cell2  = row.insertCell(1);
				var cell3  = row.insertCell(2);
				var cell4  = row.insertCell(3);
				var cell5  = row.insertCell(4);
				var cell6  = row.insertCell(5);
				var cell7  = row.insertCell(6);
				
					cell1.innerHTML  = j;
					cell2.innerHTML  = informacionBusqueda[i].pago;
					cell3.innerHTML  = informacionBusqueda[i].fecha;
					cell4.innerHTML  = informacionBusqueda[i].hora;
					cell5.innerHTML  = informacionBusqueda[i].forma_pago;
					cell6.innerHTML  = informacionBusqueda[i].numero_factura;
					cell7.innerHTML  = informacionBusqueda[i].monto_pago;
					j = j -1;
					
						cell1.className  = "estiloTDP";
						cell2.className  = "estiloTDP";
						cell3.className  = "estiloTDP";
						cell4.className  = "estiloTDP";
						cell5.className  = "estiloTIP";
						cell6.className  = "estiloTIP";
						cell7.className  = "estiloTDP";
	
				X=1;
			}
		if (X==1){
			var row = table.insertRow(0);
			row.className = "estilo2";
			var cell1  = row.insertCell(0);
			var cell2  = row.insertCell(1);
			var cell3  = row.insertCell(2);
			var cell4  = row.insertCell(3);
			var cell5  = row.insertCell(4);
			var cell6  = row.insertCell(5);
			var cell7  = row.insertCell(6);
					 
			cell1.innerHTML  = '<span style="width: 10%; text-align: center; font-size: 11px;"> N </span>';
			cell2.innerHTML  = '<span style="width: 10%; text-align: center; font-size: 11px;"> Pago </span>';
			cell3.innerHTML  = '<span style="width: 10%; text-align: center; font-size: 11px;"> Fecha </span>';
			cell4.innerHTML  = '<span style="width: 10%; text-align: center; font-size: 11px;"> Hora </span>';
			cell5.innerHTML  = '<span style="width: 10%; text-align: center; font-size: 11px;"> Forma Pago </span>';
			cell6.innerHTML  = '<span style="width: 10%; text-align: center; font-size: 11px;"> Factura </span>';
			cell7.innerHTML  = '<span style="width: 10%; text-align: center; font-size: 11px;"> Monto Pago </span>';
			
			//document.getElementById('tituloDetPagos').style.width = '800px';
			document.getElementById('tituloDetPagos').style.display = 'table-row';
			document.getElementById('trPagos').style.display = 'none';
		}else{
			document.getElementById('tituloDetPagos').style.display = 'none';
			document.getElementById('trPagos').style.display = 'none';
		}
	}	
	
	function mostrarInformacionHistorialNotasCredito(e){	
		var informacionBusqueda = e;
		totalRegT = document.getElementById("tableNotasCredito").rows.length;
		for (var i=0;i < totalRegT; i++) {
			 document.getElementById("tableNotasCredito").deleteRow(0);
			}
		X=0;
		document.getElementById("tableNotasCredito").style.width= '100%';
		var table = document.getElementById("tableNotasCredito").getElementsByTagName('tbody')[0];
		for(var i in informacionBusqueda)
			{	var row   = table.insertRow(0);
				var cell1  = row.insertCell(0);
				var cell2  = row.insertCell(1);
				var cell3  = row.insertCell(2);
				var cell4  = row.insertCell(3);
				var cell5  = row.insertCell(4);
				var cell6  = row.insertCell(5);
				var cell7  = row.insertCell(6);
				var cell8  = row.insertCell(7);
				var cell9  = row.insertCell(8);
				var cell10 = row.insertCell(9);
				var cell11 = row.insertCell(10);
					cell1.innerHTML  = informacionBusqueda[i].c9;
					cell2.innerHTML  = informacionBusqueda[i].c1;
					cell3.innerHTML  = informacionBusqueda[i].c2;
					cell4.innerHTML  = informacionBusqueda[i].c3;
					cell5.innerHTML  = informacionBusqueda[i].c4;
					cell6.innerHTML  = informacionBusqueda[i].c5;
					cell7.innerHTML  = informacionBusqueda[i].c6;
					cell8.innerHTML  = informacionBusqueda[i].c7;
					cell9.innerHTML  = informacionBusqueda[i].c8;
					cell10.innerHTML = '<img src="../../../../images/iconos/viewICON.png" onClick="informacionNCIndividual('+informacionBusqueda[i].c11+');" width="20px"/>';
					cell11.innerHTML = '<img src="../images/icons/workFlowICON.png" onClick="consultaProceso('+informacionBusqueda[i].c10+')" width="20px"/>';
					
						cell1.className  = "estiloTDP";
						cell2.className  = "estiloTDP";
						cell3.className  = "estiloTDP";
						cell4.className  = "estiloTDP";
						cell5.className  = "estiloTDP";
						cell6.className  = "estiloTIP";
						cell7.className  = "estiloTIP";
						cell8.className  = "estiloTDP";
						cell9.className  = "estiloTDP";							
				X=1;
			}
		if (X==1){
			var row = table.insertRow(0);
			row.className = "estilo2";
			var cell1  = row.insertCell(0);
			var cell2  = row.insertCell(1);
			var cell3  = row.insertCell(2);
			var cell4  = row.insertCell(3);
			var cell5  = row.insertCell(4);
			var cell6  = row.insertCell(5);
			var cell7  = row.insertCell(6);
			var cell8  = row.insertCell(7);
			var cell9  = row.insertCell(8);
			
					 
			cell1.innerHTML  = '<span style="width: 10%; text-align: center; font-size: 11px;"> Trámite </span>';
			cell2.innerHTML  = '<span style="width: 10%; text-align: center; font-size: 11px;"> NC </span>';
			cell3.innerHTML  = '<span style="width: 10%; text-align: center; font-size: 11px;"> NC SRI </span>';
			cell4.innerHTML  = '<span style="width: 10%; text-align: center; font-size: 11px;"> Fecha </span>';
			cell5.innerHTML  = '<span style="width: 10%; text-align: center; font-size: 11px;"> Hora </span>';
			cell6.innerHTML  = '<span style="width: 10%; text-align: center; font-size: 11px;"> Establecimiento </span>';
			cell7.innerHTML  = '<span style="width: 10%; text-align: center; font-size: 11px;"> Punto Emisión </span>';
			cell8.innerHTML  = '<span style="width: 10%; text-align: center; font-size: 11px;"> Monto</span>';
			cell9.innerHTML  = '<span style="width: 10%; text-align: center; font-size: 11px;"> Disponibilidad </span>';
			cell9.colSpan = 3;
			
			
			
			//document.getElementById('tituloDetNC').style.width = '800px';
			document.getElementById('tituloDetNC').style.display = 'block';
		}else{
			document.getElementById('tituloDetNC').style.display = 'none';
		}
	}
	
	function llenarInformacionAnticipoConvenio (e){
		var informacionCliente = e;
		var X=0;
		for(var i in informacionCliente)
			{   X=1;
				document.getElementById('fechaPagoConvenio').innerHTML= informacionCliente[i].fecha_pago;
				document.getElementById('montoPagoConvenio').innerHTML= informacionCliente[i].monto_pago;
				document.getElementById('formaPagoConvenio').innerHTML= informacionCliente[i].forma;
				
			}
			if(X==0){
				parent.errorAlert('El pago ingresado no corresponde a la cuenta de servicio ó ya no se encuentra vigente.');
			}
		}
	
	function llenarInformacionConvenioParametros (e){
		var informacionCliente = e;
		var cuota = 0;
		document.getElementById('numCuotasConvenio').innerHTML='';
		for(var i in informacionCliente)
			{   for(j=informacionCliente[i].cuotas_minimo;j<=informacionCliente[i].cuotas_maximo;j++){
					$('#numCuotasConvenio').append($('<option>', {
						value: j,
						text: j+' cuotas'
					}));
				}
				
				document.getElementById('porcentajeLimiteAnticipo').innerHTML = informacionCliente[i].porcentaje_anticipo_minimo_sa;
				document.getElementById('cuotaLimiteConvenio').innerHTML = informacionCliente[i].cuotas_minima_sin_autorizacion;
				document.getElementById('porcentajeInteresConvenio').innerHTML = informacionCliente[i].tasa_interes_mora_mensual;
				interes = (document.getElementById('capitalConvenioDeuda').innerHTML*informacionCliente[i].tasa_interes_mora_mensual/100);
				document.getElementById('valorInteresConvenio').innerHTML = interes.toFixed(2);
				monto = parseFloat(document.getElementById('valorInteresConvenio').innerHTML) + parseFloat(document.getElementById('capitalConvenioDeuda').innerHTML) + parseFloat(document.getElementById('interesConvenioDeuda').innerHTML);
				document.getElementById('montoConvenioFinal').innerHTML = monto.toFixed(2);
				cuota = (document.getElementById('totalConvenioDeuda').innerHTML / document.getElementById('numCuotasConvenio').value)+interes;
				document.getElementById('montoCuotaConvenioFinal').innerHTML = cuota.toFixed(2);
			}
			window.top.document.getElementById('load').style.display = 'none';
		}
	
	function llenarInformacionSConvenioParametros (e){
		var informacionCliente = e;
		var cuota = 0;
		document.getElementById('numCuotasConvenioS').innerHTML='';
		for(var i in informacionCliente)
			{   for(j=informacionCliente[i].cuotas_minimo;j<=informacionCliente[i].cuotas_maximo;j++){
					$('#numCuotasConvenioS').append($('<option>', {
						value: j,
						text: j+' cuotas'
					}));
				}
				document.getElementById('porcentajeInteresConvenio').innerHTML = informacionCliente[i].tasa_interes_mora_mensual;
			}
			window.top.document.getElementById('load').style.display = 'none';
		}
	
	
	function calculaValorCuotaConvenio(){	
		var cuota = (document.getElementById('totalConvenioDeuda').innerHTML / 
					 document.getElementById('numCuotasConvenio').value)+parseFloat(document.getElementById('valorInteresConvenio').innerHTML);
		document.getElementById('montoCuotaConvenioFinal').innerHTML = cuota.toFixed(2);
		
	}
	
	function llenarInformacionBusqueda (e){
		var informacionCliente = e;
		for(var i in informacionCliente)
			{
				document.getElementById('idCliente').innerHTML				= informacionCliente[i].id_cliente;
				document.getElementById('tipoCliente').innerHTML			= informacionCliente[i].tipo_cliente;
				document.getElementById('tipoIdentificacion').innerHTML		= informacionCliente[i].tipo_identificacion;
				document.getElementById('identificacion').innerHTML			= informacionCliente[i].numero_identificacion;
				document.getElementById('categoriaCliente').innerHTML		= informacionCliente[i].categoria_cliente;
				document.getElementById('nombreCliente').innerHTML			= informacionCliente[i].nombre_cliente;
				document.getElementById('direccionCliente').innerHTML		= informacionCliente[i].direccion;
				document.getElementById('emailCliente').innerHTML			= informacionCliente[i].correo_electronico;
				document.getElementById('telefonoCliente').innerHTML		= informacionCliente[i].telefono;
				
				parent.document.getElementById("divLoadding").style.display = 'none';
				
			}	
	}	
		
	function mensajeTransaccion(e){
		var resp=eval(e);
		console.log(resp[0].resp);
		alert(resp[0].resp);
		document.getElementById("divLoadding").style.display = 'none';		
	}
	
	function limpiarTabla(){
		document.getElementById('idCliente').innerHTML				= '';
		document.getElementById('tipoCliente').innerHTML			= '';
		document.getElementById('tipoIdentificacion').innerHTML		= '';
		document.getElementById('identificacion').innerHTML			= '';
		document.getElementById('categoriaCliente').innerHTML		= '';
		document.getElementById('nombreCliente').innerHTML			= '';
		document.getElementById('direccionCliente').innerHTML		= '';
		document.getElementById('emailCliente').innerHTML			= '';
		document.getElementById('telefonoCliente').innerHTML		= '';
		document.getElementById('saldoDeudaCliente').innerHTML		= '';
		document.getElementById('tituloDetFactura').style.display 	= 'none';
		document.getElementById('trFacturas').style.display 		= 'none';
		
		//document.getElementById('tituloDetTramitesVigentes').style.display 		= 'none';
		//document.getElementById('tituloDetTramitesProcesados').style.display 	= 'none';
		//document.getElementById('detalleTramitesVigentes').style.display 		= 'none';
		//document.getElementById('detalleTramitesProcesados').style.display 		= 'none';
		
		/*document.getElementById('numeroCuenta').innerHTML= "";
		document.getElementById('claveCatastral').innerHTML= "";
		document.getElementById('direccion').innerHTML= "";
		document.getElementById('medidor').innerHTML= "";
		document.getElementById('consumidor').innerHTML= "";
		document.getElementById('identificacion').innerHTML= "";
		document.getElementById('nombreC').innerHTML= "";
		document.getElementById('estado').innerHTML= "";
		document.getElementById('beneficio').innerHTML= "";
		document.getElementById('cobranza').innerHTML= "";
		document.getElementById('temision').innerHTML= "0,00";
		document.getElementById('tvencido').innerHTML= "0,00";
		document.getElementById('ttotal').innerHTML= "0,00";
		document.getElementById('tableRubros').innerHTML= "<tbody></tbody>";
		document.getElementById('etiqueta1g').innerHTML = '-';
		document.getElementById('etiqueta2g').innerHTML = '-';
		document.getElementById('etiqueta3g').innerHTML = '-';
		document.getElementById('etiqueta4g').innerHTML = '-';
		document.getElementById('etiqueta5g').innerHTML = '-';
		document.getElementById('etiqueta6g').innerHTML = '-';
		document.getElementById('etiquetaT1g').innerHTML = '-';
		document.getElementById('etiquetaT2g').innerHTML = '-';
		document.getElementById('etiquetaT3g').innerHTML = '-';
		document.getElementById('etiquetaT4g').innerHTML = '-';
		document.getElementById('etiquetaT5g').innerHTML = '-';
		document.getElementById('etiquetaT6g').innerHTML = '-';
		document.getElementById('etiquetaS1g').innerHTML = '-';
		document.getElementById('etiquetaS2g').innerHTML = '-';
		document.getElementById('etiquetaS3g').innerHTML = '-';
		document.getElementById('etiquetaS4g').innerHTML = '-';
		document.getElementById('etiquetaS5g').innerHTML = '-';
		document.getElementById('etiquetaS6g').innerHTML = '-';
		document.getElementById('barrra1g').style.height = "0px";
		document.getElementById('barrra2g').style.height = "0px";
		document.getElementById('barrra3g').style.height = "0px";
		document.getElementById('barrra4g').style.height = "0px";
		document.getElementById('barrra5g').style.height = "0px";
		document.getElementById('barrra6g').style.height = "0px";
		document.getElementById('tituloDetConvenios').style.display = 'none';
		document.getElementById('tituloDetPagos').style.display = 'none';
		document.getElementById('tituloDetFactura').style.display = 'none';
		document.getElementById('tituloDetNC').style.display = 'none';
		document.getElementById('tituloServiciosAdministrativos').style.display = 'none';
		document.getElementById('tituloDetTramitesVigentes').style.display = 'none';
		document.getElementById('tituloDetTramitesProcesados').style.display = 'none';
		document.getElementById('tituloDetConveniosC').style.display = 'none';
		document.getElementById('trConveniosC').style.display = 'none';
		document.getElementById('trConvenios').style.display = 'none';
		document.getElementById('trPagos').style.display = 'none';
		document.getElementById('trFacturas').style.display = 'none';
		document.getElementById('trNotasCredito').style.display = 'none';
		document.getElementById('detalleTramitesVigentes').style.display = 'none';
		document.getElementById('detalleTramitesProcesados').style.display = 'none';
		document.getElementById('detalleServiciosAdministrativos').style.display = 'none';
		totalRegT = document.getElementById("tableFacturas").rows.length;
		
		if (totalRegT >0){
			for (var i=1;i < totalRegT; i++) {
			 document.getElementById("tableFacturas").deleteRow(1);
			}	
		}*/
	}
	
	function enterBusqueda(e){
		if(e.keyCode == 13){
			buscarInformacion(document.getElementById('busqueda').value);
		}
	}
	
	function muestraTR(obj){
		if(document.getElementById(obj).style.display=='table-row')
		  {document.getElementById(obj).style.display='none';}
		else
		  {document.getElementById(obj).style.display='table-row';}  	
	}
	
	function abrirPredio(){
		if(document.getElementById('numeroCuenta').innerHTML != ''){
			var cmp = new Padder(6);
			window.top.document.getElementById('load').style.display = 'block';
			rutaFom = 'forms/catastro/viewPrediosIndividualReadOnly.php?idPredio='+document.getElementById('id_predio').innerHTML;
			tramite = 'PRE-'+cmp.pad(document.getElementById('id_predio').innerHTML);
			window.top.frames["PPrincipal"].createNewTab('Tab_dhtml',tramite,'',rutaFom,true,document.getElementById('id_predio').innerHTML, 0,0,0);	
		}
	}
	
	function abrirCliente(){
		if(document.getElementById('numeroCuenta').innerHTML != ''){
			var cmp = new Padder(6);
			window.top.document.getElementById('load').style.display = 'block';
			rutaFom = 'forms/catastro/viewClienteIndividualReadOnly.php?idCliente='+document.getElementById('id_cliente').innerHTML;
			tramite = 'CLI-'+cmp.pad(document.getElementById('id_cliente').innerHTML);
			window.top.frames["PPrincipal"].createNewTab('Tab_dhtml',tramite,'',rutaFom,true,document.getElementById('id_cliente').innerHTML, 0,0,0);	
		}
	}
	
	function abrirConsumos(){
		if(document.getElementById('numeroCuenta').innerHTML != '' &&  document.getElementById('medidor').innerHTML != ''){
			var cmp = new Padder(6);
			window.top.document.getElementById('load').style.display = 'block';
			rutaFom = 'forms/catastro/viewLecturasCuentaReadOnly.php?cuentaServicio='+document.getElementById('numeroCuenta').innerHTML;
			tramite = 'CTA-'+document.getElementById('numeroCuenta').innerHTML;
			window.top.frames["PPrincipal"].createNewTab('Tab_dhtml',tramite,'',rutaFom,true,document.getElementById('numeroCuenta').innerHTML, 0,0,0);	
		}
	}
	
	function abrirLegalizacion(){
		if(document.getElementById('numeroCuenta').innerHTML != ''){
			var cmp = new Padder(6);
			window.top.document.getElementById('load').style.display = 'block';
			rutaFom = 'forms/catastro/viewLegalizacionCuentaReadOnly.php?cuentaServicio='+document.getElementById('numeroCuenta').innerHTML;
			tramite = 'LEG-'+document.getElementById('numeroCuenta').innerHTML;
			window.top.frames["PPrincipal"].createNewTab('Tab_dhtml',tramite,'',rutaFom,true,document.getElementById('numeroCuenta').innerHTML, 0,0,0);	
		}
	}
	
	function consultaProceso(idTramite){
		 if(idTramite != ''){
			var cmp = new Padder(6);
			document.getElementById('tableTramiteIndividual').innerHTML = '';
			document.getElementById('tituloProceso').innerHTML = '';
							
			//window.top.document.getElementById('load').style.display = 'block';
			rutaFom = '../php/informacionTramiteTabla.php';
			$.ajax({
					type:'POST',
					data: 'idTramite='+idTramite,
					url:rutaFom,
					success:function(data){
						data = eval(data);
							document.getElementById('modalProcesoSeleccionado').style.display = 'flex';
							document.getElementById('tableTramiteIndividual').innerHTML = data[0];
							document.getElementById('tituloProceso').innerHTML = data[1];
						}
				  }); 
			//tramite = 'VTR-'+cmp.pad(idTramite);
			//window.top.frames["PPrincipal"].createNewTab('Tab_dhtml',tramite,'',rutaFom,true,idTramite, 0,0,0);	
		}
		/*if(idTramite != ''){
			if (idTramite == 1){
				document.getElementById('idTramiteSolicitud').innerHTML = '1';
				document.getElementById('tiempoSolicitud').innerHTML = '9 días';
				document.getElementById('fechaSolicitudConsulta').innerHTML = '09/03/2020';
				document.getElementById('fechaSolicitudConsulta').innerHTML = '14/03/2020';
				document.getElementById('solicitudRealizada').href = '../digitalDocs/00000000001.pdf';
				document.getElementById('respuestaSolicitud').href = '../digitalDocs/00000000002.pdf';
			}
			if (idTramite == 2){
				document.getElementById('idTramiteSolicitud').innerHTML = '2';
				document.getElementById('tiempoSolicitud').innerHTML = '1 días';
				document.getElementById('solicitudRealizada').href = '../digitalDocs/00000000003.pdf';
				document.getElementById('respuestaSolicitud').href = '../digitalDocs/00000000004.pdf';
				document.getElementById('fechaSolicitudConsulta').innerHTML = '19/02/2020';
				document.getElementById('fechaSolicitudConsulta').innerHTML = '19/02/2020';
			}
		   document.getElementById('modalProcesoSeleccionado').style.display = 'flex';
	  	   }	
		*/
	}

	function nuevaSolicitud(){
		/*if(idTramite != ''){
			var cmp = new Padder(6);
			window.top.document.getElementById('load').style.display = 'block';
			rutaFom = 'forms/atencionCiudadana/viewVistaSeguimientoTramite.php?idTramite='+idTramite;
			tramite = 'VTR-'+cmp.pad(idTramite);
			window.top.frames["PPrincipal"].createNewTab('Tab_dhtml',tramite,'',rutaFom,true,idTramite, 0,0,0);	
		}*/
		
		document.getElementById('modalNuevoProcesoSolicitud').style.display = 'block';
		
	}

	function cerrarSolicitud(){
		document.getElementById('modalNuevoProcesoSolicitud').style.display = 'none';
	}

	function cerrarProceso(){
		document.getElementById('modalProcesoSeleccionado').style.display = 'none';
	}

	function countChars(obj, sho, cantidad){
			disp = cantidad - parseInt(obj.value.length);
			document.getElementById(sho).innerHTML = 'Disponibles '+disp+' de '+cantidad+' caracteres';
		}


