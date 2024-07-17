
//................................
function SOsolonumeros() {
var key=window.event.keyCode;
//alert (key);
  if ((key < 48 || key > 57) && (key !=44)) {
	  window.event.keyCode=0;
	  return false;
	  //alert("Sólo números o la coma decimal")
  }
  return true;
}
function SOtxNombres() {
 if ((event.keyCode != 32) && (event.keyCode < 65) || (event.keyCode > 90) && (event.keyCode < 97) || (event.keyCode > 122))
  event.returnValue = false;
}

function SOtrim(myString)   {
     return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
}

function SOborraCampos() {
	
	document.getElementById("SOnombre").value = "";
	document.getElementById("SOemail").value = "";
	document.getElementById("SOapellidos").value = "";
	document.getElementById("SOtelefono").value = "";
	document.getElementById("SOcomentarios").value = "";
}


//........................................................................................................

SOCaptchaOK = 0;
SObodyCartaCli = "";
$(document).ready(function(){
   //selecciono todos los elementos de la clase "mitexto"
   //$("#SOmarcoMensaje").html("Introduzca sus datos");
   //var ElementoMensaje = $("#SOmarcoMensaje");
   //..............
   $("#SOnombre").change(function() {
		SOValidaNombre(); 
   });
   //..............
   $("#SOtelefono").change(function() {
		SOValidaTelefono(); 
   });
    //..............
   $("#SOemail").change(function() {
		SOVerificarDireccionCorreo(); 
   });
   
   //..............
   $('#SOcode').change(function() {
	SOComprobarCode(); 	
	});

   //..............
   $("#SOButton1").click(function() {
		SOEnviaFormulario();    
   });
    
    /*$("#SOButton2").click(function() {
		SOCierraCorreoSoliciInfo(); 
   });*/
   
});
//.......................................................................................................
function SOCierraCorreoSoliciInfo() {
	d = document.getElementById("CorreoSoliciInfo");
	d.style.display  = "none";
	

}
function SOMuestraCorreoSoliciInfo() {
	document.getElementById('CorreoSoliciInfo').style.display  = "block";
}
//.......................................................................................................
function SOValidaComentarios() {
	$("#SOmarcoMensaje").html(""); 
	var comenta = SOtrim($("#SOcomentarios").val());
	if (comenta.length < 10) {
		$("#SOmarcoMensaje").html("<span class='rojo'>Explica el motivo</span>");
		return false;
	}
	return true;
	
}
//.......................................................................................................
function SOComprobarCode() {
	  $("#SOmarcoMensaje").html("");  
      var parametros = {
             "code" : $('#SOcode').val()
     };
	$.ajax({
             data:  parametros,
             url:   '../php/VerificaCaptcha.php',
             type:  'post',
             beforeSend: function () {
                     $("#SOmarcoMensaje").html("Validando captcha...");
             },
             success:  function (response) {
                     //$("#SOrecogeMensajes").html(response);
					 if (response.trim() != "OK") {
						$("#SOmarcoMensaje").html("<span class='rojo'>Código captcha incorrecto</span>"); 
						SOCaptchaOK = 0;
						return false;
					 } else {
						$("#SOmarcoMensaje").html("");
						SOCaptchaOK = 1; 
						return true;
					 }
             }
        });
}
//.......................................................................................................
function SOValidaNombre() {
	$("#SOmarcoMensaje").html("");  
	if ( trim($("#SOnombre").val()).length <3 ) {
		$("#SOmarcoMensaje").html("<span class='rojo'>Informe el nombre</span>");
		return false;
	}
	return true;
	
}
//.......................................................................................................
function SOVerificarDireccionCorreo() {
$("#SOmarcoMensaje").html("");  
 var direccion = $("#SOemail").val();

if (direccion.length < 5) {
    $("#SOmarcoMensaje").html("<span class='rojo'>Informe un email</span>");
    return false;	
}
   var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
    if (regex.test($('#SOemail').val().trim())) {
        return true;	
    }
    else {
		$("#SOmarcoMensaje").html("<span class='rojo'>Formato de email incorrecto</span>");
        return false;
    }
}
//.......................................................................................................



//.......................................................................................................
function SOValidaTelefono() {
	$("#SOmarcoMensaje").html("");  
	var telefono = $("#SOtelefono").val();
	
	if (telefono.length == 0) {
		return true;
	}
	if ( $("#SOtelefono").html().length >0 && ($("#SOtelefono").html().length < 5 ||  $("#SOtelefono").html().length > 12)) {
		$("#SOmarcoMensaje").html("<span class='rojo'>El Teléfono no parece correcto</span>");
		return false;
	}
	return true;
	
}

