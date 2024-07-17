<?php
include_once('../conexion/conn_bbdd.php');
include_once('../php/ValidaLoginScript.php');
include_once('ClassAsesoriaSesioncypeee.php');
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
<title>Desarrollo Digital de tu carrera</title>
<?php include_once('PaginaCabecera.php'); ?>    
<!--..........FullCalendar.....................................-->
<link rel='stylesheet' type='text/css' href='FullCalendar/css/fullcalendar.css' />
<script type='text/javascript' src='FullCalendar/js/moment.min.js'></script>
<script type='text/javascript' src='FullCalendar/js/fullcalendar.min.js'></script>
<script type='text/javascript' src='FullCalendar/locale/es.js'></script>   
<script type='text/javascript' src="../php/AsesoriaSesioncypeee.js"></script>        
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
var elementos = H_final - H_inicio +1 ;

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
    var arranque = hora_i;
    var parada = 0;
    if (H_final - hora_f < 1) {
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
    alert(1, ArrayHorario);
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
        fixedWeekCount: false,
        eventLimit: true,
        contentHeight: 'auto',
       
        validRange: {
            start: moment(),      //.day(), // data actual
            end: moment().add(300, 'days') // data actual + 14 (15 com a data atual)
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
                echo 'window.location.href = "../mantenimiento/AsesoriasListacypeee.php";';
             } ?>
        },  
	});
});
    
</script>    





<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '5448788538479360');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=5448788538479360&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
























</head>
<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $DatosWeb->GetTrimValor('codigo_tagmanager') ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<br>
<script  src="../php/VideotutorialesLoginNOIndexAsesorias.js"></script> 
    <h1 class ="NewtituloApartado">Ingenieros & Arquitectos Digitales</h1>
    <br>
 <div id="AsesoriasCalendario"> 
     <div id="CalendarioLeft">
         <div id="AsesoriaCartel">


         <video width="100%" height="100%" controls autoplay>
  <source src="../video/presentacionmedifestructuras.mp4" type="video/mp4">
 
Your browser does not support the video tag.
</video>

         </div>      



         <div id="AsesoriaCartelG1">
              <div class="AsesoriaCartelE"><img src="../imagenes/flecha.png" alt="Flecha"></div> 
              <div class="AsesoriaCartelD">Reserve su llamada con nosotros</div> 
              <div class="clear"></div>
              <div class="AsesoriaCartelO">Haga CLICK en el día del Calendario para revisar disponibilidad</div>
         </div>
     </div>
     <A NAME="InicioFormulario"></A>
     <div id="CalendarioRight">
         <div id="calendar"></div>
         <div  id="AsesoriaForm"><?php include_once('AsesoriasFormulariocypeee.php'); ?></div>
     </div>
           
 </div>   
    
 <div  class="clear"></div>   
<div class="separador"></div> <div class="separador"></div> 

    <div class="separador"></div> 
    <div class="ficha_aula_box_inferior">
        <h2 >Llamada gratuita</h2>
        <ul>
            <li class="asesoria_lista">Mediante la llamada conocerá exactamente en qué consite la propuesta para <span class = "azulNegreta">obtener su página web ya programada lista para utilizar</span> junto con un plan personalizado de marketing de contenidos.</li>
            <li class="asesoria_lista">Comenzarás a familiarizarte con la adquisición de clientes y creación de contenido <span class = "azulNegreta">pudiendo llegar a vivir de la creación de contenido y desarrollo de proyectos.</span></li>
            <li class="asesoria_lista">Aclararemos todas sus dudas, <span class = "azulNegreta"> revisaremos su caso personal</span> y guiaremos su aprendizaje.</li>
            <li class="asesoria_lista">En el caso de no existir días disponibles en el calendario o algun problema rellenando el formulario puede escribir a:<span class = "azulNegreta"> emprendecon@medifestructuras.com</span> </li> 
            <li class="asesoria_lista">El objetivo será enseñarle todo lo que hemos aprendido estos 7 años en el mercado de capacitación y consultoría de proyectos. </li> 
            <li class="asesoria_lista">Elaboraremos su página web y le indicaremos cómo debe de utilzarla. </li> 
            <li class="asesoria_lista">Sólamente trabajaremos con profesionales que tengan la voluntad de esforzarse día tras día.</li> 
            <li class="asesoria_lista">Únicamente atendemos 3 llamadas diarias.</li> 
           
        </ul>  
       
    </div> 
    <br><br>
</section>


</body>




</html>
