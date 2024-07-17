    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    
    
<div id="MenuPrincipal2"><img src="../imagenes/logos/<?php echo $DatosWeb->GetTrimValor('web_logoforo') ?>"  alt="Logo Foro <?php echo $DatosWeb->GetTrimValor('web_dominio') ?>" height="60"/> </div>


<header>
<div class="menu_bar" onClick="VerNav()" >


    
  <svg width="7%" height="100%" viewBox="0 0 74 74"  class="hamburguesasvg">
     <line x1="20" y1="22" x2="53" y2="22" style="stroke-width:9px; stroke:rgba(247,243,247,1.00); stroke-linecap:round"/>
     <line x1="20" y1="52" x2="53" y2="52" style="stroke-width:9px; stroke:rgba(247,243,247,1.00); stroke-linecap:round"/>
     <line x1="20" y1="37" x2="53" y2="37" style="stroke-width:9px; stroke:rgba(247,243,247,1.00); stroke-linecap:round"/>
  </svg>
</div>   


<nav id="navegador">
    <div class="menu" onclick="PantallaBusqueda(1)"><i class="fa fa-search"></i> BUSCAR</div>
    <?php if ($_SESSION['NumeroUsuario'] == 0) { ?> 

       <!--    <div class="menu" onclick="CierraRegistrarse(1)">REGISTRARSE</div> -->


        <!--    <div class="menu" onclick="CierraAcceder(1)">LOGIN</div> -->

    <?php } else {?>  
        <div class="menu" onclick="CierraPerfil(1)">EDITAR PERFIL</div>
    <?php } ?> 
      <?php echo $DatosWeb->EscribeMenuForos("Foros") //La carpeta en la que estamos es Foros  ?>

</nav>
    
    
    
<?php if ($_SESSION['NumeroUsuario'] != 0) { ?>


    <div class="derecha">
        
    <br><br><br><br><br>
    <div style="display:flex; justify-content:center; align-items:center">
        <button style="background-color: #ede8e8; color: #655050; border-radius: 30px; padding: 20px;">
            <img src="../imagenes/userforo.png" alt="imagenusuario" width="20px" height="20px" style="margin-right: 10px;">
            Bienvenido/a: <b><?php echo EmailAlumno($_SESSION['NumeroUsuario'],$conexion);?></b>
        </button>
    </div>
</div>








<?php } else { ?>  
    <br />
    <?php } ?>   
    
</header>
<script>
function coordenadas(event) {
 CursorX = event.clientX;
 CursorY = event.pageY;
   
}
  function VerNav(){
    a=document.getElementById("navegador").style.display;
      if (a=="none") {
          document.getElementById("navegador").style.display="block";
      } else {
           document.getElementById("navegador").style.display="none";
      }
      
  }
function Descarga(id) {
	 <?php
	  if ($_SESSION['NumeroUsuario'] == 0) {
        echo 'alert ("Conéctate para poder participar");';
        echo 'return;';
	  } else { 
	      echo 'cadena = "../paginas/BajarFicheroForos.php?id="+id;';
        echo 'location.href = cadena;';
    }
    ?>
} 

function VerFichaTema(id)  {
    <?php
    if ($_SESSION['es_colaborador'] > 0 || $_SESSION['es_admin'] > 0 ) {
       echo  'cadena = "../mantenimiento/ForosTemasFicha.php?registro_tema="+id;';
       echo 'location.href = cadena;';
    }
    ?>
} 
function VerFichaCuestion(id)  {
    <?php
    if ($_SESSION['es_colaborador'] > 0 || $_SESSION['es_admin'] > 0 ) {
       echo  'cadena = "../mantenimiento/ForosCuestionesFicha.php?registro_cuestion="+id;';
       echo 'location.href = cadena;';
    }
    ?>
}  
function VerFichaMensaje(id)  {
    <?php
    if ($_SESSION['es_colaborador'] > 0 || $_SESSION['es_admin'] > 0 ) {
       echo  'cadena = "../mantenimiento/ForosMensajesFicha.php?registro_mensaje="+id;';
       echo 'location.href = cadena;';
    }
    ?>
}  
function VerFichaAlumno(id)  {
    <?php
    if ($_SESSION['es_colaborador'] > 0 || $_SESSION['es_admin'] > 0 ) {
       echo  'cadena = "../mantenimiento/VTAlumnosFicha.php?registro="+id;';
       echo 'location.href = cadena;';
    }
    ?>
}     
function ResponderMensaje(id_mensaje,id_cuestion) {
    <?php
    if ($_SESSION['NumeroUsuario'] == 0) {
        echo 'alert ("Conéctate para poder participar");';
        echo 'return;';
    } else if (BloqueadoAContestar($_SESSION['NumeroUsuario'],$conexion) > 0 ){
        echo 'alert ("Revisa tu autorización para poder participar, escríbenos un correo");';
        echo 'return;';
    }
    ?>
    document.getElementById("num_mensaje_padre").value = id_mensaje;
    document.getElementById("num_cuestion").value = id_cuestion;
    document.getElementById("NumeroPadre").innerHTML = id_mensaje;
    document.getElementById("RecursoPantalla").style.display = "none";
    document.getElementById("MensajePantalla").style.display = "block";
    document.getElementById("MensajePantalla").style.left = 0+"px";
    document.getElementById("MensajePantalla").style.top = CursorY-10+"px";
}
    