//.......................................................................................................
function SOValidaFormulario() {
	$("#SOmarcoMensaje").html(""); 
	
	if (!SOValidaNombre()){
		return false;
	}
    if (!SOVerificarDireccionCorreo()){
		return false;
	}
	if (!SOValidaTelefono()){
		return false;
	}
	
	if (SOCaptchaOK == 0) {
		$("#SOmarcoMensaje").html("<span class='rojo'>Código captcha incorrecto, pulse de nuevo ENVIAR</span>");
		return false;
	}
    if (!SOValidaComentarios()){
		return false;
	}
	
	
	return true;
}
//.......................................................................................................
function SOEnviaFormulario(){
	
	if (!SOValidaFormulario()) {
		 return false;
	} 
    
   
	$('#SOButton1').css("display","none");
	
	 SOAnotaRegistroEmail();
	
	if (!SOResuelveBodyCarta()) {	
	     return false;	
	}
    return true;
}
//...........................................................................
function SOResuelveBodyCarta()	{
		     var parametros = {
        "nombre"        : $('#SOnombre').val() ,
			  "apellidos"     : $('#SOapellidos').val() ,
			  "email"         : $('#SOemail').val() ,
			  "telefono"      : $('#SOtelefono').val() ,
			  "ciudad"        :  "" ,
			  "comentarios"   : $('#SOcomentarios').val() ,
			  "Nombre_correo" : DENombre_correo  
              };  
		$.ajax({
             data:  parametros,
             url:   '../cartas/CartaConsultasCli.php',
             type:  'post',
             beforeSend: function () {
                      $("#SOmarcoMensaje").html("Componiendo carta ...."); 
             },
             success:  function (response) {
				 SObodyCartaCli = response;
				 SOEnviaCartas();
             },
			 error: function(){
                $("#SOmarcoMensaje").html("<span class='rojo'>Error componiendo carta</span>");
				$('#SObotones').css("display","inline");
				return false;
            }
        });	
	
	
}

//............................................................................
function SOEnviaCartas()	{
			  var parametros = {
        "nombre"        : $('#SOnombre').val() ,
			  "apellidos"     : $('#SOapellidos').val() ,
			  "email"         : $('#SOemail').val() ,
			  "telefono"      : $('#SOtelefono').val() ,
			  "ciudad"        : "" ,
			  "comentarios"   : $('#SOcomentarios').val() ,
			  "Nombre_correo" : DENombre_correo ,
			  "bodyCarta"     : SObodyCartaCli
              };  
	$.ajax({
             data:  parametros,
             url:   '../php/SoliciInfoEnviaMail.php',
             type:  'post',
             beforeSend: function () {
                      $("#SOmarcoMensaje").html("Enviando emails ...."); 
             },
             success:  function (response) {
					 if (response.trim() != "OK") {
						$("#SOmarcoMensaje").html("<span class='rojo'>"+response+"</span>"); 
						$('#SObotones').css("display","inline");
						return false;
					 } else {
						
						 $("#SOmarcoMensaje").html("Le hemos enviado un Email <br>En breve nos pondremos en contacto<br>Gracias por su confianza"); 
						return true;
					 }
             },
			 error: function(){
                $("#SOmarcoMensaje").html("<span class='rojo'>Error enviando Emails</span>");
				$('#SObotones').css("display","inline");
				return false;
            }
        });	
}

//............................................................................
function SOAnotaRegistroEmail()	{
			  var parametros = {
        "nombre"        : $('#SOnombre').val() ,
			  "apellidos"     : $('#SOapellidos').val() ,
			  "email"         : $('#SOemail').val() ,
			  "telefono"      : $('#SOtelefono').val() ,
			  "ciudad"        : "" ,
			  "comentarios"   : $('#SOcomentarios').val() ,
			  "emisor_correo" : DEemisorcorreo  
              };  
	 
	 
	$.ajax({
             data:  parametros,
             url:   '../php/AnotaSolicitudSoliciInfo.php',
             type:  'post',
             beforeSend: function () {
                    $("#SOmarcoMensaje").html("Anotando operación ......"); 
             },
             success:  function (response) {
					 if (response.trim() != "OK") {
						$("#SOmarcoMensaje").html("<span class='rojo'>"+response+"</span>"); 
						$('#SObotones').css("display","inline");
						return false;
					 } else {
						 $("#SOmarcoMensaje").html("Anotando operación ..."); 
						return true;
					 }
             },
			 error: function(){
                $("#SOmarcoMensaje").html("<span class='rojo'>Error anotando operación</span>");
				$('#SObotones').css("display","inline");
				return false;
            }
        });		
	
	
}
//...........................................................................
