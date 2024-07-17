
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
ExtensionFicheroOK = 0;
TamanyoOK = 0;
EnviarFichero = 1;
tiempotrans = 0;
bodyCartaCli = "";
$(document).ready(function(){
   //selecciono todos los elementos de la clase "mitexto"
   $("#marcoMensaje").html("Enter your details");
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
   $("#adjuntarFichero").click(function() {
		VerFichero(); 
   });
   //..............
   $('#code').change(function()
    {
	ComprobarCode(); 	
	});
    //..............
   $(':file').change(function()
    {
      CambioFile(); 	    
    });
   //..............
   $("#Button1").click(function() {
		EnviaFormulario(); 
   });
   
});
//.......................................................................................................
function CambioFile(){
//obtenemos un array con los datos del archivo
        $("#marcoMensaje").html("");
		$("#marcoNombreFichero").css("display", "none"); 
		TamanyoOK = 0;
		ExtensionFicheroOK = 0;
        var file = $("#userfile")[0].files[0];
        var fileName = file.name;
        fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        var fileSize = file.size;
        var fileType = file.type;
		var mensaje = "FILE: "+fileName+", WEIGHT: "+fileSize+" bytes";
		tiempotrans = fileSize * 5 / 9000000;
		tiempotrans=Math.floor(tiempotrans);
			tiempotrans = tiempotrans +1;
	   //...................................................................
		var fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
		var extensiones = "/dwg/zip/gz/gzip/arj/tar/tar.gz/tarz/tgz/rar/";
		if (extensiones.indexOf(fileExtension.toLowerCase()) < 1) {
			$("#marcoMensaje").html("<span class='rojo'>Files accepted: DGW, ZIP, RAR. TAR ARJ</span>");
			return false;
		} else {
			ExtensionFicheroOK = 1;	
		}

		//...................................................................
		$("#marcoNombreFichero").css("display", "block"); 	
		if (fileSize >  7000000) {
			mensaje = mensaje + "<br><span class = 'rojo'>For files larger than 7 MB it is preferable to use personal mail by attaching the file<br>Transmission can be made very slow, even failing</span>";
		    $("#marcoMensaje").html("<span class='rojo'>Compress the file, if it is not</span>");
			$("#marcoNombreFichero").html(mensaje);
		    	if (fileSize <=  9000000) {
			     TamanyoOK = 1;	
			    } else {
				  return false;
			    }
			
		} else {
		   TamanyoOK = 1;	
		}
		$("#marcoNombreFichero").html(mensaje);
		
		return true;			
}
//.......................................................................................................

