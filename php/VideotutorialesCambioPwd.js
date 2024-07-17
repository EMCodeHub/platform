
//................................

function trim (myString)   {
     return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
}



//........................................................................................................


bodyCartaCli = "";
$(document).ready(function(){
   //selecciono todos los elementos de la clase "mitexto"
   $("#marcoConexion").html("");
  
   $("#usuario").change(function() {
		VerificarDireccionCorreo(); 
   });

   $("#Cambiar").click(function() {
		EnviaFormulario(); 
   });
   
});
//.......................................................................................................
function FormatoPwd(Txt) {
    //var regex = /^[a-zA-Z0-9]+$/;....>  ^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,15}$
    //var regex = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^\w\s]).{8,}$/;    
    var regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,15}$/;
    if (Txt.match(regex)!=null) {
        return true;	
    }
return false;	
}
//.......................................................................................................
function VerificarDireccionCorreo() {
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
    var pwd = $("#pwdNew").val();

  	if (pwd.length < 6) {
		$("#marcoConexion").html("<span class='rojo'>Informe una contaseña de al menos 6 caracteres</span>");
		return false;
	}
	if (FormatoPwd(pwd) == false) {
		$("#marcoConexion").html("<span class='rojo'>Contraseña: Mínimo de seis y máximo de 15 caracteres, al menos una letra mayúscula, una letra minúscula y un número</span>");
        return false;
	}
	return true;
  
}

//.......................................................................................................
function PasswordsDiferentes() {
	$("#marcoConexion").html("");  
    var pwd1 = $("#pwdNew").val();
    var pwd2 = $("#pwdRepe").val();
	var pwd = $("#pwd").val();
   if (pwd1.length < 6) {
        $("#marcoConexion").html("Contraseña debe ser más larga de 5 caracteres");
       return false;	
   }
   if (pwd1 != pwd2) {
        $("#marcoConexion").html("Las nuevas contraseñas son diferentes");
       return false;	
   }
   if (pwd == pwd1) {
        $("#marcoConexion").html("No está cambiando la contraseña");
       return false;	
   }
   
   return true;
}



//.......................................................................................................
function ValidaFormulario() {
	$("#marcoConexion").html(""); 
	
    if (!VerificarDireccionCorreo()){
		return false;
	}
	if (!validaPWD()){
		return false;
	}
	if (!PasswordsDiferentes()) {
		 return false;
	} 
	return true;
}
//.......................................................................................................
function EnviaFormulario(){
	
	if (!ValidaFormulario()) {
		 return false;
	} 
	
	CambiaPwd();
	
	
}
//.......................................................................................................
function CambiaPwd()	{
		     var parametros = {
              "usuario" : $('#usuario').val() ,
			  "pwd"     : $('#pwd').val() ,
			  "pwdNew"  : $('#pwdNew').val()
              };  
		$.ajax({
             data:  parametros,
             url:   '../php/CambiaPwd.php',
             type:  'post',
             beforeSend: function () {
                      $("#marcoConexion").html("conectando con el servidor"); 
             },
             success:  function (response) {
				   if (response.trim() != "OK") {
						$("#marcoConexion").html(response); 
						return "NO-OK";
				   } else {
					   $("#marcoConexion").html("Contraseña cambiada"); 
						location.href = "../index.php";
				   }
 
             },
			 error: function(){
                $("#marcoConexion").html("<span class='rojo'>Error cambiando la contraseña</span>");
				return "NO-OK";
            }
        });	
	
}



