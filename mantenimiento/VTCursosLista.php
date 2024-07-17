<?php
session_start();
if ($_SESSION['es_admin'] != 1 ) {
     header("Location: ../index.php");
     exit;
}
include_once('../php/VTCursosScrip.php');
?>
<!doctype html>
<html lang="es">


 <SCRIPT LANGUAGE="JavaScript"> 
  function VerListaWeb(){
		URL = "../paginas/**pendiente**ListaWebCursos.php";
		window.open(URL,"Listado de Videotutoriales de la Web","width=1000,height=700,scrollbars=YES,resizable=YES,LEFT=200,TOP=100") 	
	}
	   function edita(reg) {
		   document.getElementById('registro').value = reg; 
		   document.getElementById('alta').value = 0;
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action="VTCursosFicha.php";
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
		   document.datos.action="VTCursosFicha.php";
		   document.datos.submit();
	   }
	   
	function SeleccionaCategoria(campo) {
	       document.getElementById('id_categoria').value = campo.value;
		    // document.getElementById('RecetaID').value = 0;
		   document.getElementById('registro').value = 0;
		   document.getElementById('alta').value = 0;
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action="VTCursosLista.php";
		   document.datos.submit();
	   }
	   //................................
       function goBack() {
            window.history.back();
        }	
    </SCRIPT>
  

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lista Cursos-Videotutoriales</title>
<link href="../css/estilosMantenimiento.css" rel="stylesheet" type="text/css" />


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
<br>
<div class="TituloLista">
Cursos-Videotutoriales
<?php
   if ($_REQUEST['id_categoria'] !=0) {
   echo " ".DescripcionCategoria($_REQUEST['id_categoria'] ,$conexion);
   }
?>
</div>
<div class = "TituloTablaVTCurso"> &nbsp; &nbsp;
<input name="Anterior" type="button" value ="Volver" onClick = "location.href='mantenimiento.php'" /> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
<input name="Alta nuevo Curso-Videotutorial" type="button" value ="Alta nuevo Curso-Videotutorial" onClick="altaRegistro()" />&nbsp; &nbsp; &nbsp;
<!--<input name="Ver Lista Web" type="button" value ="Ver Lista Web" onClick="VerListaWeb()" />-->

&nbsp; &nbsp;Seleccionar cursos de la Categoria:  <?php echo hazSelectIndiceFiltro("vtcategorias","id",$_REQUEST['id_categoria'],$_REQUEST['id_categoria'],$conexion,"id_categoria",1,1); ?>


</div>

<div class = "Separador"> &nbsp;</div><br>

<div class="envoltorioCursos">

<?php




pintaVTCursos($conexion);



/*echo "<br>usuario ................".$_SESSION['usuario']         ;
echo "<br>pwd.....................".$_SESSION['pwd']             ;
echo "<br>regId...................".$_SESSION['regId']           ;
echo "<br>EsCliente...............".$_SESSION['esCliente']       ;
echo "<br>autentificado...........".$_SESSION['autentificado']   ;
echo "<br>esAdmin.................".$_SESSION['esAdmin']         ;
echo "<br>registradoAcceso........".$_SESSION['registradoAcceso'];*/
?>

</div>

<div class = "TituloTablaVTCurso" >  &nbsp; &nbsp;
<input name="Anterior" type="button" value ="Volver" onClick = "location.href='mantenimiento.php'" /> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
<input name="Alta nuevo Curso-Videotutorial" type="button" value ="Alta nuevo Curso-Videotutorial" onClick="altaRegistro()" /></div>
</div>
</form>
<div class = "clear"></div>
<?php
   $ControlErrores = ControlCursosLotes($conexion);
   //ControlErrores[0] --> Cursos con descuento
   //ControlErrores[1] --> Máximo lote de cursos
   if ($ControlErrores[0] > $ControlErrores[1] ){
       echo '<p class="rojoGordo" >ERROR-> Hay más cursos con descuento('.$ControlErrores[0].') que lotes informados('.$ControlErrores[1].')</p>';
   } 
?>
<br>

Si CAMBIA el número de cursos con descuento es OBLIGATORIO editar la tabla de precios por la compra de más de un curso
</body>
</html>
<?php mysqli_close($conexion); ?>
