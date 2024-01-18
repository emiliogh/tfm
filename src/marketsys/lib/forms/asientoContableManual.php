<?php include "../php/sesionSecurityForms.php";?>
<!doctype html>
<html lang="en-US">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html">
  <title>Registro Asiento Manual</title>
  <script type="text/javascript" src="../jquery/jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="../jquery/jquery-ui-forms.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/styleCajas.css">
  <link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
  <script type="text/javascript" src="../js/componentes.js"></script>
</head>	
<body bgcolor="#fff" style="left: 0px;" onLoad="parent.document.getElementById('divLoadding').style.display = 'none';">
	<div id="identificacionCliente" name="identificacionCliente">
		<div id="usuarioCliente" name="usuarioCliente">
			<table style="width: 100%;">
				<thead>
					<tr>
						<td colspan="4" class="estilo3">
							INFORMACIÓN DIARIO
						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="clsEtiquetasTable" style="width: 10%;">
							Fecha
					    </td>
						<td class="clsObjetosTable">
							<input id="fechaAsientoContable" type="text" style="width: 99%; height: 15px;"
								   value="<?php echo date("d/m/Y")?>" />
						<td rowspan="4" style="width: 120px;">
							<button type="button" id="btn_guardar" onClick="registraAsiento();" style="width: 100%;"><br>
								<img src="../images/icons/movimiento.png" width="38px" alt=""/><br><br>
								Registrar Asiento Contable</button>
					    </td>
					</tr>
					<tr>
						<td class="clsEtiquetasTable" style="width: 10%;">
							Tipo Asiento
					    </td>
						<td class="clsObjetosTable">
							<select id="cmbTipoAsientoContable" style="width: 99.5%">
							  <option value="0" SELECTED>Seleccione una Opción.</option>
							</select>
						</td>	
					</tr>
					<tr>
						<td class="clsEtiquetasTable" style="width: 10%;">
							Descripción
					    </td>
						<td class="clsObjetosTable">
							<input id="descripcionAsientoContable" type="text" autocomplete="off"
								   style="width: 99%; height: 15px; text-transform: uppercase;"/>
						</td>	
					</tr>
					<tr>
						<td class="clsEtiquetasTable">
							Glosa
					    </td>
						<td class="clsObjetosTable">
							<textarea id="observacionMovimiento" class="required" type="text" autocomplete="off" 
									  style="width: 99%; height: 30px; text-transform: uppercase;"></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="4" class="estilo3">
							BÚSQUEDA DE CUENTAS
						</td>
					</tr>
					<tr>
						<td colspan="4">
							<table style="width: 100%;">
								<tr>
									<td style="width: 80px; padding-top: 5px; padding-bottom: 5px;">
										<input onFocus="this.blur()" id="idItem" name="idItem" type="text" 
											   style="width: 95%; height: 21px;"/>
										<input id="idCuenta" name="idCuenta" type="text" style="display: none;"/>
										<input id="codigoCuenta" name="codigoCuenta" type="text" style="display: none;"/>
										<input id="descripcionCuenta" name="descripcionCuenta" type="text" 
											   style="display: none;"/>
									</td>
									<td>
										<input id="item" name="item" class="required" type="text" style="width: 100%; height: 21px;"/>
									</td>
									<td style="width: 10%; text-align: center;">
										<table style="width: 100%;">
										   <tr>
											<td style="width: 30%; text-align: center;">
												<button type="button" class="add-row" style="width: 100%;">
													<img src="../images/icons/add.png" height="18px" alt=""/>
												</button>
											</td>   
											<td style="width: 35%; text-align: center;">
												<button type="button" class="clear-search" style="width: 100%;">
													<img src="../images/icons/clear_.png" height="18px" alt=""/>
												</button>
											</td>
										   </tr>
										</table>	
									</td>
								   </tr>
								</table>   
							</td>
						</tr>
						<tr>
							<td colspan="4" class="estilo3">
								DETALLE DEL ASIENTO CONTABLE
							</td>
						</tr>
						<tr>
						  <td colspan="4" class="estilo2">
							<table id="tableMovimientos" id="tableMovimientos" style="width: 100%;">
								<thead>
									<tr class="tablaAperturaHead">
										<td style="width: 8%;">N°</td>
										<td style="width: 10%;">Código Cuenta</td>
										<td style="width: 60%;">Descripción</td>
										<td style="width: 10%;">DEBE</td>
										<td style="width: 10%;">HABER</td>
										<td style="width: 2%;"></td>
									</tr>
								</thead>
								<tbody id="tablaAsientoDetalles" style="background: #fff; margin: 0px; padding: 0px;">	
								</tbody>		
								<tfoot>	
									<tr class="tablaAperturaFood">
										<td colspan="3">	
										</td>
										<td  style="text-align: right;">
											<span id="txtSumaDebe" style="width: 100px;">0.00</span>		
										</td>
										<td  style="text-align: right;">
											<span id="txtSumaHaber" style="width: 100px;">0.00</span>		
										</td>
										<td>	
										</td>
									</tr>
								</tfoot>		
							</table>
						</td>
					</tr>
				</tbody>	
			</table>
        </div>
    </div>
