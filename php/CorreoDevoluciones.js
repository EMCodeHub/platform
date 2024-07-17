
//................................
function CDsolonumeros() {
var key=window.event.keyCode;
//alert (key);
  if ((key < 48 || key > 57) && (key !=44)) {
	  window.event.keyCode=0;
	  return false;
	  //alert("Sólo números o la coma decimal")
  }
  return true;
}
function CDtxNombres() {
 if ((event.keyCode != 32) && (event.keyCode < 65) || (event.keyCode > 90) && (event.keyCode < 97) || (event.keyCode > 122))
  event.returnValue = false;
}

function CDtrim(myString)   {
     return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
}

function CDborraCampos() {
	
	document.getElementById("nombre").value = "";
	document.getElementById("email").value = "";
	document.getElementById("apellidos").value = "";
	document.getElementById("telefono").value = "";
	document.getElementById("comentarios").value = "";
}


//........................................................................................................

CaptchaOK = 0;
bodyCartaCli = "";
$(document).ready(function(){
   //selecciono todos los elementos de la clase "mitexto"
   //$("#CDmarcoMensaje").html("Introduzca sus datos");
   //var ElementoMensaje = $("#CDmarcoMensaje");
   //..............
   $("#nombre").change(function() {
		CDValidaNombre(); 
   });
   //..............
   $("#telefono").change(function() {
		CDValidaTelefono(); 
   });
    //..............
   $("#email").change(function() {
		CDVerificarDireccionCorreo(); 
   });
   
   //..............
   $('#code').change(function() {
	CDComprobarCode(); 	
	});

   //..............
   $("#Button1").click(function() {
		CDEnviaFormulario(); 
   });
    $("#Button2").click(function() {
		CDCierraCorreoDevoluciones(); 
   });
   
});
//.......................................................................................................
function CDCierraCorreoDevoluciones() {
	d = document.getElementById("CorreoDevoluciones");
	d.style.display  = "none";
	

}
function CDMuestraCorreoDevoluciones() {
	document.getElementById('CorreoDevoluciones').style.display  = "block";
}
//.......................................................................................................
function CDValidaComentarios() {
	$("#CDmarcoMensaje").html(""); 
	var comenta = CDtrim($("#comentarios").val());
	if (comenta.length < 10) {
		$("#CDmarcoMensaje").html("<span class='rojo'>Explica el motivo</span>");
		return false;
	}
	return true;
	
}
//.......................................................................................................
function CDComprobarCode() {
	  $("#CDmarcoMensaje").html("");  
      var parametros = {
             "code" : $('#code').val()
     };
	$.ajax({
             data:  parametros,
             url:   'php/VerificaCaptcha.php',
             type:  'post',
             beforeSend: function () {
                     $("#CDmarcoMensaje").html("Validando captcha...");
             },
             success:  function (response) {
                     //$("#CDrecogeMensajes").html(response);
					 if (response.trim() != "OK") {
						$("#CDmarcoMensaje").html("<span class='rojo'>Código captcha incorrecto</span>"); 
						CaptchaOK = 0;
						return false;
					 } else {
						$("#CDmarcoMensaje").html("");
						CaptchaOK = 1; 
						return true;
					 }
             }
        });
}
//.......................................................................................................
function CDValidaNombre() {
	$("#CDmarcoMensaje").html("");  
	if ( trim($("#nombre").val()).length <3 ) {
		$("#CDmarcoMensaje").html("<span class='rojo'>Informe el nombre</span>");
		return false;
	}
	return true;
	
}
//.......................................................................................................
function CDVerificarDireccionCorreo() {
$("#CDmarcoMensaje").html("");  
 var direccion = $("#email").val();

if (direccion.length < 5) {
    $("#CDmarcoMensaje").html("<span class='rojo'>Informe un email</span>");
    return false;	
}
   var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
    if (regex.test($('#email').val().trim())) {
        return true;	
    }
    else {
		$("#CDmarcoMensaje").html("<span class='rojo'>Formato de email incorrecto</span>");
        return false;
    }
}
//.......................................................................................................



//.......................................................................................................
function CDValidaTelefono() {
	$("#CDmarcoMensaje").html("");  
	var telefono = $("#telefono").val();
	
	if (telefono.length == 0) {
		return true;
	}
	if ( $("#telefono").html().length >0 && ($("#telefono").html().length < 5 ||  $("#telefono").html().length > 12)) {
		$("#CDmarcoMensaje").html("<span class='rojo'>El Teléfono no parece correcto</span>");
		return false;
	}
	return true;
	
}

