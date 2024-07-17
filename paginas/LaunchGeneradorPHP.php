<?php
  include_once('../conexion/conn_bbdd.php');
  session_start();
   
  if (!isset($_REQUEST['NumeroCurso'])) {
	$_REQUEST['NumeroCurso'] = 0;
  }
  
	$_SESSION['ver_curso'] = 0;
   
	$_SESSION['NumeroCurso'] = $_REQUEST['NumeroCurso'];
	
  if (!isset($_REQUEST['modo_ver'])) {
	$_REQUEST['modo_ver'] = 0;
  }

  if ($_REQUEST['modo_ver'] == 1) {
	  $_SESSION['ver_curso'] = 1;
  } else {
	  $_SESSION['ver_curso'] = 0;
  }

  if ($_SESSION['es_admin'] != 1) {
      $longitud = count($_SESSION['permisos']);
      for($i=0; $i<$longitud; $i++) {
		   if ($_SESSION['permisos'] [$i] == $_SESSION['NumeroCurso']) {
	          $_SESSION['ver_curso'] = 1;
			  $_REQUEST['modo_ver'] = 1;
           }
       }

  }
  
  $tit = "";
  $fichero = "";

   $FormatVTCursos = "SELECT id_curso, titulo_cur,  web_ficherophp
                      FROM vtcursos 
					  WHERE  id_curso = %d";
   $queVTCursos = sprintf($FormatVTCursos, $_SESSION['NumeroCurso']); 

   
   $resVTCursos = mysqli_query($conexion, $queVTCursos) or die(mysqli_error($conexion));
    
   $totVTCursos = mysqli_num_rows($resVTCursos);
   if ($totVTCursos> 0) {  //.....Registro de conexión
   	 while ($rowRegistros = mysqli_fetch_assoc($resVTCursos)) {
		$tit =  $rowRegistros['titulo_cur'];
		$fichero =  $rowRegistros['web_ficherophp'];
   	 }
    }
  mysqli_free_result($resVTCursos);	
//...................................................................
function ExisteFichero ($file) {  
   if (file_exists($file) ) {	
	    return true;    
   } else {
       return false;    
   }    
}
  
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<style>
  .rojo {
	  color:#C00;
	  
  }
</style>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Lanzador del Generador de Cursos para grabar fichero de salida de cada curso</title>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> 
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
<script>
bodyCurso ="";
function GeneraCurso(numero) {
		     var parametros = {   
			  "NumeroCurso"    : numero
              };  
		$.ajax({
             data:  parametros,
              url: 'VTGeneradorPHPCursoContenido.php',
             type:  'post',
			 async: false,
             beforeSend: function () {
                      $("#mensaje").html("Componiendo el texto del curso (Resolviendo PHP)"); 
             },
       success:  function (response) {
				         bodyCurso = response+"   ";
				         $("#mensaje").html("Curso compuesto con éxito. Vamos a grabar grabar los "+response.length+" bytes del fichero en trozos de 5000"); 
						 if (HazPartes()) {
							  $("#mensaje").html("Curso grabado con ÉXITO: Verificar que se ha construído bien el menú y que se ve bien el curso"); 
						 } else {
							  $("#mensaje").html("<span class='rojo'>ERROR troceando y grabando el fichero-->HazPartes()</span>"); 
						 }
						 
				  
             },
			 error: function(){
                $("#mensaje").html("<span class='rojo'>Error procesando lectura del curso, ponle INACTIVO hasta que funcione</span>");
				
				return false;
            }
        });
        	
}


function HazPartes(){
	
   var ArrayPartes = [];
   var LongitudParte=3000;
   var bodyCursoLongitud = bodyCurso.length;
   var bodyCursoModulo = bodyCursoLongitud % LongitudParte;
   
   if (bodyCursoModulo == 0) {
	   bodyCurso = bodyCurso + " ";
	   bodyCursoLongitud = bodyCurso.length;
       bodyCursoModulo = bodyCursoLongitud % LongitudParte;
   }
    var NumPartes = parseInt(bodyCursoLongitud / LongitudParte);
	$("#Partes").html("Longitud = "+bodyCursoLongitud+"  Modulo = "+bodyCursoModulo+ " Partes= "+NumPartes+"<br>"); 
	var UltimoFinal = 0;
	for (x=0; x <= NumPartes ; x++) {
		var inicio = 0;
		var final = 0;
		if (x == 0 ) {
			inicio = 0;
			final = (bodyCursoLongitud < LongitudParte -1 ? bodyCursoLongitud : 	LongitudParte -1 );	
		} else if (x == NumPartes) {
			inicio = UltimoFinal ;
			final = bodyCursoLongitud ;
		} else {
			inicio = UltimoFinal;
			final = inicio + LongitudParte;
		}
		UltimoFinal =  final;
		var valores = [inicio, final];
		ArrayPartes.push(valores);
		$("#Partes").append("Parte  "+x+" = " +  inicio + "     " +    final     +"<br>");
		
	}
	$("#Partes").append("<br>Inicio grabación de los trozos del fichero<br>");
	for (j =0; j<ArrayPartes.length; j++) {
	 var salida = 	ArrayPartes[j];
	 $("#Partes").append("Grabando Parte  "+j+" = " +  salida[0] + "     " +    salida[1]+"  ");
	   GrabaCurso(j,ArrayPartes.length,salida[0],salida[1]);
	 //setTimeout(GrabaCurso(j,salida[0],salida[1]), 90000);
	}
return true;	
}

