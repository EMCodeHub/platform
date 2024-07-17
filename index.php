<?php
include_once('conexion/conn_bbdd.php');
include_once('php/ValidaLoginScript.php');
include_once('php/ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb =   new ParametrosClass($conexion);



include_once('php/CartasPromocionalesSeleccionarScript.php'); //...para llamar al reenvio de cartas -> CartasPromocionalesSEleccionar.php


include_once('php/SesionesCookies.php'); //Inicio de sesión y necesita $DatosWeb





if ($_SESSION['es_admin'] == 1 ) {
   $situacionCartas = ReenviarCPendientes($conexion,1);
   if ($situacionCartas == 3) {
    header("Location: mantenimiento/CartasPromocionalesSeleccionar.php");
     exit;
   }
}






$CursoEnPromocion  = $DatosWeb->GetValor('curso_en_promocion');

?>
<!DOCTYPE html>
<html lang="es" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script  src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>   
<link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,500,800" rel="stylesheet">    
    
<?php include_once('paginas/PaginaCabecera.php'); ?>  

<?php
include_once('paginas/NewWebEstilos.php');
include_once('paginas/PaginaCursoPHP01_2.php'); 
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>

<title>CURSOS CYPE</title>

<script  src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>





<!--

<style>
        /* Estilos para el div fijo en la esquina inferior derecha */
        .fixed-corner {
            position: fixed;
            bottom: 20px; /* Distancia desde abajo */
            right: 20px; /* Distancia desde la derecha */
			z-index:999999;
      
			
        }
    </style>

-->


<!--

<script>

$(document).ready(function() {
    // Cargar el contenido de base.html usando jQuery
    $('.fixed-corner').load('templates/base.html');
});

</script>


<script src="./js/randomid.js"></script>



<script>
// Generar el identificador único al cargar la página
const uniqueId = generateUniqueId();

// Almacenar el identificador único en localStorage
localStorage.setItem('sessionId', uniqueId);

// Opcional: Mostrar el identificador único en la consola


</script>


      -->













<script>
CursoEnPromocion = <?php echo $CursoEnPromocion ?>;  
function CierraTomaDeDatos(modo) {
	var j=document.getElementById("TomaDeDatos");
	if (modo == 0){
		j.style.display="none";
	} else {
		j.style.display="block";
	}
}
</script>

<script  src="php/VideotutorialesLogin.js"></script>
<script  src="php/VTCalculoDescuentosCobrosIndex.js"></script>
<script  src="php/CorreoDevoluciones.js"></script>
<?php if ($DatosWeb->GetValor('landing_reducida') == 0 ) { ?>
          <script  src="php/Landing.js"></script>
    <?php } else { ?>
          <script  src="php/LandingReducida.js"></script>
<?php } ?>    
    

<?php



$clausulaNOTIN = "";  //...................................para seleccionar cursos y no cursos del alumno
if(	$_SESSION['NumeroUsuario'] != 0) {  
	$longitud = count($_SESSION['permisos']);
	if ($longitud > 0) {
       for($i=0; $i<$longitud; $i++) {
	        if ($i == 0 ) {
		      $clausulaNOTIN .= "(".$_SESSION['permisos'] [$i];
	        }  else {
		      $clausulaNOTIN .= ",".$_SESSION['permisos'] [$i];
	        }
        }
	$clausulaNOTIN .= ")";
 }
}
echo "<script>DENombre_correo = '".$DatosWeb->GetTrimValor('NombrePrincipal')."';\n";
echo "DEemisorcorreo = '".$DatosWeb->GetTrimValor('CorreoPrincipal')."';\n";
echo "</script>\n";




?>


<!-- Facebook Pixel Code -->


<!-- End Facebook Pixel Code -->










</head>



<body class="dark-mode">



<div class="fixed-corner">

</div>





<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $DatosWeb->GetTrimValor('codigo_tagmanager') ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php
include_once('paginas/MenuIndex.php');                 
include_once('php/IndexScript.php');
$EnsenyarLanding = 0;
if ($CursoEnPromocion > 0) {
      $EnsenyarLanding = 1; //.......ver si enseñamos o no la landing
      $longitud = count($_SESSION['permisos']);
	  if ($longitud > 0) {
         for($i=0; $i<$longitud; $i++) {
		      if ($_SESSION['permisos'] [$i] == $CursoEnPromocion) {
				  $EnsenyarLanding = 0;
			  }
         }
       } 
}
?>
    
<div class="PocoEspacio" ></div>
<div class="clear"></div>
<div class = "Aviso"></div>
    





<div class="ContenedorSlider">    




    <input type="radio" id="1" name="image-slide" hidden/>
    <input type="radio" id="2" name="image-slide" hidden/>
    <input type="radio" id="3" name="image-slide" hidden/>
    <div class="slider">
        <ul class="sliderUL">
          <li><img src="imagenes/11p.png" alt=""/> <div class="parrafos" ><h2>Cursos de CYPE con Soporte Técnico</h2><p>Foro de alumnos</p></div></li>
          <li><img src="imagenes/22p.png" alt=""/> <div class="parrafos" ><h2>Descubra nuestra metodología</h2>
              <p>Le ayudamos con sus proyectos</p>
              
              </div></li>
          <li><img src="imagenes/33p.png" alt=""/> <div class="parrafos" ><h2>Capacitación online</h2><p>Inscríbase</p></div></li>
        </ul>
        <div class="pagination">
            <label class="pagination-item" for="1"></label>
            <label class="pagination-item" for="2"></label>
            <label class="pagination-item" for="3"></label>  
        </div>
    </div>



    <div class="overlay"></div>



</div>   










     
<?php if ($_SESSION['NumeroUsuario'] != 0) { ?>
<div id="DivDescBienve"> 
  <div id="DivBienvenida"> 
    Bienvenido/a: <b><?php  echo EmailAlumno($_SESSION['NumeroUsuario'],$conexion);?></b>
     <div class="DivBienvenida2">
        <input name="Cambio Contraseña" type="button" class ="ButtonGrisP" value ="&nbsp;&nbsp;Cambio de Contraseña&nbsp;&nbsp;" 
       onclick="location.href='paginas/VideotutorialesCambioPwd.php?'"/> 
     </div>
  </div>
</div>  
<?php } ?>  

<?php  include_once('paginas/PantallaPwd.php'); ?>

<?php   ////////// Mientras construimos NOTIN vamos llamando a los cursos del alumno
     include_once('php/IndexScript.php');
     include_once('paginas/VTCalculoDescuentosIndex.php');
?>
   

<?php if ($EnsenyarLanding == 1) {?> 


   <!--

  <div id="NewDivVideoBoton">
    <input name="CursoGratis" 
 	                 type="button" id="BotonInscripcion" class ="ButtonGris" value ="INSCRÍBASE a nuestro Curso GRATUITO" onclick="javascript:CierraTomaDeDatos(1)"/> 
    </div>

-->


<?php } ?> 
    

<?php if (PresentarDescuento($conexion,$DatosWeb->GetValor('descuento_activo'))) { ?>
           
  <div id="NewDivVideoBoton">

                <div id="DivDescuentos"> 

                 <input name="Descuentos" 
 	                 type="button" id="botonCalcular" class ="ButtonGris" value ="PROMOCIONES por compra de más de un curso " onclick="javascript:VerDescuentos(1)"/><br> 
                        

                  </div>

              <br>


              <?php if (count($_SESSION['permisos']) > 0) {?> 

                <div id="DivDescuentos3" style="display:none"> 
                <input name="Login" 
                type="button" id="botonCalcular2"  class ="ButtonGris" value ="LOGIN" onclick="javascript:VerLogin(1)"/><br> 
                </div>


                <?php } else {?> 

                  <div id="DivDescuentos3" style="display:block"> 
                <input name="Login" 
                type="button" id="botonCalcular2" class ="ButtonGris" value ="LOGIN" onclick="javascript:VerLogin(1)"/><br> 
                </div>


                  <?php } ?>


               
          </div><br>
<?php } ?>








<div class="clear"></div>

<h1 class ="NewtituloApartado">Cursos onLine</h1>


   
<div id="TomaDeDatos"> 
 <div id="PresentacionCruz2"> <img id="ImaIndex2" src="imagenes/AspaCierre.gif"  alt="Aspa de Cierre" onclick="CierraTomaDeDatos(0)"/> </div><div class="clear"></div>
    <div class="LandingI"> <img src="imagenes/FotoLanding001.jpg"  alt="Curso Gratuito" /></div>
    <div class="LandingD"> 
       <p class="negreta2">Accede al curso GRATIS</p>
       <br />
       <input id="TuNombre" name="TuNombre" size=40 type="text" placeholder="¿Nombre?"/>
       <br />
       
       <?php if ($DatosWeb->GetValor('landing_reducida') == 0 ) { ?>
                <input id="TusApellidos" name="TusApellidos" size=40 type="text" placeholder="¿Apellidos?"/>
                <br />
       <?php } ?>
        
       <input id="TuCorreo" name="TuCorreo" size=40 type="text" placeholder="Indíquenos su email"/>
       <br />
      
        <?php if ($DatosWeb->GetValor('landing_reducida') == 0 ) { ?>
                <input id="TuTfn" name="TuTfn" size=40 type="text" placeholder="¿Numero celular?"/>
                <br />
                <input id="TuPais" name="TuPais" size=40 type="text" placeholder="¿País?"/>
                <br />
        <?php } ?>

       <input type="checkbox" id="TuBox" value="1"> <span class="pequenyo">Acepto la Política de Privacidad</span>
       <br />

    </div>
     <div class="LandingD2"> 
        <p><b>Política de Privacidad</b></p>
        <p>Los datos que nos facilites son para uso interno, no se ceden a terceros</p>  
     </div>
    <div class="clear"></div>
    <div id="mensajeLanding"></div>
    <div id="botonesAceptacion">
        <input type="button" id="LDButton1" name="Salir" value="Salir" class ="ButtonGrisP"  />
         &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" id="LDButton2" name="EnviarDatos" value="Enviar Datos"  class ="ButtonGrisP"/>
        <br /> <br />
     </div>  
     <div id="mensajeFinal">
       <p>Le hemos enviado un email</p>
       <p>Abra su correo y confirme la inscripción</p>
    <p><b>Revise su correo no deseado</b></p>
       <br />
        <input type="button" id="LDButton3" name="Salir" value="Salir" class ="ButtonGrisP"  />
        <br /><br /><br />
     </div>
     
</div>



<?php if ($_SESSION['NumeroUsuario'] != 0) { ?>
    
      <div class="NewContenedorCursosTotal"> 
           <?php if (count($_SESSION['permisos']) > 0) {?> 
             <div class="azulGenerico"><h2>Estos son tus cursos:</h2></div>
           <?php } else {?> 
          <div class="azulGenerico"><h2>No se han encontrado cursos activos</h2></div>
           <?php } ?>
      </div> 
    
<?php } ?> 
 
 <div class="NewContenedorCursosTotal">
 <?php	
    if(	$_SESSION['NumeroUsuario'] != 0) {  
	   $longitud = count($_SESSION['permisos']);
	   if ($longitud > 0) {
         for($i=0; $i<$longitud; $i++) {
	       dibujaRajolaVideotutorial($_SESSION['permisos'] [$i],$conexion);
         }
       }
}
?> 
</div> 
    
    
<div class="clear"></div>
<div class="NewContenedorCursosTotal">  
     <?php
     if (count($_SESSION['permisos']) == 0) {
        echo '<div class="azulGenerico"><h2>Formación e-learning con soporte técnico</h2></div><br>';
     } else {
         if (cuentaNOPagados($clausulaNOTIN,$conexion) > 0) {
             echo '<div class="azulGenerico"><h2>Otros cursos del catálogo</h2></div>';
         } else {
             echo "";
         }
     }
    ?> 
</div>    
<div class="NewContenedorCursosTotal">  
    <?php 
        dibujaCatalogoRajoles($clausulaNOTIN,$conexion);
     ?>
</div>    

<br />

<div class="clear"></div> 
<br /> 
  

<br><br><br><br>


<div class="NewAsistencia"  >

<br><br>
        <p class="NewAsistenciaTitulo">Ofrecemos una alternativa de formación y crecimiento profesional </p>
        <p class="ArialBlancoSombra">Seguimiento</p>
         <h2 class="NewAsistenciaSubTitulo"> Mediante el Foro respondemos a nuestros alumnos en tiempo reducido (24h-48h) </h2> 
         <p id="garantia" class="ArialBlancoSombra" onclick="CDMuestraCorreoDevoluciones()" style="cursor:pointer">Garantía</p>
              
         <h2 class="NewAsistenciaSubTitulo" onclick="CDMuestraCorreoDevoluciones()" style="cursor:pointer"> Devolución de la inversión en caso de justificación adecuada</h2>
         <div class="centro">
		 <?php
                include_once('paginas/CorreoDevoluciones.php');
		 ?>
         </div>
         <p class="ArialBlancoSombra" style="cursor:auto">Objetivo</p>
          <h2 class="NewAsistenciaSubTitulo">Adquirir las habilidades necesarias para abordar la profesión de ingeniero </h2>



          <p class="ArialBlancoSombra" style="cursor:auto">Opiniones de alumnos</p>
      
          <span class="lipointerArial" onClick="location.href='Foros/TemaForo.php?id=32'"> Click aquí</span>

          <br>




          <br><br>






      

          <br>
  </div>
 
  
<!--

<div class="clear"></div> 

<div class="PocoEspacio"></div>

<div class="NewFila_60_izdaBlack">

       <div class="NewCelda_40_izdaP">
         <img src="imagenes/logos/LogoMedif.png"  alt="Logo <?php echo $DatosWeb->GetTrimValor('web_dominio') ?>" /> 
       </div>
       <div class="NewCelda_60_izda">
            <br /> <br>
            <b>PRESENTACIÓN DE CONTENIDOS
            <br />CARTA AL ALUMNO</b>
           <br />
           <br />  <br> <br>
            Un saludo para todos, mi nombre es <b>Eduardo Mediavilla</b> y en la actualidad dirijo una oficina técnica de <b>proyectos internacionales. </b> <br>
            <br />

            En esta oficina ofrecemos a nuestros clientes una solución integral arquitectónica, estructural, topográfica, hidrosanitaria, eléctrica, contra incendios y legal.<br> 
            Hemos tenido la gran suerte de poder trabajar activamente en proyectos importantes repartidos en Latinoamérica y España. <br> <br>

            Actualmente, desarrollamos <b>proyectos de construcción</b> residencial e industrial en el Ecuador. Y paralelamente dirijo la plataforma de capacitación <b>medifestructuras</b>, <br> 

            la cual en los últimos años, ha logrado ser de gran interés y utilidad para muchos profesionales.  <br> <br>

            Conozco de primera mano aquello que necesitan los clientes, y además soy conocedor de las dificultades que existen a la hora de aprender <b>diseño estructural <br> o de instalaciones. </b> Sobretodo si todavía se está comenzando. Y no se han tenido casos de referencia para el aprendizaje.<br> <br>

            Por un lado nos encontramos el tema <b>técnico y normativo,</b> por otro lado tenemos la <b>parte financiera y económica,</b> y finalmente las decisiones que tomamos los técnicos <br> e ingenieros de obra en el día a día, las cuales repercuten en los 2 temas anteriormente citados. <b></b><br> <br>

            Con tanta información y tanta responsabilidad, en ocasiones es mejor tomar un tiempo para capacitarse. <b>Interiorizar</b> los conceptos elementales y necesarios, e iniciar con su <br> oficina de proyectos aportando un gran servicio al cliente. <br> <br>

            Yo mismo pasé por la etapa dónde trabajaba en una empresa por el día, y por la noche no dormía, debido a las largas horas de estudio para lograr aportar <b> seguridad<br> y confianza a mis diseños,</b> compré Cursos y Másters digitales hasta lograr tener suficiente perspectiva y criterio.

            A día de hoy, <b>año 2023</b>, continúo viendo<br> en mis alumnos las mismas ganas que yo tuve de aprender y sigo teniendo, pero sólamente si se edifica un conocimiento limpio sobre unos buenos cimientos, éste logra perdurar. <br> <br>

            Es por ello que he creado 9 cursos, donde aporto todo lo que conozco de mi profesión. Siendo 8 de estructuras y 1 de instalaciones, explicando paso a paso todos los problemas <br>que podemos tener cuando estamos diseñando. <br> <br>

            Pero eso no es todo, hemos abierto un <b>foro de consultas para alumnos, </b> por si se siente perdido en algun momento y desea una respuesta rápida, referente a un aspecto del curso <br>o a un proyecto real que se encuentre desarrollando.

            Es probable que si ya está realizando los cursos esté haciendo un gran esfuerzo por completarlos, y además no sea fácil estar atento<br> a todos los videos y material existente. Ya que existe mucho contenido y requiere de un <b>gran compromiso.</b> <br> <br>

            Pero si logra completarlos todos sin excepción, puedo asegurarle que no cometerá errores que yo pude haber cometido en el pasado, ya que diáriamente actualizamos <br> y agregamos nuevo contenido, aportando nuevos casos y nuevas experiencias, junto con nuevos trucos de diseño. <br> <br>

            Es por ello que le recomendamos que revise los contenidos de los cursos periódicamente, ya que en ocasiones aportamos nuevos casos interesantes. Ya que el <b>usuario</b> una vez adquirido,<br> es <b>permanente.</b> No creemos en el aprendizaje bajo presión. Nosotros no limitamos el <b>acceso a los contenidos.</b><br> <br>

            Personalmente valoro mucho el esfuerzo de muchos de ustedes por aprender, no sólamente mediante mis contenidos sino por el mero compromiso de seguir aprendiendo y <br>actualizando conocimientos de nuestra maravillosa profesión. <br> <br>
            
      

           

            Personalmente, <b>soy profesor vocacional.</b> Disfruto mucho enseñando y respondiendo <b>consultas mediante el Foro</b> y me enorgullece que con mi ayuda muchos de <br>ustedes hayan alcanzado sus objetivos académicos y laborales.  <br> <br>

            Escríbanos su experiencia en el apartado de <a href="https://www.medifestructuras.com/Foros/TemaForo.php?id=32">opiniones de alumnos</a> <br> <br>

            También le animamos a que conozca nuestro trabajo académico y divulgativo en nuestro canal de Youtube: <a href="https://www.youtube.com/channel/UCLMWAmi1DX83jj75a9w7dsg">Medif Consultoria</a>, donde hemos publicado más de 190 videos gratuitos. <br> <br>

            Aprovechamos para recordar que los cursos disponen de certificado, una vez completados los ejercicios y enviados al correo <b>eduardo.mediavilla@cype.com </b>  <br><br>

            Me despido atentamente. <br> <br><br>

            <b>Ing. MSc. Eduardo Mediavilla,</b> <br>
            
            Consultor Internacional y Gerente Técnico Cype Ingenieros Ecuador
           
            <br><br><br>


         


               <br />
               <br />
          <b>Asesorías personalizadas</b>
            <br />
            <br />
            Disponemos del servicio de asesoría personalizada <a href="https://www.medifestructuras.com/paginas/AsesoriasYObras.php">Haz clic aquí para conocer más de este servicio</a>
            <ul class = "listaButllet">
              <li>Dirigido a arquitectos, ingenieros, profesionales y estudiantes que requieren <b>avanzar de forma rápida y urgente</b> con un proyecto determinado, y no disponen de tiempo.</li> <br><br>
            </ul>
        
            -->
            <br><br><br><br><br><br><br><br>
        

<!--

          </div>
        <div class="clear"></div> 
      <div class="NewCelda_40_izdaP">
         <img src="imagenes/RealizacionCalculos.gif"  alt="Edificio CYPE" /> 
      </div>
      <div class="NewCelda_60_izda">
        <b>OBRAS Y ASESORIAS REALIZADAS</b>
        <ul>
          <li><h2 class="linkCurso">Impartimos cursos en toda latinoamérica y España</h2></li>
          <li><h2 class="linkCurso">Hemos realizado proyectos en diferentes países:</h2>
             <ul>
                 <li><h3 class="linkCurso">Ecuador, México, Argentina, Perú, Colombia, Republica Dominicana, Bolivia, España</h3></li>
            </ul>
          </li>
        </ul>
      </div>
      <div class="clear"></div> 
 
      <div class="NewCelda_40_izdaP">
         <img src="imagenes/YouTube.gif"  alt="Logo YouTube"  
           onclick="location.href='https://www.youtube.com/channel/UCLMWAmi1DX83jj75a9w7dsg'"/> 
      </div>
      <div class="NewCelda_60_izda">
        <b>ALGUNAS DE NUESTRAS PUBLICACIONES EN YOUTUBE</b>
        <ul>
        
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=LHynFU1SQ50&t=57s'"> <h2 class="linkCurso">Agrietamiento de secciones para obtención de derivas en SAP y CYPECAD</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=cS14QQG_tYM'"><h2 class="linkCurso">Aplicación correcta de carga muerta en edificaciones (Lineal t/ml + superficial t/m2)</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=Abzg9dY-SvA'"><h2 class="linkCurso">Armado de Confinamiento en Vigas de entrepiso CYPECAD</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=H8D_QolqFHs'"><h2 class="linkCurso">Cálculo y diseño de estación de servicios NSR-10: Aspectos teóricos</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=EmdT2z8NDpU'"><h2 class="linkCurso">Cálculo y diseño de un puente grúa</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=uzvh9339Hf8'"><h2 class="linkCurso">Cimentación con CYPECAD al estilo latinoamericano</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=cT0uO2pSkJU'"><h2 class="linkCurso">Columnas de acero rellenas de hormigón</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=lwjOMP43pis'"><h2 class="linkCurso">Composición de fachadas en sistema Forsa muros de tensión plana CYPECAD</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=QWVF3QOm48k&t=64s'"><h2 class="linkCurso">Conceptos de Edición de Losas CYPECAD</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=YejegZ2Q1mc&t=922s'"><h2 class="linkCurso">Criterios de ductilidad en diseño sismorresistente</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=-0Lb3nx_4Ss'"><h2 class="linkCurso">Curso nivel especialista en diseño por desempeno AENL Pushover</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=5I88qDOR6LU&t=31s'"><h2 class="linkCurso">Diagramas de momentos y cortantes obtención de reacciones</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=cKPU7fK2RXk'"><h2 class="linkCurso">Diferencias y precauciones de configuración de espectro sísmico SAP/ETABS y CYPECAD</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=IDG9C-B4NTI'"><h2 class="linkCurso">Dinámica de estructuras: amplificación y redundancia</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=uYh4OwdvCbA'"><h2 class="linkCurso">Edición manual tablas de montaje en vigas en CYPECAD</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=Rsb3YBW4SNU'"><h2 class="linkCurso">Elementos de confinamiento/borde en muros sometidos a flexocompresion TIPS</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=me4TgJxZ63E'"><h2 class="linkCurso">Elementos Diafragma Diagonales de Hormigón V invertida CYPE 3D/CYPECAD</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=ZRSYt25dq4Q'"><h2 class="linkCurso">Evento Grupo Bim 27 abril 2019</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=m5jpX3t2_RQ&t=61s'"><h2 class="linkCurso">Fallas frágiles en vigas de acero (elementos finitos) y otros conceptos sismorresistentes</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=_PgFIcSr_vY'"><h2 class="linkCurso">Importancia de articular/empotrar vigas secundarias en estructuras de acero CYPE 3D Y CYPECAD</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=ay9jOn_YSHo'"><h2 class="linkCurso">Invitación Cursos Presenciales Estructuras Sismorresistentes</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=bsPAjA8zqAY'"><h2 class="linkCurso">Longitud no arriostrada según código ANSI/AISC 341-10</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=YMgyeUXyWJ4'"><h2 class="linkCurso">Los mejores trucos de diseño con CYPECAD</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=Qwf7K_jQA7c'"><h2 class="linkCurso">Método de las secciones para obtención de diagramas</h2></div> </li>    
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=2FbbTDJsCEE'"><h2 class="linkCurso">Modelado torre eléctrica CYPE 3D</h2></div> </li>   
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=CLVy8ssmxGI'"><h2 class="linkCurso">Modelado y Calculo Tanque Imhoff CYPECAD</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=PpY6Nvfejps'"><h2 class="linkCurso">Posibilidades de modelado de cimentación para torre eléctrica</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=Hh1g77ptrUQ'"><h2 class="linkCurso">Presentación Jornadas de ingeniería ambiental Quito diciembre 3-4</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=26vwhydOwe4'"><h2 class="linkCurso">Qince consejos para el dominio y manejo de softwares estructurales para ingeniería</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=UeYYlckpvOQ&t=22s'"><h2 class="linkCurso">Revisión de proyecto real muros de mampostería CYPECAD</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=a8-P5wXgGJg'"><h2 class="linkCurso">Revisión profesional de proyecto de hormigón armado</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=chbv2AYzHSU'"><h2 class="linkCurso">Seminario de Cimentaciones con CYPECAD Interacción Suelo-Estructura</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=h39s2Junn-w'"><h2 class="linkCurso">Seminario electricidad y automatismos CYPECAD MEP y otros programas</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=AkoYjXWasRg'"><h2 class="linkCurso">Seminario estructuras sismorresistentes norma NSR-10</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=NJXPoKO-nno'"><h2 class="linkCurso">Sistema de muros de tensión plana con CYPECAD modelado</h2></div> </li>
        <li> <div class ="linkCurso" onclick="location.href='https://www.youtube.com/watch?v=GowM4SeFACs'"><h2 class="linkCurso">Truco de diseño de cerchas mediante CYPE 3D</h2></div> </li>

        </ul>
      </div>




    -->
      
























































</div>      
<div class="clear"></div> 
      
 <?php include_once('paginas/PaginaPieIndex.php'); ?>
 <?php include_once('paginas/PaginaCursoPHP01_4.php'); ?>
 <br />
 <br />    
</body>
</html>
