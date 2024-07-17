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

//.................................................
include_once('../php/ForosClasesScrip.php');
?>
<!doctype html>
<html lang="es">


      <SCRIPT LANGUAGE="JavaScript"> 
	   function edita(reg) {
		   document.getElementById('registro_clase').value = reg; 
		   document.getElementById('alta').value = 0;
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action = "ForosClasesFicha.php";
		   document.datos.submit();
	   }
	   function altaRegistro(reg) {
		   document.getElementById('registro_clase').value = 0;
		   document.getElementById('alta').value = 1;
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action = "ForosClasesFicha.php";
		   document.datos.submit();
	   }
	      function SeleccionaPorFecha(campo) {
		   document.getElementById('FechaFiltro').value = campo.value;
		   document.getElementById('registro_clase').value = 0;
		   document.getElementById('alta').value = 0;
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action = "ForosClasesLista.php";
		   document.datos.submit();
	   }
	
    </SCRIPT>
  

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>VIDEOTUTORIALES: Foros-Clases</title>
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


 ///...%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%.empieza body
  echo '<body onload="'."location.href = '#".$_REQUEST['id']."'".'">';
  
 	include_once('../conexion/conn_bbdd.php');  
 

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

<br>

<div class="TituloLista">Foros: Clases </div>
<div class = "TituloTablaForoC"> &nbsp; &nbsp;
<input name="Anterior" type="button" value ="Volver" onClick = "location.href='<?php echo $_REQUEST['volver_clase'] ?>'" /> &nbsp; &nbsp; &nbsp; &nbsp;

<input name="Alta Foro Clase" type="button" value ="Alta Foro Clase" onClick="altaRegistro()" />


&nbsp; &nbsp;Fecha alta >= a:  <input id = "FechaFiltro" name="FechaFiltro" size="12"  maxlength="12"  onChange="SeleccionaPorFecha(this)"  value="<?php $_REQUEST['FechaFiltro'] ?>" />
<?php echo elfecha('FechaFiltro', 'date');?>
</div>
<script>
document.getElementById('FechaFiltro').value = <?php echo '"'.$_REQUEST['FechaFiltro'].'"';?>
</script>




<div class = "Separador"> &nbsp;</div><br>

<div class="envoltorioCursos">

<?php
   pintaForosClases($conexion);
?>

</div>

<div class = "TituloTablaForoC" >  &nbsp; &nbsp;
<input name="Anterior" type="button" value ="Volver" onClick = "location.href='<?php echo $_REQUEST['volver_clase'] ?>'" /> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
<input name="Alta Foro Clase" type="button" value ="Alta Foro Clase" onClick="altaRegistro()" /></div>
</div>
</form>

<br><div class="clear"></div>
Si se asigna <B>num_curso</B> hay que tener permisos del curso para acceder al foro. Si es = 0, cualquiera puede acceder; 
<B>num_temas</B> se recalculará automáticamente
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
