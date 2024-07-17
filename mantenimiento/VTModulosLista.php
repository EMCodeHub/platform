<?php
session_start();
if ($_SESSION['es_admin'] != 1 ) {
     header("Location: ../index.php");
     exit;
}
if (!isset($_REQUEST['id_vtcurso'])) {
	$_REQUEST['id_vtcurso'] = 0;
}
if (!isset($_REQUEST['volver_a'])) {
	$_REQUEST['volver_a'] = "";
}
if (!isset($_REQUEST['registro'])) {
	$_REQUEST['registro'] = 0;
}



include_once('../php/VTModulosScrip.php');
?>
<!doctype html>
<html lang="es">


 <SCRIPT LANGUAGE="JavaScript"> 
  function VerListaWeb(){
		URL = "../paginas/**pendiente**ListaWebCursos.php";
		window.open(URL,"Listado de Videotutoriales de la Web","width=1000,height=700,scrollbars=YES,resizable=YES,LEFT=200,TOP=100") 	
	}
	function volver() {
		<?php if ($_REQUEST['volver_a'] != "") { ?>
		   document.getElementById('registro').value = <?php echo $_REQUEST['id_vtcurso']  ?>; 
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action="<?php echo ( $_REQUEST['id_vtcurso'] >0 ? "VTCursosFicha.php" : "VTCursosLista.php" )  ?>";
		   document.datos.submit();
		 <?php } else { ?>
		   location.href='mantenimiento.php';
		   <?php }?> 
		   
	   }
	
	   function edita(reg) {
		   document.getElementById('registro').value = reg; 
		   document.getElementById('alta').value = 0;
		    document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action="VTModulosFicha.php";
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
		   document.datos.action="VTModulosFicha.php";
		   document.datos.submit();
	   }
	   
	function SeleccionaCurso(campo) {
	       document.getElementById('id_vtcurso').value = campo.value;
		    // document.getElementById('RecetaID').value = 0;
		   document.getElementById('registro').value = 0;
		   document.getElementById('alta').value = 0;
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action="VTModulosLista.php";
		   document.datos.submit();
	   }
	  
    </SCRIPT>
  

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lista Módulos-Videotutoriales</title>
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
    echo '<input id = "id_vtcurso" name="id_vtcurso" type="hidden" value="'. $_REQUEST['id_vtcurso'].'" />'; /*para ligar sus hijos módulos vtcursomodulo*/
	echo '<input id = "registro" name="registro" type="hidden" value="'. $_REQUEST['registro'].'" />'; /*para volver a la página llamada,saber el registro o id*/
	echo '<input id = "volver_a" name="volver_a" type="hidden" value="'. $_REQUEST['volver_a'].'" />'; /*para volver a la página llamada,saber el registro o id*/
?>


   <?php
      if ($_REQUEST['id_vtcurso'] !=0) {
   ?>	   
<table width="90%" border="0">
  <tr>
    <td class="informacionFicheros" width="6%">CURSO:</td>
    <td class="informacionFicheros" width="92%"><?php echo DescripcionCurso($_REQUEST['id_vtcurso'] ,$conexion);?>	</td>
  </tr>
</table>

   <?php
     }
   ?>
<div class="TituloLista">
Módulos:
</div>
<br>
<div class = "TituloTablaVTModulo"> &nbsp; &nbsp;
<input name="Anterior" type="button" value ="Volver" onClick = "volver()" /> &nbsp; &nbsp;
<input name="Menu" type="button" value ="Ir a Menu" onClick = "location.href='mantenimiento.php'" /> &nbsp; &nbsp; 
<input name="Alta nuevo Módulo" type="button" value ="Alta nuevo Módulo" onClick="altaRegistro()" />&nbsp; &nbsp; 
<!--<input name="Ver Lista Web" type="button" value ="Ver Lista Web" onClick="VerListaWeb()" />-->

&nbsp; &nbsp;Seleccionar módulos del Videotutorial:  <?php echo hazSelectIndiceFiltro("vtcursos","id_curso",$_REQUEST['id_vtcurso'],$_REQUEST['id_vtcurso'],$conexion,"id_vtcurso",1,1); ?>


</div>

<div class = "Separador"> &nbsp;</div><br>

<div class="envoltorioCursos">

<?php




pintaVTModulos($conexion);



/*echo "<br>usuario ................".$_SESSION['usuario']         ;
echo "<br>pwd.....................".$_SESSION['pwd']             ;
echo "<br>regId...................".$_SESSION['regId']           ;
echo "<br>EsCliente...............".$_SESSION['esCliente']       ;
echo "<br>autentificado...........".$_SESSION['autentificado']   ;
echo "<br>esAdmin.................".$_SESSION['esAdmin']         ;
echo "<br>registradoAcceso........".$_SESSION['registradoAcceso'];*/
?>

</div>

<div class = "TituloTablaVTModulo" >  &nbsp; &nbsp;
<input name="Anterior" type="button" value ="Volver" onClick = "volver()" /> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
<input name="Alta nuevo Módulo" type="button" value ="Alta nuevo Módulo" onClick="altaRegistro()" /></div>
</div>
</form>

<br>
<br>
</body>
</html>
<?php mysqli_close($conexion); ?>
