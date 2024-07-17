
<?php

/*
Conjunto de ficheros :
Desde VTCursoContenido.js se apunta a:
     CartaVTCursosCli--> compone la carta
	 VTCursoEnviaMail--> envia correo al ciente. ¿Con copia oculta a e-mailcomercial?
	 VTCursoNuevoMail---> anotar en base de datos la recepción de la solicitud

*/	 
  session_start();
   
  if (!isset($_REQUEST['NumeroCurso'])) {
	$_REQUEST['NumeroCurso'] = 0;
  }
  
	$_SESSION['ver_curso'] = 0;
   
	$_SESSION['NumeroCurso'] = $_REQUEST['NumeroCurso'];
	
  if (!isset($_REQUEST['modo_ver'])) {
	$_REQUEST['modo_ver'] = 0;
  }

  if ($_REQUEST['modo_ver'] == 1) {
	  $_SESSION['ver_curso'] = 1;
  } else {
	  $_SESSION['ver_curso'] = 0;
  }

  
  
  if ($_SESSION['es_admin'] != 1) {
      $longitud = count($_SESSION['permisos']);
      for($i=0; $i<$longitud; $i++) {
		   if ($_SESSION['permisos'] [$i] == $_SESSION['NumeroCurso']) {
	          $_SESSION['ver_curso'] = 1;
			  $_REQUEST['modo_ver'] = 1;
           }
       }

  }

 include_once('../php/VTCursoContenidoScrip.php');
 include_once('../conexion/conn_bbdd.php');
 include_once('../php/ValidaLoginScript.php');
 include_once('../php/ParametrosClass.php'); //Clase ParametrosClass
 $DatosWeb =   new ParametrosClass($conexion);

 
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<?php  
include_once('EstilosScripsNOIndex.php');

$txtCertificado = ""; // si ofrecemos certificados estará el campo de emisión certificados activo, se obtendrá un texto.length > 0
$txtProcEvaluacion = "";
$FormatMaestros = "SELECT A.id_curso, A.titulo_cur , A.preciotutorial, A. id_mailcomer, A.certificado_diploma, A.proc_evaluacion, 
B.id AS IDEMAIL, B.correoelectronico , B.nombre_interno , B.nombre_correo , B.es_smtp , 
B.es_pop3 , B.servidor , B.puerto , B.seguridad , B.requiere_auth , B.usuario , B.password , B.usa_logo , B.fichero_logo   
from vtcursos A, emailscomerciales B 
where A.id_mailcomer = B.id
and A.id_curso = %d";

$queMaestros = sprintf($FormatMaestros,$_REQUEST['NumeroCurso']); 
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
$totMaestros = mysqli_num_rows($resMaestros);

if ($totMaestros == 1) {
       //....correo para el cliente...................................................................
          while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {	 
		    echo "<script>Nombre_correo = '".$rowRegistros['nombre_correo']."';\n";
			echo "emisorcorreo = '".$rowRegistros['correoelectronico']."';\n";
			echo "numCurso = '".$rowRegistros['id_curso']."';\n";
			echo "tituloCurso = '".$rowRegistros['titulo_cur']."';\n";
			echo "precioCurso = ".$rowRegistros['preciotutorial'].";\n";
			echo "</script>";
			$txtCertificado = trim($rowRegistros['certificado_diploma']);
			$txtProcEvaluacion = trim($rowRegistros['proc_evaluacion']);
		  }
}



?>

<title>Contenido del Videoturorial</title>
     <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
     <script type="text/javascript" src="../php/VTCursoContenido.js"></script>
     <script type="text/javascript" src="../php/VTCursoContenidoCobros.js"></script>
     <script type="text/javascript" src="../php/VTCalculoDescuentosCobros.js"></script>
   

<?php include_once('PaginaCabecera.php'); ?>  


<?php  
$FormatMaestros = " SELECT correoelectronico , nombre_correo   
from emailscomerciales 
where tipocorreo = 1 limit 1";

$queMaestros = $FormatMaestros; 
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
$totMaestros = mysqli_num_rows($resMaestros);

if ($totMaestros == 1) {
       //....correo para el cliente...................................................................
          while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {	 
		    echo "<script>DENombre_correo = '".$rowRegistros['nombre_correo']."';\n";
			echo "DEemisorcorreo = '".$rowRegistros['correoelectronico']."';\n";
			echo "</script>";
		  }
}

?>
 
<script>
 CursorX = 0;
 CursorY = 0;  
 AntiguaY = 0;  
 procesoActivo = 0;
 posY = 0;
<?php 
 if ($_SESSION['es_admin'] == 1) { /*=========== inicio es admin ================================================*/
 ?>
  function Reload(modo) {
	   document.getElementById('modo_ver').value = modo;
	   document.datos_admin.submit();
  }
<?php 
 } /*============================================= final es admin ================================================*/
?>


