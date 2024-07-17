<?php include_once('../conexion/conn_bbdd.php'); include_once('../php/ValidaLoginScript.php');include_once('../php/ParametrosClass.php');$DatosWeb =   new ParametrosClass($conexion);include_once('../php/SesionesCookies.php'); ?>
<!DOCTYPE html>
<html lang="es" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
    
<?php $NumeroCurso = 10;include_once('NewWebEstilosNOIndex.php');include_once('../php/IndexScript.php');include_once('PaginaCursoPHP01.php');  ?>
	
<script>Nombre_correo = 'Eduardo ';
emisorcorreo = 'eduardo.mediavilla@cype.com';
numCurso = '10';
tituloCurso = 'CALCULO Y DISEÑO DE UN PUENTE GRÚA  ';
precioCurso = 145;
</script><script>DENombre_correo = 'Eduardo ';
DEemisorcorreo = 'eduardo.mediavilla@cype.com';
</script>

<script  src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script><script  src="../php/VTCursoContenido.js"></script><script  src="../php/VTCursoContenidoCobros.js"></script><script  src="../php/VTCalculoDescuentosCobros.js"></script>   
<title>CALCULO Y DISEÑO DE UN PUENTE GRÚA  </title>
    
<?php include_once('PaginaCabecera.php');  ?>    
    
	

<script>
 CursorX = 0;
 CursorY = 0;  
 AntiguaY = 0;  
 procesoActivo = 0;
 posY = 0;

function ComprarCurso() {
	
a = document.getElementById("CompraCurso");a.style.display= "none";b = document.getElementById("CorreoGeneral");b.style.display= "none";d    = document.getElementById("CorrreoCobros");posY = d.style.top = CursorY-200;if (posY < 100) { posY = 100;}d.style.top = posY+"px";d.style.display= "block";m = document.getElementById("envoltorioGeneralDescuentos");m.style.display= "none";     
    
}
		

</script>

<?php include_once('PaginaCursoPHP01_2.php');  ?>
</head>

<body onMouseMove="javascript:coordenadas(event);">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TM8DJ4"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

 
<?php include_once('MenuNOIndexCursosVideotutoriales.php');  ?>   
<div class="clear"></div>
<div id="logoPrincipalVideotutoriales"><img src="../imagenes/logos/<?php echo $DatosWeb->GetTrimValor("web_logoblanco") ?>"  alt="medifestructuras.com Logo"></div>

    
    
    
    

<section class="contenedor">
      

 <div class="ficha">  



<?php if ($_SESSION["ver_curso"] == 1) {    include_once('VTCursoCabeceraPago.php'); } else {	  include_once('VTCursoCabeceraNoPago.php'); } ?>


<div class="centro">

<?php include_once('VTCalculoDescuentos.php'); ?> 


</div>
</div><!-- end .ficha ................................................................................ -->
<!--Ficha ............................................................................................ -->
<div class="ficha">
<div class="ficha_fila">  <!--Solicutud de certificado -->


<?php include_once('PaginaCursoPHP02.php'); ?>
</div> <!-- ficha_fila    Solicutud de certificado -->

