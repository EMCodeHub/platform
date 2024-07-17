function CSVPendientes(nombreCampoMensaje){
 if (nombreCampoMensaje == "MensajeCSV1") {
	 $('#botonPendientes1').css('display','none'); 
 } else {
	  $('#botonPendientes2').css('display','none'); 
 }
	
var fichero = "CartasPromocionalesPendientes_"+Date.now()+".csv";
  var parametros = {
	    "salida"       : fichero
	  
  };    
	var campo = $("#"+nombreCampoMensaje);
       $.ajax({
             data:  parametros,
             url:   '../php/CartasPromocionalesCSV.php',
             type:  'GET', 
             async: false,
             beforeSend: function () {
				 if (nombreCampoMensaje == "MensajeCSV1") {
					  $("#MensajeCSV1").html("Preparando archivo"); 
				 } else {
					  $("#MensajeCSV2").html("Preparando archivo"); 
				 }

             },
             success:  function (response) {
				  if (nombreCampoMensaje == "MensajeCSV1") {
					  $("#MensajeCSV1").html("Fichero gererado: CSVFicheros/"+fichero);
					  if (response.substring(0,4) == "ERROR") {
						 $("#MensajeCSV1").html(response);  
					  }
				 } else {
					  $("#MensajeCSV2").html("Fichero gererado: CSVFicheros/"+fichero); 
					 if (response.substring(0,4) == "ERROR") {
						 $("#MensajeCSV2").html(response);  
					  }
				 }
             },
			 error: function(jqXHR, textStatus, errorThrown){
				 if (nombreCampoMensaje == "MensajeCSV1") {
					  $("#MensajeCSV1").html("<span class='rojo'>"+errorThrown+"</span>");
				 } else {
					  $("#MensajeCSV2").html("<span class='rojo'>"+errorThrown+"</span>");
				 }
             }
        });	  
}
	
	

function LimpiaCalculos(){
   AlumnosAfectados = 0; 
   $("#numAlumnos").html(""); 
   LimpiaInicializaMensajes();
}
function LimpiaInicializaMensajes(){
    $('#MensajeCarta1').css('display','block');
    $('#MensajeCarta2').css('display','block');
    $('#MensajeCarta3').css('display','block');
    $('#MensajeCarta4').css('display','block');
    $('#MensajeCarta5').css('display','block');
    $('#MensajeCarta1').html("");
    $('#MensajeCarta2').html("");
    $('#MensajeCarta3').html("");
    $('#MensajeCarta4').html("");
    $('#MensajeCarta5').html(""); 
	$('#MensajeCSV1').html("");
	$('#MensajeCSV2').html("");
	$('#parrafoEnviar1').html("");

}
function VerCarta(){
    var carta = $('#cartaElegida').val() ;
    var textoAsunto = $('#asunto').val() ;  
    $('#CartaYaEncontrada').html(""); 
    if (textoAsunto == ""){
        $("#cartaElegida option:contains('')").attr('selected', 'selected');
        alert("Definir antes el asunto");
        $('#asunto').focus();
        return;
    }
    if (carta == ""){
        alert("No ha escogido ninguna carta. Elija una");
        return;
    }
    var encontradaCarta = CompruebaSiExisteCarta(carta);  
      
    if (encontradaCarta.trim() != "OK") {
        $("#CartaYaEncontrada").html(encontradaCarta); 
        HayErrores = 1;
        alert("ERROR(1)-> "+encontradaCarta);   
    }
    var URL = "../cartas/PomocionSemanal/"+carta+"?NumeroAlumno="+IDPruebas;
    window.open(URL,"Carta a enviar","width=1000,height=700,scrollbars=YES,resizable=YES,LEFT=200,TOP=100"); 
}
//...........................................................................
function ChecksSeleccionados(){
    var checkboxes = document.getElementById("FormSeleccionCartas").checkbox; 
    var numeroSeleccionados = 0;
      for (var x=0; x < checkboxes.length; x++) {
        if (checkboxes[x].checked) { 
             numeroSeleccionados = numeroSeleccionados +1;
        }
      }
    if (numeroSeleccionados == 0){
        alert("Seleccione algún curso");
        return false;
    }
    return true;
}
//...........................................................................
function PrimeraValidacion() {
  var carta = $('#cartaElegida').val() ;
  var textoAsunto = $('#asunto').val() ; 
  if (HayErrores > 0){
    alert("Hay errores, mire el texto en rojo");
    return false;
    
  }    
  if (textoAsunto == ""){
        alert("Definir antes el asunto");
        $('#asunto').focus();
        return false;
  }
  if (carta == ""){
        alert("No ha escogido ninguna carta. Elija una");
        return false;
  }
   if (!ChecksSeleccionados()){
       return false;
   }
return true;
}