function ComprarCurso() {
	
<?php 
	echo 'a = document.getElementById("CompraCurso");';
    echo 'a.style.display= "none";';
	echo 'b = document.getElementById("CorreoGeneral");';
    echo 'b.style.display= "none";';
    echo 'd    = document.getElementById("CorrreoCobros");';
    echo 'posY = d.style.top = CursorY-200;';
    echo 'if (posY < 100) { posY = 100;}';
    echo 'd.style.top = posY+"px";';
    echo 'd.style.display= "block";';
   
   ?>     
    
}
		

</script>


</head>

<body onMouseMove="javascript:coordenadas(event);">






<div id="logoPrincipalVideotutoriales"><img src="<?php echo $DatosWeb->GetTrimValor('web_url') ?>/imagenes/logos/<?php echo $DatosWeb->GetTrimValor('web_logoblanco') ?>"  alt="Logo <?php echo $DatosWeb->GetTrimValor('web_dominio') ?>"></div>


<?php

   /*
	  $numero2 = count($_REQUEST);
      $tags2 = array_keys($_REQUEST); // obtiene los nombres de las varibles
      $valores2 = array_values($_REQUEST);// obtiene los valores de las varibles

     for($i=0;$i<$numero2;$i++){ 
         echo $tags2[$i]."=".$valores2[$i]."   "; 
      }
	  echo "<br>Final parámetros ========================================================Forma de ver:". $_SESSION['ver_curso']."    ==================";	  

*/
?>















<div id = "CorrreoCobros">
  <!--INI --- estará oculto, se activrá si clicas en el icono correo ............................-->
  <div id = "correoCobrosDatos" >
    <?php  
   if ($_SESSION['es_admin'] == 1) {
	  	  echo '<div class="centro"><div class="rojo">Eres Administrador: Compras en PRUEBAS si HAS HABILITADO en 2checkout.com->Panel<br> la modalidad PRUEBAS</div></div>'; 	   	   
   }
   ?>
    <p class="pide_panPreMensaje"> Ofrecemos interesantes DESCUENTOS por la adquisición de más de un curso.  &nbsp;&nbsp;
      <input name="Descuentos" type="button" class ="btnVerPagina" value ="&nbsp;&nbsp&nbsp;CALCULAR DESCUENTO&nbsp;&nbsp;&nbsp;" onClick="javascript:VerDescuentos(1)"/>
    </p>
    <p class="pide_panPreTit">Comprar el videotutorial</p>
    <form  class="formulario">
      <!--<div class="mitad">-->
      <br>
      <div align="center" class = "pide_panPreMensaje">
        <script> document.write(tituloCurso.toUpperCase()) </script>
      </div>
      <br>
      <br>
      <div class="clear"></div>
      <div style="margin-left:10%">
        <label class="pide_panPre">Importe </label>
        <label class="pide_panPreMensaje">
          <script> document.write(precioCurso) </script>
          &nbsp;<?php echo $DatosWeb->GetTrimValor('moneda') ?></label>
        <div class="clear"></div>
        <label class="pide_panPre">Email </label>
        <input id = "CBemail" type="text" name="CBemail" size="35" maxlength="99" value= "<?php if (isset( $_REQUEST['CBemail'])) { echo $_REQUEST['CBemail']; }?>" required >
        <br>
        <label class="pide_panPre">Repita el Email </label>
        <input id = "CBemail2" type="text" name="CBemail2" size="35" maxlength="99" value= "<?php if (isset( $_REQUEST['CBemail2'])) { echo $_REQUEST['CBemail2']; }?>" required >
      </div>
      <br>
      <div class="clear"></div>
      <br>
      <div align="center" class = "pide_panPreMensaje">
        <div id = "CBmarcoMensaje" >&nbsp;</div>
      </div>
      <br>
      <div class="clear"></div>
    </form>
    <div id= "CBBotones" align="center">
      <button id = "CBButton1" class="botonVisa" ><img src="../imagenes/Tarjeta_on.gif" alt="Tarjeta Visa" /></button>
      &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
      <button  id = "CBButton3" class="botonVisa" ><img src="../imagenes/Transfer_on.gif" alt="Transferencia Bancaria" /></button>
    </div>
    <br>
    <br>
    <div class ="centro">
      <input id = "CBButton4" name="Salir" type="button" class ="btnVerPagina" value ="&nbsp;&nbsp;&nbsp;&nbsp;Salir&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" />
    </div>
    <br>
    <br>
    <div class="clear"></div>
  </div>
