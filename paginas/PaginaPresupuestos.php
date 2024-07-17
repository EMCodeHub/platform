<?php
/* grupo d programas-------------------------------
PresupuestoPeticion.php
PresupuestoEnviaEmail.php
PresupuestoNuevoEmail.php
CartaPresupuestosCli.php
-----------------------------------------------------*/
include_once('../conexion/conn_bbdd.php');
include_once('../php/ValidaLoginScript.php');
include_once('../php/ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb =   new ParametrosClass($conexion);
include_once('../php/SesionesCookies.php'); //Inicio de sesión y asignación de sus variables despues de DatosWeb
?>

<!DOCTYPE html>
<html lang="es" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script  src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,500,800" rel="stylesheet">    

<script  src="../php/VideotutorialesLoginNOIndex.js"></script> 
<?php include_once('PaginaCabecera.php'); ?>  
<?php
include_once('NewWebEstilosNOIndex.php');
include_once('../php/IndexScript.php');
include_once('PaginaCursoPHP01_2.php');  
?>
    
<title>Presupuestos Cálculo de Estructuras</title>
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
?>
<script>
     Nombre_correo = '<?php echo $DatosWeb->GetTrimValor('NombrePrincipal') ?>';
     emisorcorreo = '<?php echo $DatosWeb->GetTrimValor('CorreoPrincipal') ?>';
</script>  
 
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $DatosWeb->GetTrimValor('codigo_tagmanager') ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php
include_once('MenuNOIndex.php');   
?>
 
<div class="PocoEspacio" ></div>
<div class="clear"></div>
  <div class = "Aviso"></div>


<div id="VideoIndex" class="NewDivVideo" >
     <img id="ImaIndex" src="../imagenes/proyectos.png"  alt="Fotograma Inicial Index" />
</div>

<BR />
 
<br><br>

<h1 class ="NewtituloApartado">Cálculo de estructuras/instalaciones - Planos de ejecución de obra</h1>

<br><br>
 
<?php
     include_once('PantallaPwd.php');
?>
<div class="ficha_fila">
    <div id="botonCalcular" class="NewContenedorCursosTotal" >   
     <input name="Descuentos" type="button" class ="ButtonGris" value ="&nbsp;&nbsp;&nbsp;Solicitar PRESUPUESTO&nbsp;&nbsp;&nbsp;" onClick="location.href='PresupuestoPeticion.php'" /> 
    </div>
 </div>
<div class="ficha_fila">
Somos especialistas en <strong>diseño estructural y diseño de instalaciones para edificios.</strong> Hemos realizado múltiples proyectos en Latinoamérica y España, nos adaptamos a las normativas y exigencias de cada pais. Y <strong>cada proyecto recibe un trato específico.</strong>
Podemos entregarle los planos y memorias de cualquier proyecto, debido a que tenemos muchas experiencias de referencia, lo cual nos da una visión muy positiva para darle los mejores resultados. Obtendremos una relación kg material / m2 muy ajustada a la realidad.<br><br>
Conocemos la forma de trabajar de cada pais, proveedores de material y técnicas constructivas, debido a que hemos trabajado internacionalmente desde 2014, y de forma continuada. Entregamos proyectos de estructuras para zona sísmica y zona no sísmica.<br><br>
Realizamos el diseño y ejecución de todas las instalaciones que intervienen dentro de una edificación. Para el desarrollo de dicho proyecto utilizamos las herramientas nuevas CYPE BIM Instalaciones, preparada para ofrecer una solución integral de las instalaciones de la edificación, entre otras: <strong> adaptación acústica, envolvente,  suministro de agua, evacuación de agua, contra incendio, placas solares, iluminación, domótica, etc.</strong><br><br>
</div>

 <br />
<div class="ficha_fila">
 <div class = "celda_40_izda"><img src="../imagenes/EdificioAcero.png"  alt="Edificio acero"></div>
 <div class = "celda_60_decha">
 <h1 class ="tituloApartado2">EDIFICIOS DE ACERO</h1>
 
  <p>Para estos edificios utilizamos la herramienta <strong>CYPECAD.</strong> y en ciertas ocasiones <strong> CYPE 3D</strong></p> 
  <p>Con ella podemos realizar edificios de acero, <strong>analizar el comportamiento</strong> de los mismos ante un <strong>posible sismo</strong> para proponer las mejores soluciones geométricas y un dimensionado de cada uno de los elementos para una repuesta estructural óptima.</p> 
   <p> Siempre pensando en optimizar al máximo el material y por lo tanto adaptarnos a las necesidades del cliente respetando la normativa vigente, nuestro equipo de ingenieros propondrán la <strong>solución más económica</strong>, ahorrando material sin poner en peligro a las personas ni a los edificios.</p>
   <p> El acero es un material que conviene arriostrar adecuadamente para evitar tener fallas frágiles, además existen <strong>uniones precalificadas</strong> que debemos plantear para nuestros proyectos.</p>
   <p> Los edificios de acero són en general más costosos o caros que un edificio de hormigón, pero tienen la particularidad de ser<strong> más rápidos de construir y además són altamente dúctules y seguros</strong></p>
   <p> Para este tipo de proyectos deberemos de controlar el periodo de vibración del edificio, debido a que acostumbran a tener desplazamientos mayores que los edificios de hormigón. Es por ello que los pórticos deberán de arriostrarse, y contemplar la posibilidad de utilizar cruces de san andres.</p>
   <p> Tambien será importante contemplar otro tipo de soluciones para zona sísimica, como por ejemplo<strong> pórticos EBF (Excentrically braced frames),</strong> la cual es una solución para cuando se utilizan luces superiores a 8 metros.</p>
   <p> En definitiva, escoger la tipología constructuva para este caso será de vital importancia, también se utiliza mucho el <strong>sistema de nucleo de hormigón armado</strong> para la caja de ascensores y el resto de estructura metálica</p>
   <p> Podemos ayudarle para que tome la mejor decisión antes de invertir en la construcción, tomar decisiones a tiempo es la solución más inteligente para evitar problemas futuros. <strong>Deberá de ponerse en manos de un profesional con experiencia. </strong></p>
   <p> Las estructuras de acero, tienen uniones <strong>articuladas, empotradas, y semi-empotradas,</strong> saber proponerlas y evaluarlas también será otro aspecto clave en el proyecto. </p>
</div>
</div> <!-- end .ficha_fila -->
  <div class="ficha_fila">
      <div class = "celda_40_izda">
             <img src="../imagenes/naves.png"  alt="Edificio acero">
      </div>
      <div class = "celda_60_decha">
       <h1 class ="tituloApartado2">NAVES</h1>
        <p><strong>GALPONES o NAVES INDUSTRIALES</strong></p>
        <p>Utilizamos de manera inteligente los materiales y geometría para poder aprovechar toda la ligereza que nos brinda el acero y crear espacios estructurales amplios sin necesidad de proyectar grandes vigas ni columnas. Únicamente aprovechar la triangulación y disposiciones de barras adecuadas para una correcta <strong>respuesta estructural.</strong></p>
        <p>Contamos con las técnicas adecuadas de ingeniería para diseñar y optimizar en nuestros diseños. </p>
        <p>Hemos realizado múltiples diseños de galpones/naves industriales. Para ello, en la totalidad de casos hemos utilizado el software CYPE 3D, el cual nos da la posibilidad de realizar un modelado tridimensional y obtener mucha información del proyecto </p>
        <p>Estas estructuras se realizan habitualmente de dos formas posibles. Con perfiles de<strong> alma llena (IPE HEB W) o perfiles en celosía (C,doble L),</strong> y la decisión de utilizar una tipología u otra dependerá siempre del presupuesto para el proyecto. </p>
        <p>Acostumbran a ser estructuras ligeras destinadas a cubrir grandes superficies, y suelen pesar entre 20 y 35 kg/m2. Evidentemente dependiendo del diseñador y criterios empleados. Pero lo más importante será arriostrar las cubiertas con tensores. </p>
        <p>Evidentemente tambien podría proponerse una solución de <strong>columnas de hormigón y cerchas metálicas, </strong>de hecho se comporta muy bien ante acciones sísimicas, pero será importante dimensionar adecuadamente las uniones.</p>
        <p>Como consultores, hemos tenido ocasión de realizar múltiples naves industriales en muchos paises, y podemos entregarle la información precisa para su proyecto. </p>
        <p>Este tipo de estructuras acostumbra a trabajar con <strong>acero conformado en frio </strong>para la formación de cerchas y celosias, y emplea perfiles tipo doble L para la triangulación de la cercha, o el alma.<p>
      </div>
   </div> <!-- end .ficha_fila -->

<div class="ficha_fila">

<div class = "celda_40_izda"><img src="../imagenes/hormigon.png"  alt="Concreto reforzado"></div>
<div class = "celda_60_decha">
<h1 class ="tituloApartado2">HORMIGÓN ARMADO</h1>
  <p><strong>ESTRUCTURAS DE HORMIGÓN ARMADO</strong></p>
  <p>El hormigón, como bien sabemos, es un material que trabaja muy bien a compresión, pero hay que reforzarlo con acero para que trabaje bien a flexión.</p>
  <p>Proponemos <strong>soluciones estructurales</strong> a proyectos de esta tipología. Analizando previamente los esfuerzos y reforzando con acero solamente en aquellos lugares donde es necesario.</p>
  <p>Realizamos el cálculo de muros, pilares, vigas y cimentación. Utilizando este análisis previo de esfuerzos. El programa finalmente nos entregará toda la <strong>documentación gráfica</strong> para poder llevar a obra y <strong>ejecutar el proyecto</strong>.</p>
  <p>Los edificios de hormigón armado que superen cierto número de pisos, deberán de pasar el <strong>chequeo de columna fuerte-viga débil,</strong> mediante este chequeo aseguraremos que la formación de rótulas plásticas se formen antes en la viga que en la columna</p>
  <p>Y en muchas ocasiones, este chequeo es insuficiente para tomar una correcta decisión de diseño, y se debe recurrir a realizar un<strong> AENL Pushover,</strong> mediante el cual simulamos un empuje progresivo de los pórticos y podremos ver dónde se forman las primeras rótulas plásticas</p>
  <p>Es por ello, que diseñar en hormigón no siempre es fácil, pero debe de mantenerse los conceptos de la teoría de diseño por desempeño, mediante la cual podemos incluso prever el comportamiento de un material heterogéneo como el hormigón armado.</p>
  <p>Pero dominando estos conceptos, <strong>pueden realizarse estructuras muy seguras y duraderas,</strong> siempre que se respeten los recubrimientos de la armadura y la calidad de los materiales utilizados.</p>
</div>
</div> <!-- end .ficha_fila -->

<div class="ficha_fila">
<div class = "celda_40_izda"><img src="../imagenes/ObraCivil.jpg"  alt="obra civil"></div>
<div class = "celda_60_decha">
<h1 class ="tituloApartado2">Obra civil</h1>
  <p><strong>DISEÑO Y ASESORIA EN OBRA CIVIL</strong></p>
  <p>Disponemos de un servicio de <strong>asesoría técnica, logística y legal</strong> enfocada a constructores y planificadores urbanísticos.</p>
  <p>Podemos asesorar su proyecto en términos legales para que el desarrollo del mismo sea un <strong>éxito.</strong><p>

  <div id="botonCalcular" class="NewContenedorCursosTotal" >   
     <input name="Descuentos" type="button" class ="ButtonGris" value ="&nbsp;&nbsp;&nbsp;Solicitar PRESUPUESTO&nbsp;&nbsp;&nbsp;" onClick="location.href='PresupuestoPeticion.php'" /> 
    </div>
</div>
</div> <!-- end .ficha_fila -->

<div class="centro90"><?php include_once('PaginaPieNOIndex.php'); ?></div>
<?php include_once('PaginaCursoPHP01_4.php'); ?>





</body>
</html>