function SalirMensaje() {
    document.getElementById("MensajePantalla").style.display = "none";
}  
function SalirCuestion() {
    document.getElementById("CuestionPantalla").style.display = "none";
}  
function SalirRecurso() {
    document.getElementById("RecursoPantalla").style.display = "none";
} 
    
function AfegirRecurso(id_mensaje,id_cuestion) {
    <?php
    if ($_SESSION['NumeroUsuario'] == 0) {
        echo 'alert ("Conéctate para poder participar");';
        echo 'return;';
    } else if (BloqueadoAContestar($_SESSION['NumeroUsuario'],$conexion) > 0 ){
        echo 'alert ("Revisa tu autorización para poder participar, escríbenos un correo");';
        echo 'return;';
    }
    ?>    
    document.getElementById("num_mensaje").value = id_mensaje;
    document.getElementById("num_cuestion").value = id_cuestion;
    document.getElementById("MensajePantalla").style.display = "none";
    document.getElementById("RecursoPantalla").style.display = "block";
    document.getElementById("RecursoPantalla").style.left = 0+"px";
    document.getElementById("RecursoPantalla").style.top = CursorY-10+"px";         
}
function AfegirCuestion(id_tema,tiene_permiso) {
     
    <?php
    if ($_SESSION['NumeroUsuario'] == 0) {
        echo 'alert ("Conéctate para poder participar");';
        echo 'return;';
    }
    ?>
    if (tiene_permiso == 0) {
     alert ("FORO PRIVADO: Es necesario tener permisos de acceso al curso");  
     return;
    }
   document.getElementById("num_tema").value = id_tema; 
   
   document.getElementById("CuestionPantalla").style.display = "block";
   document.getElementById("CuestionPantalla").style.left = 0+"px";
   document.getElementById("CuestionPantalla").style.top = CursorY-30+"px";        
}
function VerCuestion(id_cuestion,tiene_permiso)  {
    if (tiene_permiso == 1) {
       $cadena = "CuestionForo.php?id="+id_cuestion;
       location.href = $cadena;
    } else {
        alert ("FORO PRIVADO: Es necesario tener permisos de acceso al curso"); 
    }
}    
function PantallaBusqueda(modo) {
		document.getElementById("Acceder").style.display = "none";
    document.getElementById("Registrarse").style.display = "none";
    document.getElementById("Perfil").style.display = "none";
    if (modo == 0) {
        document.getElementById("Busqueda").style.display = "none";
    } else {
        document.getElementById("Busqueda").style.top = CursorY-5-window.scrollY+"px";        
        document.getElementById("Busqueda").style.display = "block";
        document.getElementById("pal_abra").focus;
    }
    
    
}    
 function EjecutaBusqueda() {
     vv = document.getElementById("pal_abra").value;
     if (vv.length < 3) {
          alert("Introduzca una palabra");
         document.getElementById("pal_abra").focus;
          return;
     }
  
     cadena = "BusquedaForo.php?palabras="+vv;
     location.href = cadena;
 }   
function CierraPerfil(modo) {
	document.getElementById("Acceder").style.display = "none";
    document.getElementById("Registrarse").style.display = "none";
	var j=document.getElementById("Perfil");
	if (modo == 0){
		j.style.display="none";
	} else {
		j.style.display="block";
	}
}    
    
    
    
</script>



