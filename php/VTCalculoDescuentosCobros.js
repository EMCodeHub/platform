CaptchaOK = 0;
bodyCartaCli = "";
procesoActivo = 0;
$(document).ready(function(){
	
	
	
   //selecciono todos los elementos de la clase "mitexto"
   //$("#marcoMensaje").html("Introduzca sus datos");


   $("#DEmarcoMensaje").html("Informe un EMAIL");

   $("#DEemail").change(function() {
		DEVerificarDireccionCorreo($("#DEemail").val(),1); 
		
   });
   $("#DEemail").focusin(function() {
		DELipiaMensaje(); 
		
   });
   $("#DEemail").focusout(function() {
		DEVerificarDireccionCorreo($("#DEemail").val(),1); 
		
   });
   
    $("#DEemail2").change(function() {
		DEVerificarDireccionCorreo($("#DEemail2").val(),2); 
   });
   
   $("#DEemail2").focusin(function() {
		DELipiaMensaje(); 
		
   });
   $("#DEemail2").focusout(function() {
		DEVerificarDireccionCorreo($("#DEemail2").val(),2); 
		
   });
   //..............
   $("#DEButton1").click(function() {
		DEEnviaFormulario(1); 
   });
   $("#DEButton2").click(function() {
		DEEnviaFormulario(2); 
   });
    $("#DEButton3").click(function() {
		DEEnviaFormulario(3); 
   });
      
   $("#DEButton4").click(function() {
		DESalirPago(); 
   }); 
   
   
});
function DEborraCampos() {
	
	document.getElementById("DEemail").value = "";
	document.getElementById("DEemail2").value = "";
}

function DESalirPago() {
	  d = document.getElementById("CorrreoCobrosDescuentos");
	  d.style.display= "none";
}

function ltrim(stringToTrim) {
	return stringToTrim.replace(/^\s+/,"");
}
//.......................................................................................................
function DEVerificarDireccionCorreo(direccion, numeroCorreo) {
	
$("#DEmarcoMensaje").html("");  

if (direccion.length < 5) {
    $("#DEmarcoMensaje").html("Informe un EMAIL. Después pulse en la plataforma de pago");
    return false;	
}
   var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
    if (regex.test(direccion.trim())) {
		if (numeroCorreo == 2) {
		    $("#DEmarcoMensaje").html("Pulse en la imagen de la plataforma de pago");
		}
		
		return true;	
    }
    else {
		$("#DEmarcoMensaje").html("Formato de email incorrecto");
        return false;
    }
}
//.......................................................................................................


