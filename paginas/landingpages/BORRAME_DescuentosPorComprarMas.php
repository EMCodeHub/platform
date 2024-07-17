<!doctype html>
<html lang="es">
<?php
  session_start();
$_SESSION['FotoCabecera'] = "../imagenes/FotoPrincipal2.jpg"; 
  
 include_once('../conexion/conn_bbdd.php');
 include_once('EstilosScripsNOIndex.php');
 include_once('EstilosScripsNOIndex.php');

?>



<head>
<meta charset="utf-8">
<meta content="Eduardo Mediavilla Villodre" name="author"/>
<meta content="Medif contacto" name="description" />
<meta content="CYPE, estructuras, calculo estructuras, encuentros, presentacionesCYPE" name="keywords"/>

<meta property="og:title" content="Aula CYPE en Ecuador:Calendario de encuentros Cursos prácticos, presentaciones, seminarios y jornadas técnicas" />
<meta property="og:type" content="article" />
<meta property="og:url" content=" http://www.medifestructuras.com/index.php" />
<!--<meta property="og:image" content=" http://www.jmptechnological.com/..imagenes/jmp_foto_600.png" />-->
<meta property="og:description" content="Usamos software de última generación para presupuestar en diferentes escenarios. Realizamos cursos presenciales y a distancia del software CYPE" />

<?php  
/* grupo d programas-------------------------------
PresupuestoPeticion.php
PresupuestoEnviaEmail.php
PresupuestoNuevoEmail.php
CartaPresupuestosCli.php
-----------------------------------------------------*/
include_once('EstilosScripsNOIndex.php');
?>

<title>Medif: Contacte con nosotros</title>

<SCRIPT LANGUAGE="JavaScript">
function VerSeccionCorreo(titulo) {
		if (titulo == 0){
			document.getElementById('TituloCorreo').innerHTML = "Solicitud de reembolso";
		} else {
			document.getElementById('TituloCorreo').innerHTML = "Realice su consulta";
		}
		document.getElementById('CorreoGeneral').style.display  = "block";
		
}

function VerLocalizacion() {
		URL = "https://www.google.es/maps/place/Avenida+6+de+Diciembre+%26+José+Bosmediano,+Quito+170135,+Ecuador/@-0.187394,-78.4818395,17z/data=!3m1!4b1!4m5!3m4!1s0x91d59a7eb7c27d95:0x588c97881fcc0e8a!8m2!3d-0.1873994!4d-78.4796508";
		window.open(URL,"Localización Medif","width=1000,height=800,scrollbars=YES,resizable=YES,LEFT=100,TOP=50") 	
}

</script>


     <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
     <script type="text/javascript" src="../php/ContactoPeticion.js"></script>


</head>
<body>
 <!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-TM8DJ4"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TM8DJ4');</script>
<!-- End Google Tag Manager -->

<?php  
include_once('CabNoIndex.php');
$FormatMaestros = "SELECT A.id,  A. id_mailcomer,
B.id AS IDEMAIL, B.correoelectronico , B.nombre_interno , B.nombre_correo , B.es_smtp , 
B.es_pop3 , B.servidor , B.puerto , B.seguridad , B.requiere_auth , B.usuario , B.password , B.usa_logo , B.fichero_logo   
from cursos A, emailscomerciales B 
where A.id_mailcomer = B.id
and A.id = 3
";
$queMaestros = sprintf($FormatMaestros); 
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
$totMaestros = mysqli_num_rows($resMaestros);

if ($totMaestros == 1) {
       //....correo para el cliente...................................................................
          while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {	 
		    echo "<script>Nombre_correo = '".$rowRegistros['nombre_correo']."';\n";
			echo "emisorcorreo = '".$rowRegistros['correoelectronico']."';\n";	
			echo "</script>";
		  }
}

