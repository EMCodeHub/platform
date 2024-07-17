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
    var regex = /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/g;
    if (regex.test(Txt)) {
        return true;	
    }
return false;	
}
function Sestrim (myString)   {
     return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
}
function SesLipiaMensaje ()   {
      $("#SesMensaje").html("&nbsp;");
}
//........................................................................................................
bodyCartaSesion = "";
//...................................................................................................
//.......................................................................................................
function SesValidaDireccionCorreo() {
$("#SesMensaje").html("&nbsp;");  
 var direccion = $("#SesCorreo").val();
if (direccion.length < 5) {
    $("#SesMensaje").html("<span class='rojo'>Informe un email</span>");
    return false;	
}
   var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
    if (regex.test($('#SesCorreo').val().trim())) {
        return true;	
    } else {
        $("#SesMensaje").html("<span class='rojo'>Formato de email incorrecto</span>");
        $("#SesCorreo").focus();
        return false;
    }
}
//.......................................................................................................
function SesValidaTelefono() {
	$("#SesMensaje").html("&nbsp;");  
	var telefono = $("#SesTelefono").val();
	if (telefono.length < 6 || telefono.length > 12 ) {
		$("#SesMensaje").html("<span class='rojo'>El Teléfono no parece correcto</span>");
        $("#SesTelefono").focus();
		return false;
	}
	return true;
}

//.......................................................................


//.......................................................................................................
function SesValidaNombre() {
	$("#SesMensaje").html("&nbsp;");  
	var nombre = Sestrim($("#SesNombre").val());
	if ( Sestrim(nombre).length <3 ) {
		$("#SesMensaje").html("<span class='rojo'>Informe el nombre</span>");
		return false;
	}
	if ( SesFormatoTxtValido(nombre) == false) {
		$("#SesMensaje").html("<span class='rojo'>Formato Nombre incorrecto</span>");
        $("#SesNombre").focus();
		return false;
	}
	return true;
}
//.......................................................................................................
function SesValidaApellidos() {
	$("#SesMensaje").html("&nbsp;");  
	var apellidos = Sestrim($("#SesApellidos").val());
	if ( Sestrim(apellidos).length <3 ) {
		$("#SesMensaje").html("<span class='rojo'>Informe los apellidos</span>");
		return false;
	}
	if ( SesFormatoTxtValido(apellidos) == false) {
		$("#SesMensaje").html("<span class='rojo'>Formato Apellidos incorrecto</span>");
		$("#SesApellidos").focus();
        return false;
	}
	return true;
}

//.......................................................................................................
function SesValidaCiudad() {
	$("#SesMensaje").html("&nbsp;");  
	var ciudad = Sestrim($("#SesCiudad").val());
	if ( Sestrim(ciudad).length <3 ) {
		$("#SesMensaje").html("<span class='rojo'>Informe los apellidos</span>");
		return false;
	}
	if ( SesFormatoTxtValido(ciudad) == false) {
		$("#SesMensaje").html("<span class='rojo'>Formato Ciudad incorrecto</span>");
		$("#SesCiudad").focus();
        return false;
	}
	return true;
}

//.......................................................................................................
function SesValidaPais() {
	$("#SesMensaje").html("&nbsp;"); 
	var pais = Sestrim($("#SesPais").val());
	if (pais.length < 3) {
		$("#SesMensaje").html("<span class='rojo'>Informe su país</span>");
        $("#SesPais").focus();
		return false;
	}
	if (SesFormatoTxtValido(pais) == false) {
		$("#SesMensaje").html("<span class='rojo'>Formato Pais incorrecto</span>");
        $("#SesPais").focus();
		return false;
	}
	return true;
	
}
//.......................................................................................................
function SesValidaObservaciones() {
	$("#SesMensaje").html("&nbsp;"); 
	var pais = Sestrim($("#SesObservaciones").val());
	if (pais.length < 3) {
		$("#SesMensaje").html("<span class='rojo'>Informe sobre el tipo de proyectos que realiza</span>");
        $("#SesObservaciones").focus();
		return false;
	}
	return true;
	
}
//.......................................................................................................
function SesValidaHora() {
	$("#SesMensaje").html("&nbsp;"); 
	var hora = $('#SesHora').val()
	if (hora < 8) {
		$("#SesMensaje").html("<span class='rojo'>Informe la hora de inicio</span>");
        $("#SesHora").focus();
		return false;
	}
	return true;
	
}

//.......................................................................................................
function SesValidaFormulario() {
	$("#SesMensaje").html("&nbsp;"); 
	if (!SesValidaHora()){
		return false;
	}
	if (!SesValidaDireccionCorreo()){
		return false;
	}
	if (!SesValidaTelefono()){
		return false;
	}
   
	if (!SesValidaNombre()){
		return false;
	}
    if (!SesValidaApellidos()){
		return false;
	}
   if (!SesValidaCiudad()){
		return false;
	}
    if (!SesValidaPais()){
		return false;
	}
    if (!SesValidaObservaciones()){
		return false;
	}
	return true;
}
//.......................................................................................................
function CerrarSolicitudSesion(){
    window.location.reload();
    /*$('#AsesoriaForm3').css("display","none");
    $('#AsesoriaForm').css("display","none");
    $('#AsesoriaCartel').css("display","block");*/
}