<script>
	var cmbFormasPago = new componente.cmb; 
		cmbFormasPago.ini('cmbTipoAsientoContable');
		cmbFormasPago.loadFromUrlAd('../cmb/cmbTfnTiposAsientos.php');
	
	var indx = 0;
	var url = '../../lib/cmb/cmbTfnCatalogoAutocomplete.php';
	document.getElementById('idCuenta').value = '';
	document.getElementById('codigoCuenta').value = '';
	document.getElementById('descripcionCuenta').value = '';
	$.ajax({
		type:'POST',
		url:url,
		data:'id=1',
		success:function(data){
			$( "#item" ).autocomplete({
			  source: eval(data)
			});
			$( "#item" ).on( "autocompleteselect", function( event, ui ) {
				document.getElementById('idItem').value = ui.item[3];
				document.getElementById('idCuenta').value = ui.item[2];
				document.getElementById('codigoCuenta').value = ui.item[3];
				document.getElementById('descripcionCuenta').value = ui.item[4];
			});
				
		}
	});
	
	/*Nuevo Producto*/
	$(".new-row").click(function(){
		registraNuevoProducto();
	});
	
	/*Añadir Fila*/
	$(".add-row").click(function(){
		if ($("#idItem").val() != ''){
			var id = $("#idCuenta").val();
			var codigo = $("#codigoCuenta").val();
			var descripcion = $("#descripcionCuenta").val();
			
			indx ++;
			var idMov = indx;
			var res = String.fromCharCode(34);
			
			var markup = "<tr style='color: #000;' name='TR"+idMov+"'>"+
							"<td style='text-align: right;'>"+idMov+"</td>"+
				            "<td style='display: none;'>"+id+"</td>"+
							"<td style='font-weight: 200;'>"+codigo+"</td>"+
							"<td style='font-weight: 200;'>"+descripcion+"</td>"+
							"<td><input id='debe"+idMov+"' name='debe"+idMov+"' onChange='calcularValores(1,"+idMov+")' "+
							     "type='text' style='text-align: right; width: 96%; top:0px; height:23px;' autocomplete='off' "+ 
								 "value='0.00' onkeypress='return filterFloat(event,this);' ondblclick='limpiarValor(this)'/></td>"+
							"<td><input id='haber"+idMov+"' name='haber"+idMov+"' onChange='calcularValores(2,"+idMov+")' "+
							     "type='text' style='text-align: right; width: 96%; height: 23px;' autocomplete='off' "+
								 "value='0.00' onkeypress='return filterFloat(event,this);' ondblclick='limpiarValor(this)'/></td>"+
							"<td><button type='button' class='delete-row' onClick='EliminarFila(this);'>"+
								"<img src='../images/icons/clear.png' height='20px' alt=''/></button></td></tr>";
			$("#tableMovimientos").append(markup);
			$("#idCuenta").val('');
			$("#codigoCuenta").val('');
			$("#descripcionCuenta").val('');
			$("#idItem").val('');
			$("#item").val('');
		}
	});
	
	
	$(".clear-search").click(function(){
		$("#idItem").val('');
		$("#item").val('');
		$("#costoPromedio").val('');
		$("#costoIdeal").val('');
	});
	
	function EliminarFila (r){
		var i = r.parentNode.parentNode.rowIndex;
		var id = document.getElementById("tableMovimientos").rows[i].cells[0].innerHTML;
		var ValDebe = document.getElementById("txtSumaDebe").innerHTML;
		var ValHaber = document.getElementById("txtSumaHaber").innerHTML;
		
		var TotRDebe = document.getElementById("debe"+id).value;
		var TotRHaber = document.getElementById("haber"+id).value;
		
		    ValDebe = ValDebe - TotRDebe;
			ValHaber = ValHaber - TotRHaber;
		
			var n = parseFloat(ValDebe).toFixed(2);
				document.getElementById("txtSumaDebe").innerHTML = n;
			var n = parseFloat(ValHaber).toFixed(2);
				document.getElementById("txtSumaHaber").innerHTML = n;
		
		document.getElementById("tableMovimientos").deleteRow(i);
	}
	
	function zeroPad(num, places) {
	  var zero = places - num.toString().length + 1;
	  return Array(+(zero > 0 && zero)).join("0") + num;
	}
	
	function calcularValores(tipo,id){
		if (tipo == 1){
			if (document.getElementById("debe"+id).value != 0){
				vl = document.getElementById("debe"+id).value;
				 vl = parseFloat(vl);
				 document.getElementById("debe"+id).value = vl.toFixed(2);
				 document.getElementById("haber"+id).value = '0.00'}
			else{document.getElementById("debe"+id).value = '0.00';
				 document.getElementById("haber"+id).focus();}
		}
		if (tipo == 2){
			if (document.getElementById("haber"+id).value != 0){
				vl = document.getElementById("haber"+id).value;
				 vl = parseFloat(vl);
				 document.getElementById("haber"+id).value = vl.toFixed(2);
				 document.getElementById("debe"+id).value = '0.00'}
			else{document.getElementById("haber"+id).value = '0.00';
				 document.getElementById("debe"+id).focus();}
		}
		
		calculaSaldosTotales();
	}
	
	function calculaSaldosTotales(){
		var tblDetAsCon = document.getElementById('tablaAsientoDetalles');
			montoDebe = 0;
		    montoHaber = 0;
			for(var i = 0; i < tblDetAsCon.rows.length; i++){
				var idLinea 	 = tblDetAsCon.rows[i].cells[0].innerHTML;
				montoDebe = montoDebe + parseFloat(document.getElementById('debe'+idLinea).value);
				montoHaber=	montoHaber+ parseFloat(document.getElementById('haber'+idLinea).value);
				
			}
		document.getElementById('txtSumaDebe').innerHTML = montoDebe.toFixed(2);
		document.getElementById('txtSumaHaber').innerHTML = montoHaber.toFixed(2);
	}
	
	function registraAsiento(){
		parent.document.getElementById('divLoadding').style.display = 'block';
		
		if (document.getElementById("cmbTipoAsientoContable").value == 0){
			parent. modalAlertPrincipal(2, 'MarketSys', 
										   'Para registrar el asiento contable debe seleccionar un tipo de asiento.',
										    0, 'Aceptar', '')
			parent.document.getElementById('divLoadding').style.display = 'none';
			return 0;
		}
		if (document.getElementById("descripcionAsientoContable").value == ''){
			parent. modalAlertPrincipal(2, 'MarketSys', 
										   'Para registrar el asiento contable debe digitar la descripción del asiento contable.',
										    0, 'Aceptar', '')
			parent.document.getElementById('divLoadding').style.display = 'none';
			return 0;
		}
		if (document.getElementById("observacionMovimiento").value == ''){
			parent. modalAlertPrincipal(2, 'MarketSys', 
										   'Para registrar el asiento contable debe digitar la glosa informativa '+
										   'del asiento contable.',
										    0, 'Aceptar', '')
			parent.document.getElementById('divLoadding').style.display = 'none';
			return 0;
		}
		if (document.getElementById("txtSumaDebe").innerHTML != document.getElementById("txtSumaHaber").innerHTML){
			parent. modalAlertPrincipal(2, 'MarketSys', 
										   'Para registrar el asiento contable deben ser iguales los totales del debe y el haber.',
										    0, 'Aceptar', '')
			parent.document.getElementById('divLoadding').style.display = 'none';
			return 0;
		}
		
		var url = '../../lib/php/registraAsientoContableManual.php';
			var tipo = document.getElementById("cmbTipoAsientoContable").value
			var desc = document.getElementById("descripcionAsientoContable").value
			var glos = document.getElementById("observacionMovimiento").value
			var debe = document.getElementById("txtSumaDebe").innerHTML
			var habe = document.getElementById("txtSumaHaber").innerHTML
		$.ajax({
			type:'POST',
			url:url,
			data:'tipo='+tipo+'&desc='+desc+'&glos='+glos+'&debe='+debe+'&habe='+habe,
			success:function(data){ 
				valId = eval(data);
				if (valId[0] == 0){
					valId = valId[1];
					var tblDetAsCon = document.getElementById('tablaAsientoDetalles');
						for(var i = 0; i < tblDetAsCon.rows.length; i++){
							var idLinea = tblDetAsCon.rows[i].cells[0].innerHTML;
							var idCta	= tblDetAsCon.rows[i].cells[1].innerHTML;	
							var debe 	= document.getElementById("debe"+idLinea).value
							var habe 	= document.getElementById("haber"+idLinea).value
							var url 	= '../../lib/php/registraAsientoContableDetalleManual.php';
							var linea	= i+1;
							$.ajax({
								type:'POST',
								url:url,
								async: false,
								data:'id='+valId+'&linea='+linea+'&idCta='+idCta+'&debe='+debe+'&habe='+habe,
								success:function(data){ 
											

								}
							});
						}
						location.reload();
						parent. modalAlertPrincipal(2, 'MarketSys', 
										   			   'Se ha registrado su asiento contable de forma satisfactoria.',
										    			0, 'Aceptar', '');
					}
				
			}
		});
		
	
	}
	
	function limpiarValor(item){
		item.value = '';
		item.focus();
	}
	
	function valideKey(evt){
    var code = (evt.which) ? evt.which : evt.keyCode;
    //backspace
	if(code==8){return true;}
       else if(code>=48 && code<=57) {
            //is a number
            return true;
                   }else{return false;}
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
	
	function soloLetras(e) {
		key = e.keyCode || e.which;
		tecla = String.fromCharCode(key).toLowerCase();
		letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
		especiales = [8, 37, 39, 46];

		tecla_especial = false
		for(var i in especiales) {
			if(key == especiales[i]) {
				tecla_especial = true;
				break;
			}
		}

		if(letras.indexOf(tecla) == -1 && !tecla_especial)
			return false;
	}
	
	function soloNumeros(e) {
		// Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
		key = e.keyCode || e.which;
		tecla = String.fromCharCode(key).toLowerCase();
		letras = "0123456789";
		especiales = [8];

		tecla_especial = false
		for(var i in especiales) {
			if(key == especiales[i]) {
				tecla_especial = true;
				break;
			}
		}

		if(letras.indexOf(tecla) == -1 && !tecla_especial)
			return false;
	}
	
	function soloNumerosLetras(e) {
		// Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
		key = e.keyCode || e.which;
		tecla = String.fromCharCode(key).toLowerCase();
		letras = "0123456789 áéíóúabcdefghijklmnñopqrstuvwxyz";
		especiales = [8, 37, 39, 44, 46];

		tecla_especial = false
		for(var i in especiales) {
			if(key == especiales[i]) {
				tecla_especial = true;
				break;
			}
		}

		if(letras.indexOf(tecla) == -1 && !tecla_especial)
			return false;
	}
</script>
</body>
</html>