function GrabaCurso(NumeroTrozo,Totales,ini,fin) {
		     var parametros = {   
			  "bodycurso"      : bodyCurso.substring(ini,fin),
			  "fichero"        : '<?php echo $fichero ?>',
			  "NumeroTrozo"    : NumeroTrozo,
			  "TotalTrozos"    : Totales
              };  
		$.ajax({
             data:  parametros,
             url:   'VTGrabaPHPCursoContenido.php',
             type:  'post',
			 async: false,
             beforeSend: function () {
                      $("#Partes").append(" grabación del trozo número: "+NumeroTrozo+"  "); 
             },
             success:  function (response) {
				 $("#Partes").append("CORRECTO"+"<br>"); 
             },
			 error: function(jqXHR, textStatus, errorThrown) {
				 $("#Partes").append('<span class="rojo">ERROR</span>'+"<br>"); 
				 $("#mensaje").html('<span class="rojo">ERROR troceando y grabando el fichero-->HazPartes()</span>');
				 alert('NO GRABADO:An error occurred... Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information!');

                 $('#result').html('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');

				 $("#Substring").append("<br>*******(inicio)**texto del error en grabación****************"+"<br>"); 
				 a = bodyCurso.substring(ini,fin);
				 $("#Substring").append("****************longitud *******"+a.length+"<br>");
				 
				 $("#Substring").append(bodyCurso.substring(ini,fin));
				 
				 
				 $("#Substring").append("<br>*******(fin)**texto del error****************"+"<br>"); 
				 
                
            }
        });	
}


</script>



</head>

<?php if (ExisteFichero($fichero)){ ?>
    <body>
        <br /><span class="rojo"> ERROR: El fichero </span>html/paginas/<?php echo $fichero ?>  <span class="rojo">ya EXISTE</span>
    <br /> <br />Es NECESARIO <span class="rojo">BORRAR el arxivo antes</span> de generar el nuevo
    <br /> Entra con FILEZILLA y BÓRRALO
    <br /> <br />  Antes de borrar el fichero cópialo en local (en tu ordenador), después lo borras
    <br /> Si tienes problemas para generar el nuevo curso siempre puedes recuperarlo de la copia  aunque no esté actualizado
        <br /> <br /> <span class="rojo">Otra opción es que renombres el fichero</span>, sin necesidad de borrarlo. Por ejemplo: le pones la fecha delante--> 20200107_NombreCurso.php  (Recomiendo lo renombres por delante, podrás localizarlo mejor)
       <br /> <br />Para borrar o renombrar con Filezilla te pones encima del fichero y botón de la derecha 
        
    <br /> <br /> Cuando el sistema detecte que no existe el fichero te dejará volverlo a generar
    <br /> <br /> Siempre que generes un curso de nuevo debes entrar a comprobar si todo va bien
    <br /> <br />
 <?php }  else { ?> 
    <body onload="javascript:GeneraCurso(<?php echo $_REQUEST['NumeroCurso'] ?>)">
    
    Vamos a generar el curso Número: <?php echo $_REQUEST['NumeroCurso'] ?>
    <br /><br />
    Título del curso: <?php echo $tit ?>
    <br /><br />
    Fichero de salida: paginas/<?php echo $fichero ?>
    
    <br /><br />
    ESTADO PROCESO:
    <BR />
    <p id='mensaje'>Antes de llamar a la función GeneraCurso()</p>
    <div id="Partes"></div>
    <div id="Substring"></div>
    <div id="result"></div>
    <br />
    <br />
    <br />
    <br />
    <div id="elBody"></div> 
<?php } ?>    
</body>
</html>