
function CBborraCampos() {
	
	document.getElementById("CBemail").value = "";
	document.getElementById("CBemail2").value = "";
}

function SalirPago() {
	  d = document.getElementById("CorrreoCobros");
	  d.style.display= "none";
}

//.......................................................................................................
function CBVerificarDireccionCorreo(direccion, numeroCorreo) {
	
$("#CBmarcoMensaje").html("");  

if (direccion.length < 5) {
    $("#CBmarcoMensaje").html("Informe un EMAIL. Después pulse en la plataforma de pago");
    return false;	
}
   var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
    if (regex.test(direccion.trim())) {
		if (numeroCorreo == 2) {
		    $("#CBmarcoMensaje").html("Pulse en la imagen de la plataforma de pago");
		}
		
		return true;	
    }
    else {
		$("#CBmarcoMensaje").html("Formato de email incorrecto");
        return false;
    }
}
//.......................................................................................................


//.......................................................................................................
function CBValidaFormulario() {
	$("#CBmarcoMensaje").html(""); 
	
    if (!CBVerificarDireccionCorreo($("#CBemail").val(),1)){
		return false;
	}
	    if (!CBVerificarDireccionCorreo($("#CBemail2").val(),2)){
		return false;
	}


    if (  $("#CBemail").val() != $("#CBemail2").val()) {
		$("#CBmarcoMensaje").html("E mails son diferentes");
		return false;
	
    }
	$("#CBmarcoMensaje").html("Pulse en forma de pago. Le redigiremos a una página segura para que pueda entrar sus datos");
	
	return true;
}
//.......................................................................................................
function CBEnviaFormulario(pagina){
	
	/*if (pagina == 1 || pagina == 2 ) {  
	 //	PENDIENTE
	  $("#CBmarcoMensaje").html("Módulo NO operativo: Utilice la modalidad de TRANSFERENCIA.<br>Seguimos trabajando, disculpe las molestias");
	 
	 if ( trim($("#CBemail").val()).length > 5 && $("#CBemail").val() == $("#CBemail2").val()  ) {
	     if (pagina == 1) {
		     CBAnotaRegistroEmail("Solicitud VISA");
	     } else {
		     CBAnotaRegistroEmail("Solicitud PayPal");
	     }
	 }
	 
	  return false;
	}
	*/
	
	
	if (!CBValidaFormulario()) {
		 return false;
	} 
	
	if (pagina == 1) {
		 CBAnotaRegistroEmail("Solicitud VISA");
		//destino = '../php/Visa.php?mail='+document.getElementById("CBemail").value;
		// location.href = destino;
	} 
	if (pagina == 2) {
		/*CBAnotaRegistroEmail("Solicitud PayPal");
		location.href='../php/Paypal.php';*/
	} 
	if (pagina == 3) {
		//enviar carta con los datos PENDIENTE
		$("#CBmarcoMensaje").html("Procesando  carta ---");
		if (procesoActivo == 0) {
		   if (!CBResuelveBodyCarta()){
	           $("#CBmarcoMensaje").html("Se ha producido un error, vuelva a intentarlo. Gracias");
               return false;
		   }
		}
		
	} 
    return true;
}
//............................................................................
function CBAnotaRegistroEmail(tipomensaje)	{
			  var parametros = {
              "CBemail"       : $('#CBemail').val() ,
			  "Nombre_correo" : Nombre_correo ,
			  "NumIdCurso"    : numCurso,
			  "mailemisor"    : emisorcorreo,
			  "tipomensaje"   : tipomensaje,
			   "agente"       : "Web",
			   "tituloCurso"  : tituloCurso,
			   "precio"       : precioCurso
              };  
	 
	 
	$.ajax({
             data:  parametros,
             url:   'php/VTCobrosAnotaSolicitud.php',
             type:  'post',
             beforeSend: function () {
                    $("#CBmarcoMensaje").html("Anotando operación ......"); 
             },
             success:  function (response) {
					 if (response.trim() != "OK") {
						$("#CBmarcoMensaje").html("<span class='rojo'>"+response+"</span>"); 
						$('#botones').css("display","inline");
						return false;
					 } else {
						 //$("#CBmarcoMensaje").html("Gracias por su confianza");   dejemos el mensaje como esté
						 if (tipomensaje == "Solicitud VISA") {
						      destino = 'php/Visa.php?mail='+document.getElementById("CBemail").value;
		                      location.href = destino;
						 }
						 if (tipomensaje == "Solicitud Transferencia") {
							 $("#CBmarcoMensaje").html("Le emos enviado un e-mail con los datos de la transferencia"); 
						 }
						return true;
					 }
             },
			 error: function(){
                $("#CBmarcoMensaje").html("<span class='rojo'>Error anotando operación.</span>");
				$('#botones').css("display","inline");
				return false;
            }
        });		
	
	
}
//...........................................................................
function AnulaBotonTransferencia() {
	    $("#CBBotones").html('<img  src="imagenes/Transfer_enviado_correo.gif"  />');
}
//...........................................................................
function CBEnviaCartaTransfer()	{
			  var parametros = {
			  "email"         : $('#CBemail').val() ,
			  "Nombre_correo" : Nombre_correo ,
			  "bodyCarta"     : bodyCartaCli,
			  "NumIdCurso"    : numCurso
              };  
	$.ajax({
             data:  parametros,
             url:   'php/VTCobrosTransferEnviaMail.php',
             type:  'post',
             beforeSend: function () {
                      $("#CBmarcoMensaje").html("Enviando mail con datos bancarios ...."); 
             },
             success:  function (response) {
					 if (response.trim() != "OK") {
						$("#CBmarcoMensaje").html("<span class='rojo'>"+response+"</span>"); 
						$('#botones').css("display","inline");
						return false;
					 } else {
						 $("#CBmarcoMensaje").html("Le hemos enviado un Email con los datos de la transferencia"); 
						 AnulaBotonTransferencia();
						 CBAnotaRegistroEmail("Solicitud Transferencia");
						return true;
					 }
             },
			 error: function(){
                $("#CBmarcoMensaje").html("<span class='rojo'>Error enviando Emails</span>");
				$('#botones').css("display","inline");
				return false;
            }
        });	
}

//...........................................................................
function CBResuelveBodyCarta()	{
		procesoActivo = 1; //......tenemos una petición en máquina
		     var parametros = {   
			  "CBemail"       : $('#CBemail').val() ,
			  "Nombre_correo" : Nombre_correo ,
			  "NumIdCurso"    : numCurso
              };  
		$.ajax({
             data:  parametros,
             url:   'cartas/CartaVTCobrosTransfer.php',
             type:  'post',
             beforeSend: function () {
                      $("#CBmarcoMensaje").html("Componiendo carta ...."); 
             },
             success:  function (response) {
				 bodyCartaCli = response;
				 CBEnviaCartaTransfer();
				 procesoActivo = 0; 
             },
			 error: function(){
                $("#CBmarcoMensaje").html("<span class='rojo'>Error componiendo carta</span>");
				$('#botones').css("display","inline");
				procesoActivo = 0;
				return false;
            }
        });	
	
	
}
