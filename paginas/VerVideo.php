<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
//........................................................
function ComponerBodyCarta()	{
		     var parametros = {   
			  "Param1"       : "_" 
              };  
		$.ajax({
             data:  parametros,
             url:   '../cartas/CartaVTExcesoConexiones.php',
             type:  'post',
             beforeSend: function () {
                      $("#CBmarcoMensaje").html("Componiendo carta ...."); 
             },
             success:  function (response) {
				 bodyCartaCli = response;
				 EnviaCartaAlumno(bodyCartaCli);
             },
			 error: function(){
                $("#CBmarcoMensaje").html("<span class='rojo'>Error componiendo carta</span>");
				
				return false;
            }
        });	
	
}
//........................................................
function EnviaCartaAlumno(PbodyCartaCli)	{
		     var parametros = {
			  "bodyCarta"     : PbodyCartaCli
              };  
	$.ajax({
             data:  parametros,
             url:   '../php/VTExcesoConexEnviaMail.php',
             type:  'post',
             beforeSend: function () {
                      $("#CBmarcoMensaje").html("Enviando e-mail ...."); 
             },
             success:  function (response) {
					 if (response != "OK") {
						$("#CBmarcoMensaje").html("<span class='rojo'>"+response+"</span>"); 
						return false;
					 } else {
						 $("#CBmarcoMensaje").html("Le hemos enviado un Email con las instrucciones de desbloqueo del usuario");
						 InsertaFechaAviso(); 
						return true;
					 }
             },
			 error: function(){
                $("#CBmarcoMensaje").html("<span class='rojo'>Error enviando el e-mail, póngase en contacto con nosotros</span>");
				return false;
            }
        });	
	
}
//........................................................
function InsertaFechaAviso()	{
		     var parametros = {   
			  "Param1"       : "_" 
              };  
		$.ajax({
             data:  parametros,
             url:   '../php/VTExcesoConexAnotaAviso.php',
             type:  'post',
             beforeSend: function () {
                      $("#CBmarcoMensaje").html("Actualizando datos"); 
             },
             success:  function (response) {
			    $("#CBmarcoMensaje").html("<span class='rojo'>Si persiste el bloqueo póngase en contacto con nosotros</span>");
             },
			 error: function(){
                $("#CBmarcoMensaje").html("<span class='rojo'>Error actualizando datos</span>");
				
				return false;
            }
        });	
}

//.............................................
</script>
<?php
 session_start();
 include_once('EstilosScripsNOIndex.php');
 include_once('../conexion/conn_bbdd.php');
 include_once('../php/VTSesionesUsoRecursosScript.php');

/*$numero2 = count($_REQUEST);
$tags2 = array_keys($_REQUEST); // obtiene los nombres de las varibles
$valores2 = array_values($_REQUEST);// obtiene los valores de las varibles
for($i=0;$i<$numero2;$i++){ 
    echo $tags2[$i]."=".$valores2[$i]."   "; 
}
*/

    $ConexionesExcedidas = 0;   // si se detectan múltiples conexiones se activará a valor 1: Ver función CTRConexiones()

  	$carpetaCurso = "";
   	$archivo = "";
    $titulo_curso = "";
	  $titulo_video = "";
	  $codigoYouTube = "";
	  $FormatArchivo = "SELECT carpetadeficheros, vtcurmodbloqvideo.es_de_pago, url_YouTube, video_pago, titulo_video, titulo_cur
                         FROM    vtcursos, vtcursomodulo, vtcurmodbloque, vtcurmodbloqvideo
					     WHERE   vtcursomodulo.id_vtcurso = vtcursos.id_curso
					       and   vtcurmodbloque.id_vtcurmodulo = vtcursomodulo.id_modulo
						   and   vtcurmodbloqvideo.id_vtcurmodbloque = vtcurmodbloque.id_bloque 
					       and   id = %d";
	  $queArchivo = sprintf($FormatArchivo,  $_REQUEST['id']); 				  
				
				//echo 	  $queArchivo;
   
   $resArchivo = mysqli_query($conexion, $queArchivo) or die(mysqli_error($conexion));
   $totArchivo = mysqli_num_rows($resArchivo);
   $sePaga = 0;
   if ($totArchivo> 0) {  //.....Registro de conexión
   	 while ($rowRegistros = mysqli_fetch_assoc($resArchivo)) {
		$archivo = "";
   	 	$carpetaCurso = $rowRegistros['carpetadeficheros'];
		$titulo_curso = $rowRegistros['titulo_cur'];
	    $titulo_video = $rowRegistros['titulo_video'];

		if ($rowRegistros['es_de_pago'] == 1) {
			 if (isset($_SESSION['NumeroCurso'])) {   //para que no funcione la página si la llaman desde fuera de vtcursocontendo
      			$archivo = $rowRegistros['video_pago'];
			      $sePaga = 1;
			 }
		} else {
			$archivo = $rowRegistros['url_YouTube'];
		}   	 	
   	 }
   }


if ( $sePaga == 1) {
   $archivo = basename($archivo);
   $ruta = "../VIDEOTUTORIALES/".$carpetaCurso."/".$archivo;
   InsertaUsoRecurso("V",$_REQUEST['id'],$conexion);
   $ConexionesExcedidas = CTRConexiones($conexion);
   if ($ConexionesExcedidas > 0) {
	   $ruta = "Conexiones Excedidas";  //.... anulamos la variable ruta para que no llegue al vídeo si se han excedido las conexiones
   }
   
   
} else {
	$archivo = trim($archivo);
	$ruta = $archivo;
	$final = strlen($archivo); 
	$inicio = strpos($archivo,'=');
	$codigoYouTube = substr($archivo,$inicio+1,$final-$inicio-1);
}
mysqli_free_result($resArchivo);

/*echo "<br>ruta--->".$ruta."<br>";
echo "<br>codigo--->".$codigoYouTube."<br>"
*/
//................................... si exceso de conexiones enviar un e-mail y anotar fecha del aviso	
		
	
//................................... enviar correo a Comercial si persiste en su actitud	
		
//................................... anotar la fecha del aviso en vtavisoalumno	


?>
<script>
function IniciaVideo() {
	document.getElementById("pantalla").play();
}

</script>
<title><?php echo  $titulo_video ?></title>
</head>
<body > 
   <div class="PocoEspacio"></div>
   <div class="centro">
 
   	<?php if ($ConexionesExcedidas == 0) {
            echo "<b>".$titulo_curso."</b>&nbsp;&nbsp;";
            echo '<input name="VolverAlCurso" type="button" class ="ButtonGrisP" value ="Volver al curso" onclick="javascript:window.history.back()"/>';
            echo "<br>".$titulo_video."</br></br>";  
         } else {
            echo "<b>"."<br><br>Hemos detectado múltiples conexiones para este usuario"."</b><br><br> En breve le enviamos un e-mail con instrucciones para desbloquear el usuario <br><br> ";
            echo '<br><div class = "pide_panPreMensaje"><div id = "CBmarcoMensaje" ><div class="centro">&nbsp;</div></div></div>';
            echo "<br><script> ComponerBodyCarta() </script>";
            exit;
   } ?>
   
   <div class ="videoCurso">

   

   <?php if ($sePaga == 1) { ?>
               <video  id="pantalla" controls >
                 <source src="<?php echo $ruta ?>" type="video/mp4">
                 Your browser does not support the video tag.
               </video>
   <?php  } else { ?>
               <div class="centro_objeto">          
                    <object data="https://www.youtube.com/embed/<?php echo  $codigoYouTube ?>"></object>
               </div>
   <?php  } ?>
    
  </div>
  </div>   
</body>
</html>
