<?php

/* -------------------------------------------------------------------------------------------------------------- 
Hemos enviado una carta solicitando el cobro de cantidades pendientes. La carta es: CartaCobrosOtrosSolicitudPago
Lleva el enlace a esta página, desde donde se llamará a 2checkout para completar el pago
En vtsolcobro anotaremos la fecha f_clickenlace. Fecha en la que clican el enlace
Luego, si en vtsolcobro vemos la f_cobro informada es que el pago se ha consumado

-----------------------------------------------------*/
include_once('../conexion/conn_bbdd.php');
include_once('../php/ValidaLoginScript.php');
include_once('../php/ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb =   new ParametrosClass($conexion);
include_once('../php/SesionesCookies.php'); //Inicio de sesión y asignación de sus variables despues de DatosWeb
//......................ver si Referencia es correcta ............................
$mensajeError = "";
$Referencia = $_REQUEST['Referencia'];
$numeroPrimo  = $DatosWeb->GetTrimValor('numeroprimo');
$solicitud = 0;
$modulo = $Referencia % $numeroPrimo ;
if ($modulo == 0) {
	  $solicitud = $Referencia / $numeroPrimo ;  
} else {
      $mensajeError = "La referencia es <strong>incorrecta</strong>, si cree que es un error póngase en contacto con nosotros";
}
if ($solicitud == 0) {
        $mensajeError = "La referencia es <strong>incorrecta</strong>, si cree que es un error póngase en contacto con nosotros"; 
}
//......................Datos de la solicitud ............................



if ($solicitud != 0 ) {
         $f_emision   = "";
         $f_cobro     = "";
         $f_anulacion = "";
         $email       = "";
         $concepto    = "";
         $descripcion = "";
         $importe     = 0;
         $moneda      = "";
         $FormatMaestros = "SELECT id, 
         	                      f_emision,
         	                      f_cobro, 	
         	                      f_anulacion, 
         	                      email_destino, 
         	                      importe, 
         	                      moneda, 
         	                      concepto, 
         	                      descripcion
                              FROM vtsolcobro     
                             WHERE id = %d";
         $queMaestros = sprintf($FormatMaestros,$solicitud);
         $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));     
         $totMaestros = mysqli_num_rows($resMaestros);     
         if ($totMaestros > 0){
         	 while ($rowVTMaestros = mysqli_fetch_assoc($resMaestros)) {
         		 $f_emision   = $rowVTMaestros['f_emision'];
                 $f_cobro     = $rowVTMaestros['f_cobro'];
                 $f_anulacion = $rowVTMaestros['f_anulacion'];
                 $email       = $rowVTMaestros['email_destino'];
                 $concepto    = $rowVTMaestros['concepto'];
                 $descripcion = $rowVTMaestros['descripcion'];
                 $importe     = $rowVTMaestros['importe'];
                 $moneda      = $rowVTMaestros['moneda'];      
         	 }	
         } else {
         	$mensajeError = "La <strong>referencia no existe</strong>, si cree que es un error póngase en contacto con nosotros";
         }
         mysqli_free_result($resMaestros);
          if (!empty($f_cobro)){
              $mensajeError = "El importe <strong>ya está abonado</strong>, día: <strong>".$f_cobro."</strong>";
          }
         
          if (!empty($f_anulacion)){
              $mensajeError = "La operación <strong>está anulada</strong> desde el día: <strong>".$f_anulacion."</strong>";
          }
         //......................(fin) Datos de la solicitud ............................
         //...........................anotar f_clickenlace ....................................
         $FormatUpdate = "UPDATE vtsolcobro SET f_clickenlace = CURDATE() WHERE id = %d"; 
         $queUpdate = sprintf($FormatUpdate,$solicitud ); 
         $resUpdate = mysqli_query($conexion, $queUpdate) or die(mysqli_error($conexion));
         mysqli_free_result($resUpdate);
         //.......................(fin)....anotar f_click ....................................
    $destino = "../php/VisaCobrosOtros.php?Referencia=".$solicitud;
}  // de solicitud !=0
?>

<!DOCTYPE html>
<html lang="es" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script  src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,500,800" rel="stylesheet">    