//.......................................................................................................
function CDValidaFormulario() {
	$("#CDmarcoMensaje").html(""); 
	
	if (!CDValidaNombre()){
		return false;
	}
    if (!CDVerificarDireccionCorreo()){
		return false;
	}
	if (!CDValidaTelefono()){
		return false;
	}
	
	if (CaptchaOK == 0) {
		$("#CDmarcoMensaje").html("<span class='rojo'>Código captcha incorrecto, pulse de nuevo ENVIAR</span>");
		return false;
	}
    if (!CDValidaComentarios()){
		return false;
	}
	
	
	return true;
}
//.......................................................................................................
function CDEnviaFormulario(){
	
	if (!CDValidaFormulario()) {
		 return false;
	} 
	$('#CDbotones').css("display","none");
	
	 CDAnotaRegistroEmail();
	
	if (!CDResuelveBodyCarta()) {	
	     return false;	
	}
    return true;
}
//...........................................................................
function CDResuelveBodyCarta()	{
		     var parametros = {
              "nombre"        : $('#nombre').val() ,
			  "apellidos"     : $('#apellidos').val() ,
			  "email"         : $('#email').val() ,
			  "telefono"      : $('#telefono').val() ,
			  "ciudad"        :  "" ,
			  "comentarios"   : $('#comentarios').val() ,
			  "Nombre_correo" : DENombre_correo  
              };  
		$.ajax({
             data:  parametros,
             url:   'cartas/CartaConsultasCli.php',
             type:  'post',
             beforeSend: function () {
                      $("#CDmarcoMensaje").html("Componiendo carta ...."); 
             },
             success:  function (response) {
				 bodyCartaCli = response;
				 CDEnviaCartas();
             },
			 error: function(){
                $("#CDmarcoMensaje").html("<span class='rojo'>Error componiendo carta</span>");
				$('#CDbotones').css("display","inline");
				return false;
            }
        });	
	
	
}

//............................................................................
function CDEnviaCartas()	{
			  var parametros = {
              "nombre"        : $('#nombre').val() ,
			  "apellidos"     : $('#apellidos').val() ,
			  "email"         : $('#email').val() ,
			  "telefono"      : $('#telefono').val() ,
			  "ciudad"        : "" ,
			  "comentarios"   : $('#comentarios').val() ,
			  "Nombre_correo" : DENombre_correo ,
			  "bodyCarta"     : bodyCartaCli
              };  
	$.ajax({
             data:  parametros,
             url:   'php/ReembolsoEnviaMail.php',
             type:  'post',
             beforeSend: function () {
                      $("#CDmarcoMensaje").html("Enviando emails ...."); 
             },
             success:  function (response) {
					 if (response.trim() != "OK") {
						$("#CDmarcoMensaje").html("<span class='rojo'>"+response+"</span>"); 
						$('#CDbotones').css("display","inline");
						return false;
					 } else {
						
						 $("#CDmarcoMensaje").html("Le hemos enviado un Email <br>En breve nos pondremos en contacto<br>Gracias por su confianza"); 
						return true;
					 }
             },
			 error: function(){
                $("#CDmarcoMensaje").html("<span class='rojo'>Error enviando Emails</span>");
				$('#CDbotones').css("display","inline");
				return false;
            }
        });	
}

//............................................................................
function CDAnotaRegistroEmail()	{
			  var parametros = {
              "nombre"        : $('#nombre').val() ,
			  "apellidos"     : $('#apellidos').val() ,
			  "email"         : $('#email').val() ,
			  "telefono"      : $('#telefono').val() ,
			  "ciudad"        : "" ,
			  "comentarios"   : $('#comentarios').val() ,
			  "emisor_correo" : DEemisorcorreo  
              };  
	 
	 
	$.ajax({
             data:  parametros,
             url:   'php/AnotaSolicitudDevolucion.php',
             type:  'post',
             beforeSend: function () {
                    $("#CDmarcoMensaje").html("Anotando operación ......"); 
             },
             success:  function (response) {
					 if (response.trim() != "OK") {
						$("#CDmarcoMensaje").html("<span class='rojo'>"+response+"</span>"); 
						$('#CDbotones').css("display","inline");
						return false;
					 } else {
						 $("#CDmarcoMensaje").html("Anotando operación ..."); 
						return true;
					 }
             },
			 error: function(){
                $("#CDmarcoMensaje").html("<span class='rojo'>Error anotando operación</span>");
				$('#CDbotones').css("display","inline");
				return false;
            }
        });		
	
	
}
//...........................................................................
