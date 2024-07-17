<?php

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
<script  src="../php/CorreoDevolucionesNoIndex.js"></script>
<script  src="../php/CorreoSoliciInfoNoIndex.js"></script>    
<?php include_once('PaginaCabecera.php'); ?>  
<?php
include_once('NewWebEstilosNOIndex.php');
include_once('../php/IndexScript.php');
include_once('PaginaCursoPHP01_2.php');  
?>
<?php
 $mapslocalizacion = ""; 
 $finalidadweb = "";
 $FormatMaestros  = "SELECT mapslocalizacion, 
                            finalidadweb               
                       FROM vtparamdatosweb
                      WHERE id = 1";
   $queMaestros = $FormatMaestros;
   $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
   $totMaestros = mysqli_num_rows($resMaestros);
   while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {
	  $mapslocalizacion     = $rowRegistros['mapslocalizacion']; 
      $finalidadweb         = $rowRegistros['finalidadweb'];   
   }     //while
mysqli_free_result($resMaestros); 

?>   
<title><?php echo $DatosWeb->GetTrimValor('web_dominio')?>: Contacto</title>

<script>
    DENombre_correo = '<?php echo $DatosWeb->GetTrimValor('NombrePrincipal') ?>';
    DEemisorcorreo = '<?php echo $DatosWeb->GetTrimValor('CorreoPrincipal') ?>'; 
    function VerLocalizacion() {
		URL = "<?php echo $mapslocalizacion ?>";
		window.open(URL,"Localización <?php echo $DatosWeb->GetTrimValor('web_dominio') ?>","width=1000,height=800,scrollbars=YES,resizable=YES,LEFT=100,TOP=50") 	
    }
</script>  
 
</head>
<body class="dark-mode">
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
     <img id="ImaIndex" src="../imagenes/contacto22.png"  alt="<?php echo $DatosWeb->GetTrimValor('web_dominio')?> Aviso Legal" />
</div>







<?php
     include_once('PantallaPwd.php');
?>
<div id="content-wrap">
<article class="aviso_legal">
<h1 class ="NewtituloApartado">Contacta con nosotros</h1>
<br>
<hr>
    <br>
    <div class="Contacto5"><img src="../imagenes/logos/<?php echo $DatosWeb->GetTrimValor('carta_logo')?>"  alt="<?php echo $DatosWeb->GetTrimValor('web_dominio')?>"> </div>
    
     <div class="Contacto55"><br><strong><?php echo $DatosWeb->GetTrimValor('carta_funcionempresa')?></strong>
        <br><?php echo $DatosWeb->GetTrimValor('carta_direcc1')?>
        <br><?php echo $DatosWeb->GetTrimValor('carta_direcc2')?>
        <br><?php echo $DatosWeb->GetTrimValor('carta_poblacion')?>
        <br>
         <br>
         <span class="lipointerArial" onClick="VerLocalizacion()"> Pulsa sobre el mapa para más detalles</br><br>
       <img  src="../imagenes/LocalizacionMapa.png"  alt="<?php echo $DatosWeb->GetTrimValor('web_dominio')?> Localización"></span>
    </div>
    
    <div class="Contacto40">
        <br><br>
        <?php echo $finalidadweb ?>
    </div>
    <div class="clear"></div>
    <div class="centro90" style="margin-bottom: 30px;"><?php include_once('PaginaPieNOIndex.php'); ?></div>  <!-- content-wrap -->
    <div class ="clear"></div>
    <hr>
    <a id="reembolso">
    <h2>Solicitud de reembolso</h2>
     <div class="centro">
		 <?php include_once('CorreoDevolucionesNoIndex.php'); ?>
     </div>  
    <p class="PALegal"><span id="abrirDevoluciones" class="lipointerArial" onClick="CDMuestraCorreoDevoluciones()"> Pulsa este enlace y explícanos tu motivo</span></p>
      
    <hr>
    <h2>Te ayudamos ?</h2>
    
        <?php include_once('CorreoSoliciInfoNoIndex.php'); ?>
        
<?php include_once('PaginaCursoPHP01_4.php'); ?>





</body>
</html>