//...........................................................................
function ProbarCarta() {
    if (!PrimeraValidacion()){
        return false;
    }
    if (AlumnosAfectados == 0){
       alert("Calcule ANTES a cuántos alumnos afecta");
       return false;   
   }
    cartaProbada = 1;
    $('#BotonProbar').html("<span class='azul'>&nbsp; Mire el buzón y compruebe que el email RECIBIDO es correcto</span>");
    LimpiaInicializaMensajes();
    ProcesarRegistrosAlumnos(0,1,"","");
    location.href = '#Fin';
}
//...........................................................................
function CadenaSeleccionados(){
  var cadena = "(";
  var nn = 0;
  var checkboxes = document.getElementById("FormSeleccionCartas").checkbox; 
      for (var x=0; x < checkboxes.length; x++) {
        if (checkboxes[x].checked) { 
            if (nn == 0) {
                cadena =  cadena + checkboxes[x].value;
            } else {
                cadena = cadena + ", " + checkboxes[x].value;
            }
            nn = nn+1;
        }
      }  
      cadena = cadena + ")";
      return cadena;
}
//...........................................................................
function CadenaNOSeleccionados(){
  var cadena = "(";
  var nn = 0;
  var checkboxes = document.getElementById("FormSeleccionCartas").checkbox; 
      for (var x=0; x < checkboxes.length; x++) {
        if (!checkboxes[x].checked) { 
            if (nn == 0) {
                cadena =  cadena + checkboxes[x].value;
            } else {
                cadena = cadena + ", " + checkboxes[x].value;
            }
            nn = nn+1;
        }
      }  
      cadena = cadena + ")";
      return cadena;
}
//...........................................................................
function CompruebaSiExisteCarta(Pcarta) {
  var devolver = "";    
  var parametros = {
        "carta"         : Pcarta
  };    
       $.ajax({
             data:  parametros,
             url:   '../php/CartasPromocionalesExisteCarta.php',
             type:  'GET', 
             async: false,
             beforeSend: function () {
                  $("#MensajeCarta1").html("Verificando si la carta ha sido enviada"); 
             },
             success:  function (response) {
                  //$("#MensajeCarta1").html(""); 
				  devolver =  response;
             },
			 error: function(jqXHR, textStatus, errorThrown){
                  //$("#MensajeCarta2").html("<span class='rojo'>"+textStatus+"</span>");
                 $("#MensajeCarta2").html("<span class='rojo'>"+errorThrown+"</span>");
				  return false;
             }
        });	  
 return devolver;     
}

