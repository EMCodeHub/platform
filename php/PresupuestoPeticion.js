
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

function trimPresup (myString)   {
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
		var mensaje = "ARCHIVO: "+fileName+", PESO: "+fileSize+" bytes";
		tiempotrans = fileSize * 5 / 9000000;
		tiempotrans=Math.floor(tiempotrans);
			tiempotrans = tiempotrans +1;
	   //...................................................................
		var fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
		var extensiones = "/dwg/zip/gz/gzip/arj/tar/tar.gz/tarz/tgz/rar/";
		if (extensiones.indexOf(fileExtension.toLowerCase()) < 1) {
			$("#marcoMensaje").html("<span class='rojo'>Ficheros aceptados: DWG, ZIP, RAR. TAR ARJ</span>");
			return false;
		} else {
			ExtensionFicheroOK = 1;	
		}

		//...................................................................
		$("#marcoNombreFichero").css("display", "block"); 	
		if (fileSize >  7000000) {
			mensaje = mensaje + "<br><span class = 'rojo'>Para ficheros superiores a 7 MB es preferible utilizar el correo personal adjuntando en él el archivo<br>La transmisión puede hacerse muy lenta, incluso fallar</span>";
		    $("#marcoMensaje").html("<span class='rojo'>Comprima el archivo, si no lo está</span>");
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
                     $("#recogeMensajes").html("Procesando, espere por favor...");
             },
             success:  function (response) {
                     $("#recogeMensajes").html(response);
					 if (response.trim() != "OK") {
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
	
	 
	if ( trimPresup($("#nombre").val()).length <3 ) {
		$("#marcoMensaje").html("<span class='rojo'>Informe el nombre</span>");
		$("#nombre").focus();
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
	$("#email").focus();
    return false;	
}
   var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
    if (regex.test($('#email').val().trim())) {
        return true;	
    }
    else {
		$("#marcoMensaje").html("<span class='rojo'>Formato de email incorrecto</span>");
		$("#email").focus();
        return false;
    }
}
//.......................................................................................................
function ValidaCiudad() {
	$("#marcoMensaje").html(""); 
	var telefono = $("#ciudad").val();
	if (telefono.length < 3) {
		$("#marcoMensaje").html("<span class='rojo'>Informe su ciudad</span>");
		$("#ciudad").focus();
		return false;
	}
	return true;
	
}
//.......................................................................................................
function ValidaComentarios() {
	$("#marcoMensaje").html(""); 
	var comenta = $("#comentarios").val();
	if (comenta.length < 5) {
		$("#marcoMensaje").html("<span class='rojo'>Haga alguna observación o comentario</span>");
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
		$("#telefono").focus();
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
			 mensa = "Fichero muy grande";
			}
			if (ExtensionFicheroOK == 0 ) {
			 mensa = "Error extensión";
			}
			
			$("#marcoMensaje").html("<span class='rojo'>Revise el fichero: "+mensa+"</span>");
			return false;
		}
		
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
			  "fichero"       : "No informado",	
			  "Nombre_correo" : Nombre_correo  
              };  
	  } 
		$.ajax({
             data:  parametros,
             url:   '../cartas/CartaPresupuestosCli.php',
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
			  "fichero"     : "No informado" ,
			  "bodyCarta"   : bodyCartaCli		  
              };
		} 
	 
	$.ajax({
             data:  parametros,
             url:   '../php/PresupuestosEnviaMail.php',
             type:  'post',
             beforeSend: function () {
                      $("#marcoMensaje").html("Enviando emails ...."); 
             },
             success:  function (response) {
					 if (response.trim() != "OK") {
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
			  "fichero"     : "No informado" ,
			  "emisorcorreo"      : emisorcorreo 
              };
		} 
	 
	$.ajax({
             data:  parametros,
             url:   '../php/PresupuestosNuevoMail.php',
             type:  'post',
             beforeSend: function () {
                    $("#marcoMensaje").html("Anotando operación ......"); 
             },
             success:  function (response) {
					 if (response.trim() != "OK") {
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
                  $("#marcoMensaje").html("NO SALGA DE LA PANTALLA<BR>Estamos enviando el fichero. Aprox: "+tiempotrans+" min" );  
            },
            //una vez finalizado correctamente
            success: function(data){
				if (data.trim() == "OK") {
					$("#marcoMensaje").html("Resolviendo carta"); 
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
                $("#marcoMensaje").html("<span class='rojo'>Error en la transmisión, vuelva a intentarlo</span>");
				$('#botones').css("display","inline");
				return false;
            }
        });

}

