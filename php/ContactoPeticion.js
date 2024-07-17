
//................................
function solonumeros() {
var key=window.event.keyCode;
//alert (key);
  if ((key < 48 || key > 57) && (key !=44)) {
	  window.event.keyCode=0;
	  return false;
	  //alert("Sólo números o la coma decimal")
  }
  return true;
}
function txNombres() {
 if ((event.keyCode != 32) && (event.keyCode < 65) || (event.keyCode > 90) && (event.keyCode < 97) || (event.keyCode > 122))
  event.returnValue = false;
}

function trim (myString)   {
     return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
}

function borraCampos() {
	
	document.getElementById("nombre").value = "";
	document.getElementById("email").value = "";
	document.getElementById("apellidos").value = "";
	document.getElementById("telefono").value = "";
	document.getElementById("ciudad").value = "";
	document.getElementById("comentarios").value = "";
}


//........................................................................................................

CaptchaOK = 0;
bodyCartaCli = "";
$(document).ready(function(){
   //selecciono todos los elementos de la clase "mitexto"
   $("#marcoMensaje").html("Introduzca sus datos");
   //var ElementoMensaje = $("#marcoMensaje");
   //..............
   $("#nombre").change(function() {
		ValidaNombre(); 
   });
   //..............
   $("#telefono").change(function() {
		ValidaTelefono(); 
   });
    //..............
   $("#email").change(function() {
		VerificarDireccionCorreo(); 
   });
   
   //..............
   $('#code').change(function()
    {
	ComprobarCode(); 	
	});

   //..............
   $("#Button1").click(function() {
		EnviaFormulario(); 
   });
   
});
//.......................................................................................................
//.......................................................................................................
function ValidaComentarios() {
	$("#marcoMensaje").html(""); 
	var comenta = $("#comentarios").val();
	if (comenta.length < 10) {
		$("#marcoMensaje").html("<span class='rojo'>Haga alguna observación o comentario</span>");
		return false;
	}
	return true;
	
}
//.......................................................................................................
function ComprobarCode() {
	  $("#marcoMensaje").html("");  
      var parametros = {
             "code" : $('#code').val()
     };
	$.ajax({
             data:  parametros,
             url:   '../php/VerificaCaptcha.php',
             type:  'post',
             beforeSend: function () {
                     $("#recogeMensajes").html("Procesando, espere por favor...");
             },
             success:  function (response) {
                     $("#recogeMensajes").html(response);
					 if ($("#recogeMensajes").html() != "OK") {
						$("#marcoMensaje").html("<span class='rojo'>Código incorrecto</span>"); 
						CaptchaOK = 0;
						return false;
					 } else {
						CaptchaOK = 1; 
						return true;
					 }
             }
        });
}
//.......................................................................................................
function ValidaNombre() {
	$("#marcoMensaje").html("");  
	if ( trim($("#nombre").val()).length <3 ) {
		$("#marcoMensaje").html("<span class='rojo'>Informe el nombre</span>");
		return false;
	}
	return true;
	
}
//.......................................................................................................
function VerificarDireccionCorreo() {
$("#marcoMensaje").html("");  
 var direccion = $("#email").val();

if (direccion.length < 5) {
    $("#marcoMensaje").html("<span class='rojo'>Informe un email</span>");
    return false;	
}
   var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
    if (regex.test($('#email').val().trim())) {
        return true;	
    }
    else {
		$("#marcoMensaje").html("<span class='rojo'>Formato de email incorrecto</span>");
        return false;
    }
}
//.......................................................................................................
function ValidaCiudad() {
	$("#marcoMensaje").html(""); 
	var telefono = $("#ciudad").val();
	if (telefono.length < 3) {
		$("#marcoMensaje").html("<span class='rojo'>Informe su ciudad</span>");
		return false;
	}
	return true;
	
}


//.......................................................................................................
function ValidaTelefono() {
	$("#marcoMensaje").html("");  
	var telefono = $("#telefono").val();
	
	if (telefono.length == 0) {
		return true;
	}
	if ( $("#telefono").html().length >0 && ($("#telefono").html().length < 5 ||  $("#telefono").html().length > 12)) {
		$("#marcoMensaje").html("<span class='rojo'>El Teléfono no parece correcto</span>");
		return false;
	}
	return true;
	
}

