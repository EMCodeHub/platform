<?php include_once('../conexion/conn_bbdd.php'); include_once('../php/ValidaLoginScript.php');include_once('../php/ParametrosClass.php');$DatosWeb =   new ParametrosClass($conexion);include_once('../php/SesionesCookies.php'); ?>
<!DOCTYPE html>
<html lang="es" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
    
<?php $NumeroCurso = 7;include_once('NewWebEstilosNOIndex.php');include_once('../php/IndexScript.php');include_once('PaginaCursoPHP01.php');  ?>
	
<script>Nombre_correo = 'Eduardo ';
emisorcorreo = 'eduardo.mediavilla@medifestructuras.com';
numCurso = '7';
tituloCurso = 'CURSO INTERACCIÓN ELEMENTOS CONSTRUCTIVOS CON LA ESTRUCTURA';
precioCurso = 145;
</script><script>DENombre_correo = 'Eduardo ';
DEemisorcorreo = 'eduardo.mediavilla@medifestructuras.com';
</script>

<script  src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script><script  src="../php/VTCursoContenido.js"></script><script  src="../php/VTCursoContenidoCobros.js"></script><script  src="../php/VTCalculoDescuentosCobros.js"></script>   
<title>CURSO INTERACCIÓN ELEMENTOS CONSTRUCTIVOS CON LA ESTRUCTURA</title>
    
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
           
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">TEORÍA Y METODOLOGÍA</h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/05Cursointeraccionelementos/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Presentación power point de conceptos y metodología</h3><p class ="bloque_descriVT" >Realizaremos análisis teóricos</p>
<div class="clear"></div><b>Recursos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:Descarga('R',102)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/PDF.gif" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Memoria de calculo</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:Descarga('R',103)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/PPT.gif" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Power Point</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:Descarga('R',105)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/PDF.gif" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Catalogo morteros 1</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:Descarga('R',106)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/PDF.gif" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Catalogo morteros 2</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:Descarga('R',107)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/PDF.gif" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Catalogo morteros 3</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:Descarga('R',108)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/PDF.gif" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Catalogo bloques de hormigón </div><div class='clear'></div><br><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(180)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Conceptos parte 1</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(181)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Conceptos parte 2</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(182)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Conceptos parte 3</div><div class='clear'></div><br></div><div class="clear"></div></article>
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">ANÁLISIS DE MODELOS</h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/05Cursointeraccionelementos/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Análisis de 4 modelos teóricos.</h3><p class ="bloque_descriVT" >Analizaremos la estructura desnuda, la estructura completa con cerramientos, un piso blando en planta baja y un piso blando en entrepiso</p>
<div class="clear"></div><b>Recursos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:Descarga('R',104)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/XLS.gif" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Excel</div><div class='clear'></div><br><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(183)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Análisis de modelos teóricos (A)</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(184)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Análisis de modelos teóricos (B)</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(185)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Análisis de modelos teóricos (C)</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(186)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Análisis de modelos teóricos (D)</div><div class='clear'></div><br></div><div class="clear"></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/05Cursointeraccionelementos/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Análisis de 2 casos reales</h3><p class ="bloque_descriVT" >Analizaremos una vivienda unifamiliar y un edificio en altura</p>
<div class="clear"></div><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(187)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Ejercicio con vivienda unifamiliar curso numero 3 medifestructuras</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(188)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Ejercicio con edificio en altura</div><div class='clear'></div><br></div><div class="clear"></div></article>
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">MATERIAL DE REFUERZO</h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/05Cursointeraccionelementos/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Bienvenida y funcionamiento</h3><p class ="bloque_descriVT" >El día 25 de junio de 2020 se realizó un seminario online en vivo, donde se habló del planteamiento necesario para poder plantear la profesión de ingeniero estructural a nivel internacional.<br><br>El seminario  puedes visualizarlo antes de iniciar el curso, o después. Indistintamente, pero es necesario que lo visualices para que adquieras el enfoque preciso a la hora de trabajar e interpretar diferentes normativas, y de forma especifica para el curso de interacción de elementos constructivos con la estructura. Si necesitas algún dato acerca de una normativa especifica, puedes solicitarlo mediante el Foro de la plataforma.<br><br>La única norma que existe es la de utilización individual de usuario. Le deseamos mucha suerte con el avance de su aprendizaje.</p>
<div class="clear"></div><b>Recursos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:Descarga('R',273)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/WORD.gif" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Seminario Internacional de proyectos</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:Descarga('R',274)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/WORD.gif" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Links videos en directo</div><div class='clear'></div><br></div><div class="clear"></div></article>   </div> 
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
   
    <p id="botonCalcular"> <input name="Descuentos" type="button" class ="ButtonGrisnuevo" value ="Calcula tu DESCUENTO por adquirir más de un curso" onClick="javascript:VerDescuentos(1)"/> </p>
   
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
      <br> <br> 
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
   