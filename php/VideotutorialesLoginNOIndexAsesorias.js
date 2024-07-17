bodyCartaCli = "";
/*$(document).ready(function(){
   //selecciono todos los elementos de la clase "mitexto"
   $("#marcoConexion").html("");
  
   $("#usuario").change(function() {
		LoginVerificarDireccionCorreo(); 
   });

   $("#Login").click(function() {
		LoginEnviaFormulario(); 
   });
    $("#CerrarLogin").click(function() {
		VerLogin(0); 
   });
   
});*/

function VerLogin(modo){
	if (modo == 1) {
	    document.getElementById("PantallaPwd").style.display  = "block";
		document.getElementById("usuario").focus();
	} else {
		document.getElementById("PantallaPwd").style.display  = "none";
	}
}

//................................

function trim(myString)   {
     return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
}


//.......................................................................................................
function LoginVerificarDireccionCorreo() {
$("#marcoConexion").html("");  
 var direccion = $("#usuario").val();

if (direccion.length < 5) {
    $("#marcoConexion").html("<span class='rojo'>Informe un email</span>");
    return false;	
}
   var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
    if (regex.test($('#usuario').val().trim())) {
        return true;	
    }
    else {
		$("#marcoConexion").html("Formato de email incorrecto");
        return false;
    }
}
//.......................................................................................................
function validaPWD() {
	$("#marcoConexion").html("");  
    var pwd = $("#pwd").val();

   if (pwd.length < 6) {
        $("#marcoConexion").html("Contraseña debe ser más larga de 5 caracteres");
       return false;	
   }
   return true;
}
//.......................................................................................................
function LoginValidaFormulario() {
	$("#marcoConexion").html(""); 
	
    if (!LoginVerificarDireccionCorreo()){
		return false;
	}
	if (!validaPWD()){
		return false;
	}
	
	return true;
}
//.......................................................................................................
function LoginEnviaFormulario(){
	
	if (!LoginValidaFormulario()) {
		 return false;
	} 

	PermisosUsuario();
	
	
}
//.......................................................................................................
function PermisosUsuario()	{
		     var parametros = {
              "usuario" : $('#usuario').val() ,
			  "pwd"     : $('#pwd').val() 
              };  
		$.ajax({
             data:  parametros,
             url:   '../php/ValidaLogin.php',
             type:  'post',
             beforeSend: function () {
                      $("#marcoConexion").html("conectando con el servidor"); 
             },
             success:  function (response) {
				   if (response.trim() != "OK") {
						$("#marcoConexion").html("Error->"+response); 
						
				   } else {
					   $("#marcoConexion").html("Conectado"); 
						location.href = "../index.php";
				   }
 
             },
			 error: function(){
                $("#marcoConexion").html("<span class='rojo'>Error calculando permisos</span>");
				
            }
        });	
	
	
}


//.......................................................................................................

function PwdOlvidado(){
	
	if (!LoginVerificarDireccionCorreo()) {
		 return false;
	} 
     ControlExisteCliente();
	
}
//...........................................................................
function ControlExisteCliente()	{
		     var parametros = {
              "usuario" : $('#usuario').val() 
              };  
		$.ajax({
			 async:false, 
             data:  parametros,
             url:   '../php/PerdidaPassword.php',
             type:  'post',
             beforeSend: function () {
                      $("#marcoConexion").html("Verificando usuario"); 
             },
             success:  function (response) {
					
				   if (response.trim() != "OK") {
						$("#marcoConexion").html(response); 
						return "0";
				   } else {
					   $("#marcoConexion").html("Le hemos enviado un e-mail con su password"); 
						return "1";
				   }
 
             },
			 error: function(){
                $("#marcoConexion").html("Error verificando e-mail");
				return "0";
            }
        });	
	

}
//...........................................................................
function 	EnviaCartaPwd() {
	ResuelveBodyCartaPwd();
	
	
}
//...........................................................................
function ResuelveBodyCartaPwd()	{
		     var parametros = {
              "usuario" : $('#usuario').val() 
              };  
		$.ajax({
             data:  parametros,
             url:   '../cartas/CartaPasswordPerdida.php',
             type:  'post',
             beforeSend: function () {
                      $("#marcoConexion").html("Componiendo carta Pwd"); 
             },
             success:  function (response) {
				 bodyCartaCli = response;
				 EnviaCartaPwd(bodyCartaCli);
             },
			 error: function(){
                $("#marcoConexion").html("Error componiendo carta pwd");
				return false;
            }
        });	
	
	
}

//............................................................................
function EnviaCartaPwd(body)	{
		     var parametros = {
              "usuario"   : $('#usuario').val(),
			  "bodyCarta" :  body
              };  
	$.ajax({
             data:  parametros,
             url:   '../php/VTPasswordEnviaMail.php',
             type:  'post',
             beforeSend: function () {
                      $("#marcoConexion").html("Enviando mail Pwd"); 
             },
             success:  function (response) {
					 if (response.trim() != "OK") {
						$("#marcoConexion").html(response); 
						return false;
					 } else {
						 $("#marcoConexion").html("Le hemos enviado un e-mail con su contraseña"); 
						return true;
					 }
             },
			 error: function(){
                $("#marcoConexion").html("Error enviando Email Pwd");
				return false;
            }
        });	
}