//.......................................................................................................
function ValidaFormulario() {
	$("#marcoMensaje").html(""); 
	
	if (!ValidaNombre()){
		return false;
	}
    if (!VerificarDireccionCorreo()){
		return false;
	}
	if (!ValidaTelefono()){
		return false;
	}
    if (!ValidaCiudad()){
		return false;
	}
	
	if (CaptchaOK == 0) {
		$("#marcoMensaje").html("<span class='rojo'>Código incorrecto</span>");
		return false;
	}
    if (!ValidaComentarios()){
		return false;
	}
	
	
	return true;
}
//.......................................................................................................
function EnviaFormulario(){
	if (!ValidaFormulario()) {
		 return false;
	} 
	$('#botones').css("display","none");
	if (!ResuelveBodyCarta()) {	
	          return false;	
	}
    return true;
}
//...........................................................................
function ResuelveBodyCarta()	{
		     var parametros = {
              "nombre"        : $('#nombre').val() ,
			  "apellidos"     : $('#apellidos').val() ,
			  "email"         : $('#email').val() ,
			  "telefono"      : $('#telefono').val() ,
			  "ciudad"        : $('#ciudad').val() ,
			  "comentarios"   : $('#comentarios').val() ,
			  "Nombre_correo" : Nombre_correo  
              };  
		$.ajax({
             data:  parametros,
             url:   '../cartas/CartaConsultasCli.php',
             type:  'post',
             beforeSend: function () {
                      $("#marcoMensaje").html("Componiendo carta ...."); 
             },
             success:  function (response) {
				 bodyCartaCli = response;
				 EnviaCartas();
             },
			 error: function(){
                $("#marcoMensaje").html("<span class='rojo'>Error componiendo carta</span>");
				$('#botones').css("display","inline");
				return false;
            }
        });	
	
	
}

//............................................................................
function EnviaCartas()	{
			  var parametros = {
              "nombre"        : $('#nombre').val() ,
			  "apellidos"     : $('#apellidos').val() ,
			  "email"         : $('#email').val() ,
			  "telefono"      : $('#telefono').val() ,
			  "ciudad"        : $('#ciudad').val() ,
			  "comentarios"   : $('#comentarios').val() ,
			  "Nombre_correo" : Nombre_correo ,
			  "bodyCarta"     : bodyCartaCli
              };  
	$.ajax({
             data:  parametros,
             url:   '../php/ContactoEnviaMail.php',
             type:  'post',
             beforeSend: function () {
                      $("#marcoMensaje").html("Enviando emails ...."); 
             },
             success:  function (response) {
					 if (response != "OK") {
						$("#marcoMensaje").html("<span class='rojo'>"+response+"</span>"); 
						$('#botones').css("display","inline");
						return false;
					 } else {
						 AnotaRegistroEmail();
						 //$("#marcoMensaje").html("Le hemos enviado un Email con sus datos<br>En breve nos pondremos en contacto<br>Gracias por su confianza"); 
						return true;
					 }
             },
			 error: function(){
                $("#marcoMensaje").html("<span class='rojo'>Error enviando Emails</span>");
				$('#botones').css("display","inline");
				return false;
            }
        });	
}

//............................................................................
function AnotaRegistroEmail()	{
			  var parametros = {
              "nombre"        : $('#nombre').val() ,
			  "apellidos"     : $('#apellidos').val() ,
			  "email"         : $('#email').val() ,
			  "telefono"      : $('#telefono').val() ,
			  "ciudad"        : $('#ciudad').val() ,
			  "comentarios"   : $('#comentarios').val() ,
			  "Nombre_correo" : Nombre_correo  
              };  
	 
	 
	$.ajax({
             data:  parametros,
             url:   '../php/ContactoNuevoMail.php',
             type:  'post',
             beforeSend: function () {
                    $("#marcoMensaje").html("Anotando operación ......"); 
             },
             success:  function (response) {
					 if (response != "OK") {
						$("#marcoMensaje").html("<span class='rojo'>"+response+"</span>"); 
						$('#botones').css("display","inline");
						return false;
					 } else {
						 $("#marcoMensaje").html("Le hemos enviado un Email con sus datos<br>En breve nos pondremos en contacto<br>Gracias por su confianza"); 
						return true;
					 }
             },
			 error: function(){
                $("#marcoMensaje").html("<span class='rojo'>Error enviando Emails</span>");
				$('#botones').css("display","inline");
				return false;
            }
        });		
	
	
}
//...........................................................................
