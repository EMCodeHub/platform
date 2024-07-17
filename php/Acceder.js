function ACCPwdOlvidado() {
	
	if (!ACCValidaDireccionCorreo()) {
		 return false;
	} 
     ACCControlExisteCliente();
}
//...........................................................................
function ACCControlExisteCliente()	{
		     var parametros = {
              "usuario" : $('#TuCorreo').val() 
              };  
		$.ajax({
			 async:false, 
             data:  parametros,
             url:   '../php/PerdidaPassword.php',
             type:  'post',
             beforeSend: function () {
                      $("#mensajeAcceder").html("Verificando usuario"); 
             },
             success:  function (response) {	
				   if (response != "OK") {
						$("#mensajeAcceder").html(response); 
						return "0";
				   } else {
					   $("#mensajeAcceder").html("Le hemos enviado un e-mail con su password"); 
						return "1";
				   }
 
             },
			 error: function(){
                $("#mensajeAcceder").html("Error verificando e-mail");
				return "0";
            }
        });	
	

}
function FormatoTxtValido(Txt) {
    var regex = /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/g;
    if (regex.test(Txt)) {
        return true;	
    }
return false;	
}


function FormatoPwd(Txt) {
    //var regex = /^[a-zA-Z0-9]+$/;....>  ^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,15}$
    //var regex = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/;    
    var regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,15}$/;
    if (Txt.match(regex)!=null) {
        return true;	
    }
return false;	
}





function ACCTrim (myString)   {
     return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
}

//........................................................................................................

bodyCartaCli = "";
$(document).ready(function(){
    $("#TuCorreo").change(function() { ACCValidaDireccionCorreo(); });
    $("#TuAlias").change(function() { REGValidaAlias(); });
    $("#TuBoxReg" ).mouseover(function() { REGLimpiaMensaje(); });
    $("#Conecta").click(function() { ACC1EnviaFormulario();  });
    $("#BtnRegistro").click(function() { REGEnviaFormulario();  }); 
   
    $("#PerfilAlias").change(function() { PerfilValidaAlias(); });
    $("#PerfilDescripcion").change(function() { PerfilValidaDescripcion(); });
    $("#BtnPerfil").click(function() { ValidaPerfil();  }); 
    
 });
//.......................................................................................................
function REGLimpiaMensaje ()   {
      $("#mensajeRegistro").html("&nbsp;");
}
//.......................................................................................................
function REGValidaAlias() {
   $("#mensajeRegistro").html("");  
	var alias = ACCTrim($("#TuAlias").val());
	if ( ACCTrim(alias).length <3 ) {
		$("#mensajeRegistro").html("<span class='rojo'>Informe el alias</span>");
		return false;
	}
	if ( FormatoTxtValido(alias) == false) {
        $("#mensajeRegistro").html("<span class='rojo'>Alias: Sólo letras y números</span>");
		return false;
	} 
    
	return true; 
    
}
//.......................................................................................................
function ACCValidaDireccionCorreo() {
$("#mensajeAcceder").html("");  
 var direccion = $("#TuCorreo").val();

if (direccion.length < 5) {
    $("#mensajeAcceder").html("<span class='rojo'>Informe un email</span>");
    return false;	
}
   var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
    if (regex.test($('#TuCorreo').val().trim())) {
        return true;	
    }
    else {
        $("#mensajeAcceder").html("<span class='rojo'>Formato de email incorrecto</span>");
        return false;
    }
}
//.......................................................................................................
function REGValidaDireccionCorreo() {
$("#mensajeRegistro").html("");  
 var direccion = $("#TuEmailReg").val();

if (direccion.length < 5) {
    $("#mensajeRegistro").html("<span class='rojo'>Informe un email</span>");
    return false;	
}
   
  var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
    if (regex.test($('#TuEmailReg').val().trim())) {
        return true;	
    }
    else {
        $("#mensajeRegistro").html("<span class='rojo'>Formato de email incorrecto</span>");
        return false;
    }
}
//..................................................................................
function ACCValidaPwd() {
    var dato = $("#TuPwd").val();
    if (dato.length < 6  ) {
        $("#mensajeAcceder").html("<span class='rojo'>Contraseña debe tener más de 5 caracteres</span>");
        return false;
    }
    //if ( FormatoPwd(dato) == false) {
	//	$("#mensajeAcceder").html("<span class='rojo'>Password: Mínimo de ocho y máximo de 10 caracteres, al menos una letra mayúscula, una letra minúscula, un número y un carácter especial</span>");
     //   return false;
	//}
    return true;
}
//.......................................................................................................
function REGValidaPwd() {
	$("#mensajeRegistro").html(""); 
	var pwd = ACCTrim($("#TuPwdReg").val());
	if (pwd.length < 6) {
		$("#mensajeRegistro").html("<span class='rojo'>Informe una contaseña</span>");
		return false;
	}
	if (FormatoPwd(pwd) == false) {
		$("#mensajeRegistro").html("<span class='rojo'>Contraseña: Mínimo de seis y máximo de 15 caracteres, al menos una letra mayúscula, una letra minúscula y un número</span>");
        return false;
	}
	return true;
	
}
function REGValidaCheck () {
	if ($("#TuBoxReg").prop('checked') ){
       return true;
    } else {
        $("#mensajeRegistro").html("<span class='rojo'>Confirme la política de privacidad</span>");	
        return false;
	}
}
//.......................................................................................................
function REGValidaDescripcion() {
	$("#mensajeRegistro").html(""); 
	var descri = ACCTrim($("#TuDescripcion").val());
    if (descri.length == 0) {
        return true;
        }
	if ( FormatoTxtValido(descri) == false) {
		$("#mensajeRegistro").html("<span class='rojo'>Descripción: Sólo letras y números</span>");
        return false;
	}
	return true;
	
}