//.......................................................................................................
function EnviaSolicitudSesion(){
	if (!SesValidaFormulario()) {
		 return false;
	} 
	$('#SesBotonAceptar').css("display","none");
    $('#SesBotonSalir').css("display","none");
	$("#SesMensaje").html("Anotando Reserva");
	
	RealizaGestion();
	   
    return true;
}
//..................................................alta de la solicitud ........
//............................................................................
function RealizaGestion() {
  var parametros = {
              "Dia"           : $('#SesDia').val() ,
			  "Hora"          : $('#SesHora').val() ,
			  "Correo"        : $('#SesCorreo').val() ,
			  "Telefono"      : $('#SesTelefono').val() ,
			  "UsuSkype"      : $('#SesUsuSkype').val() ,
			  "Nombre"        : $('#SesNombre').val() ,
			  "Apellidos"     : $('#SesApellidos').val() ,
			  "Ciudad"        : $('#SesCiudad').val() ,
			  "Pais"          : $('#SesPais').val() ,
			  "Observaciones" : $('#SesObservaciones').val()		  
  };  
	 
	$.ajax({
             data:  parametros,
             url:   '../php/AsesoriaSolicitudAltaSesioncypee.php',
             type:  'post',
			 async:  false,
             beforeSend: function () {
                    $("#SesMensaje").html("Anotando operación ......"); 
             },
             success:  function (response) {
					 if (response.trim() != "OK") {
						$("#SesMensaje").html("<span class='rojo'>"+response+"</span>"); 
				        $('#SesBotonAceptar').css("display","block");
                        $('#SesBotonSalir').css("display","block");
						return false;
					 } else { 
                         SesResuelveBodyCarta();
						return true;
					 }
             },
			 error: function(){
                $("#SesMensaje").html("<span class='rojo'>Error anotando operacion</span>");
				$('#SesBotonAceptar').css("display","inline-block");
                $('#SesBotonSalir').css("display","inline-block");
				return false;
            }
        });		
}
//...........................................................................
function SesResuelveBodyCarta()	{
  var parametros = {
              "Dia"           : $('#SesDia').val() ,
			  "Hora"          : $('#SesHora').val() ,
			  "Correo"        : $('#SesCorreo').val() ,
			  "Telefono"      : $('#SesTelefono').val() ,
			  "UsuSkype"      : $('#SesUsuSkype').val() ,
			  "Nombre"        : $('#SesNombre').val() ,
			  "Apellidos"     : $('#SesApellidos').val() ,
			  "Ciudad"        : $('#SesCiudad').val() ,
			  "Pais"          : $('#SesPais').val() ,
			  "Observaciones" : $('#SesObservaciones').val()		  
  };  
		$.ajax({
             data:  parametros,
             url:   '../cartas/CartaAsesoriaSesioncypee.php',
             type:  'post', 
			 async: false,
             beforeSend: function () {
                      $("#SesMensaje").html("Componiendo carta ...."); 
             },
             success:  function (response) {
				 bodyCartaSesion = response;
                 
                 //$("#SesMensaje").html(bodyCartaSesion); 
                 
                 $("#SesMensaje").html("&nbsp;"); 
                 SesEnviaCartas();
				 return true;
             },
			 error: function(){
                $("#SesMensaje").html("<span class='rojo'>Error componiendo carta</span>");
				$('#SesBotonAceptar').css("display","inline-block");
                $('#SesBotonSalir').css("display","inline-block");
				return false;
            }
        });	
	
	
}

//............................................................................
function SesEnviaCartas()	{
  var parametros = {
              "Dia"           : $('#SesDia').val() ,
			  "Hora"          : $('#SesHora').val() ,
			  "Correo"        : $('#SesCorreo').val() ,
			  "Telefono"      : $('#SesTelefono').val() ,
			  "UsuSkype"      : $('#SesUsuSkype').val() ,
			  "Nombre"        : $('#SesNombre').val() ,
			  "Apellidos"     : $('#SesApellidos').val() ,
			  "Ciudad"        : $('#SesCiudad').val() ,
			  "Pais"          : $('#SesPais').val() ,
			  "Observaciones" : $('#SesObservaciones').val(),
              "BodyCarta"     : bodyCartaSesion
  };  
	$.ajax({
             data:  parametros,
             url:   '../php/AsesoriaSesionEnviaMailcypee.php',
             type:  'post',
			 async: false,
             beforeSend: function () {
                      //$("#SesMensaje").html("Enviando emails ...."); 
             },
             success:  function (response) {
					 if (response.trim() != "OK") {
						$("#SesMensaje").html("<span class='rojo'>"+response+"</span>"); 
                        $('#SesBotonAceptar').css("display","inline-block");
                        $('#SesBotonSalir').css("display","inline-block");
						return false;
					 } else {
						
						$("#SesMensaje").html("Le hemos enviado un Email para CONFIRMAR la reserva<br>(Compruebe el correo no deseado)"); 
						$('#SesBotonSalir').css("display","inline-block");
                         return true;
                         
					 }
             },
			 error: function(){
                $("#SesMensaje").html("<span class='rojo'>Error enviando Emails</span>");
				$('#SesBotonAceptar').css("display","inline-block");
                $('#SesBotonSalir').css("display","inline-block");
				return false;
            }
        });	
}


//...........................................................................