//.......................................................................................................
function DEValidaFormulario() {
	$("#DEmarcoMensaje").html(""); 
	
    if (!DEVerificarDireccionCorreo($("#DEemail").val(),1)){
		return false;
	}
	    if (!DEVerificarDireccionCorreo($("#DEemail2").val(),2)){
		return false;
	}


    if (  $("#DEemail").val() != $("#DEemail2").val()) {
		$("#DEmarcoMensaje").html("E mails son diferentes");
		return false;
	
    }
	$("#DEmarcoMensaje").html("Pulse en forma de pago. Le redigiremos a una página segura para que pueda entrar sus datos");
	
	return true;
}
//.......................................................................................................
function DEEnviaFormulario(pagina){
	if (!DEValidaFormulario()) {
		 return false;
	} 
	if (pagina == 1) {
		 DEAnotaRegistroEmail("Solicitud VISA");
	} 
	if (pagina == 2) {
	} 
	if (pagina == 3) {
		$("#DEmarcoMensaje").html("Procesando  carta ---");
		if (procesoActivo == 0) {
		   if (!DEResuelveBodyCarta()){
	           $("#DEmarcoMensaje").html("Se ha producido un error, vuelva a intentarlo. Gracias");
               return false;
		   }
		}
		
	} 
    return true;
}
//............................................................................
function DEAnotaRegistroEmail(tipomensaje)	{
	          strprimerCursoCadena = cadenaCursosComprados.split(",",1);
              primerCursoCadena = parseInt(strprimerCursoCadena,10);
			  var parametros = {
              "DEemail"       : $('#DEemail').val() ,
			  "Nombre_correo" : DENombre_correo ,
			  "DENumIdCurso"  : primerCursoCadena,
			  "mailemisor"    : DEemisorcorreo,
			  "tipomensaje"   : tipomensaje,
			  "agente"        : "Web",
			  "loteCursos"    : cadenaCursosComprados,
			  "DEimporte"     : ImporteTotalCompra
              };  
		
			  	 
	$.ajax({
             data:  parametros,
             url:   '../php/VTCobrosDescuentosAnotaSolicitud.php',
             type:  'post',
             beforeSend: function () {
                    $("#DEmarcoMensaje").html("Anotando operación ......"); 
             },
             success:  function (response) {
					 if (response.trim() != "OK") {
						$("#DEmarcoMensaje").html("<span class='rojo'>"+response+"</span>"); 
						$('#botones').css("display","inline");
						return false;
					 } else {
						 //$("#DEmarcoMensaje").html("Gracias por su confianza");   dejemos el mensaje como esté
						 if (tipomensaje == "Solicitud VISA") {
						      destino = '../php/VisaDescuentos.php?mail='+document.getElementById("DEemail").value+'&DEcadena='+cadenaCursosComprados+'&DEimporte='+ImporteTotalCompra;
				              location.href = destino;
						 }
						 if (tipomensaje == "Solicitud Transferencia") {
							 $("#DEmarcoMensaje").html("Le hemos enviado un e-mail con los datos de la transferencia"); 
						 }
						return true;
					 }
             },
			 error: function(){
                $("#DEmarcoMensaje").html("<span class='rojo'>Error anotando operación.</span>");
				$('#botones').css("display","inline");
				return false;
            }
        });		
	
	
}
//...........................................................................
function AnulaBotonTransferencia() {
	    $("#DEBotones").html('<img  src="../imagenes/Transfer_enviado_correo.gif"  />');
}
//...........................................................................
function DEEnviaCartaTransfer()	{
			  var parametros = {
			  "DEemail"       : $('#DEemail').val() ,
			  "bodyCarta"     : bodyCartaCli,
			  "loteCursos"    : cadenaCursosComprados
              };  
			  
	$.ajax({
             data:  parametros,
             url:   '../php/VTCobrosDescuentosTransferEnviaMail.php',
             type:  'post',
             beforeSend: function () {
                      $("#DEmarcoMensaje").html("Enviando mail con datos bancarios ...."); 
             },
             success:  function (response) {
					 if (response.trim() != "OK") {
						$("#DEmarcoMensaje").html("<span class='rojo'>"+response+"</span>"); 
						$('#botones').css("display","inline");
						return false;
					 } else {
						 $("#DEmarcoMensaje").html("Le hemos enviado un Email con los datos de la transferencia"); 
						 AnulaBotonTransferencia();
						 DEAnotaRegistroEmail("Solicitud Transferencia");
						return true;
					 }
             },
			 error: function(){
                $("#DEmarcoMensaje").html("<span class='rojo'>Error enviando Email</span>");
				$('#botones').css("display","inline");
				return false;
            }
        });	
}

//...........................................................................
function DEResuelveBodyCarta()	{
		procesoActivo = 1; //......tenemos una petición en máquina
		     var parametros = {   

              "DEemail"       : $('#DEemail').val() ,
			  "Nombre_correo" : DENombre_correo ,
			  "mailemisor"    : DEemisorcorreo,
			  "loteCursos"    : cadenaCursosComprados,
			  "DEimporte"     : ImporteTotalCompra
              };  
			  
		$.ajax({
             data:  parametros,
             url:   '../cartas/CartaVTCobrosDescuentosTransfer.php',
             type:  'post',
             beforeSend: function () {
                      $("#DEmarcoMensaje").html("Componiendo carta ...."); 
             },
             success:  function (response) {
				 bodyCartaCli = response;
				 DEEnviaCartaTransfer(); 
				 procesoActivo = 0; 
             },
			 error: function(){
                $("#DEmarcoMensaje").html("<span class='rojo'>Error componiendo carta</span>");
				$('#botones').css("display","inline");
				procesoActivo = 0;
				return false;
            }
        });	
	
	
}
