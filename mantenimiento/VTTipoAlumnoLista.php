<?php
session_start();
if ($_SESSION['es_admin'] != 1 && $_SESSION['es_colaborador'] != 1) {
     header("Location: ../index.php");
     exit;
}
if (!isset($_REQUEST['id_vtcurmodulo'])) {
	$_REQUEST['id_vtcurmodulo'] = 0;
}
if (!isset($_REQUEST['volver_a'])) {
	$_REQUEST['volver_a'] = "";
}
if (!isset($_REQUEST['registro'])) {
	$_REQUEST['registro'] = 0;
}



include_once('../php/VTTipoAlumnoScrip.php');
?>
<!doctype html>
<html lang="es">
<head>

 <script> 

	function volver() {
		   location.href='mantenimiento.php';
		   
	   }
	
	   function edita(reg) {
		   document.getElementById('registro').value = reg; 
		   document.getElementById('alta').value = 0;
		    document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action="VTTipoAlumnoFicha.php";
		   document.datos.submit();
	   }
	   function altaRegistro(reg) {
	   /* document.getElementById('RecetaID').value = 0; */
	    	   
		   /*if (document.getElementById('SeccionID').value < 1) {
			 alert("Selecciona una sección de una receta en concreto, Todas no. Valor enviado = "+ document.getElementById('SeccionID').value);
			 return
		   }
		   */
		   document.getElementById('registro').value = 0;
		   document.getElementById('alta').value = 1;
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action="VTTipoAlumnoFicha.php";
		   document.datos.submit();
	   }
    </script>
  


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lista Videotutoriales Tipos de Alumno </title>
<link href="../css/estilosMantenimiento.css" rel="stylesheet" type="text/css" />


</head>
<?php


 ///...%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%.empieza body
  echo '<body onload="'."location.href = '#".$_REQUEST['registro']."'".'">';
  
 	include_once('../conexion/conn_bbdd.php');
/*$numero2 = count($_POST);
$tags2 = array_keys($_POST); // obtiene los nombres de las varibles
$valores2 = array_values($_POST);// obtiene los valores de las varibles

// crea las variables y les asigna el valor
for($i=0;$i<$numero2;$i++){ 
    echo $tags2[$i]." = ".$valores2[$i]."   "; 
}*/

  
?>

<form id = "datos" name= "datos"  method="post">  <!--action="SubgruposFicha.php"-->
<input id = "alta" name="alta" type="hidden" value="0" />
<input id = "filtro" name="filtro" type="hidden" value="<?php $_REQUEST['filtro'] ?>" />
<?php
   
	echo '<input id = "registro" name="registro" type="hidden" value="'. $_REQUEST['registro'].'" />'; /*para volver a la página llamada,saber el registro o id*/
	echo '<input id = "volver_a" name="volver_a" type="hidden" value="'. $_REQUEST['volver_a'].'" />'; /*para volver a la página llamada,saber el registro o id*/
?>
<br>

<div class="TituloLista">
Tipos de Alumnos
</div>
<div class = "TituloTablaVTBloque"> &nbsp; &nbsp;
<input name="Anterior" type="button" value ="Volver" onClick = "volver()" /> &nbsp; &nbsp; 
<input name="Menu" type="button" value ="Menu" onClick = "location.href='mantenimiento.php'" /> &nbsp; &nbsp;
<input name="Alta nuevo Tipo de Alumno" type="button" value ="Alta nuevo Tipo de Alumno" onClick="altaRegistro()" />&nbsp; &nbsp;
No editar registros, requiere cambiar programación
</div>

<div class = "Separador"> &nbsp;</div><br>

<div class="envoltorioCursos">

<?php




pintaVTTipoAlumno($conexion);



/*echo "<br>usuario ................".$_SESSION['usuario']         ;
echo "<br>pwd.....................".$_SESSION['pwd']             ;
echo "<br>regId...................".$_SESSION['regId']           ;
echo "<br>EsCliente...............".$_SESSION['esCliente']       ;
echo "<br>autentificado...........".$_SESSION['autentificado']   ;
echo "<br>esAdmin.................".$_SESSION['esAdmin']         ;
echo "<br>registradoAcceso........".$_SESSION['registradoAcceso'];*/
?>

</div>

<div class = "TituloTablaVTBloque" >  &nbsp; &nbsp;
<input name="Anterior" type="button" value ="Volver" onClick = "volver()" /> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
<input name="Alta nuevo Tipo de Alumno" type="button" value ="Alta nuevo Tipo de Alumno" onClick="altaRegistro()" /></div>
</div>
</form>

<br>
<br>
</body>
</html>
<?php mysqli_close($conexion); ?>
