 (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-62544837-1', 'auto');
  ga('send', 'pageview');
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
function LipiaMensaje (myString)   {
      $("#CBmarcoMensaje").html("&nbsp;");
}

function borraCampos() {
	
	document.getElementById("nombre").value = "";
	document.getElementById("email").value = "";
	document.getElementById("apellidos").value = "";
	document.getElementById("telefono").value = "";
	document.getElementById("ciudad").value = "";
	document.getElementById("comentarios").value = "";
}

function CierraCorreoGeneral() {
	document.getElementById('CorreoGeneral').style.display  = "none";
	
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
   
   $("#Button2").click(function() {
		CierraCorreoGeneral(); 
   });
   //.........................................segundo formulario
   

   $("#CBmarcoMensaje").html("Informe un EMAIL");

   $("#CBemail").change(function() {
		CBVerificarDireccionCorreo($("#CBemail").val(),1); 
		
   });
   $("#CBemail").focusin(function() {
		LipiaMensaje(); 
		
   });
   $("#CBemail").focusout(function() {
		CBVerificarDireccionCorreo($("#CBemail").val(),1); 
		
   });
   
    $("#CBemail2").change(function() {
		CBVerificarDireccionCorreo($("#CBemail2").val(),2); 
   });
   
   $("#CBemail2").focusin(function() {
		LipiaMensaje(); 
		
   });
   $("#CBemail2").focusout(function() {
		CBVerificarDireccionCorreo($("#CBemail2").val(),2); 
		
   });
   //..............
   $("#CBButton1").click(function() {
		   CBEnviaFormulario(1); 
   });
   $("#CBButton2").click(function() {
		CBEnviaFormulario(2); 
   });
    $("#CBButton3").click(function() {
		CBEnviaFormulario(3); 
   });
      
   $("#CBButton4").click(function() {
		SalirPago(); 
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
			  "Nombre_correo" : Nombre_correo ,
			  "NumIdCurso"    : numCurso
              };  
		$.ajax({
             data:  parametros,
             url:   '../cartas/CartaVTCursosCli.php',
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
			  "bodyCarta"     : bodyCartaCli,
			  "NumIdCurso"    : numCurso
              };  
	$.ajax({
             data:  parametros,
             url:   '../php/VTCursoEnviaMail.php',
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
						 //$("#marcoMensaje").html("Le hemos enviado un Email con sus datos<br>Confirme su inscripcon desde su correo<br>Gracias por su confianza"); 
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
			  "Nombre_correo" : Nombre_correo ,
			  "NumIdCurso"    : numCurso,
			  "mailemisor"    : emisorcorreo
              };  
	 
	 
	$.ajax({
             data:  parametros,
             url:   '../php/VTCursoNuevoMail.php',
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
						 $("#marcoMensaje").html("Le hemos enviado un Email con su solicitud<br>Gracias por su confianza"); 
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
function VerDocumentoAdjunto(URL) {
		
		window.open(URL,"Programa / Documentacion curso","width=900,height=700,scrollbars=YES,resizable=YES,LEFT=250,TOP=100") 	

}

function Descarga(tipo,id) {
	cadena = "BajarFichero.php?tipo="+tipo+"&id="+id;
   location.href = cadena;
}




/*

function AvisoDebeComprar(ofset) {


	if (ofset > 0) {
	  d = document.getElementById('CompraCurso');
      d.style.left = CursorX+ofset+"px";
      d.style.top = CursorY-25+"px";
	}
	d.style.display= "block";
}

*/



function entraReg(reg){
  
  reg.style.backgroundColor ='#41355b47';
  
}











function salReg(reg){
  
  reg.style.backgroundColor='#41355b47';
  document.getElementById('CompraCurso').style.display= "none";
  
}

function VerVideo(id) {
	URL = "VerVideo.php?id="+id;
	
	 		/* window.open(URL,"Curso MEDIF","width=1000,height=700,scrollbars=YES,resizable=YES,LEFT=300,TOP=50") 	*/
      window.open(URL,"_self");
}

function GetImagenSolicitud(Cual,id) {
	//alert("entra en GetImage..."+"Cual--->"+Cual+" id="+id);
	if (Cual == 1) {
		id.src = "../imagenes/SolicitarInformacion_naranja.gif";
		
	} else {
		id.src = "../imagenes/SolicitarInformacion_amarillo.gif";
	}
	
}
function GetImagenCart(Cual,id) {
	//alert("entra en GetImage..."+"Cual--->"+Cual+" id="+id);
	if (Cual == 1) {
		id.src = "../imagenes/AddToCart_naranja.gif";
		
	} else {
		id.src = "../imagenes/AddToCart_amarillo.gif";
	}
	
}
function GetImagenPagoTarjeta(Cual,id) {
	//alert("entra en GetImage..."+"Cual--->"+Cual+" id="+id);
	if (Cual == 1) {
		id.src = "../imagenes/Tarjeta_on.gif";
		
	} else {
		id.src = "../imagenes/Tarjeta_off.gif";
	}
	
}
function GetImagenPagoTransfer(Cual,id) {
	//alert("entra en GetImage..."+"Cual--->"+Cual+" id="+id);
	if (Cual == 1) {
		id.src = "../imagenes/Transfer_on.gif";
		
	} else {
		id.src = "../imagenes/Transfer_off.gif";
	}
	
}
function GetImagenPagoPaypal(Cual,id) {
	//alert("entra en GetImage..."+"Cual--->"+Cual+" id="+id);
	if (Cual == 1) {
		id.src = "../imagenes/Paypal_on.gif";
		
	} else {
		id.src = "../imagenes/Paypal_off.gif";
	}
	
}
function RecibirInformacion() {
	document.getElementById('CorreoGeneral').style.display  = "block";
	document.getElementById('CorrreoCobros').style.display  = "none";
}

function VerDescuentos(modo) {
		document.getElementById("CorrreoCobros").style.display="none";
		j = document.getElementById('CorrreoCobrosDescuentos');
		d = document.getElementById('envoltorioGeneralDescuentos');


	
		j.style.display= "none";
		if(modo == 0) {
			d.style.display= "none";

		} else {
           posY = d.style.top = CursorY;
		   if (posY < 100) { posY = 100;}
		   d.style.top = posY+"px";
		   		   
	        d.style.display= "block";
		    d = document.getElementById('botonesCompra');
	        d.style.display= "block";
			
			var checkboxes = document.getElementById("formDescuentos").checkbox;
			for (var x=0; x < checkboxes.length; x++) {
			   //checkboxes[x].disabled ="false"; 
			   checkboxes[x].disabled = false; 
			 }

		}
	}

function coordenadas(event) {
 CursorX = event.clientX;
 CursorY = event.pageY;
 
}



