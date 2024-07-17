
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

function trimCuestion (myString)   {
     return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
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
   $("#marcoMensaje").html("");
   //..............
   /*$('#code').change(function()
    {
	ComprobarCode(); 	
	});*/
    //..............
   $(':file').change(function()
    {
      CambioFile(); 	    
    });
   //..............
   $("#ButtonEnviar").click(function() {
		EnviaFormulario(); 
   });
    //..............
   $("#ButtonSalir").click(function() {
		SalirRecurso(); 
   });
    //..............
   $("#ButtonSalir2").click(function() {
		SalirRecurso(); 
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
		var mensaje = "ARCHIVO: "+fileName+", TAMAÑO: "+fileSize+" bytes";
		tiempotrans = fileSize * 5 / 9000000;
		tiempotrans=Math.floor(tiempotrans);
			tiempotrans = tiempotrans +1;
	   //...................................................................
		var fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
		var extensiones = "/txt/tif/tiff/pptx/ppt/ppsx/pps/potx/dotx/dot/gif/png/bmp/docx/doc/xlsx/xls/jpg/jpeg/mp4/mov/avi/mpeg/pdf/dwg/zip/gz/gzip/arj/tar/tar.gz/tarz/tgz/rar/";
		if (extensiones.indexOf(fileExtension.toLowerCase()) < 1) {
			$("#marcoMensaje").html("<span class='rojo'>Ficheros aceptados: Videos, imagenes, XLSX, DOCX, PDF</span>");
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
function ValidaFormulario() {
	$("#marcoMensaje").html(""); 
	
		if ( TamanyoOK == 0 || ExtensionFicheroOK == 0 ) {
			var mensa ="";
			if (TamanyoOK == 0 ) {
			    mensa = "Fichero muy grande";
			}
			if (ExtensionFicheroOK == 0 ) {
			   mensa = "Error extensión fichero";
			}
			
			$("#marcoMensaje").html("<span class='rojo'>Revise el fichero: "+mensa+"</span>");
			return false;
		}
 
    if (trimCuestion($("#titulo_recurso").val()).length < 15) {
        $("#marcoMensaje").html("<span class='rojo'>Título debe ser más largo</span>");
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
	if 	(!EnviaFichero()) {			
			return false;
	}
  return true;
}

//...........................................................................
function EnviaFichero()	{
	    var formData = new FormData($(".formulario")[0]);
        var message = ""; 
        //hacemos la petición ajax  
		
        $.ajax({
			//header
            url: '../php/CuestionForoUpload.php',  
            type: 'POST',
            // Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
			headers: {
				'Cache-Control': 'no-store, no-cache, must-revalidate, proxy-revalidate, max-age=0'
		   	},
			//header
            //mientras enviamos el archivo
            beforeSend: function(){
                  $("#marcoMensaje").html("Estamos enviando el fichero. Menos de: "+tiempotrans+" min" );  
            },
            //una vez finalizado correctamente
            success: function(data){
				if (data.trim() == "OK") {
					$("#marcoMensaje").html("Transmision CORRECTA: Puede tardar unos minutos en actualizarse la pagina"); 
					//..........................llamar componer body de la carta y ResuelveBodyCarta llamará a envío de cartas()
					 
					 //....PENDIENTE .....poner boton salir
					 $('#RecursoPantalla').css("display","none");
                    location.reload(true);
					 //window.location.href = "CuestionForo.php?id="+$("#num_cuestion").val()+"#M"+$("#num_mensaje").val();
					 
					 return true; 
				} else {
					$("#marcoMensaje").html("<span class='rojo'>"+data+"</span>"); 
					$('#botones').css("display","inline");
					return false;
				}
	
	         },
            //si ha ocurrido un error
            error: function(error){
				console.log('holaaaa', error);
                $("#marcoMensaje").html("<span class='rojo'>Error en la transmisión, vuelva a intentarlo subiendo una imagen más pequeña en píxeles</span>");
				$('#botones').css("display","inline");
				return false;
            }
        });

}

