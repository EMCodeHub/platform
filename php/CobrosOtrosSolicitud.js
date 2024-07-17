function CPsolonumeros() {
	if ( (event.keyCode < 48  || event.keyCode > 57) && (event.keyCode != 44) ) {
      event.returnValue = false;
    }
}


function CPtxNombres() {
 if ((event.keyCode != 32) && (event.keyCode < 65) || (event.keyCode > 90) && (event.keyCode < 97) || (event.keyCode > 122))
  event.returnValue = false;
}

function FormatoTxtValido(Txt) {
    var regex = /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/g;
    if (regex.test(Txt)) {
        return true;	
    }
return false;	
}

function CPtrim (myString)   {
     return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
}

//........................................................................................................
bodyCartaCli = "";

//.......................................................................................................
function CPValidaConcepto() {
	$("#mensaGeneral").html("&nbsp;");  
	var concepto = $("#concepto").val();
 
	if ( concepto.length < 5 ) {
		$("#mensaGeneral").html("<span class='rojo'>Informe el concepto</span>");
		return false;
	}
	return true;
}

//.......................................................................................................
function CPVerificarDireccionCorreo(validatodo) {
$("#mensaAlumno").html("&nbsp;");  
var direccion = $("#email_destino").val();

if (direccion.length < 5) {
    $("#mensaAlumno").html("<span class='rojo'>Informe un email</span>");
    return false;	
}
   var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
    if (!regex.test($('#email_destino').val().trim())) {
        $("#mensaAlumno").html("<span class='rojo'>Formato de email incorrecto</span>");
        return false;
    }
    if (validatodo == 0) {
      return true;    
    }
    DescribeSiExisteAlumno();
    return true;
}
//.......................................................................................................
function CPValidaImporte() {
$("#mensaGeneral").html("&nbsp;");  
 var importe = $("#importe").val();

if (importe < 1) {
    $("#mensaGeneral").html("<span class='rojo'>Informe un importe</span>");
    $("#importe").focus();
    return false;	
}
return true; 
}
//.......................................................................................................
function CPValidaMoneda() {
$("#mensaGeneral").html("&nbsp;");  
 var moneda = $("#moneda").val();

if (moneda == "") {
    $("#mensaGeneral").html("<span class='rojo'>Informe la moneda</span>");
    $("#moneda").focus();
    return false;	
}
return true; 
}
//.......................................................................................................
function CPValidaCobroAnulacion($alta) {
    
$("#mensaGeneral").html("&nbsp;");  
 var f_cobro = $("#f_cobro").val();
 var f_anulacion = $("#f_anulacion").val();

    if (f_cobro != "" && f_anulacion != "") {
        $("#mensaGeneral").html("<span class='rojo'>Si cobrado no puede estar anulado</span>");
        return false;	
     }
  $("#mensaGeneral").html("&nbsp;");
  return true;
}
//.......................................................................................................
function CPValidaFormulario() {
	$("#mensaGeneral").html("&nbsp;");
    $("#mensaAlumno").html("&nbsp;");
    $("#mensaAltaOperacion").html(".........");
    $("#mensaAltaComponerCarta").html(".........");
    $("#mensaAltaEnviarCarta").html("Pendiente enviar email");
    
	
	if (!CPVerificarDireccionCorreo(1)){
		return false;
	}
    if (!CPValidaImporte()){
		return false;
	}
    if (!CPValidaMoneda()){
		return false;
	}
	if (!CPValidaConcepto()){
		return false;
	}
	if (!CPValidaCobroAnulacion(1)){
		return false;
	}
	return true;
}
//.......................................................................................................
function CPEnviaFormulario(){
	
	$('#botonesAceptacion').css("display","none");
	$('#procesandoAceptacion').css("display","block");
	RealizaGestion();
	//$("#botonFinal").css("display","block"); 
}
//..................................................ver si existe email en vtalumnos ........