<div class="ficha_fila">

   <div class = "celda_10_izdaVT"><p class="tituloApartado">Contenido del Curso</p></div>
   <div class = "celda_90_dechaVT"> 
   <div class ="FichaListaFilaRaya"></div>
           
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">INTRODUCCION AL FUNCIONAMIENTO DE UN PUENTE GRUA </h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/08PuenteGrua/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Funcionamiento y partes de un puente grúa </h3><p class ="bloque_descriVT" >Revisaremos y analizaremos todo lo necesario para posteriormente modelar todos los esfuerzos que actuaran en el puente grua.</p>
<div class="clear"></div><b>Recursos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:Descarga('R',161)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/PDF.gif" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Eurocodigo parte 1</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:Descarga('R',162)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/PDF.gif" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Eurocodigo parte 2</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:Descarga('R',163)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/PPT.gif" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Power point de conceptos</div><div class='clear'></div><br><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(263)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Parte 1</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(264)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Parte 2</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(265)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Parte 3</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(266)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Parte 4</div><div class='clear'></div><br></div><div class="clear"></div></article>
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">EJEMPLO PRACTICO NUMERICO</h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/08PuenteGrua/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Ejemplo numérico</h3><p class ="bloque_descriVT" >Realizaremos una selección de perfil a través de cálculos numéricos. Obtencion de inercia mínima y resistencia a flexión simple. </p>
<div class="clear"></div><b>Recursos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:Descarga('R',167)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/RAR.gif" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Catalogos</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:Descarga('R',168)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/PDF.gif" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Norma americana</div><div class='clear'></div><br><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(267)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Parte 1</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(268)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Parte 2</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(269)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Parte 3</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(270)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Parte 4</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(271)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Parte 5</div><div class='clear'></div><br></div><div class="clear"></div></article>
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">EJEMPLO PRACTICO CON SOFTWARE CYPE 3D</h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/08PuenteGrua/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Modelado de la viga carril con Cype 3d</h3><p class ="bloque_descriVT" >Modelaremos teniendo en cuenta todo lo aprendido en la teoría, analizaremos y escogeremos el perfil de la viga carril</p>
<div class="clear"></div><b>Recursos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:Descarga('R',164)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/XLS.gif" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Excel</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:Descarga('R',165)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/PDF.gif" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >ANSI-AISC 360-10 LRFD</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:Descarga('R',166)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/PDF.gif" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >EAE Normativa española de perfiles (solicitar vía email) </div><div class='clear'></div><br><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(272)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Parte 1</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(273)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Parte 2</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(274)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Parte 3</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(275)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Parte 4</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(276)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Parte 5</div><div class='clear'></div><br></div><div class="clear"></div></article>
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">EJEMPLO PRACTICO CON SOFTWARE CRANEWAY</h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/08PuenteGrua/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Calculo de un puente grúa mediante Craneway</h3><p class ="bloque_descriVT" >Realizaremos un calculo completo con el programa craneway</p>
<div class="clear"></div><b>Recursos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:Descarga('R',169)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/PPT.gif" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Power point craneway</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:Descarga('R',170)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/PDF.gif" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Teorías de fatiga Palmgren Miner</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:Descarga('R',190)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/PDF.gif" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Prontuario perfiles para proyecto real ubicado en España. </div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:Descarga('R',191)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/PDF.gif" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Listado de resultados de Craneway proyecto real, puente grúa 5 toneladas</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:Descarga('R',192)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/PDF.gif" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Catálogo de puentes grúa para proyecto real marca ABUS, documento con datos importantes para proyecto real.</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:Descarga('R',193)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/PDF.gif" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Interesante Tesis para extracción de ideas</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:Descarga('R',280)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/WORD.gif" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Link video : Uniones en viga carril consulta de alumno</div><div class='clear'></div><br><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(277)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Parte 1</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(278)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Parte 2</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(279)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Parte 3</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(280)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Parte 4</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(281)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Parte 5</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(282)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Parte 6</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(283)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Parte 7</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(285)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Parte 8</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(460)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Planteamiento de proyecto real 5 toneladas de capacidad</div><div class='clear'></div><br></div><div class="clear"></div></article>
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">ESTUDIO DE CASO REAL</h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/08PuenteGrua/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Casos reales</h3><p class ="bloque_descriVT" >En este bloque introduciremos un conjunto de videos destinados a la evaluación de uniones, diseño de ménsula y evaluación del comportamiento general del puente grúa.<br><br>Trabajaremos casos de la consultoría y casos externos (alumnos)<br><br></p>
<div class="clear"></div><b>Recursos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:Descarga('R',227)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/WORD.gif" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Planos nave industrial</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:Descarga('R',228)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/WORD.gif" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Memoria nave industrial</div><div class='clear'></div><br><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(563)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Aplicación de cargas a nave industrial</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(564)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Análisis de perfiles y límite de desplazamientos (Nave industrial México)</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(565)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Análisis de diagonales (por elementos finitos) Nuevo software CYPE Connect Steel</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(567)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Casos de cargas, distribución de hipótesis, posiciones y análisis ménsula.</div><div class='clear'></div><br></div><div class="clear"></div></article>   </div> 
</div> 
</div>

