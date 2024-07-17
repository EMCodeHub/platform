<!DOCTYPE html>
<?php
include_once('../conexion/conn_bbdd.php');
include_once('../php/ValidaLoginScript.php');
include_once('../paginas/NewWebEstilosForos.php');    
include_once('../php/ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb =   new ParametrosClass($conexion);
include_once('../php/SesionesCookies.php'); //Inicio de sesión y asignación de sus variables
?>
<html lang="es" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Foro CYPE - Arquitectura online</title>  
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script  src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>      
<?php include_once('../paginas/PaginaCabecera.php'); ?>
<script>
 CursorX = 0;
 CursorY = 0;  

function CierraAcceder(modo) {
   
	var j=document.getElementById("Acceder");
	if (modo == 0){
		j.style.display="none";
	} else {
         CierraRegistrarse(0);
		j.style.display="block";
	}
	
}
function CierraRegistrarse(modo) {
	
	var j=document.getElementById("Registrarse");
	if (modo == 0){
		j.style.display="none";
	} else {
        CierraAcceder(0);
		j.style.display="block";
	}
}

</script>
<script  src="../php/Acceder.js"></script>
<script  src="../php/VideotutorialesLogin.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes"/>


<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '687264758883702');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=687264758883702&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

</head>
<body onMouseMove="javascript:coordenadas(event);">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $DatosWeb->GetTrimValor('codigo_tagmanager') ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php
include_once('../php/IndexScript.php');
include_once('../php/ForosScript.php');
include_once('../paginas/MenuForos.php'); 
include_once('../paginas/PaginaCursoPHP01_2.php');    
?>

<br><br> <br><br> 
 


 <?php echo ForosClases($conexion); ?>
    
     
<?php 
include_once('ForoPie.php'); 
include_once('ForoPantallas.php');  
?>   
<div class = "Aviso"></div>
<?php include_once('../paginas/PaginaCursoPHP01_4.php'); ?>
</body>
</html>