function VerFichero() {
    if($("#adjuntarFichero").is(':checked')) {  
            $("#marcoEligeFichero").css("display", "inline"); 
			$("#marcoNombreFichero").css("display", "block");  
			CambioFile(); 
			EnviarFichero = 1;
    } else {  
            $("#marcoEligeFichero").css("display", "none");  
			$("#marcoMensaje").html("");  
			$("#marcoNombreFichero").css("display", "none");  
			EnviarFichero = 0;	
    }
	
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
                     $("#recogeMensajes").html("Processing, please wait...");
             },
             success:  function (response) {
                     $("#recogeMensajes").html(response);
					 if (response.trim() != "OK") {
						$("#marcoMensaje").html("<span class='rojo'>Incorrect code</span>"); 
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
		$("#marcoMensaje").html("<span class='rojo'>Enter first name</span>");
		return false;
	}
	return true;
	
}
//.......................................................................................................
function VerificarDireccionCorreo() {
$("#marcoMensaje").html("");  
 var direccion = $("#email").val();

if (direccion.length < 5) {
    $("#marcoMensaje").html("<span class='rojo'>Report an email</span>");
    return false;	
}
   var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
    if (regex.test($('#email').val().trim())) {
        return true;	
    }
    else {
		$("#marcoMensaje").html("<span class='rojo'>Incorrect email format</span>");
        return false;
    }
}
//.......................................................................................................
function ValidaCiudad() {
	$("#marcoMensaje").html(""); 
	var telefono = $("#ciudad").val();
	if (telefono.length < 3) {
		$("#marcoMensaje").html("<span class='rojo'>Report your city</span>");
		return false;
	}
	return true;
	
}
//.......................................................................................................
function ValidaComentarios() {
	$("#marcoMensaje").html(""); 
	var comenta = $("#comentarios").val();
	if (comenta.length < 5) {
		$("#marcoMensaje").html("<span class='rojo'>Make some comments or comments</span>");
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
		$("#marcoMensaje").html("<span class='rojo'>Phone does not seem right</span>");
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
	if($("#adjuntarFichero").is(':checked'))  {
		if ( TamanyoOK == 0 || ExtensionFicheroOK == 0 ) {
			var mensa ="";
			if (TamanyoOK == 0 ) {
			 mensa = "Very large file";
			}
			if (ExtensionFicheroOK == 0 ) {
			 mensa = "Extension error";
			}
			
			$("#marcoMensaje").html("<span class='rojo'>Check the file: "+mensa+"</span>");
			return false;
		}
		
	}
	if (CaptchaOK == 0) {
		$("#marcoMensaje").html("<span class='rojo'>Incorrect code</span>");
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
	
	if($("#adjuntarFichero").is(':checked'))  {
		if 	(!EnviaFichero()) {			
			return false;
	    }
	} else {
	     if (!ResuelveBodyCarta()) {	
	          return false;	
	     }
	}
return true;
}
//...........................................................................
function ResuelveBodyCarta()	{

	
	  if($("#adjuntarFichero").is(':checked'))  {
		   var file = $("#userfile")[0].files[0];
           var fileName = file.name; 
           var parametros = {
              "nombre"        : $('#nombre').val() ,
			  "apellidos"     : $('#apellidos').val() ,
			  "email"         : $('#email').val() ,
			  "telefono"      : $('#telefono').val() ,
			  "ciudad"        : $('#ciudad').val() ,
			  "comentarios"   : $('#comentarios').val() ,
			  "fichero"       : fileName,
			  "Nombre_correo" : Nombre_correo
          };
	  } else {
		       var parametros = {
              "nombre"        : $('#nombre').val() ,
			  "apellidos"     : $('#apellidos').val() ,
			  "email"         : $('#email').val() ,
			  "telefono"      : $('#telefono').val() ,
			  "ciudad"        : $('#ciudad').val() ,
			  "comentarios"   : $('#comentarios').val() ,
			  "fichero"       : "Uninformed",	
			  "Nombre_correo" : Nombre_correo  
              };  
	  } 
		$.ajax({
             data:  parametros,
             url:   '../cartas/CartaPresupuestosCli_eng.php',
             type:  'post',
             beforeSend: function () {
                      $("#marcoMensaje").html("Composing letter ...."); 
             },
             success:  function (response) {
				 bodyCartaCli = response;
				 EnviaCartas();
             },
			 error: function(){
                $("#marcoMensaje").html("<span class='rojo'>Error composing letter</span>");
				$('#botones').css("display","inline");
				return false;
            }
        });	
	
	
}

//............................................................................
function EnviaCartas()	{
	 
	  
	  if($("#adjuntarFichero").is(':checked'))  {
	       var file = $("#userfile")[0].files[0];
           var fileName = file.name; 
           var parametros = {
              "nombre"      : $('#nombre').val() ,
			  "apellidos"   : $('#apellidos').val() ,
			  "email"       : $('#email').val() ,
			  "telefono"    : $('#telefono').val() ,
			  "ciudad"      : $('#ciudad').val() ,
			  "comentarios" : $('#comentarios').val() ,
			  "fichero"     : fileName ,
			  "bodyCarta"   : bodyCartaCli
			  
          };
	  } else {
		       var parametros = {
              "nombre"      : $('#nombre').val() ,
			  "apellidos"   : $('#apellidos').val() ,
			  "email"       : $('#email').val() ,
			  "telefono"    : $('#telefono').val() ,
			  "ciudad"      : $('#ciudad').val() ,
			  "comentarios" : $('#comentarios').val() ,
			  "fichero"     : "Uninformed" ,
			  "bodyCarta"   : bodyCartaCli		  
              };
		} 
	 
	$.ajax({
             data:  parametros,
             url:   '../php/PresupuestosEnviaMail_eng.php',
             type:  'post',
             beforeSend: function () {
                      $("#marcoMensaje").html("Sending emails ...."); 
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
                $("#marcoMensaje").html("<span class='rojo'>Error sending emails</span>");
				$('#botones').css("display","inline");
				return false;
            }
        });	
}

//............................................................................
function AnotaRegistroEmail()	{
	  if($("#adjuntarFichero").is(':checked'))  {
	       var file = $("#userfile")[0].files[0];
           var fileName = file.name; 
           var parametros = {
              "nombre"      : $('#nombre').val() ,
			  "apellidos"   : $('#apellidos').val() ,
			  "email"       : $('#email').val() ,
			  "telefono"    : $('#telefono').val() ,
			  "ciudad"      : $('#ciudad').val() ,
			  "comentarios" : $('#comentarios').val() ,
			  "fichero"     : fileName ,
			  "emisorcorreo"      : emisorcorreo 
          };
	  } else {
		       var parametros = {
              "nombre"      : $('#nombre').val() ,
			  "apellidos"   : $('#apellidos').val() ,
			  "email"       : $('#email').val() ,
			  "telefono"    : $('#telefono').val() ,
			  "ciudad"      : $('#ciudad').val() ,
			  "comentarios" : $('#comentarios').val() ,
			  "fichero"     : "Uninformed" ,
			  "emisorcorreo"      : emisorcorreo 
              };
		} 
	 
	$.ajax({
             data:  parametros,
             url:   '../php/PresupuestosNuevoMail.php',
             type:  'post',
             beforeSend: function () {
                    $("#marcoMensaje").html("Noting Operation ......"); 
             },
             success:  function (response) {
					 if (response != "OK") {
						$("#marcoMensaje").html("<span class='rojo'>"+response+"</span>"); 
						$('#botones').css("display","inline");
						return false;
					 } else {
						 $("#marcoMensaje").html("We have sent you an Email with your data<br>We will contact you shortly<br>Thank you for your trust"); 
						return true;
					 }
             },
			 error: function(){
                $("#marcoMensaje").html("<span class='rojo'>Error sending E-mails</span>");
				$('#botones').css("display","inline");
				return false;
            }
        });		
	
	
}
//...........................................................................
function EnviaFichero()	{
	    var formData = new FormData($(".formulario")[0]);
        var message = ""; 
        //hacemos la petición ajax  
		
        $.ajax({
            url: '../php/PresupuestoUpload.php',  
            type: 'POST',
            // Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            //mientras enviamos el archivo
            beforeSend: function(){
                  $("#marcoMensaje").html("DO NOT EXIT THE SCREEN<BR>We are sending the file. Aprox: "+tiempotrans+" min" );  
            },
            //una vez finalizado correctamente
            success: function(data){
				if (data == "OK") {
					$("#marcoMensaje").html("Resolving letter"); 
					//..........................llamar componer body de la carta y ResuelveBodyCarta llamará a envío de cartas()
					 ResuelveBodyCarta();
					 return true; 
				} else {
					$("#marcoMensaje").html("<span class='rojo'>"+data+"</span>"); 
					$('#botones').css("display","inline");
					return false;
				}
	
	         },
            //si ha ocurrido un error
            error: function(){
                $("#marcoMensaje").html("<span class='rojo'>Error in transmission, please try again</span>");
				$('#botones').css("display","inline");
				return false;
            }
        });

}