//.......................................................................................................
function ACC1ValidaFormulario() {
	$("#mensajeAcceder").html(""); 
	
    if (!ACCValidaDireccionCorreo()){
		return false;
	}
    if (!ACCValidaPwd()){
		return false;
	}
	return true;
}
//.......................................................................................................
function REGValidaFormulario() {
	$("#mensajeRegistro").html(""); 
    
    if (!REGValidaAlias()){
		return false;
	}
    if (!REGValidaDescripcion()){
		return false;
	}
    if (!REGValidaDireccionCorreo()){
		return false;
	}
    
    if (!REGValidaPwd()){
		return false;
	}
    
    if (!REGValidaCheck()){
		return false;
	}
    
    
	return true;
}
//.......................................................................................................
function ACC1EnviaFormulario(){
	if (!ACC1ValidaFormulario()) {
        return false;
	} 
	UsuarioOK();
}
//.......................................................................................................
function REGEnviaFormulario(){
	if (!REGValidaFormulario()) {
        return false;
	} 
	REGRealizaGestion();
}
//.................................................hacer conexion ...DE ACCESO.....
function UsuarioOK()	{
    var parametros = {
        "usuario" : $('#TuCorreo').val() ,
        "pwd"     : $('#TuPwd').val() 
    };  
		$.ajax({
             data:  parametros,
             url:   '../php/ValidaLogin.php',
             type:  'post',
             beforeSend: function () {
                      $("#mensajeAcceder").html("conectando con el servidor"); 
             },
             success:  function (response) {
                 if (response.trim() != "OK") {
                     $("#mensajeAcceder").html(response); 
                     return false;
                 } else {
                     $("#mensajeAcceder").html("Conectado");
                     location.href="Foro.php";
                 }
             },
            error: function(){
                $("#mensajeAcceder").html("<span class='rojo'>Error interno, vuelva a intentarlo</span>");
                 return false;
            }
        });	
	
	
}

//.....TRATAMIENTO Enviar correo para que confirme el alta, guardar datos en forosolicitudes.................
function REGRealizaGestion()	{
			  var parametros = {
                 "nombre"        : $('#TuAlias').val() ,
			     "descripcion"   : $('#TuDescripcion').val() ,
			     "email"         : $('#TuEmailReg').val() ,
			     "palabra"       : $('#TuPwdReg').val() 
			 
              };  
	 
	 
	$.ajax({
             data:  parametros,
             url:   '../php/ForoAltaSolicitud.php',
             type:  'post',
        async:  false,
             beforeSend: function () {
                    $("#mensajeRegistro").html("Anotando operación ......"); 
                    $('#BotonAceptar').css("display","none");
             },
             success:  function (response) {
                 if (response.trim() != "OK") {
						$("#mensajeRegistro").html("<span class='rojo'>"+response+"</span>"); 
						//$('#BotonAceptar').css("display","block");
						return false;
				} else {
						REGResuelveBodyCarta(); 
						return true;
				}
             },
			 error: function(){
                $("#mensajeRegistro").html("<span class='rojo'>Error anotando operacion</span>");
				$('#BotonAceptar').css("display","block");
				return false;
            }
        });		
	
	
}


