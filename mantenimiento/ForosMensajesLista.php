<?php
session_start();
if ($_SESSION['es_admin'] != 1 ) {
     header("Location: ../index.php");
     exit;
}
//.......................................................
if (!isset($_REQUEST['volver_clase'])) {
	$_REQUEST['volver_clase'] = "mantenimiento.php";
}
if (!isset($_REQUEST['volver_tema'])) {
	$_REQUEST['volver_tema'] = "ForosClasesFicha.php";
}
if (!isset($_REQUEST['volver_cuestion'])) {
	$_REQUEST['volver_cuestion'] = "ForosTemasFicha.php";
}
if (!isset($_REQUEST['volver_mensaje'])) {
	$_REQUEST['volver_mensaje'] = "ForosCuestionesFicha.php";
}
if (!isset($_REQUEST['volver_recurso'])) {
	$_REQUEST['volver_recurso'] = "ForosMensajesFicha.php";
}
//.......................................................
if (!isset($_REQUEST['registro_clase'])) {
	$_REQUEST['registro_clase'] = 0;
}
if (!isset($_REQUEST['registro_tema'])) {
	$_REQUEST['registro_tema'] = 0;
}
if (!isset($_REQUEST['registro_cuestion'])) {
	$_REQUEST['registro_cuestion'] = 0;
}
if (!isset($_REQUEST['registro_mensaje'])) {
	$_REQUEST['registro_mensaje'] = 0;
}
if (!isset($_REQUEST['registro_recurso'])) {
	$_REQUEST['registro_recurso'] = 0;
}
//................................................
if (!isset($_REQUEST['operacion'])) {
	$_REQUEST['operacion'] = "NADA";
}
if (!isset($_REQUEST['FechaFiltro'])) {
	$_REQUEST['FechaFiltro'] = "";
}
if (!isset($_REQUEST['sel_pendientes'])) {
	$_REQUEST['sel_pendientes'] = 0;
}
//.................................................
include_once('../php/ForosMensajesScrip.php');
?>
<!doctype html>
<html lang="es">
      <SCRIPT LANGUAGE="JavaScript"> 
	   function edita(reg) {
		   document.getElementById('registro_mensaje').value = reg; 
		   document.getElementById('alta').value = 0;
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action="ForosMensajesFicha.php";
		   document.datos.submit();
	   }
	   function altaRegistro(reg) {
		   document.getElementById('registro_mensaje').value = 0;
		   document.getElementById('alta').value = 1;
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action="ForosMensajesFicha.php";
		   document.datos.submit();
	   }
	   function SeleccionaPorFecha(campo) {
		   document.getElementById('FechaFiltro').value = campo.value;
		   document.getElementById('registro_cuestion').value = 0;
		   document.getElementById('alta').value = 0;
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action="ForosMensajesLista.php";
		   document.datos.submit();
	   }
	function SeleccionaCuestion(campo) {
		   document.getElementById('registro_cuestion').value = campo.value;
		   document.getElementById('alta').value = 0;
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action="ForosMensajesLista.php";
		   //alert("Seccion--> "+campo.value+"     Receta---> "+ document.getElementById('RecetaID').value);
		   document.datos.submit();
	   }
    function SeleccionaPendientes(elemento) {
        j = document.getElementById("sel_pendientes");
        if (elemento.checked) {
            j.value = 1;
         } else {
            j.value = 0; 
        }
        document.getElementById('alta').value = 0;
        document.datos.action="ForosMensajesLista.php";
        document.datos.submit();    
    }
    </SCRIPT>
  

<style>

.rowCabeceraAlumnos{
	width: 4000px;
	height: 12px;
	position: relative;
	color: #06F;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	float:left;
	margin-bottom:8px;
	clear:both;	
}

</style>






<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Foros: Mensajes</title>
<link href="../css/estilosMantenimiento.css" rel="stylesheet" type="text/css" /> 
<!-Hoja de estilos del calendario --> 
  <link rel="stylesheet" type="text/css" media="all" href="../php/calendar/calendar-green.css" title="win2k-cold-1" /> 

  <!-- librería principal del calendario --> 
 <script type="text/javascript" src="../php/calendar/calendar.js"></script> 

 <!-- librería para cargar el lenguaje deseado --> 
  <script type="text/javascript" src="../php/calendar/lang/calendar-es.js"></script> 

  <!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código --> 
  <script type="text/javascript" src="../php/calendar/calendar-setup.js"></script> 

</head>
<?php