?>
<section class="contenedor">
        <h1 class ="tituloApartado">Contacte con nosotros</h1>

    <div class="ficha">
    <div class="envoltorioMedif">
            <div class = "bandera">
     <div onClick="location.href='contacto_eng.php'" >
        <div class = "bandera_texto">English</div>
        <div class = "bandera_img"><img src="../imagenes/bandera_eng.jpg" width="30" height="29"> </div>
        </div>
     </div>

    <div class="ficha_fila">
        <div class = "celda_5_izda">
        
        <img src="../imagenes/logos/LogoMedif_FondoGris.jpg"  alt="Medif"> 
        </div>  
        <div class = "celda_95_decha">
        <br>     
        <br><strong>CONSULTORIA Y DISEÑO DE ESTRUCTURAS</strong>
        <br>Calle 6 de Diciembre y Bosmediano
        <br>Torres del Norte. Junto CNE. Departamento 3B
        <br>Quito
        <br><hr>
       </div>
   </div> <!-- end .ficha_fila -->
   <div id = "CorreoGeneral">    <!--INI --- estará oculto, se activrá si clicas en el icono correo ............................-->
   <div id="correoContacto" >
           <p id = 'TituloCorreo' class="pide_panPreTit">Realice su consulta</p>
        <form  class="formulario">
	    
        <div class="mitad">
	     <br>
 	     <label class="pide_panPre">Nombre </label><input id = "nombre" type="text" name="nombre" size="35" maxlength="30" onKeypress='return txNombres()' value= "<?php if (isset( $_REQUEST['nombre'])) { echo $_REQUEST['nombre']; }?>" required> 
	     <br> 
      	 <label class="pide_panPre">Apellidos </label><input id = "apellidos" type="text" name="apellidos" size="35" maxlength="100" onKeypress='return txNombres()'  value= "<?php if (isset( $_REQUEST['apellidos'])) { echo $_REQUEST['apellidos']; }?>" required> 
	     <br> 

	     <label class="pide_panPre">Email </label> <input id = "email" type="text" name="email" size="35" maxlength="99" value= "<?php if (isset( $_REQUEST['email'])) { echo $_REQUEST['email']; }?>" required > 
	     <br> 
	     <label class="pide_panPre">Teléfono</label> <input id = "telefono" type="text" name="telefono" size="35" maxlength="30" onKeypress='return solonumeros()' value= "<?php if (isset( $_REQUEST['telefono'])) { echo $_REQUEST['telefono']; }?>" >
	     <br> 
	     <label class="pide_panPre">Ciudad</label> <input id = "ciudad" type="text" name="ciudad" size="35" maxlength="30"  onKeypress='return txNombres()' value= "<?php if (isset( $_REQUEST['ciudad'])) { echo $_REQUEST['ciudad']; }?>" >
         <br>  

         <div class="clear"></div>
         <img src="captcha.php" border="0" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id = "code" name="code" width="6" />
            
	 </div>
	
	 <div class="mitad">
 
         <label class="pide_panPre"> Observaciones:</label>
         <br>
         <textarea id = "comentarios" class="areaTexto" cols="40" rows="10" name="comentarios"  ><?php if (isset( $_REQUEST['comentarios'])) { echo $_REQUEST['comentarios']; }?></textarea>
         <div class="clear"></div>
         <div align="center">
               <div id = "marcoMensaje"></div>
        </div>
        <div class="clear"></div>
        <div id = "botones" >
           <center>
           <input  type="Button"  id= "Button1" name="Button"  value="Enviar">
           <input  type="Button" value="Borrar" onClick="borraCampos()"> 
           </center>
        </div>

        
	 </div> 
     <div class="clear"></div>
    
     <div align="center"><div id = "marcoNombreFichero"></div></div>
     
 <div id = "recogeMensajes"></div>