//...........................................................................
function REGResuelveBodyCarta()	{
			  var parametros = {
                 "nombre"        : $('#TuAlias').val() ,
			     "descripcion"   : $('#TuDescripcion').val() ,
			     "email"         : $('#TuEmailReg').val() ,
			     "palabra"       : $('#TuPwdReg').val() 
			 
              };  

		$.ajax({
             data:  parametros,
             url:   '../cartas/CartaForoInscripcion.php',
             type:  'post', 
			 async: false,
             beforeSend: function () {
                      $("#mensajeRegistro").html("Componiendo carta ...."); 
             },
             success:  function (response) {
				 bodyCartaCli = response;
				 $("#mensajeRegistro").html(""); 
				 REGEnviaCartas();
				 return true;
             },
			 error: function(){
                $("#mensajeRegistro").html("<span class='rojo'>Error componiendo carta</span>");
				$('#BotonAceptar').css("display","block");
				return false;
            }
        });	
	
	
}

//............................................................................
function REGEnviaCartas()	{
    var parametros = {
    "nombre"        : $('#TuAlias').val() ,
    "descripcion"   : $('#TuDescripcion').val() ,
    "email"         : $('#TuEmailReg').val() ,
    "palabra"       : $('#TuPwdReg').val(),
    "bodyCarta"     : bodyCartaCli   
    }; 
    $.ajax({
             data:  parametros,
             url:   '../php/ForoAltaAlumnoEnviaMail.php',
             type:  'post',
			 async: false,
             beforeSend: function () {
                      //$("#mensajeAcceder").html("Enviando emails ...."); 
             },
             success:  function (response) {
                 if (response.trim() != "OK") {
						$("#mensajeRegistro").html("<span class='rojo'>"+response+"</span>"); 
						$('#BotonAceptar').css("display","block");
						return false;
                 } else {
						 $("#mensajeRegistro").html("Le hemos enviado un correo para que CONFIRME su inscripción"); 
						return true;
					 }
             },
        error: function(){
                $("#mensajeRegistro").html("<span class='rojo'>Error enviando Emails</span>");
				$('#BotonAceptar').css("display","inline");
				return false;
            }
        });	
}
//.......................................................................................................
function PerfilValidaAlias() {
   $("#mensajePerfil").html("");  
	var alias = ACCTrim($("#PerfilAlias").val());
	if ( ACCTrim(alias).length > 0 ) {
	   if ( FormatoTxtValido(alias) == false) {
            $("#mensajePerfil").html("<span class='rojo'>Alias: Sólo letras y números</span>");
		    return false;
	} 
}
	return true; 
}
//.......................................................................................................
function PerfilValidaDescripcion() {
   $("#mensajePerfil").html("");  
	var alias = ACCTrim($("#PerfilDescripcion").val());
	if ( ACCTrim(alias).length > 0 ) {
	   if ( FormatoTxtValido(alias) == false) {
            $("#mensajePerfil").html("<span class='rojo'>Descripción: Sólo letras y números</span>");
		    return false;
	} 
}
	return true; 
}

//.......................................................................................................
function PerfilValidaPwd() {
   $("#mensajePerfil").html("");  
   var pwd1 = ACCTrim($("#PerfilPwd").val());
   var pwd2 = ACCTrim($("#PerfilPwd2").val()); 
   if  (pwd1.length >0 || pwd2.length >0) {
        if (pwd1 != pwd2) {
            $("#mensajePerfil").html("<span class='rojo'>Las contraseñas son diferentes</span>");
            return false;
        }
   	    if (FormatoPwd(pwd1) == false) {
		  $("#mensajePerfil").html("<span class='rojo'>Contraseña: Mínimo de seis y máximo de 15 caracteres, al menos una letra mayúscula, una letra minúscula y un número</span>");
          return false;
	    }
     
   }
 return true;
}
//.......................................................................................................
function ValidaPerfil() {
  if (!PerfilValidaAlias()){
		return false;
  }   
  if (!PerfilValidaDescripcion()){
		return false;
	}  
  if (!PerfilValidaPwd()){
		return false;
	}  
    GrabaPerfil();
}
//............................................................................
function GrabaPerfil()	{
     var parametros = {
    "alias"         : $('#PerfilAlias').val() ,
    "descripcion"   : $('#PerfilDescripcion').val() ,
    "palabra"       : $('#PerfilPwd').val()
    }; 
    $.ajax({
             data:  parametros,
             url:   '../php/GrabaPerfil.php',
             type:  'post',
			 async: false,
             beforeSend: function () {
                      $("#mensajePerfil").html("");
                      $('#BtnPerfil').css("display","none");
             },
             success:  function (response) {
                 if (response.trim() != "OK") {
						$("#mensajePerfil").html("<span class='rojo'>"+response+"</span>"); 
						$('#BtnPerfil').css("display","block");
						return false;
                 } else {
                     $("#mensajePerfil").html("Cambios realizados");
                 }
             },
        error: function(){
                $("#mensajePerfil").html("<span class='rojo'>Error grabando datos, vuelve a intentarlo</span>");
				$('#BtnPerfil').css("display","block");
				return false;
            }
        });	
}
