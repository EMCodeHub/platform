<?php
include_once('../conexion/conn_bbdd.php');
include_once('../php/ValidaLoginScript.php');
include_once('../php/ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb =   new ParametrosClass($conexion);

$tituloPagina = "";
$FormatTemas = "SELECT cuestion
                  FROM foroscuestiones
                 WHERE id = %d";
$queTemas = sprintf($FormatTemas,$_REQUEST['id']);
$resTemas = mysqli_query($conexion, $queTemas) or die(mysqli_error($conexion));  
$totTemas = mysqli_num_rows($resTemas);     
if ($totTemas > 0){
	while ($rowTemas = mysqli_fetch_assoc($resTemas)) {
		$tituloPagina = $rowTemas['cuestion']; 
	}
}
mysqli_free_result($resTemas); 
?>

<!DOCTYPE html>
<html lang="es" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Foro CYPE - <?php echo $tituloPagina?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script  src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>    
    
<?php include_once('../paginas/PaginaCabecera.php'); ?>       
<script>
 CursorX = 0;
 CursorY = 0;  

function CierraAcceder(modo) {
   
	var j=document.getElementById("Acceder");
	if (modo == 0){
		j.style.display="none";
	} else {
         CierraRegistrarse(0);
		j.style.display="block";
	}
	
}
function CierraRegistrarse(modo) {
	
	var j=document.getElementById("Registrarse");
	if (modo == 0){
		j.style.display="none";
	} else {
        CierraAcceder(0);
		j.style.display="block";
	}
}

</script>
<script  src="../php/Acceder.js"></script>
<script  src="../php/VideotutorialesLogin.js"></script>
<script  src="../php/widgEditor.js"></script>  
<script  src="../php/CuestionForo.js"></script>      
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes"/>
<?php

include_once('../php/SesionesCookies.php'); //Inicio de sesión y asignación de sus variables
include_once('../paginas/NewWebEstilosForos.php')    
//$CursoEnPromocion  = 9;   //....... cambiar si cambia el curso de la landing, el curso gratis

?>
</head>
<body onMouseMove="javascript:coordenadas(event);">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $DatosWeb->GetTrimValor('codigo_tagmanager') ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php
include_once('../php/IndexScript.php');
include_once('../php/ForosScript.php');
include_once('../paginas/MenuForos.php'); 
include_once('../paginas/PaginaCursoPHP01_2.php');    
?>


    
 <div id="MensajePantalla">
		<div class="centro"><b>Respuesta al Mensaje <span id="NumeroPadre"></span></b></div>

		<form id="formmensaje" name = "formmensaje" action="../php/ForoMensajeAlta.php" >
			<input id = "num_mensaje_padre"  name="num_mensaje_padre"  type="hidden" /> 
            <input id = "num_cuestion"  name="num_cuestion"  type="hidden" /> 
			<fieldset>
				<label for="noise">
					Escriba su Contestación:
				</label>
				<textarea id="noise" name="noise" class="widgEditor nothing"></textarea>
			</fieldset>
			
			<fieldset class="submit">
				<input type="submit" value="Enviar al Foro" />
                <input type="button" value="Salir" onclick="SalirMensaje()"/>
			</fieldset>
		</form>	
		
</div>
  
    <div id="RecursoPantalla">
   	
        <div class="cenro">
          <div class="MensajeRecLineaCentro"> 
            <img src="../imagenes/FlechaUpload.gif" alt="Upload" width="30" height="30"  /> &nbsp; ADJUNTAR FICHERO: Imagen, Vídeo, PDF, XLSX, DOCX ...
          </div>
        </div>
        <form enctype="multipart/form-data" class="formulario">
	    
	     <input type="text" id = "num_mensaje" name="num_mensaje" hidden />
         <input type="text" id = "num_cuestion" name="num_cuestion" hidden />
	     <label class="pide_panPre"> Título / Descripción del contenido del fichero:</label>
         <br>
         <textarea id = "titulo_recurso" class="areaTexto" cols="100" rows="5" name="titulo_recurso"  ><?php if (isset( $_REQUEST['titulo_recurso'])) { echo $_REQUEST['titulo_recurso']; }?></textarea>

	      <div id = "marcoEligeFichero">
               <br>
               <label class="pide_panPre">Fichero: </label>   
               <input type="file" id="userfile" name="userfile"  >
        </div>
        <!--<img src="../paginas/captcha.php" alt="captcha"  /> &nbsp;&nbsp;&nbsp;<input type="text" id = "code" name="code" maxlength="6" />-->        
         <div class="centro"><div id = "marcoMensaje"></div></div>
         <div class="centro"><div id = "marcoNombreFichero"></div></div>
         <div class="centro"><div id = "recogeMensajes"></div></div>

         <div class="clear"></div>
         <fieldset class="submit" id = "botones" >
           <input  type="Button"  id= "ButtonEnviar" name="ButtonEnviar"  value="Enviar">
           <input  type="Button"  id= "ButtonSalir"  name="ButtonSalir"   value="Salir"> 
        </fieldset>
        
     <div class="clear"></div>
    
     <div class="centro"><div id = "marcoNombreFichero"></div></div>
     <div class="centro"><div id = "recogeMensajes"></div></div>
   </form> 
</div>



   
    
    
<!-- ........ ....... ......... ......... ......... .......... -->
    
<section class="EnvoltorioForoClase">    
   <?php 
      ActualizaVisitas($_REQUEST['id'],$conexion);
      echo PintaCuestionById($_REQUEST['id'],$conexion); 
    ?> 
</section> 
    <div class="clear"></div>
    <br/>
<?php 
    include_once('CuestionPie.php'); 
    include_once('ForoPantallas.php'); 
?> 
<div class = "Aviso"></div>
 <?php 
function ActualizaVisitas($id,$conexion){
$id_cuestion =  $id;
$id_tema = 0;
$FormatTemas = "SELECT id_forostemas
                  FROM foroscuestiones
                 WHERE  id = %d";

$queTemas = sprintf($FormatTemas,$id);
$resTemas = mysqli_query($conexion, $queTemas) or die(mysqli_error($conexion));  
$totTemas = mysqli_num_rows($resTemas);     
if ($totTemas > 0){
	while ($rowTemas = mysqli_fetch_assoc($resTemas)) {
		$id_tema = $rowTemas['id_forostemas']; 
	}
}
mysqli_free_result($resTemas); 
          
$FormatTemas = "UPDATE forostemas 
                   set veces_visitado = veces_visitado +1 
                 WHERE id= %d";
$queTemas = sprintf($FormatTemas,$id_tema);
$resTemas = mysqli_query($conexion, $queTemas) or die(mysqli_error($conexion)); 
mysqli_free_result($resTemas);  
    
    
$FormatTemas = "UPDATE foroscuestiones 
                   set veces_visitada = veces_visitada +1 
                 WHERE id= %d";
$queTemas = sprintf($FormatTemas,$id_cuestion);
$resTemas = mysqli_query($conexion, $queTemas) or die(mysqli_error($conexion)); 
mysqli_free_result($resTemas);  

} 
?>    
<?php include_once('../paginas/PaginaCursoPHP01_4.php'); ?>
</body>
</html>