/* $numero2 = count($_REQUEST);
$tags2 = array_keys($_REQUEST); // obtiene los nombres de las varibles
$valores2 = array_values($_REQUEST);// obtiene los valores de las varibles

// crea las variables y les asigna el valor
for($i=0;$i<$numero2;$i++){ 
    echo $tags2[$i]."=".$valores2[$i]."  <br /> "; 
}   
   */ 
    
    

 ///...%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%.empieza body
  echo '<body onload="'."location.href = '#".$_REQUEST['id']."'".'">';
  
 	include_once('../conexion/conn_bbdd.php');



 
 /*foreach($_POST as $nombre_campo => $valor){ 
   echo "<br />".$nombre_campo . "='" . $valor . "';"; 
} */ 
  
?>

<form id = "datos" name= "datos"  method="post">  
<input id = "registro_clase"    name="registro_clase"    type="hidden" value="<?php echo $_REQUEST['registro_clase'] ?>" />
<input id = "registro_tema"     name="registro_tema"     type="hidden" value="<?php echo $_REQUEST['registro_tema'] ?>" />
<input id = "registro_cuestion" name="registro_cuestion" type="hidden" value="<?php echo $_REQUEST['registro_cuestion'] ?>" />
<input id = "registro_mensaje"  name="registro_mensaje"  type="hidden" value="<?php echo $_REQUEST['registro_mensaje'] ?>" />
<input id = "registro_recurso"  name="registro_recurso"  type="hidden" value="<?php echo $_REQUEST['registro_recurso'] ?>" />  
<input id = "alta" name="alta" type="hidden" value="0" />
<input id = "filtro" name="filtro" type="hidden" value="<?php echo $_REQUEST['filtro'] ?>" />
<input id = "volver_clase"    name="volver_clase"    type="hidden" value="<?php echo $_REQUEST['volver_clase'] ?>" />
<input id = "volver_tema"     name="volver_tema"     type="hidden" value="<?php echo $_REQUEST['volver_tema'] ?>" />
<input id = "volver_cuestion" name="volver_cuestion" type="hidden" value="<?php echo $_REQUEST['volver_cuestion'] ?>" /> 
<input id = "volver_mensaje"  name="volver_mensaje"  type="hidden" value="<?php echo $_REQUEST['volver_mensaje'] ?>" /> 
<input id = "volver_recurso"  name="volver_recurso"  type="hidden" value="<?php echo $_REQUEST['volver_recurso'] ?>" />
<input id = "sel_pendientes"  name="sel_pendientes"  type="hidden" value="<?php echo $_REQUEST['sel_pendientes'] ?>" />


<br>
    
     
<div class="TituloLista">Foros: Mensajes</div>
    
<div class = "TituloTablaForoCues"> &nbsp; &nbsp;
<input name="Anterior" type="button" value ="Volver" onClick = "location.href='<?php echo Volver() ?>'" /> &nbsp; &nbsp; &nbsp; &nbsp;

<input name="Alta Mensaje" type="button" value ="Alta Mensaje" onClick="altaRegistro()" />

&nbsp; &nbsp;Seleccionar Cuestion:  <?php echo hazSelectIndiceFiltro("foroscuestiones","id",$_REQUEST['registro_cuestion'],$conexion,"cuestionID",1,1); ?>

&nbsp; &nbsp;Fecha alta >= a:  <input id = "FechaFiltro" name="FechaFiltro" size="12"  maxlength="12"  onChange="SeleccionaPorFecha(this)"  value="<?php $_REQUEST['FechaFiltro'] ?>" />
<?php echo elfecha('FechaFiltro', 'date');?>
 &nbsp; &nbsp;   
<?php
    $chequeado = "";
    if ($_REQUEST['sel_pendientes'] == 1) {
        $chequeado = "checked";
    }
?>    
<input type="checkbox" id="check_pendientes" <?php echo $chequeado ?> onChange="SeleccionaPendientes(this)"> PENDIENTES de revisar

</div>
    
    
<script>
document.getElementById('FechaFiltro').value = <?php echo '"'.$_REQUEST['FechaFiltro'].'"';?>
</script>
<div class = "Separador"> &nbsp;</div><br>
<div class="envoltorioCursos">
<?php
pintaMensajes($conexion);
?>

</div>

<div class = "TituloTablaForoCues" >  &nbsp; 
<input name="Anterior" type="button" value ="Volver" onClick = "location.href='<?php echo Volver() ?>'" /> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
      
<input name="Alta Mensaje" type="button" value ="Alta Mensaje" onClick="altaRegistro()" /></div>
</div>
</form>

<br>
<br>
<script type="text/javascript"> 

<?php
   
		echo 'Calendar.setup({ inputField: "'.'FechaFiltro'.'", ifFormat : "%Y-%m-%d",  button : "'."BOT".'FechaFiltro'.'" }); ';   

   	   
/*   Calendar.setup({ 
    inputField     :    "campo_fecha",     
     ifFormat     :     "%d/%m/%Y",    
     button     :    "lanzador"     
     }); */

?>

</script> 

</body>
</html>
<?php mysqli_close($conexion); ?>