<!-- entrega de certificados (ini) ..............................................................................................-->
<?php include_once('PaginaCursoPHP03.php'); ?><!--entrega de certificados (fin) ..............................................................................................-->




</section><!-- end .contenedor -->
<div id = "CompraCurso">
<img style="cursor:pointer" src="../imagenes/AddToCart_naranja.gif"  alt="Carrito compra" onMouseOut="javascript:GetImagenCart(1,this)" onMouseOver="javascript:GetImagenCart(2,this);AvisoDebeComprar(0)" onclick="javascip:ComprarCurso()"/>

</div>


<div class="centro"> 
   <div id = "CorrreoCobros">    
   <div id = "correoCobrosDatos2" >
   <br>
    <?php if (PresentarDescuento($conexion,$DatosWeb->GetValor("descuento_activo"))) {?> 
   
    <p id="botonCalcular"> <input name="Descuentos" type="button" class ="ButtonGrisP" value ="Calcula tu DESCUENTO por adquirir más de un curso" onClick="javascript:VerDescuentos(1)"/> </p>
   
     <?php } ?>     
           <p class="pide_panPreTit">Comprar el videotutorial</p>
          
        <form  class="formulario">
	    
        <!--<div class="mitad">-->
      <br>
         
       
           <div class = "pide_panPreMensaje"><div class="centro"><script> document.write(tituloCurso.toUpperCase()) </script></div></div> 
           <br><br>
          <div class="clear"></div>
          
          
          <div style="margin-left:10%">
         <label class="pide_panPre">Importe </label> 
         <label class="pide_panPreMensaje">
         	
         	145 <?php  echo $DatosWeb->GetValor("moneda") ?>   

         </label> 
         <div class="clear"></div>
      <label class="pide_panPre">Email </label> <input id = "CBemail" type="text" name="CBemail" size="35" maxlength="99" value= "" required > 
      <br> 
      <label class="pide_panPre">Repita el Email </label> <input id = "CBemail2" type="text" name="CBemail2" size="35" maxlength="99" value= "" required > 
         
         </div>
      <br> 
            
     <div class="clear"></div>
     <br>
       <div class = "pide_panPreMensaje"><div class="centro"><div id = "CBmarcoMensaje" >&nbsp; </div></div></div>
       <br>
     <div class="clear"></div>
  </form>   
     
     <div id= "CBBotones">
         
        <button id = "CBButton1" class="botonVisa" ><img src="../imagenes/Tarjeta_on.gif" alt="Tarjeta Visa" /></button>  

        <!--
           &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
        <button  id = "CBButton3" class="botonVisa" ><img src="../imagenes/Transfer_on.gif" alt="Transferencia Bancaria" /></button> 
    -->
    
      </div>
       <br>
       <br>
      <div class ="centro"> <input id = "CBButton4" name="Salir" type="button" class ="ButtonGrisP" value ="&nbsp; &nbsp; &nbsp; &nbsp; Salir&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; " /></div>
       <br>
       <br> 
     <div class="clear"></div>
    
 
</div>
   </div> 
   
 </div>   
  <!-- FIN CORREO-->
    <br />
<div class = "Aviso"></div>
    <div class="ficha">
       <?php include_once('PaginaPieNOIndex.php'); ?>    </div>
<?php include_once('PaginaCursoPHP01_4.php');  ?></body>

</html>
   