<script  src="../php/VideotutorialesLoginNOIndex.js"></script> 
<?php include_once('PaginaCabecera.php'); ?>  
<?php
include_once('NewWebEstilosNOIndex.php');
include_once('../php/IndexScript.php');
include_once('PaginaCursoPHP01_2.php');  
?>
    
<title>Pago de Servicios</title>
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
 
<script>
    function IniZio(){
        <?php if ($mensajeError != "") { ?>
             document.getElementById('ReferenciaNOOK').style.display  = "block";
             document.getElementById('ReferenciaOK').style.display  = "none";
        <?php } else {?>
             document.getElementById('ReferenciaNOOK').style.display  = "none";
             document.getElementById('ReferenciaOK').style.display  = "block";
        <?php }?>    
    }     
</script>
</head>
    
    
<body onLoad="javascrip:IniZio()">

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

<div class="ContenedorSlider">    
    <input type="radio" id="1" name="image-slide" hidden/>
    <input type="radio" id="2" name="image-slide" hidden/>
    <input type="radio" id="3" name="image-slide" hidden/>
    <div class="slider">
        <ul class="sliderUL">
          <li><img src="../imagenes/SliderIndex01.jpg" alt=""/> <div class="parrafos" ><h2>Cursos CYPE</h2><p>Escuela OnLine</p></div></li>
          <li><img src="../imagenes/SliderIndex02.jpg" alt=""/> <div class="parrafos" ><h2>Especialidades</h2>
              <p>Hormigón, Estructuras Metálicas</p>
              <p>Análisis PushOver, Instalaciones BIM</p>
              </div></li>
          <li><img src="../imagenes/SliderIndex03.jpg" alt=""/> <div class="parrafos" ><h2>Accede al Curso Gratis</h2><p>Inscríbete</p></div></li>
        </ul>
        <div class="pagination">
            <label class="pagination-item" for="1"></label>
            <label class="pagination-item" for="2"></label>
            <label class="pagination-item" for="3"></label>  
        </div>
    </div>
</div> 
 
 <h1 class ="NewtituloApartado">Pago de servicios prestados</h1>

<?php
     include_once('PantallaPwd.php');
?>  
  
    
<div class="ficha_fila">
<p class="centro">Hemos habilitado esta página para hacerle más cómodo el pago de los servicios que le hemos prestado.</p>
</div>

    
<div id="ReferenciaOK" class="ficha_CobrosOtros"> <!-- Pantalla si la referencia es buena-->
<div class="NewCelda_40_Cobro">Fecha:</div>
<div class="NewCelda_60_Cobro"><?php echo $f_emision ?> </div>
<div class="clear"></div> 
    
<div class="NewCelda_40_Cobro">Concepto:</div>
<div class="NewCelda_60_Cobro"><?php echo $concepto ?></div>
<div class="clear"></div> 
    
<?php if (!empty($descripcion)) { ?>  
      <div class="NewCelda_40_Cobro">Descripción:</div>
      <div class="NewCelda_60_Cobro"><?php echo $descripcion ?></div>
      <div class="clear"></div>    
<?php } ?>

<div class="NewCelda_40_Cobro">Importe:</div>
<div class="NewCelda_60_Cobro"><?php echo $importe.' '.$moneda ?></div>
<div class="clear"></div> 
    
    

  
     <input name="Pagos" type="button" class ="ButtonGrisP" value ="Realizar Pago" onClick="location.href='<?php echo $destino ?>'" /> 
  
 

</div>    <!--(Fin) Pantalla si la referencia es buena-->
    
    

<div id="ReferenciaNOOK" class="ficha_CobrosOtros"> <!-- Pantalla si la referencia NO buena o servicio ya  abonado-->
    <p><?php echo $mensajeError; ?></p>
    <input name="Salir" type="button" class ="ButtonGrisP" value ="Salir" onClick="location.href='../index.php'" /> 

</div>    <!--(Fin) Pantalla si la referencia es buena-->
    
<div class="separadorGrande"></div>   
    
    
    
<div class="centro90"><?php include_once('PaginaPieNOIndex.php'); ?></div>
<?php include_once('PaginaCursoPHP01_4.php'); ?>

</body>
</html>