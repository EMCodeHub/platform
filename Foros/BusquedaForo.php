<!DOCTYPE html>
<html lang="es" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
include_once('../conexion/conn_bbdd.php');
include_once('../php/ValidaLoginScript.php');
include_once('../php/ParametrosClass.php'); //Clase ParametrosClass
$DatosWeb =   new ParametrosClass($conexion);    
include_once('../php/SesionesCookies.php'); //Inicio de sesión y asignación de sus variables
include_once('../paginas/NewWebEstilosForos.php')    
//$CursoEnPromocion  = 9;   //....... cambiar si cambia el curso de la landing, el curso gratis

?>
<title>Foro CYPE - Búsqueda de contenido</title>
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

</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $DatosWeb->GetTrimValor('codigo_tagmanager') ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php
include_once('../php/IndexScript.php');
include_once('../php/ForosScript.php');
include_once('../php/ForosBusquedaScript.php');
include_once('../paginas/MenuForos.php'); 
include_once('../paginas/PaginaCursoPHP01_2.php');    
?>


 <div class="EnvoltorioForoClase">   
<div class="foroclase">
    <h2 class="foroclasetitulo">Búsqueda de contenido</h2>
   <p class="foroclasedescri">BUSCAR: <b><span class="rojoGenerico"><?php echo strip_tags($_REQUEST['palabras'])?></span></b></p>
</div>
<div class="forotema">
 <?php dibujaBusqueda(strip_tags($_REQUEST['palabras']),$conexion) ?>
</div>    
</div>   
<?php 
include_once('BusquedaPie.php'); 
include_once('ForoPantallas.php');  
?>  
<div class = "Aviso"></div>
<?php include_once('../paginas/PaginaCursoPHP01_4.php'); ?>
</body>
</html>