</div>
<section class="contenedor">
       <!-- <h1 class ="tituloApartado">Videotutorial</h1>-->
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
 
 if ($_SESSION['es_admin'] == 1) { /*=========== inicio es admin ================================================*/
 ?>
     <!--Ficha ............................................................................................ -->
     <div class="ficha">
       <div class="ficha_fila">
         <div id = "menuGestion">
	       <form id = "datos_admin" name= "datos_admin" action="VTCursoContenido.php" method="post">
             <input id = "modo_ver" name="modo_ver" type="hidden" value="<?php echo $_REQUEST['modo_ver'] ?>" />
             <input id = "NumeroCurso" name="NumeroCurso" type="hidden" value="<?php echo $_REQUEST['NumeroCurso'] ?>" />
             <input name="Ver como Pagado" type="button" onclick="Reload(1)" value="Ver como Pagado" />
             <input name="Ver NO Pagado" type="button" onclick="Reload(0)" value="Ver NO Pagado" />
           </form>	
	     </div> <!--menuGestion-->
       </div> <!-- end .ficha_fila -->
     </div><!-- end .ficha ................................................................................ -->
<?php 
 } /*============================================= final es admin ================================================*/
?>
 <div class="ficha">  <!--Cabecera de curso ..........................................................-->



<?php 

 if ($_SESSION['ver_curso'] == 1) { 
    include_once('VTCursoCabeceraPago.php');
 } else {
	include_once('VTCursoCabeceraNoPago.php'); 
 }
 
 
 ?>

 <?php 
/*
echo "@@@ Usuario -->".$_SESSION['NumeroUsuario']."<br>";
echo "@@@ Curso  -->".$_SESSION['NumeroCurso']."<br>";
echo "@@@ Sesión -->".$_SESSION['NumeroSesion']."<br>";
*/
?>
<div class="centro">


<?php   
       include_once('VTCalculoDescuentos.php');
?> 


</div>
</div><!-- end .ficha ................................................................................ -->
<!--Ficha ............................................................................................ -->
<div class="ficha">
<div class="ficha_fila">  <!--Solicutud de certificado -->


<?php 
if (strlen($txtCertificado) > 0) {
    if ($_SESSION['ver_curso'] == 1) {
	   $estadoCertif = EstadoCertificado($conexion);
	   
       switch ($estadoCertif) {
       case 0:
	   	   
        echo "<br><b>Fecha inicio del curso</b>: ".FechaInicioPermiso($conexion)."<br><br>Solicita tu certificado una vez hayas realizado el modelo propuesto: Puedes ver el procedimiento al final de esta página.";
		
        break;
       case 1:
	   
        echo "<br>Recibimos tu solicitud de certificado del curso el día: ".FechaSolicitudCertificado($conexion).". En breve te respondemos.";

        break;
       case 2:
        echo "<br>Nos consta haberte enviado el certificado del curso el día: ".FechaEntregaCertificado($conexion);
        break;
        }
    } // de ver curso == 1
} // de certificado informado
?>





</div> <!-- ficha_fila    Solicutud de certificado -->


<div class="ficha_fila">

   <div class = "celda_10_izda"><p class="tituloApartado">Contenido del Curso</p></div>
   <div class = "celda_90_decha"> 
   <br><div class ="FichaListaFilaRaya"></div>
           <!--inicio celda_60_decha   ......................................inicio contenido curso-->
           
          
           <?php ContenidoCurso($conexion) ?>
           
           
   </div>  <!--fin celda_60_decha   ...........................................final contenido curso-->
</div> <!-- end .ficha_fila -->





</div><!-- end .ficha ................................................................................ -->

<!-- entrega de certificados (ini) ..............................................................................................-->
<?php 
if (strlen($txtCertificado) > 0) {
echo '<div class="ficha"><div class="ficha_fila">';	
echo '<div class="celda_10_izda">&nbsp;</div>';
echo '<div class="celda_90_decha">';
    if ($_SESSION['ver_curso'] == 1) {
		   echo '<div class = "TituloModulo">'.'CERTIFICADO / EVALUACIÓN'."</div>";
	        $estadoCertif = EstadoCertificado($conexion);
       switch ($estadoCertif) {
       case 0:
           echo str_replace("\r\n","<br>",$txtProcEvaluacion)."<br><br><br>";  
        break;
       case 1:
           echo "Estamos estudiando tu modelo.";
        break;
       case 2:
          echo "Esperamos que los conocimientos adquiridos  sean de utilidad.<br>Si tienes alguna incidencia con el certificado notifícanos la incidencia.<br>Gracias por tu confianza. ";
        break;
        }
    } // de ver curso == 1
	
	echo "</div></div></div>";
} // de certificado informado
?>

<!--entrega de certificados (fin) ..............................................................................................-->




</section><!-- end .contenedor -->
<div id = "CompraCurso">
<img style="cursor:pointer" src="../imagenes/AddToCart_naranja.gif"  onMouseOut="javascript:GetImagenCart(1,this)" onMouseOver="javascript:GetImagenCart(2,this);AvisoDebeComprar(0)" onclick="javascip:ComprarCurso()"/>

</div>
<!-----------------------------------------------------------  -->

<!--   INICIO CORREO --> 
<div align="center" style="width:100%"> </div>   <!--center-->
  <!-- FIN CORREO-->




<div class = "Aviso"></div>



</body>

</html>