function DescribeSiExisteAlumno()	{
			  var parametros = {
              "email"        : $('#email_destino').val() 
              };  
	 
	 
	$.ajax({
             data:  parametros,
             url:   '../php/CobrosOtrosSolicitudExistMail.php',
             type:  'post',
			 async:  false,
             beforeSend: function () {
                    $("#mensaAlumno").html("Buscando email en vtalumnos"); 
             },
             success:  function (response) {
						$("#mensaAlumno").html(response); 
						return true;
             },
			 error: function(){
                $("#mensaAlumno").html("<span class='rojo'>Error buscando email en vtalumnos</span>");
				return false;
            }
        });	
}
//............................................................................
function RealizaGestion()	{
			  var parametros = {
              "email"       : $('#email_destino').val() ,
			  "importe"     : $('#importe').val() ,
			  "moneda"      : $('#moneda').val() ,
			  "concepto"    : $('#concepto').val() ,
			  "descripcion" : $('#descripcion').val() ,
			  "f_emision"   : $('#f_emision').val()  
              };  
	 
	 
	$.ajax({
             data:  parametros,
             url:   '../php/CobrosOtrosAltaOperacion.php',
             type:  'post',
			 async:  false,
             beforeSend: function () {
                    $("#mensaAltaOperacion").html("Anotando operación alta......"); 
             },
             success:  function (response) {
					 if (response == "ERROR") {
						$("#mensaAltaOperacion").html("<span class='rojo'>Error, alta no realizada</span>"); 
						$('#procesandoAceptacion').html("Error");
						return false;
					 } else { 
                         $("#mensaAltaOperacion").html("Alta operación OK"); 
                         CPResuelveBodyCarta(response);
						 return true;
					 }
             },
			 error: function(jqXHR, textStatus, errorThrown) {
                $("#mensaAltaOperacion").html("<span class='rojo'>"+errorThrown+"</span>");
				$('#procesandoAceptacion').html("Error");
				return false;
            }
        });	
}
//...........................................................................
function CPResuelveBodyCarta(nummID)	{
		    var parametros = {
             "numID"        : nummID 
             };  

		$.ajax({
             data:  parametros,
             url:   '../cartas/CartaCobrosOtrosSolicitudPago.php',
             type:  'post', 
			 async: false,
             beforeSend: function () {
                      $("#mensaAltaComponerCarta").html("Componiendo carta ...."); 
             },
             success:  function (response) {
				 bodyCartaCli = response;
				 $("#mensaAltaComponerCarta").html("Carta redactada OK"); 
                 CPEnviaCartas(nummID);
				 return true;
             },
			 error: function(){
                $("#mensaAltaComponerCarta").html("<span class='rojo'>Error componiendo carta</span>");
				$('#procesandoAceptacion').html("Error");
				return false;
            }
        });	
}
//............................................................................
function CPEnviaCartas(Pid)	{
        var parametros = {
              "id"          : Pid ,
              "email"       : $('#email_destino').val() ,
			  "concepto"    : $('#concepto').val() ,
			  "bodyCarta"   : bodyCartaCli
        };  
	  
	$.ajax({
             data:  parametros,
             url:   '../php/CobrosOtrosEnviaMailPeticion.php',
             type:  'post',
			 async: false,
             beforeSend: function () {
                      $("#mensaAltaEnviarCarta").html("Enviando Email ...."); 
             },
             success:  function (response) {
					 if (response.trim() != "OK") {
						$("#mensaAltaEnviarCarta").html("<span class='rojo'>"+response+"</span>"); 
						$('#procesandoAceptacion').html("Error");
						return false;
					 } else {
                         $('#procesandoAceptacion').html("Proceso OK");
                         $('#mensaGeneral').css("display","none");
                         $("#mensaAltaEnviarCarta").html("<span class='azul'>Email enviado OK</span>"); 
                         $('#botonesCerrar').css("display","block");
						return true;
					 }
             },
			 error: function(jqXHR, textStatus, errorThrown) {
                 $("#mensaGeneral").html(errorThrown);
                 $("#mensaAltaEnviarCarta").html("<span class='rojo'>Error enviando Email</span>");
                 $('#procesandoAceptacion').html("Error");
				return false;
            }
        });	
}


//...........................................................................



