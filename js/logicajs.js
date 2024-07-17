


function SesSolonumeros() {
	if ( (event.keyCode < 48  || event.keyCode > 57) && (event.keyCode != 44) ) {
      event.returnValue = false;
    }
}


function SestxNombres() {
 if ((event.keyCode != 32) && (event.keyCode < 65) || (event.keyCode > 90) && (event.keyCode < 97) || (event.keyCode > 122))
  event.returnValue = false;
}



function SesFormatoTxtValido(Txt) {
    var regex = /^[a-zA-ZÀ-ÿ\u00f1\u00d1\d]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1\d]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1\d]+$/g;
    if (regex.test(Txt)) {
        return true;    
    }

    return false;    
}



function Sestrim (myString)   {
     return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
}


function SesLipiaMensaje ()   {
      $("#respuestaa").html("&nbsp;");
}



function SesValidaNombre() {
	$("#respuestaa").html("&nbsp;");  
	var nombre = Sestrim($("#nombre").val());
	if ( Sestrim(nombre).length <3 ) {
		$("#respuestaa").html("<br><br><span class='rojo'>Informe el nombre</span>");
		return false;
	}

	if ( SesFormatoTxtValido(nombre) == false) {
		$("#respuestaa").html("<br><br><span class='rojo'>Formato Nombre incorrecto</span>");
        $("#respuestaa").focus();
		return false;
	}
	return true;
}




function SesValidaCelular() {

	$("#respuestaa").html("&nbsp;");  
	var celular = Sestrim($("#celular").val());
	if ( Sestrim(celular).length <5 ) {
		$("#respuestaa").html("<br><br><span class='rojo'>Informe el celular</span>");
		return false;
	}

	if ( SesFormatoTxtValido(celular) == false) {
		$("#respuestaa").html("<br><br><span class='rojo'>Formato Celular incorrecto</span>");
        $("#respuestaa").focus();
		return false;
	}
	return true;
}





	function SesValidaDireccionCorreo() {
$("#respuestaa").html("&nbsp;");  
 var direccion = $("#email").val();
if (direccion.length < 5) {
    $("#respuestaa").html("<br><br><span class='rojo'>Informe un email</span>");
    return false;	
}
   var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
    if (regex.test($('#email').val().trim())) {
        return true;	
    } else {
        $("#respuestaa").html("<br><br><span class='rojo'>Formato de email incorrecto</span>");
        $("#email").focus();
        return false;
    }
}
	


	function SesValidaMensaje() {

	$("#respuestaa").html("&nbsp;");  
	var mensaje = Sestrim($("#mensaje").val());

	if ( Sestrim(mensaje).length <3 ) {
		$("#respuestaa").html("<br><br><span class='rojo'>Informe un mensaje</span>");
		return false;
	}

	return true;
}


	function SesValidaFormulario() {

	$("#respuestaa").html("&nbsp;"); 


	if (!SesValidaDireccionCorreo()){
		return false;
	}


    if (!SesValidaCelular()){
		return false;
	}



	if (!SesValidaNombre()){
		return false;
	}
 


	if (!SesValidaMensaje()){
		return false;
	}

	return true;
}




function EnviaSolicitudSesion(){
	if (!SesValidaFormulario()) {
		 return false;
	} 
	$('#Enviar').css("display","none");
 
	RealizaGestion();
	   
    return true;
}




function RealizaGestion() {

  var parametros = {

  
	          "nombre"          : $('#nombre').val() ,
			  "correo"            : $('#email').val() ,
              "celular"            : $('#celular').val(),
			  "mensaje"          : $('#mensaje').val() 
			  
  };  
	 
	$.ajax({
             data:  parametros,
             url:   '/emdevapps/php/back.php',
             type:  'post',
			 async:  true,
             beforeSend: function () {
                    $("#respuestaa").html("Anotando operación ......"); 
             },


             success:  function (res) {
					 if (res.trim() != "OK") {

						$("#respuestaa").html(res); 

				       

					   SesResuelveBodyCarta();
						
					   return false;

					 } else { 


						$("#respuestaa").html(res); 

						
						SesResuelveBodyCarta();

						return true;

					 }
             },
			 error: function(){
                $("#respuestaa").html("<span class='rojo'>Error</span>");
			
               
				return false;
            }
        });		
}



bodyCartaSesion = "";


function SesResuelveBodyCarta()	{
  var parametros = {
         
			  "nombre"          : $('#nombre').val() ,
			  "correo"            : $('#email').val() ,
              "celular"            : $('#celular').val(),
			  "mensaje"          : $('#mensaje').val() 

  };  
		$.ajax({
             data:  parametros,
             url:   '/cartas/CartaAsesoriaSesion.php',
             type:  'post', 
			 async: false,
             beforeSend: function () {
                      $("#respuestaa").html("Componiendo carta ...."); 
             },
             success:  function (response) {
				 bodyCartaSesion = response;
                 
                
                 
                 $("#respuestaa").html("&nbsp;"); 
                 SesEnviaCartas();
				 return true;
             },
			 error: function(){
                $("#respuestaa").html("<span class='rojo'>Error enviando correo</span>");
			
				return false;
            }
        });	
	
	
}




function SesEnviaCartas()	{
  var parametros = {


			  "nombre"          : $('#nombre').val() ,
			  "correo"            : $('#email').val() ,
              "celular"            : $('#celular').val(),
			  "mensaje"          : $('#mensaje').val(),
              "BodyCarta"     : bodyCartaSesion
  };  
	$.ajax({
             data:  parametros,
             url:   '/emdevapps/php/AsesoriaSesionEnviaMail.php',
             type:  'post',
			 async: false,
             beforeSend: function () {
                      //$("#SesMensaje").html("Enviando emails ...."); 
             },
             success:  function (response) {

					 if (response.trim() != "OK") {
						$("#respuestaa").html("<span class='rojo'>"+response+"</span>"); 
                     
						return false;
					 } else {
						
						$("#respuestaa").html("<span class='ok'>Le llegará un email con la información (revise correo no deseado) </span>"); 
						
                         return true;
                         
					 }
             },
			 error: function(){
                $("#respuestaa").html("<span class='rojo'>Error enviando Emails</span>");	
                
			return false;
            }
        });	
}



$(document).ready(function() {


$("#nombre").change(function() { SesValidaNombre(); });


$("#email").change(function() { SesValidaDireccionCorreo(); });

$("#celular").change(function() { SesValidaCelular(); });


$("#mensaje").change(function() { SesValidaMensaje(); });


$("#Enviar").click(function() { EnviaSolicitudSesion(); }); 



});




