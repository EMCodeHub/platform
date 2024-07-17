<?php
   echo '<?php '; 
   echo "include_once('../conexion/conn_bbdd.php'); "; 
   echo "include_once('../php/ValidaLoginScript.php');";
   echo "include_once('../php/ParametrosClass.php');";
   echo '$DatosWeb =   new ParametrosClass($conexion);';
   echo "include_once('../php/SesionesCookies.php');"; //Inicio de sesión y asignación de sus variables
   echo ' ?>';
?>

<!DOCTYPE html>
<html lang="es" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
    
<?php
session_start();
include_once('../conexion/conn_bbdd.php');
include_once('../php/ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb =   new ParametrosClass($conexion);   
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
<?php
   echo '<?php '; 
   echo "$"."NumeroCurso = ".$_REQUEST['NumeroCurso'].";";
   echo "include_once('NewWebEstilosNOIndex.php');";
   echo "include_once('../php/IndexScript.php');";
   echo "include_once('PaginaCursoPHP01.php'); ";
  
   echo ' ?>';
?>
<?php
 include_once('../php/VTGeneradorPHPScript.php');
?>

<?php
$FormatMaestros = "SELECT A.id_curso, A.titulo_cur , A.preciotutorial, A. descripcion_cur, A.objetivos 
from vtcursos A
where id_curso = %d";

$queMaestros = sprintf($FormatMaestros,$_REQUEST['NumeroCurso']); 
$resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
$totMaestros = mysqli_num_rows($resMaestros);
$Descripci = "";
if ($totMaestros == 1) {
      while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {	 
			   $Descripci = $rowRegistros['descripcion_cur'];
		  }
}
?>
	
<?php  
$precioTutorial = 0;
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
$titulo = "";
if ($totMaestros == 1) {
       //....correo para el cliente...................................................................
          while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {	 
		    echo "<script>Nombre_correo = '".$rowRegistros['nombre_correo']."';\n";
			echo "emisorcorreo = '".$rowRegistros['correoelectronico']."';\n";
			echo "numCurso = '".$rowRegistros['id_curso']."';\n";
			echo "tituloCurso = '".$rowRegistros['titulo_cur']."';\n";
			echo "precioCurso = ".$rowRegistros['preciotutorial'].";\n";
			echo "</script>";
			$titulo = $rowRegistros['titulo_cur'];
			$txtCertificado = trim($rowRegistros['certificado_diploma']);
			$txtProcEvaluacion = trim($rowRegistros['proc_evaluacion']);
			$precioTutorial = $rowRegistros['preciotutorial'];
		  }
}

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


<?php
  
  echo '<script  src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>';
  echo '<script  src="../php/VTCursoContenido.js"></script>';
  echo '<script  src="../php/VTCursoContenidoCobros.js"></script>';
  echo '<script  src="../php/VTCalculoDescuentosCobros.js"></script>';
 
?>   
<title><?php echo $titulo; ?></title>
    
<?php
   echo '<?php '; 
   echo "include_once('PaginaCabecera.php'); ";
   echo ' ?>';
?>    
    
	

<script>
 CursorX = 0;
 CursorY = 0;  
 AntiguaY = 0;  
 procesoActivo = 0;
 posY = 0;

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
    echo 'm = document.getElementById("envoltorioGeneralDescuentos");';
	echo 'm.style.display= "none";';

   ?>     
    
}
		

</script>

<?php
   echo '<?php '; 
   echo "include_once('PaginaCursoPHP01_2.php'); ";
   echo ' ?>';

?>

</head>

<body onMouseMove="javascript:coordenadas(event);">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $DatosWeb->GetTrimValor('codigo_tagmanager') ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

 
<?php
   echo '<?php '; 
   echo "include_once('MenuNOIndexCursosVideotutoriales.php'); ";
   echo ' ?>';
?>
   
<div class="clear"></div>
<div id="logoPrincipalVideotutoriales"><img src="../imagenes/logos/<?php echo '<?php echo $DatosWeb->GetTrimValor("web_logoblanco") ?>'?>"  alt="<?php echo $DatosWeb->GetTrimValor('web_dominio') ?> Logo"></div>

    
    
    
    

<section class="contenedor">
      

 <div class="ficha">  



<?php 

 echo '<?php ';
 echo 'if ($_SESSION["ver_curso"] == 1) { ';
 echo "   include_once('VTCursoCabeceraPago.php');";
 echo " } else {";
 echo "	  include_once('VTCursoCabeceraNoPago.php');"; 
 echo " }";
 echo ' ?>'; 
?>



<div class="centro">

<?php   
       echo '<?php ';
       echo "include_once('VTCalculoDescuentos.php');";
	   echo ' ?>'; 
?> 


</div>
</div><!-- end .ficha ................................................................................ -->
<!--Ficha ............................................................................................ -->
<div class="ficha">
<div class="ficha_fila">  <!--Solicutud de certificado -->


<?php
   echo '<?php ';
   echo "include_once('PaginaCursoPHP02.php');";
   echo ' ?>';
?>

</div> <!-- ficha_fila    Solicutud de certificado -->

<div class="ficha_fila">

   <div class = "celda_10_izdaVT"><p class="tituloApartado">Contenido del Curso</p></div>
   <div class = "celda_90_dechaVT"> 
   <div class ="FichaListaFilaRaya"></div>
           <?php ContenidoCurso($conexion) ?>
   </div> 
</div> 
</div>

<!-- entrega de certificados (ini) ..............................................................................................-->
<?php
   echo '<?php ';
   echo "include_once('PaginaCursoPHP03.php');";
   echo ' ?>';
?>
<!--entrega de certificados (fin) ..............................................................................................-->




</section><!-- end .contenedor -->
<div id = "CompraCurso">
<img style="cursor:pointer" src="../imagenes/AddToCart_naranja.gif"  alt="Carrito compra" onMouseOut="javascript:GetImagenCart(1,this)" onMouseOver="javascript:GetImagenCart(2,this);AvisoDebeComprar(0)" onclick="javascip:ComprarCurso()"/>

</div>


<div class="centro"> 
   <div id = "CorrreoCobros">    
   <div id = "correoCobrosDatos2" >
   <br>
    <?php echo '<?php if (PresentarDescuento($conexion,$DatosWeb->GetValor("descuento_activo"))) {?>' ?> 
   
    <p id="botonCalcular"> <input name="Descuentos" type="button" class ="ButtonGrisnuevo" value ="Calcula tu DESCUENTO por adquirir más de un curso" onClick="javascript:VerDescuentos(1)"/> </p>
   
     <?php echo '<?php } ?>'?>
     
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
         	
         	<?php  echo $precioTutorial." ".'<?php  echo $DatosWeb->GetValor("moneda") ?>' ?>
   

         </label> 
         <div class="clear"></div>
      <label class="pide_panPre">Email </label> <input id = "CBemail" type="text" name="CBemail" size="35" maxlength="99" value= "<?php if (isset( $_REQUEST['CBemail'])) { echo $_REQUEST['CBemail']; }?>" required > 
      <br> <br> 
      <label class="pide_panPre">Repita el Email </label> <input id = "CBemail2" type="text" name="CBemail2" size="35" maxlength="99" value= "<?php if (isset( $_REQUEST['CBemail2'])) { echo $_REQUEST['CBemail2']; }?>" required > 
         
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
       <?php
         echo '<?php '; 
         echo "include_once('PaginaPieNOIndex.php');";
         echo ' ?>';
       ?>
    </div>
<?php
   echo '<?php '; 
   echo "include_once('PaginaCursoPHP01_4.php'); ";
   echo ' ?>';

?>
</body>

</html>
