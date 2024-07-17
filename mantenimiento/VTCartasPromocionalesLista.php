<?php
session_start();
if ($_SESSION['es_admin'] != 1) {
     header("Location: ../index.php");
     exit;
}
if (!isset($_REQUEST['volver_a'])) {
	$_REQUEST['volver_a'] = "CartasPromocionalesSeleccionar.php";
}
include_once('../php/VTCartasPromocionalesScript.php');
?>
<!doctype html>
<html lang="es">


      <SCRIPT LANGUAGE="JavaScript"> 
	   function edita(reg) {
		   document.getElementById('registro').value = reg; 
		   document.getElementById('alta').value = 0;
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action="VTCartasPromocionalesFicha.php";
		   document.datos.submit();
	   }

	      function SeleccionaPorFecha(campo) {
		   document.getElementById('FechaFiltro').value = campo.value;
		   document.getElementById('registro').value = 0;
		   document.getElementById('alta').value = 0;
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action="VTCartasPromocionalesLista.php";
		   
		   //alert("Receta--> "+campo.value+"     Seccion---> "+ document.getElementById('SeccionID').value);
		   
		   document.datos.submit();
	   }

    </SCRIPT>
  

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>VIDEOTUTORIALES: Cartas Promocionales</title>
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

<form id = "datos" name= "datos"  method="post">  <!--action="SubgruposFicha.php"-->
<input id = "registro" name="registro" type="hidden" value="0" />
<input id = "alta" name="alta" type="hidden" value="0" />
<input id = "filtro" name="filtro" type="hidden" value="<?php $_REQUEST['filtro'] ?>" />
<?php	echo '<input id = "volver_a" name="volver_a" type="hidden" value="'. $_REQUEST['volver_a'].'" />';?> <!--/*para volver a la página llamada,saber el registro o id*/-->

<br>

<div class="TituloLista">VIDEOTUTORIALES: Cartas Promocionales</div>
<div class = "TituloTablaAlumno"> &nbsp; &nbsp;
<input name="Anterior" type="button" value ="Volver" onClick = "location.href='CartasPromocionalesSeleccionar.php'" /> &nbsp; &nbsp; &nbsp; &nbsp;
&nbsp; &nbsp;Fecha carta >= a:  <input id = "FechaFiltro" name="FechaFiltro" size="12"  maxlength="12"  onChange="SeleccionaPorFecha(this)"  value="<?php $_REQUEST['FechaFiltro'] ?>" />
<?php echo elfecha('FechaFiltro', 'date');?>
</div>
<script>
document.getElementById('FechaFiltro').value = <?php echo '"'.$_REQUEST['FechaFiltro'].'"';?>
</script>




<div class = "Separador"> &nbsp;</div><br>

<div class="envoltorioCursos">

<?php pintaCartasPromocionales($conexion); ?>

</div>

<div class = "TituloTablaAlumno" >  &nbsp; &nbsp;
<input name="Anterior" type="button" value ="Volver" onClick = "location.href='CartasPromocionalesSeleccionar.php'" /> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
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
