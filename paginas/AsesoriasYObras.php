<?php
include_once('../conexion/conn_bbdd.php');
include_once('../php/ValidaLoginScript.php');
include_once('ClassAsesoriaSesion.php');
include_once('../php/ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb =   new ParametrosClass($conexion);
include_once('../php/SesionesCookies.php'); //Inicio de sesión y asignación de sus variables

?>
<!DOCTYPE html>
<html lang="es" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script  src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,500,800" rel="stylesheet">    
<title>Asesorías y obras realizadas</title>
<?php include_once('PaginaCabecera.php'); ?>    
<!--..........FullCalendar.....................................-->
<link rel='stylesheet' type='text/css' href='FullCalendar/css/fullcalendar.css' />
<script type='text/javascript' src='FullCalendar/js/moment.min.js'></script>
<script type='text/javascript' src='FullCalendar/js/fullcalendar.min.js'></script>
<script type='text/javascript' src='FullCalendar/locale/es.js'></script>   
<script type='text/javascript' src="../php/AsesoriaSesion.js"></script>        
<?php
include_once('NewWebEstilosNOIndex.php');
include_once('../php/IndexScript.php');
include_once('PaginaCursoPHP01_2.php');  
?>
<?php 
    $Agenda = new AsesoriaSesion($conexion); 
?>

<script>
<?php 
    echo $Agenda->EscribeArrayEventos(); 
?>
function MostarCalendario () {
        document.getElementById("calendar").style.display  = "block";
        document.getElementById("AsesoriaCartelG1").style.display  = "block";
        document.getElementById("AsesoriaForm").style.display  = "none"; 
        document.getElementById("AsesoriaForm3").style.display  = "none";
    }
function VerDatosFormulario(modo){
    if (modo == 1){
       document.getElementById("AsesoriaForm4").style.display  = "block";  
        document.getElementById("AsesoriaForm3").style.display  = "none";
    } else {
       document.getElementById("AsesoriaForm4").style.display  = "none"; 
    }
}
    
 function ReservaSesion(fecha) {
     d = new Date(fecha);
     var dias = new Array('Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado')
     document.getElementById("calendar").style.display  = "none";
     document.getElementById("AsesoriaCartelG1").style.display  = "none";
     document.getElementById("AsesoriaForm").style.display  = "block"; 
     document.getElementById("AsesoriaForm3").style.display  = "block";
     document.getElementById("AsesoriaForm4").style.display  = "none";
 
     document.getElementById("diaSesion").innerHTML = dias[d.getDay()]+": "; 
     document.getElementById("SesDia").value = fecha.format();
     var Horas = CalculaHorasHabiles(fecha.format()); 
     $('#SesHora').children('option:not(:first)').remove();
     for (var x=0; x < Horas.length; x++){
            optionText = Horas[x]; 
            optionValue = Horas[x]; 
            $('#SesHora').append(`<option value="${optionValue}">  ${optionText} </option>`);  
     }
     location.href = "#InicioFormulario";
 }
    
function CalculaHorasHabiles(fecha){
var H_inicio = 8;
var H_final  = 21;
var elementos = H_final - H_inicio + 1 ;

var ArrayHorario = new Array();
for (x=0; x < elementos; x++){
   ArrayHorario.push(H_inicio+x);
}
//alert("Longitud-->"+(ArrayHorario.length)+"Primer elemento-->"+ArrayHorario[0]+" último-->"+ArrayHorario[ArrayHorario.length-1]);

var Eventos = new Array(); 
for (x=0; x < ArrayEventos.length; x++){
    tmp = ArrayEventos[x];
    if (tmp[0] == fecha ) {
        Eventos.push(ArrayEventos[x]);
    }
}
/*alert("Longitud-->"+(Eventos.length)+"Primer elemento-->"+Eventos[0]+" último-->"+Eventos[Eventos.length-1]);*/

if (Eventos.length == 0) {
    
    return ArrayHorario;
} 
for (x=0; x < Eventos.length; x++){
    var tmp = Eventos[x];
    var hora_i = tmp[1];
    var hora_f = tmp[2];
    var arranque = hora_i - 2;
    var parada = 0;
    if (H_final - hora_f < 3) {
        parada = H_final;
    } else {
        parada = hora_f -1;
    }
    
    //alert("arranque->"+arranque+" parada->"+parada);
    
    for (var j=arranque ; j <= parada; j++){
        /*//alert("posicion->"+ArrayHorario.indexOf(j));*/
        ArrayHorario.splice( ArrayHorario.indexOf(j), 1 );
    }
    /*alert("array horario tiene elementos--->"+ArrayHorario.length);*/   
}  
    if (ArrayHorario.length == 0) {
        alert("Este día no tiene horas disponibles");
    }
return ArrayHorario;      
}    
    
    
    
function addZero(i) {
    if (i < 10) {
        i = '0' + i;
    }
    return i;
}

var hoy = new Date();
var dd = hoy.getDate();
var mm = hoy.getMonth()+1;
var yyyy = hoy.getFullYear();

dd = addZero(dd);   
mm = addZero(mm);
    
    
$(document).ready(function() {
   $("#marcoConexion").html("");
  
   $("#usuario").change(function() {
		LoginVerificarDireccionCorreo(); 
   });

   $("#Login").click(function() {
		LoginEnviaFormulario(); 
   });
    $("#CerrarLogin").click(function() {
		VerLogin(0); 
   });
   
    $("#SesHora").change(function() {
        if ($("#SesHora").val() == 0){
            VerDatosFormulario(0); 
        } else {
            VerDatosFormulario(1); 
        }
   });
$("#SesCorreo").change(function() { SesValidaDireccionCorreo(); });
$("#SesTelefono").change(function() { SesValidaTelefono(); });
$("#SesUsuSkype").change(function() { SesValidaUsuSkype(); });
$("#SesNombre").change(function() { SesValidaNombre(); });
$("#SesApellidos").change(function() { SesValidaApellidos(); });
$("#SesCiudad").change(function() { SesValidaCiudad(); });
$("#SesPais").change(function() { SesValidaPais(); });
$("#SesObservaciones").change(function() { SesValidaObservaciones(); });

$("#SesTelefono").keypress(function()  { SesSolonumeros(); });
$("#SesBotonAceptar").click(function() { EnviaSolicitudSesion(); }); 
$("#SesBotonSalir").click(function()   { CerrarSolicitudSesion(); }); 
$("#SesBotonCambioDia").click(function()   { MostarCalendario(); });
  
    
    $('#calendar').fullCalendar({
        
        header: {
            left: 'prev,next',
            center: 'title'
            /*right: 'month,agendaWeek,agendaDay'*/
        },
        defaultDate: yyyy+'-'+mm+'-'+dd,
        buttonIcons: true, // show the prev/next text
        weekNumbers: false,
        editable: true,
        selectable: true,
        /*allDaySlot: true,*/
        weekends: false,
        hiddenDays: [ 0 ],
        fixedWeekCount: true,
        eventLimit: true,
        contentHeight: 'auto',
       
        validRange: {
            start: moment(),      //.day(), // data actual
            end: moment().add(45, 'days') // data actual + 14 (15 com a data atual)
        },
        
        <?php 
         echo $Agenda->PintaEventos(); 
        ?>

        dayClick: function (date, jsEvent, view) {
            //alert('Has hecho click en: '+ date.format());
            ReservaSesion(date);      
        }, 
        eventClick: function (calEvent, jsEvent, view) {
            /*$('#event-title').text(calEvent.title);
            $('#event-description').html(calEvent.description);
            $('#modal-event').modal();*/
             <?php if ($_SESSION['es_admin'] == 1 || $_SESSION['es_colaborador'] == 1) { 
                echo 'window.location.href = "../mantenimiento/AsesoriasLista.php";';
             } ?>
        },  
	});
});
    
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
        
<div class="clear"></div>
<!--<div id = "cabecerasNew"> <img src="../imagenes/Handstack.jpg" alt="Handstack"> </div>-->
<div class ="separador"></div>
<section class="contenedor">
                
<?php
     include_once('PantallaPwd.php');
?>
<script  src="../php/VideotutorialesLoginNOIndexAsesorias.js"></script> 
    <h1 class ="NewtituloApartado">Asesoramos su proyecto mediante sesión personalizada</h1>
    
 <div id="AsesoriasCalendario"> 
     <div id="CalendarioLeft">
         <div id="AsesoriaCartel"><img src="../imagenes/AsesoriaSesion.png" alt="Videoconferencia"> </div>
         <div id="AsesoriaCartelG1">
              <div class="AsesoriaCartelE"><img src="../imagenes/flecha.png" alt="Flecha"></div> 
              <div class="AsesoriaCartelD">Reserve su Sesión</div> 
              <div class="clear"></div>
              <div class="AsesoriaCartelO">Haga CLICK en el calendario o escriba a eduardo.mediavilla@cype.com</div>
         </div>
     </div>
     <A NAME="InicioFormulario"></A>
     <div id="CalendarioRight">
         <div id="calendar"></div>
         <div  id="AsesoriaForm"><?php include_once('AsesoriasFormulario.php'); ?></div>
     </div>
           
 </div>   
    
 <div  class="clear"></div>   
<div class="separador"></div> <div class="separador"></div> 

    <div class="separador"></div> 
    <div class="ficha_aula_box_inferior">
        <h2 >Descripción del  servicio:</h2>
        <ul>
            <li class="asesoria_lista">Mediante la sesión de asesoría por Skype o Zoom llegaremos a <span class = "azulNegreta">obtener los planos y memorias de su proyecto estructural / hidrosanitario / extinción de incendios</span> con las normativas específicas de su país. Además de repasar todos los conceptos necesarios de la norma para llegar a completar exitosamente el proyecto en cuestión.</li>
            <li class="asesoria_lista">Para este servicio <span class = "azulNegreta">no necesita tener licencia del software</span>, nosotros le entregaremos la documentación preparada para imprimir y de esa forma poder ingresar planos y memorias en la entidad de aprobación de proyecto, CAE o entidad colaboradora/curadurías.</li>
            <li class="asesoria_lista">La sesión se realizará con la metodología de <span class = "azulNegreta">compartir pantalla por Skype</span>, para durante la realización de la sesión, poder comentar todos los detalles que envuelven al proyecto: materiales, paso de tuberías, disposición de armado, economía de la obra, comportamiento estructural, recomendaciones y requisitos de cumplimiento entre otros puntos importantes.</li>
            <li class="asesoria_lista">La asesoría es una forma de obtener planos y memorias confiando en la experiencia de un profesional altamente cualificado que se dedica activamente a preparar este tipo de documentación, lo cual le permitirá <span class = "azulNegreta">ahorrar mucho tiempo</span>.</li>
            <li class="asesoria_lista">El número de sesiones de la asesoría dependerá de la complejidad y m<sup>2</sup> del proyecto. Pudiendo ser necesarias 2 ó 3 sesiones para conseguir los objetivos.</li>
            <li class="asesoria_lista">La sesión será grabada y entregada en formato .mp4 para de esa forma el cliente pueda repasar las decisiones del proyecto y tener criterio suficiente para dialogar con el promotor.</li>
            <li class="asesoria_lista">La VideoConferencia dura aproximadamente 3 horas a un coste de <span class = "azulNegreta">120 <?php echo $DatosWeb->GetTrimValor('moneda') ?> </span>la sesión.</li>
        </ul>  
        
    </div> 
    <div class="separador"></div> 
    <h1 class ="tituloApartado">Asesorías y Obras realizadas</h1>
        <div class="separador"></div> 
    <div class="separador"></div> 
  <div class="ficha_aula_box_inferior">
 
    <div class="ficha_fila">
<p>A continuación, se muestran algunos ejemplos de trabajos directos, formando parte del equipo de dirección facultativa en fase de proyecto.</p>
<p>Únicamente se presentan los estudios de mayor implicación. Se han realizado muchos otros trabajos derivados de asesorías online, que no aparecen en la lista. </p>
<p>El objetivo de mostrar algunos de nuestros interesantes proyectos es que conozcan aquello en lo que somos especialistas. </p>
<p>Hemos tenido la suerte de haber contado con la confianza de grandes ingenieros/as que se encuentran trabajando repartidos en todos los países de habla hispana. (Guatemala, Nicaragua, Honduras, Colombia, Ecuador, Perú, Bolivia, Republica Dominicana, Belice, México, Argentina, Paraguay, Uruguay, Chile, el Salvador, España)</p>

<p>Es por ello que queremos agradecer su confianza y celebrar sus ganas de aprender y seguir trabajando con nosotros. </p>
 
<p class ="asesoria_pais">Ecuador</p>

<ul>
<li class="asesoria_lista">Oficinas CNT Manabí Ecuador. Numero de edificios 8 .(cimentación viga T invertida, estructura realizada con pórticos de hormigón armado y losa alivianada) </li>
<li class="asesoria_lista">Oficinas JEP. Ecuador. Número de edificios 3. (cimentación plinto aislado y viga T invertida, estructura realizada con columnas de hormigón y vigas metálicas, losa steel deck) Estudios de bomberos e hidrosanitarios. </li>
<li class="asesoria_lista">Edificio de oficinas de bomberos. Riobamba Ecuador. (cimentación plinto aislado, columnas de acero rellenas de hormigón, vigas metálicas, losa steel deck) </li>
<li class="asesoria_lista">Edificio Universidad. Riobamba Ecuador. (cimentación plinto aislado, columnas de acero rellenas de hormigón, vigas metálicas, losa steel deck) Estudios de bomberos e hidrosanitarios</li>

<li class="asesoria_lista">Viviendas unifamiliares de 3 pisos. Ecuador. Numero de edificios realizados 15. (cimentación con plinto aislado, columnas de hormigón, vigas banda y losa alivianada) </li>
<li class="asesoria_lista">Viviendas con tipología forsa. Muros de tensión plana. Numero de edificios realizados 6, para urbanización de 150 casas. Manabí Ecuador. </li>
<li class="asesoria_lista">Concesionario de autos. Quito Ecuador.  (cimentación plinto aislado, columnas de acero rellenas de hormigón, vigas metálicas, losa steel deck) Estudios de bomberos e hidrosanitarios</li>
<li class="asesoria_lista">Galpón, nave industrial. Otavalo Ecuador. 30 metros. (pórtico en celosía, cimentación plinto aislado) </li>
<li class="asesoria_lista">Galpón, nave industrial. Cuenca Ecuador. 25 metros. (pórtico en celosía, cimentación plinto aislado) Estudios de bomberos e hidrosanitarios</li>
<li class="asesoria_lista">Justificación de estudio de ductilidad. Análisis no lineal pushover. aplicado a un centro de estudios primario. Quito Ecuador. </li>
<li class="asesoria_lista">Cálculo y diseño de puente grúa de 15 toneladas de capacidad. Puembo Ecuador. </li>
</ul>

<p class ="asesoria_pais">Colombia</p>
<ul>
<li class="asesoria_lista">Edificio plurifamiliar 12 pisos.  Ipiales. Nariño Colombia. (cimentación plinto aislado, estructura realizada con pórticos de hormigón armado, núcleos de ascensor con diafragma de hormigón y losa unidireccional) </li>
<li class="asesoria_lista">Edificio plurifamiliar 15 pisos.  Bogotá Colombia. (cimentación plinto aislado, estructura realizada con pórticos de hormigón armado, núcleos de ascensor con diafragma de hormigón y losa unidireccional) </li>
<li class="asesoria_lista">Galpón, nave industrial. Cali Colombia. 25 metros. (pórtico en celosía, cimentación plinto aislado) </li>
<li class="asesoria_lista">Galpón, nave industrial. Cali Colombia. 32 metros. (pórtico en alma llena, vigas tipo I y columnas tipo I. cimentación plinto aislado) Estudios de bomberos e hidrosanitarios</li>
<li class="asesoria_lista">Estación de servicios, gasolinera. Medellín Colombia. (estructura metálica, sistema de cerchas) </li>
</ul>
<p class ="asesoria_pais">México</p>
<ul>
<li class="asesoria_lista">Museo de la tierra y el agua. México. Edificios de pórticos de hormigón armado y losa alivianada. Ampliación en estructura metálica. </li>
<li class="asesoria_lista">Edificio plurifamiliar 9 pisos.  México. (cimentación plinto aislado, estructura realizada con pórticos de hormigón armado, núcleos de ascensor con diafragma de hormigón y losa unidireccional) </li>
</ul>

<p class ="asesoria_pais">Perú</p>
<ul>
<li class="asesoria_lista">Edificio plurifamiliar 8 pisos.  Lima, Perú. (cimentación plinto aislado, estructura realizada con pórticos de hormigón armado, núcleos de ascensor con diafragma de hormigón y losa alivianada unidireccional) </li>
<li class="asesoria_lista">Edificio destinado a discoteca en Cajamarca Perú. (Estructura metálica y plinto asilado, sistema de cerchas agregado) </li>
</ul>
<p class ="asesoria_pais">Argentina</p>
<ul>
<li class="asesoria_lista">Edificio plurifamiliar 9 pisos.  Buenos Aires Argentina. (cimentación con losa, estructura realizada con pórticos de hormigón armado, núcleos de ascensor con diafragma de hormigón y losa bidireccional alivianada) </li>
</ul>
    
    
    
    
    
    </div>

</div>
</section>

<br />
    
<br />
<div class="centro90"><?php include_once('PaginaPieNOIndex.php'); ?></div>
<div class = "Aviso"></div>
<?php include_once('PaginaCursoPHP01_4.php'); ?>
</body>




</html>
