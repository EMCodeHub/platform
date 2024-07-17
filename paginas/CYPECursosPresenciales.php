<?php
include_once('../conexion/conn_bbdd.php');
include_once('../php/ValidaLoginScript.php');
include_once('../php/ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb =   new ParametrosClass($conexion);
include_once('../php/SesionesCookies.php'); //despes de DatosWeb

?>
<!DOCTYPE html>
<html lang="es" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<?php include_once('PaginaCabecera.php'); ?>     
<?php  
include_once('NewWebEstilosNOIndex.php');
include_once('../php/IndexScript.php');
include_once('PaginaCursoPHP01_2.php');  
?>
<title>CYPE Quito: Calendario de encuentros Cursos prácticos, presentaciones, seminarios y jornadas técnicas</title>   
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $DatosWeb->GetTrimValor('codigo_tagmanager') ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) --> 
    
<?php  
include_once('MenuNOIndex.php');   
?>
 <div class = "Aviso"></div>

<div class="clear"></div>
<div id = "cabecerasNew"> <img src="../imagenes/FotoPrincipalAula2.png" alt ="Aula <?php echo $DatosWeb->GetTrimValor('web_dominio') ?>"> </div>
    
<div class ="separador"></div>
<section class="contenedor">

        <h1 class ="tituloApartado">Aula CYPE: Cursos Presenciales</h1>
        <p class="separador"></p>     
      
<?php
     include_once('PantallaPwd.php');
?>
<script src="../php/VideotutorialesLoginNOIndex.js"></script> 

  <div class="ficha_aula_box_inferior">

    <div class="ficha_fila">
           <article><h2 class = "tituloApartadoAzul">Cursos prácticos, presentaciones, seminarios y jornadas técnicas</h2>
           Realizamos cursos <strong>presenciales</strong>, <strong>on line</strong> y por <strong>videoconferencia</strong>.
<p>Invitamos a todos los profesionales y estudiantes del sector de la arquitectura, la ingeniería y la construcción a asistir, o participar online, a los encuentros que CYPE ha programado para las próximas fechas. </p>
           	 <p>En estos eventos, enfocados desde diferentes niveles, los asistentes podrán obtener datos técnicos sobre el software, avanzar en su manejo, plantear cuestiones, conocer la actualidad y las novedades del sector... </p>
           </article>
    </div>    <!-- end .ficha_fila -->
   
   
   
     <div class="ficha_fila">
     <article><h2 class = "tituloApartadoAzul">Calendario de cursos</h2>
     <div class="centro"><span class ="textoAzul">Pulse sobre el encuentro al que desea asistir para obtener más información y registrarse.</span></div>

     <?php
         include_once('ListaWebCursos.php');
     ?>
     </article></div>
    <!-- <iframe src="<?php echo $pagina?>" style="width:100%;height:100%"></iframe>-->

    <div class="ficha_fila">
    <article><h2 class = "tituloApartadoAzul">Cursos para personas sin tiempo</h2>
    Formación es equivelente a realizar una buena carrera profesional. Esta sección va dirigida a todas aquellas personas que deseen formarse fuera del horario laboral, a partir de las 19 horas y fines de semana. 
    <p>Con nuestro servicio de <strong>videoconferencia</strong> podrá formarse en el tiempo de que disponga.</p>
    <p>Póngase en contacto con nosotros para personalizar sus cursos.</p></article>
    
    </div>
  
    <div class="ficha_fila">
    <h2 class = "tituloApartadoAzul">Software Cype</h2>
             <div class="celda_10_izda">
      <img src="../imagenes/IconoCypeCad.gif"  alt="Icono CYPECAD"> 
      </div>   <!-- end .celda_10_izda -->  
      <div class="celda_90_decha">
      <article><h2 class = "negreta">CYPECAD</h2>
        CYPECAD ha sido concebido para realizar el diseño, cálculo y dimensionado de estructuras de hormigón armado y metálicas para edificación y obra civil, sometidas a acciones horizontales, verticales y a la acción del fuego.
Estas estructuras pueden estar compuestas por: pilares, pantallas y muros; vigas de hormigón, metálicas y mixtas; forjados de viguetas (genéricas, armadas, pretensadas, in situ, metálicas de alma llena y de celosía), placas aligeradas, losas mixtas, reticulares y losas macizas; y cimentaciones por losas, vigas de cimentación, zapatas y encepados.
        
      </article>       
     </div>     <!-- end .celda_90_decha -->
    </div>    <!-- end .ficha_fila -->


<div class="ficha_fila">
             <div class="celda_10_izda">
      <img src="../imagenes/IconoCype3D.gif"  alt="Icono Cype 3D"> </div>   <!-- end .celda_10_izda -->  
      <div class="celda_90_decha">
      <article><h2 class = "negreta">CYPE 3D</h2>
        CYPE 3D es un ágil y eficaz programa pensado para realizar el cálculo de estructuras en tres dimensiones de barras de madera, de acero, de aluminio o de cualquier material, incluido el dimensionamiento de uniones (soldadas y atornilladas de perfiles de acero laminado y armado en doble T y perfiles tubulares) y el de su cimentación con placas de anclaje, zapatas, encepados, correas de atado y vigas centradoras. Si la estructura es de barras de madera, de acero o de aluminio, puede obtener su redimensionamiento y optimización máxima.
        
      </article>       
     </div>     <!-- end .celda_90_decha -->
    </div>    <!-- end .ficha_fila -->


<div class="ficha_fila">
             <div class="celda_10_izda">
       <img src="../imagenes/IconoCypeConnect.gif"  alt="Icono Cype Connect"> </div>   
             <!-- end .celda_10_izda -->  
      <div class="celda_90_decha">
      <article><h2 class = "negreta">CYPE Connect</h2>
        CYPE-Connect es un programa diseñado para comprobar, dimensionar y generar el despiece de uniones metálicas soldadas o atornilladas con perfiles laminados en doble T.
        Tras la introducción de datos, el usuario puede seleccionar el cálculo y dimensionamiento de la unión. El programa calcula y dimensiona automáticamente la unión para que se cumplan todas las limitaciones establecidas por la norma y por el usuario. Tras el proceso, se puede obtener un listado detallado de las comprobaciones efectuadas, y el despiece de la unión en pantalla y en el plano.


        
      </article>       
     </div>     <!-- end .celda_90_decha -->
    </div>    <!-- end .ficha_fila -->



<div class="ficha_fila">
             <div class="celda_10_izda">
        <img src="../imagenes/IconoCypeGeneradorPorticos.gif"  alt="Icono Cype generador porticos"></div>   
             <!-- end .celda_10_izda -->  
      <div class="celda_90_decha">
      <article><h2 class = "negreta">Generador de pórticos</h2>
        Permite crear de forma rápida y sencilla la geometría y las cargas de peso propio, sobrecarga de uso, viento y nieve de un pórtico formado por nudos rígidos, celosías o cerchas. Proporciona el dimensionamiento de correas de cubiertas y laterales de fachadas, optimizando el perfil y la separación entre correas.




        
      </article>       
     </div>     <!-- end .celda_90_decha -->
    </div>    <!-- end .ficha_fila -->




  </div><!-- end .ficha -->

  
</section><!-- end .contenedor -->


<div class = "Aviso"></div>
<div class="centro90"><?php include_once('PaginaPieNOIndex.php'); ?></div>
<?php include_once('PaginaCursoPHP01_4.php') ?>
</body>




</html>
