
var componente={}
componente.cmb=function(){
	this.id;
	this.cmb; 
	this.newValue;
	this.ini=function(id){
		this.id=id;
		this.cmb=document.getElementById(this.id)
	  }
	this.setChangeFunction=function(f){	
		this.cmb.addEventListener('change',f)
	  }
	this.clear=function()  {
		this.cmb.innerHTML=''
	}
	this.selectValue=function(id)  {
		var options=cmb.cmb.options
		for(var i=0;i<options.length;i++){
			  if(options[i].value==id){			
				this.cmb.selectedIndex=i
			  }  
			}
	}
	this.getSelectedValue=function(){
	  return this.cmb.options[this.cmb.selectedIndex].value
	}
	
	this.addCmbData0=function()  {
	var option=document.createElement('option')
		  option.value=0
		  option.text='Seleccione una opción...'
		  this.cmb.appendChild(option)
	}
	this.addCmbData=function(data){		
		this.cmb.innerHTML=''
		this.addCmbData0()
		for(var i=0;i<data.length;i++){ 
		  var option=document.createElement('option')
		  option.value=data[i].id
		  option.text=data[i].descripcion
		  this.cmb.appendChild(option)
		}
	}
	
	this.loadFromUrl=function(url_,data_,tipo='post'){
		  $.ajax({
			type:tipo,
			dataType:'json',
			url:url_,
			data:data_,
			success:this.addCmbData.bind(this)
		  })
	}


	this.addCmbData0Ad=function()  {
	var option=document.createElement('option')
		  option.value=0
		  option.text='Seleccione una opción...'
		  this.cmb.appendChild(option)
	}
	this.addCmbDataAd=function(data){		
		this.cmb.innerHTML=''
		this.addCmbData0Ad()
		for(var i=0;i<data.length;i++){ 
		  var option=document.createElement('option')
		  option.value=data[i].id;
		  option.text=data[i].descripcion;
		  option.setAttribute("codigo", data[i].detalle);
		  this.cmb.appendChild(option)
		}
	}
	
	this.loadFromUrlAd=function(url_,data_,tipo='post'){
		  $.ajax({
			type:tipo,
			dataType:'json',
			url:url_,
			data:data_,
			success: this.addCmbDataAd.bind(this)
		  })
	}
	
	this.addCmbDataMod=function(data){		
		this.cmb.innerHTML=''
		this.addCmbData0Ad()
		for(var i=0;i<data.length;i++){ 
		  var option=document.createElement('option')
		  option.value=data[i].id
		  option.text=data[i].descripcion
		  option.setAttribute("codigo", data[i].detalle)
		  this.cmb.appendChild(option)
		}
		//alert(value_);
		this.cmb.value = this.newValue
	}
	
	this.loadFromUrlMod=function(url_,data_,tipo='post'){
		  this.newValue = data_.v
		  $.ajax({
			type:tipo,
			dataType:'json',
			url:url_,
			data:data_,
			success: this.addCmbDataMod.bind(this)
		  })
	}
	
	
}

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