//...........................................................................
function CalcularAlumnos(){
    LimpiaInicializaMensajes();
    if (!PrimeraValidacion()){
        return false;
    }
    
    //alert("Tienen: "+CadenaSeleccionados()+" No tienen: "+CadenaNOSeleccionados() );
   var parametros = {
        "TipoQuery"         : $('input:radio[name=QueTengan]:checked').val(),
        "DesgloseRegistros" : 0 ,
        "Seleccionados"     : CadenaSeleccionados(),
        "NoSeleccionados"   : CadenaNOSeleccionados() 
  };  
    
        $.ajax({
             data:  parametros,
             url:   '../php/CartasPromocionalesObtenerRegistros.php',
             type:  'GET', 
             async: false,
             beforeSend: function () {
                      $("#MensajeCarta1").html("Calculando Alumnos..."); 
             },
             success:  function (response ) {
                 elementosDevueltos = response.split("#");
                 for (var X=0; X < elementosDevueltos.length; X++){
                    if (X == 1) {
                        AlumnosAfectados = elementosDevueltos[X];
                        $("#numAlumnos").html("&nbsp;"+AlumnosAfectados); 
                    } else {
                       $("#MensajeCarta1").html(elementosDevueltos[X]);
                    }  
                }
   
				  return true;
             },
			 error: function(jqXHR, textStatus, errorThrown){
                  //$("#MensajeCarta2").html("<span class='rojo'>"+textStatus+"</span>");
                 $("#MensajeCarta2").html("<span class='rojo'>"+errorThrown+"</span>");
				  return false;
             }
        });
location.href = '#Fin';
}
//...........................................................................
function EnviarCorreos(){
    
   if(cartaProbada != 1){
      alert("Pruebe la carta y verifique que todo está bien"); 
      return false; 
   } 
   var  enviar = $('#enviar').val();
   if ( enviar != "ENVIAR") {
       alert("Escriba con mayúsculas--->ENVIAR");
       return false;
   }
    $("#EnviosCartas").html("<span class='azul'>&nbsp; Enviando las primeras 100 cartas</span>");
   
	LimpiaInicializaMensajes();
    var tipo    = $('input:radio[name=QueTengan]:checked').val();
    var selec   = CadenaSeleccionados();
    var noselec = CadenaNOSeleccionados();
    ProcesarRegistrosAlumnos(tipo,1,selec,noselec);
    location.href = '#Fin'; 
}
//...........................................................................
function ProcesarRegistrosAlumnos(TipoQuery,Desglosar,Seleccionados,NoSeleccionados){
if (TipoQuery != 0) {
	 $("#EnviosCartas").html("<span class='azul'>&nbsp; Enviando las primeras 100 cartas</span>");
}
  var devolver = false;
  var parametros = {
        "TipoQuery"         : TipoQuery ,
        "TipoSelect"        : TipoSelect[TipoQuery] ,
        "DesgloseRegistros" : Desglosar ,
        "Seleccionados"     : Seleccionados ,
        "NoSeleccionados"   : NoSeleccionados,
        "Carta"             : $('#cartaElegida').val(),
        "Asunto"            : $('#asunto').val(),
        "AfegirNom"         : $('input:radio[name=LlevaNombre]:checked').val()   
  };  
		$.ajax({
             data:  parametros,
             url:   '../php/CartasPromocionalesObtenerRegistros.php',
             type:  'GET', 
			 async: false,
             beforeSend: function () {
                      $("#MensajeCarta1").html("Procesando Query ....."); 
             },
             success:  function (response ) {
                 $("#MensajeCarta5").html("PROCESANDO LA(s) IDs => ");
                 elementosDevueltos = response.split("#");
                 for (var X=1; X < elementosDevueltos.length; X++){
                     if (X == 1) {
                        $("#MensajeCarta2").html("Alumnos encontrados: "+ elementosDevueltos[X]);
                        AlumnosEncontrados = elementosDevueltos[X];
                        AlumnosEnviados = 0;
                    } else if (X == 2) {
                       $("#MensajeCarta1").html(elementosDevueltos[X]); 
                    } else {
                       $("#MensajeCarta5").html($("#MensajeCarta5").text()+ elementosDevueltos[X]+", "); 
                        //GestionaCarta(elementosDevueltos[0],elementosDevueltos[X],$('#cartaElegida').val(),$('#asunto').val(),$('input:radio[name=LlevaNombre]:checked').val()); 
                        //....proceso de cartas.....(componer texto y enviar)..
                    }
                }

                 $("#MensajeCarta5").html($("#MensajeCarta5").text()+ "FIN OBTENER REGISTROS");
                 var mensajeFinal = "Se han añadido los alumnos a la lista de cartas pendientes de enviar";
                 $("#MensajeCarta3").html(mensajeFinal);
                 if ($("#MensajeCarta4").text() != ""){
                    $("#MensajeCarta4").html("IDs con ERROR-->"+$("#MensajeCarta4").text());
                    $('#MensajeCarta4').css('display','block');
                 }
                 if (TipoQuery > 0){
				     $("#EnviosCartas").html("<span class='azul'>&nbsp; Enviando cartas pendientes</span>");
                     ReenviaCartasPendientes(); 
                 } else {
					   $('#BotonProbar').html("<span class='azul'>&nbsp;@@BORRAME ANTES DE ENVIARCARTADEPRUEBAS()</span>");
                     EnviaCartaDePruebas(); 
					  
				 }
             },
			 error: function(jqXHR, textStatus, errorThrown){
                $("#MensajeCarta2").html("<span class='rojo'>"+errorThrown+"</span>");
				devolver = false;
            }
        });	
   return devolver;
}
//...........................................................................
function GestionaCarta(ID_carta,ID_alumno,FicheroCarta, asunto, afegirNom)	{
    
        var parametros = {
              "NumeroAlumno"  : ID_alumno 
        };  

		$.ajax({
             data:  parametros,
             url:   '../cartas/PomocionSemanal/'+FicheroCarta,
             type:  'post', 
			 async: false,
             beforeSend: function () {
                $("#MensajeCarta3").html("Componiendo carta ...."); 
             },
             success:  function (response) {
				 $("#MensajeCarta3").html("Carta compuesta OK"); 
				 EscribeAlAlumno(ID_carta,ID_alumno,response,asunto,afegirNom);
				 return true;
             },
			 error: function(){
                $("#MensajeCarta3").html("<span class='rojo'>Error componiendo carta</span>");
                 $("#MensajeCarta4").html($("#MensajeCarta4").text()+ID_alumno+ "-ERROR Carta, ");
				return false;
            }
        });	
}