</form> 
</div>
   </div> <!--FIN --- estará oculto, se activrá si clicas en el icono correo ............................-->
   <div class="ficha_fila">
      <div class = "celda_30_izda"><img src="../imagenes/ContactoTelefonista.gif"  alt="telefonista"></div>
      <div class = "celda_60_dechaContacto">
               <!--  .......................................................-->
         <div class = "puntero" onClick="VerSeccionCorreo(0)">
          <div class = "celda_10_izda_contacto">
            <img src="../imagenes/Tarjeta_on.gif"  alt="Visa"> 
          </div>
          <div class = "celda_90_decha_estrecha">
            <p><strong>SOLICITUD DE REEMBOLSO:</strong></p>
            Si ha adquirido un  curso on-line y desea que se le reembolse el importe del mismo, pulse sobre este texto para enviarnos un correo con su solicitud.
            
          </div>
          </div>
          <div class = "clear"></div>      
           <!--  .......................................................-->
      <br>
      
         <!--  .......................................................-->
         <div class = "puntero" onClick="VerSeccionCorreo(1)">
          <div class = "celda_10_izda_contacto">
            <img src="../imagenes/ContactoVideoconferencia.gif"  alt="Videoconferencia"> 
          </div>
          <div class = "celda_90_decha_estrecha">
            <p>Disponemos de un servicio de <strong>VIDEOCONFERENCIA</strong> para resolver sus dudas, consultas e incidencias. Solicite información y le asesoramos cómo puede ponerse en contacto con nosotros utilizando estas tecnologías.</p>
            <p>No importa en qué parte del mundo esté. Este servicio está especialmente diseñado para <span class = "textoAzul"><strong>INVERSORES</strong> extranjeros</span> que deseen aprovechar el tirón urbanístico de Ecuador
            </p>
          </div>
          </div>
          <div class = "clear"></div>      
           <!--  .......................................................-->
           <div class = "puntero" onClick="VerSeccionCorreo(1)">
                <div class = "celda_10_izda_contacto">
                     <img src="../imagenes/ContactoMail.gif"  alt="mail">
                </div>   
           <div class = "celda_90_decha_estrecha">
                <br>
                <p align="left">Envíenos un Email, atenderemos su consulta. <span class = "textoAzul">Reserve día y hora</span> para una videoconferencia con nuestro departamento técnico</p>
                
           </div>
             </div>  
          <div class = "clear"></div> 
          <!--  .......................................................-->
          <div class = "celda_10_izda_contacto"> 
              <img src="../imagenes/whatsapp.jpg"  alt="tfn"> 
          </div>
          <div class = "celda_90_decha_estrecha">
          <br>
              <p><strong>Teléfono</strong>: +593997070242  </p>
              
          </div>
          <div class = "clear"><br></div> 
           <!--  .......................................................-->
           
           
           
           
           
           
           
            <div class = "puntero" onClick="location.href='https://www.facebook.com/pages/Medif-Cype/701468623308438?ref=hl'">
          <div class = "celda_10_izda_contacto"> 
              <img src="../imagenes/LogoFacebook.jpg"  alt="tfn"> 
          </div>
          <div class = "celda_90_decha_estrecha">
              <p>&nbsp;</p>
              <p>Síguenos: Medif & Cype
              </p>
          </div>
          </div>
          <div class = "clear"><br></div> 

          <!--  .......................................................-->
          <div class = "celda_10_izda_contacto"> 
             
          </div>
          <div class = "celda_90_decha_estrecha">
          <center><span class= "textoAzul">Clique sobre el mapa para ver nuestra ubicación</span><br></center>
              <div id = "FotoLocalizacion" onClick="VerLocalizacion()"><img src="../imagenes/LocalizacionMedif.jpg"  alt="Localizacion Medif"></div> 
          </div>
        <!--  .......................................................-->
      
      </div> <!-- end .celda_60_decha-->
   </div> <!-- end .ficha_fila-->
</div> <!-- end .envoltorio -->

 </div><!-- end .ficha -->
</section><!-- end .contenedor -->


<div class = "Aviso"></div>

</body>
</html>
