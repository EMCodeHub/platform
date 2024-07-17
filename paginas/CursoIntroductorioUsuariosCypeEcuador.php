<?php include_once('../conexion/conn_bbdd.php'); include_once('../php/ValidaLoginScript.php');include_once('../php/ParametrosClass.php');$DatosWeb =   new ParametrosClass($conexion);include_once('../php/SesionesCookies.php'); ?>
<!DOCTYPE html>
<html lang="es" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
    
<?php $NumeroCurso = 9;include_once('NewWebEstilosNOIndex.php');include_once('../php/IndexScript.php');include_once('PaginaCursoPHP01.php');  ?>
	
<script>Nombre_correo = 'Eduardo ';
emisorcorreo = 'eduardo.mediavilla@cype.com';
numCurso = '9';
tituloCurso = 'Revisión de proyectos';
precioCurso = 0;
</script><script>DENombre_correo = 'Eduardo ';
DEemisorcorreo = 'eduardo.mediavilla@cype.com';
</script>

<script  src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script><script  src="../php/VTCursoContenido.js"></script><script  src="../php/VTCursoContenidoCobros.js"></script><script  src="../php/VTCalculoDescuentosCobros.js"></script>   
<title>Revisión de proyectos</title>
    
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
           
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">ESTRUCTURAS DE BLOQUES DE HORMIGÓN</h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/07Cursoiniciacioncype/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Estructuras que utilizan muros de bloque de hormigón</h3><p class ="bloque_descriVT" >En este bloque repasaremos los pasos a seguir para trabajar con muros de bloque de hormigón</p>
<div class="clear"></div><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(578)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Muros de bloque de hormigón</div><div class='clear'></div><br></div><div class="clear"></div></article>
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">¿CONOCES CÓMO FUNCIONA CYPECAD?</h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/07Cursoiniciacioncype/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Ejercicio completo utilizando CYPECAD</h3><p class ="bloque_descriVT" >En este bloque revisaremos un caso completo de inicio a fin utilizando CYPECAD. En poco tiempo, el alumno que revise este contenido logrará entender qué hace y cómo trabaja la herramienta CYPECAD. Evidentemente, CYPE no es únicamente CYPECAD. CYPE, es un conjunto de softwares que abordan múltiples soluciones de ingeniería. Como por ejemplo modelado de arquitectura, soluciones para estructuras, instalaciones, gestión de obra y presupuestos.</p>
<div class="clear"></div><b>Videos</b><br /><br /><?php 	  $control = 0;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(572)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/CandadoAbierto.gif" alt="Candado abierto" width="25" height="25" /><img src="../imagenes/YouTube.jpg" alt="Logo Youtube" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Premisas base de proyecto, configuraciones iniciales.</div><div class='clear'></div><?php 	  $control = 0;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(573)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/CandadoAbierto.gif" alt="Candado abierto" width="25" height="25" /><img src="../imagenes/YouTube.jpg" alt="Logo Youtube" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Cálculo y edición de columnas, vigas, losas y cimentación.</div><div class='clear'></div><br></div><div class="clear"></div></article>
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">ESTRUCTURACIÓN, EDIFICIO EN ALTURA.</h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/07Cursoiniciacioncype/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Edificio en altura</h3><p class ="bloque_descriVT" >En este bloque veremos diferentes formas de proceder ante un proyecto de hormigón armado de 14 niveles. Se realiza una explicación acerca de conceptos de estructuración avanzados. Los edificios que disponen de un número elevado de pisos son más propensos a sufrir fallas debido a la gran cantidad de masa que poseen. Nunca será igual el proceso de diseño de una edificación elevada, al de una edificación de únicamente 2 niveles.</p>
<div class="clear"></div><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(512)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >¿Cómo realizar una correcta estructuración en altura?</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(381)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Estudio de estructuración. Caso 1. Estructuración de edificación de hormigón de 14 niveles.</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(498)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Estudio de estructuración. Caso 2. Edificio Space. Medellin Colombia</div><div class='clear'></div><br></div><div class="clear"></div></article>
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">NAVES INDUSTRIALES</h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/07Cursoiniciacioncype/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Nave industrial con cercha triángulo</h3><p class ="bloque_descriVT" >En este bloque abordaremos una nave industrial bastante interesante. Hablaremos de las decisiones que se tomaron y también daremos algunos consejos para abordar la profesión de ingeniero. Sobre todo pensando en los más jóvenes.</p>
<div class="clear"></div><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(513)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Nave industrial con cercha rígida para 33 metros.</div><div class='clear'></div><br></div><div class="clear"></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/07Cursoiniciacioncype/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Nave industrial con puente grua</h3><p class ="bloque_descriVT" >Realizaremos un recorrido por un reciente proyecto que realizamos en la consultoria, fue un proyecto para Madrid, España.</p>
<div class="clear"></div><b>Videos</b><br /><br /><?php 	  $control = 0;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(461)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/CandadoAbierto.gif" alt="Candado abierto" width="25" height="25" /><img src="../imagenes/YouTube.jpg" alt="Logo Youtube" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Presentación de proyecto de Nave industrial</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(463)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Nave industrial, inicio de proyecto y toma de decisiones</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(464)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Continuamos con el análisis de las decisiones hasta llegar a los planos</div><div class='clear'></div><br></div><div class="clear"></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/07Cursoiniciacioncype/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Nave industrial con perfiles en celosía</h3><p class ="bloque_descriVT" >Realizaremos un recorrido por una estructura interesante de perfiles en celosía. Estudiaremos la longitud de pandeo de elementos.</p>
<div class="clear"></div><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(499)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Nave industrial de perfiles en celosía. Longitud de pandeo de barras</div><div class='clear'></div><br></div><div class="clear"></div></article>
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">STRUBIM SHEAR WALLS/STRUBIM REBAR/LOSAS POSTESADAS</h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/07Cursoiniciacioncype/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Vigas de acople y armado de confinamiento en muros a cortante.</h3><p class ="bloque_descriVT" >En este bloque hablaremos de nuevas aplicaciones de la version 2020 de CYPE. Hablaremos concretamente de vigas de acomplamiento y armado de confinamiento en muros a cortante. El armado de confinamiento también es denominado como cabezales o elementos de borde.</p>
<div class="clear"></div><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(447)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Ejemplo real con los nuevos softwares de CYPE STRUBIM DESIGN SHEAR WALL</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(382)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Aplicaciones nueva versión de CYPE 2020. Muros a cortante</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(383)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Armado de punzonamiento, vigas de acoplamiento y esfuerzos.</div><div class='clear'></div><br></div><div class="clear"></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/07Cursoiniciacioncype/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Losas Postesadas</h3><p class ="bloque_descriVT" >Revisaremos las novedades de CYPE, concretamente el modulo de losas postesadas.</p>
<div class="clear"></div><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(384)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Losas Postesadas</div><div class='clear'></div><br></div><div class="clear"></div></article>
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">ESTRUCTURAS METÁLICAS</h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/07Cursoiniciacioncype/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Estructuras metálicas</h3><p class ="bloque_descriVT" >En este conjunto de videos veremos conceptos elementales de estructuras metálicas.</p>
<div class="clear"></div><b>Videos</b><br /><br /><?php 	  $control = 0;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(505)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/CandadoAbierto.gif" alt="Candado abierto" width="25" height="25" /><img src="../imagenes/YouTube.jpg" alt="Logo Youtube" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >CONCEPTOS DE ESTRUCTURAS METÁLICAS PARTE 1</div><div class='clear'></div><?php 	  $control = 0;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(506)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/CandadoAbierto.gif" alt="Candado abierto" width="25" height="25" /><img src="../imagenes/YouTube.jpg" alt="Logo Youtube" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >CONCEPTOS DE ESTRUCTURAS METÁLICAS PARTE 2</div><div class='clear'></div><?php 	  $control = 0;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(508)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/CandadoAbierto.gif" alt="Candado abierto" width="25" height="25" /><img src="../imagenes/YouTube.jpg" alt="Logo Youtube" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >CONCEPTOS DE ESTRUCTURAS METÁLICAS PARTE 3</div><div class='clear'></div><br></div><div class="clear"></div></article>
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">EDIFICIO UNASUR</h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/07Cursoiniciacioncype/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Analisis del Volado Unasur Mitad del Mundo</h3><p class ="bloque_descriVT" >Realizaremos un recorrido por el modelo</p>
<div class="clear"></div><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(452)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Volado Unasur</div><div class='clear'></div><br></div><div class="clear"></div></article>
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">ESTRUCTURACIÓN DE EDIFICIO DE ACERO DESTINADO A DISCOTECA</h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/07Cursoiniciacioncype/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Análisis de edificación de acero de 2 niveles</h3><p class ="bloque_descriVT" >Realizaremos un recorrido por una interesante estructura de acero, con columnas y vigas tipo H, con uniones precalificadas a momento y con una estructura tipo cercha integrada.</p>
<div class="clear"></div><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(385)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Edificación de acero 2 niveles con cercha integrada y uniones precalificadas</div><div class='clear'></div><br></div><div class="clear"></div></article>
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">CONFERENCIAS/SEMINARIOS ONLINE</h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/07Cursoiniciacioncype/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Charla con CYPE Perú</h3><p class ="bloque_descriVT" >Conferencia con el equipo de CYPE Perú</p>
<div class="clear"></div><b>Videos</b><br /><br /><?php 	  $control = 0;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(518)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/CandadoAbierto.gif" alt="Candado abierto" width="25" height="25" /><img src="../imagenes/YouTube.jpg" alt="Logo Youtube" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Seminario con CYPE Perú. 14 trucos de CYPECAD Y CYPE 3D</div><div class='clear'></div><br></div><div class="clear"></div></article>
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">EDIFICACIÓN DESTINADA A CONCESIONARIO DE AUTOS</h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/07Cursoiniciacioncype/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Edificio de estructura mixta. Concesionario de Autos</h3><p class ="bloque_descriVT" >Realizaremos un recorrido por el proyecto, centrándonos en las decisiones mas importantes del proyecto</p>
<div class="clear"></div><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(386)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Análisis de edificio de estructura mixta destinado a exhibición y venta de vehículos.</div><div class='clear'></div><br></div><div class="clear"></div></article>
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">ESTRUCTURACIÓN Y ANÁLISIS DE EDIFICACIÓN DESTINADA A USO ADMINISTRATIVO DE OFICINAS</h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/07Cursoiniciacioncype/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Edificio destinado a oficinas de estructura mixta y con sistema de vigas T invertida</h3><p class ="bloque_descriVT" >Realizaremos un análisis por las decisiones más importantes del proyecto. Veremos como la ausencia de rigidez de un área determinada en planta produce torsiones indeseadas.</p>
<div class="clear"></div><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(387)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Edificio de estructura mixta con vinculación suelo estructura</div><div class='clear'></div><br></div><div class="clear"></div></article>
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">REVISIÓN DE NAVE INDUSTRIAL DE ALMA LLENA CON APOYO PARA PUENTE GRÚA</h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/07Cursoiniciacioncype/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Revisión de nave industrial</h3><p class ="bloque_descriVT" >Realizaremos un interesante recorrido por las situaciones y planteamiento de proyecto destinado a almacenaje (bodegas) con la particularidad de contener apoyos para la inserción de una viga carril.</p>
<div class="clear"></div><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(391)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Revisión de nave industrial con apoyo para viga carril</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(398)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Puente soporte de tuberia</div><div class='clear'></div><br></div><div class="clear"></div></article>
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">REVISIÓN DE EDIFICACIONES DE BAJO COSTO</h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/07Cursoiniciacioncype/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Revisión de edificación de hormigón de 2 niveles</h3><p class ="bloque_descriVT" >Realizaremos una explicación de las exigencias que deben cumplir las edificaciones de estas características, es decir, nos centraremos en aquellas exigencias que deberán cumplir, y aquellos puntos de la norma que no deban cumplir serán comentados.<br><br>Existe un debate constante acerca de cómo deben de ejecutarse esta tipología de edificación, en este vídeo hablaremos con argumentos sólidos acerca de los condicionamientos normativos.</p>
<div class="clear"></div><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(388)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Edificación de 2 niveles. Estructura de hormigón con losa steel deck</div><div class='clear'></div><?php 	  $control = 0;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(396)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/CandadoAbierto.gif" alt="Candado abierto" width="25" height="25" /><img src="../imagenes/YouTube.jpg" alt="Logo Youtube" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Columna fuerte viga débil
</div><div class='clear'></div><?php 	  $control = 0;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(456)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/CandadoAbierto.gif" alt="Candado abierto" width="25" height="25" /><img src="../imagenes/YouTube.jpg" alt="Logo Youtube" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Flexocompresión en columnas</div><div class='clear'></div><?php 	  $control = 0;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(503)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/CandadoAbierto.gif" alt="Candado abierto" width="25" height="25" /><img src="../imagenes/YouTube.jpg" alt="Logo Youtube" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >¿CYPE SOBREDIMENSIONA LAS ARMADURAS?</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(507)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Estructura de bambú (Guadúa)</div><div class='clear'></div><br></div><div class="clear"></div></article>
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">EDIFICIO DE ESTRUCTURA MIXTA CON MUROS DE CONTENCIÓN DE TIERRAS DESTINADO A BOMBEROS</h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/07Cursoiniciacioncype/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Edificio de estructura mixta destinado a bomberos.</h3><p class ="bloque_descriVT" >Realizaremos un recorrido por las decisiones más criticas del proyecto. Hablaremos de los materiales a escoger para la construcción del ascensor.</p>
<div class="clear"></div><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(389)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Análisis de edificación destinada a uso de Bomberos</div><div class='clear'></div><br></div><div class="clear"></div></article>
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">ESTRUCTURA COLISEO</h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/07Cursoiniciacioncype/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Estadio Cubierta y Coliseo</h3><p class ="bloque_descriVT" >Realizaremos una explicación acerca de trucos y consideraciones a la hora de realizar proyectos de alta complejidad como este.</p>
<div class="clear"></div><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(446)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Coliseo</div><div class='clear'></div><br></div><div class="clear"></div></article>
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">TIPOLOGÍA DE STEEL FRAME</h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/07Cursoiniciacioncype/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Tipología de Steel Frame</h3><p class ="bloque_descriVT" >Obtendremos los pernos de anclaje</p>
<div class="clear"></div><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(511)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Sistema de Steel Frame mediante CYPE 3D</div><div class='clear'></div><br></div><div class="clear"></div></article>
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">DISEÑO POR DESEMPEÑO </h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/07Cursoiniciacioncype/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Análisis no-lineal pushover</h3><p class ="bloque_descriVT" >Realizaremos un recorrido conceptual y teórico por las herramientas que nos permiten evaluar edificaciones existentes. Mejorar en la toma de decisiones para elevar la ductilidad de los pórticos, consiguiendo estructuras dúctiles.</p>
<div class="clear"></div><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(392)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Analisis no-lineal pushover con ETABS</div><div class='clear'></div><br></div><div class="clear"></div></article>
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">COLAPSO DE EDIFICACIÓN </h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/07Cursoiniciacioncype/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Errores que no debemos cometer</h3><p class ="bloque_descriVT" >En este video veremos un caso real de colapso. Comenzaremos este curso de casos reales examinando sucesos como este, donde una edificación colapsa a principios del año 2020 debido a un fallo conceptual de diseño estructural.</p>
<div class="clear"></div><b>Videos</b><br /><br /><?php 	  $control = 0;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(487)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/CandadoAbierto.gif" alt="Candado abierto" width="25" height="25" /><img src="../imagenes/YouTube.jpg" alt="Logo Youtube" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Colapso de edificación por punzonamiento</div><div class='clear'></div><br></div><div class="clear"></div></article>
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">METODOLOGÍA DE TRABAJO</h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/07Cursoiniciacioncype/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Metodología y formas de trabajo.</h3><p class ="bloque_descriVT" >Explicaremos el funcionamiento de la plataforma, posibilidades de inscripción.</p>
<div class="clear"></div><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(390)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Funcionamiento de medifestructuras.com</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(450)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Como realizar una correcta obtención de planos con CYPECAD</div><div class='clear'></div><br></div><div class="clear"></div></article>
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">ESTRUCTURAS METÁLICAS DE 2 NIVELES. FUNCIONAMIENTO DEL FORO DE MEDIFESTRUCTURAS.COM</h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/07Cursoiniciacioncype/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">Estructuras metálicas, periodo de vibración y agrietamiento de mampostería.</h3><p class ="bloque_descriVT" >Revisaremos los puntos más conflictivos de esta tipología de estructuras.</p>
<div class="clear"></div><b>Videos</b><br /><br /><?php 	  $control = 0;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(401)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/CandadoAbierto.gif" alt="Candado abierto" width="25" height="25" /><img src="../imagenes/YouTube.jpg" alt="Logo Youtube" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Edificación donde evaluaremos el agrietamiento de la mampostería.</div><div class='clear'></div><br></div><div class="clear"></div></article>
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">PUENTE SOPORTE DE TUBERIA</h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/07Cursoiniciacioncype/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">PUENTE COLGANTE</h3><p class ="bloque_descriVT" >Revisaremos un interesante caso real de tubería suspendida (puente colgante). Revisaremos soluciones para estos casos.</p>
<div class="clear"></div><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(397)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Puente colgante y tubería sobre cercha</div><div class='clear'></div><br></div><div class="clear"></div></article>
<article><div class = "TituloModulo"><h2 class="modulo_tituloVT">CONCEPTOS DE HIDRAULICA Y REDES DE ABASTECIMIENTO</h2></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/07Cursoiniciacioncype/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">NUEVOS SOFTWARES DE INSTALACIONES VERSIÓN CYPE 2020</h3><p class ="bloque_descriVT" >Realizaremos un recorrido por los nuevos softwares de instalaciones versión 2020</p>
<div class="clear"></div><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(421)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Instalacion de evacuacion de aguas CYPEPLUMBING SANITARY SYSTEMS</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(422)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Instalación de suministro de agua CYPEPLUMBING Water Systems</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(429)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Instalación Solar Térmica CYPE Plumbing Solar Systems</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(437)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Instalación contraincendios CYPEFIRE</div><div class='clear'></div><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(445)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Open Bim Layout Todas las instalaciones en vista 3d</div><div class='clear'></div><br></div><div class="clear"></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/07Cursoiniciacioncype/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">REDES DE ABASTECIMIENTO DE AGUA (SOFTWARE ANTIGUO, pero operativo en 2020)</h3><p class ="bloque_descriVT" >Realizaremos un analisis de una red de abastecimiento de agua de una urbanización de casas</p>
<div class="clear"></div><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(399)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Redes de abastecimiento de agua</div><div class='clear'></div><br></div><div class="clear"></div>
<div class="celda_5_izdaVT"><img src="../VIDEOTUTORIALES/07Cursoiniciacioncype/Prueba_Imagen_bloque_generico.gif" alt="Prueba_Imagen_bloque_generico.gif "></div>
<div class="celda_95_dechaVT"><h3 class="bloque_tituloVT">SUMINISTRO DE AGUA DE 1 VIVIENDA CON SOFTWARE ANTIGUO</h3><p class ="bloque_descriVT" >Realizaremos un recorrido por una instalación de suministro de agua correspondiente a una vivienda unifamiliar</p>
<div class="clear"></div><b>Videos</b><br /><br /><?php 	  $control = 1;	  $verLinks = 0;                              	  $mostrarCandado = 0;                        	  if ($_SESSION["ver_curso"] == 1) {          		  $verLinks = 1;                          	  } else {                                    		  if ($control == 0) {   			 $verLinks = 1;                       			 $mostrarCandado = 1;                 		  }                                       	  }                                            ?><?php
$txtLinkNO = "javascript:AvisoDebeComprar(25)";$txtLinkSI = "javascript:VerVideo(400)";$txtLink = $txtLinkNO;if( $verLinks == 1) { $txtLink= $txtLinkSI;} ?>
<div  class="bloqueCelda6Inicial"><img src="../imagenes/Punto.gif" alt="Punto capítulo" width="25" height="25" /><img src="../imagenes/Mp4.jpg" alt="Formato fichero" width="25" height="25" /></div><div  class="bloqueCelda88Cursor"  onclick="<?php echo  $txtLink  ?>" onmouseover = "entraReg(this)" onmouseout="salReg(this)" >Suministro de agua de una vivienda unifamiliar</div><div class='clear'></div><br></div><div class="clear"></div></article>   </div> 
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
         	
         	0 <?php  echo $DatosWeb->GetValor("moneda") ?>   

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
   