//............................................................................
function EscribeAlAlumno(IDCarta,IDAlumno,body, asunto, afegirNom)	{
    var parametros = {
              "idCarta"   : IDCarta,
              "idAlumno"  : IDAlumno,
			  "bodyCarta" : body,
			  "asunto"    : asunto,
              "afegirNom" : afegirNom
              };  
	$.ajax({
             data:  parametros,
             url:   '../php/CartasPromocionalesEnviaMail.php',
             type:  'post',
			 async: false,
             beforeSend: function () {
                    $("#MensajeCarta3").html("Enviando email ...."); 
             },
             success:  function (response) {
					 if (response.trim() != "OK") {
						$("#MensajeCarta3").html("<span class='rojo'>Error enviando correo-->"+response+"</span>"); 
                        $("#MensajeCarta4").html($("#MensajeCarta4").text()+IDAlumno+ " -"+response+", ");
						return false;
					 } else {
						 //AnotaRegistroEmail();
						$("#MensajeCarta3").html("Envío OK"); 
                        AlumnosEnviados = AlumnosEnviados +1;
						return true;
					 }
             },
			 error: function(jqXHR, textStatus, errorThrown){
                $("#MensajeCarta3").html("<span class='rojo'>Error enviando Emails</span>");
                $("#MensajeCarta4").html($("#MensajeCarta4").text()+IDAlumno+ "-ERROR Envío "+textStatus+", "+errorThrown); 
				return false;
            }
        });	
}

//...........................................................................
function ReenviaCartasPendientes(){
    //El php devolverá
    // [0] id_carta
    // [1] Fichero
    // [2] Asunto
    // [3] AñadirNombre al asunto
    // [4....] id_alumnos
    alert ("Procedemos a reenviar Cartas pendientes");
    LimpiaInicializaMensajes();
  var parametros = {
     "NoHayParametros"   : " ",
  };  
		$.ajax({
             data:  parametros,
             url:   '../php/CartasPromocionalesReenviarPendientes.php',
             type:  'GET', 
			 async: false,
             beforeSend: function () {
                      $("#MensajeCarta1").html("NO CIERRE ESTA PESTAÑA: Procesando Query Reenvío Cartas. Puede abrir otra pestaña para otras gestiones"); 
             },
             success:  function (response ) {
                 $("#MensajeCarta5").html(response);
                 
             },
			 error: function(jqXHR, textStatus, errorThrown){
                $("#MensajeCarta2").html("<span class='rojo'>"+errorThrown+"</span>");
            }
        });	
   
 $("#botonSalir").css("display","block");   
 $("#enviosAnteriores").css("display","inline");   
   
}
//...........................................................................
function EnviaCartaDePruebas(){
    //El php devolverá
    // [0] id_carta
    // [1] Fichero
    // [2] Asunto
    // [3] AñadirNombre al asunto
    // [4....] id_alumnos
    alert ("Procedemos a enviar Carta de Pruebas");
    LimpiaInicializaMensajes();
  var parametros = {
        "Carta"             : $('#cartaElegida').val(),
        "Asunto"            : $('#asunto').val(),
        "AfegirNom"         : $('input:radio[name=LlevaNombre]:checked').val() 
  };  
		$.ajax({
             data:  parametros,
             url:   '../php/CartasPromocionalesEnviarCartaDePruebas.php',
             type:  'GET', 
			 async: false,
             beforeSend: function () {
                      $("#MensajeCarta1").html("NO CIERRE ESTA PESTAÑA: Procesando Query Reenvío Cartas. Puede abrir otra pestaña para otras gestiones"); 
             },
             success:  function (response ) {
				 
				  $('#BotonProbar').html(response);
                  //$("#MensajeCarta5").html(response);
                 
             },
			 error: function(jqXHR, textStatus, errorThrown){ 
                $("#MensajeCarta2").html("<span class='rojo'>"+errorThrown+"</span>");
            }
        });	
   
 $("#botonSalir").css("display","block");   
 $("#enviosAnteriores").css("display","inline");   
   
}
//...........................................................................
