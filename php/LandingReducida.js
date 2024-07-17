function LDsolonumeros() {
	if ( (event.keyCode < 48  || event.keyCode > 57) && (event.keyCode != 44) ) {
      event.returnValue = false;
    }
}


function LDtxNombres() {
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
function LDtrim (myString)   {
     return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
}
function LDLipiaMensaje ()   {
      $("#mensajeLanding").html("&nbsp;");
}
//........................................................................................................
bodyCartaCli = "";

$(document).ready(function(){
   $("#mensajeLanding").html("Introduzca sus datos");
   $("#TuNombre").change(function() { LDValidaNombre(); });
   $("#TuCorreo").change(function() { LDVerificarDireccionCorreo(); });
   
   $( "#TuBox" ).mouseover(function() { LDLipiaMensaje(); });
   $("#LDButton2").click(function() { LDEnviaFormulario();  });
   $("#LDButton1").click(function() { CierraTomaDeDatos(0);  });
   $("#LDButton3").click(function() { CierraTomaDeDatos(0);  });
 });
//.......................................................................................................
function LDValidaNombre() {
	$("#mensajeLanding").html("");  
	var nombre = LDtrim($("#TuNombre").val());
	if ( LDtrim(nombre).length <3 ) {
		$("#mensajeLanding").html("<span class='rojo'>Informe el nombre</span>");
		return false;
	}
	if ( FormatoTxtValido(nombre) == false) {
		$("#mensajeLanding").html("<span class='rojo'>Formato Nombre incorrecto</span>");
		return false;
	}
	return true;
}
//.......................................................................................................
function LDVerificarDireccionCorreo() {
$("#mensajeLanding").html("");  
 var direccion = $("#TuCorreo").val();

if (direccion.length < 5) {
    $("#mensajeLanding").html("<span class='rojo'>Informe un email</span>");
    return false;	
}
   var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
    if (regex.test($('#TuCorreo').val().trim())) {
        return true;	
    }
    else {
		    $("#mensajeLanding").html("<span class='rojo'>Formato de email incorrecto</span>");
        return false;
    }
}
//.......................................................................................................
function LDValidaCheck () {
	if ($("#TuBox").prop('checked') ){
       return true;
    } else {
	  $("#mensajeLanding").html("<span class='rojo'>Confirme la política de privacidad</span>");	
	   return false;
	}
}

//.......................................................................................................
function LDValidaFormulario() {
	$("#mensajeLanding").html(""); 
	
	if (!LDValidaNombre()){
		return false;
	}
  if (!LDVerificarDireccionCorreo()){
		return false;
	}
  if (!LDValidaCheck()){
		return false;
	}
	return true;
}
//.......................................................................................................
function LDEnviaFormulario(){
	if (!LDValidaFormulario()) {
		 return false;
	} 
	$('#botonesAceptacion').css("display","none");
	//$("#mensajeLanding").html("Le estamos enviando un email");
	
	RealizaGestion();
	          //$("#mensajeLanding").html("<span class='rojo'>ERROR anotando la operación</span>"); 
	
	$("#mensajeFinal").css("display","block");
    return true;
}
//..................................................alta de la solicitud ........
//............................................................................
function RealizaGestion()	{
			  var parametros = {
        "nombre"        : $('#TuNombre').val() ,
			  "apellidos"     : '' ,
			  "email"         : $('#TuCorreo').val() ,
			  "telefono"      : '' ,
			  "ciudad"        : '' ,
			  "tipo"          : 'Curso Gratis' ,
			  "NumIdCurso"    : CursoEnPromocion
              };  
	 
	 
	$.ajax({
             data:  parametros,
             url:   'php/VTCursoGratisAlta.php',
             type:  'post',
			 async:  false,
             beforeSend: function () {
                    $("#mensajeLanding").html("Anotando operación ......"); 
             },
             success:  function (response) {
					 if (response.trim() != "OK") {
						$("#mensajeLanding").html("<span class='rojo'>"+response+"</span>"); 
						$('#botonesAceptacion').css("display","block");
						return false;
					 } else {
						LDResuelveBodyCarta();
						return true;
					 }
             },
			 error: function(){
        $("#mensajeLanding").html("<span class='rojo'>Error anotando operacion</span>");
				$('#botonesAceptacion').css("display","inline");
				return false;
            }
        });		
	
	
}


//...........................................................................
function LDResuelveBodyCarta()	{
		    var parametros = {
        "nombre"        : $('#TuNombre').val() ,
			  "apellidos"     : '' ,
			  "email"         : $('#TuCorreo').val() ,
			  "telefono"      : '' ,
			  "ciudad"        : '' ,
			  "tipo"          : 'Curso Gratis' ,
			  "NumIdCurso"    : CursoEnPromocion
             };  

		$.ajax({
             data:  parametros,
             url:   'cartas/CartaVTCursoGratis.php',
             type:  'post', 
			 async: false,
             beforeSend: function () {
                      $("#mensajeLanding").html("Componiendo carta ...."); 
             },
             success:  function (response) {
				 bodyCartaCli = response;
				 $("#mensajeLanding").html(""); 
				 LDEnviaCartas();
				 return true;
             },
			 error: function(){
                $("#mensajeLanding").html("<span class='rojo'>Error componiendo carta</span>");
				$('#botonesAceptacion').css("display","inline");
				return false;
            }
        });	
	
	
}

//............................................................................
function LDEnviaCartas()	{
			  var parametros = {
              "nombre"        : $('#TuNombre').val() ,
			  "apellidos"     : '' ,
			  "email"         : $('#TuCorreo').val() ,
			  "telefono"      : '' ,
			  "ciudad"        : '' ,
			  "bodyCarta"     : bodyCartaCli,
			  "NumIdCurso"    : CursoEnPromocion
              };  
	$.ajax({
             data:  parametros,
             url:   'php/VTCursoGratisEnviaMail.php',
             type:  'post',
			 async: false,
             beforeSend: function () {
                      //$("#mensajeLanding").html("Enviando emails ...."); 
             },
             success:  function (response) {
					 if (response.trim() != "OK") {
						$("#mensajeLanding").html("<span class='rojo'>"+response+"</span>"); 
						$('#botonesAceptacion').css("display","block");
						return false;
					 } else {
						 //AnotaRegistroEmail();
						//$("#mensajeLanding").html("Le hemos enviado un Email con sus datos<br>Confirme la inscripcon al curso desde su correo<br>Gracias por su confianza"); 
						return true;
					 }
             },
			 error: function(){
                $("#mensajeLanding").html("<span class='rojo'>Error enviando Emails</span>");
				$('#botonesAceptacion').css("display","inline");
				return false;
            }
        });	
}


//...........................................................................



