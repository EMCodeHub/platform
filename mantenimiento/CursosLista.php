<?php
session_start();
if ($_SESSION['es_admin'] != 1 ) {
     header("Location: ../index.php");
     exit;
}
include_once('../php/CursosScrip.php');
?>
<!doctype html>
<html lang="es">


 <SCRIPT LANGUAGE="JavaScript"> 
  function VerListaWeb(){
		URL = "../paginas/ListaWebCursos.php";
		window.open(URL,"Listado de Curss de la Web","width=1000,height=700,scrollbars=YES,resizable=YES,LEFT=200,TOP=100") 	
	}
	   function edita(reg) {
		   document.getElementById('registro').value = reg; 
		   document.getElementById('alta').value = 0;
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action="CursosFicha.php";
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
		   document.datos.action="CursosFicha.php";
		   document.datos.submit();
	   }
	      function Selecciona(campo) {
			  alert("hoyhoy ..... has llamado a Selecciona() hay que corregir esta función");
	       document.getElementById('RecetaID').value = campo.value;
		   document.getElementById('SeccionID').value = 0;
		   document.getElementById('registro').value = 0;
		   document.getElementById('alta').value = 0;
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action="CursosLista.php";
		   
		   //alert("Receta--> "+campo.value+"     Seccion---> "+ document.getElementById('SeccionID').value);
		   
		   document.datos.submit();
	   }
	function SeleccionaSeccion(campo) {
	       document.getElementById('OrganizadorID').value = campo.value;
		    // document.getElementById('RecetaID').value = 0;
		   document.getElementById('registro').value = 0;
		   document.getElementById('alta').value = 0;
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action="CursosLista.php";
		   //alert("Seccion--> "+campo.value+"     Receta---> "+ document.getElementById('RecetaID').value);
		   document.datos.submit();
	   }
    </SCRIPT>
  

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lista Cursos</title>
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
<!--<input id = "RecetaID" name="RecetaID" type="hidden" value="<?php $_REQUEST['RecetaID'] ?>" />
<input id = "OrganizadorID" name="OrganizadorID" type="hidden" value="<?php $_REQUEST['OrganizadorID'] ?>" />-->
<br>
<div class="TituloLista">Cursos</div>
<div class = "TituloTablaCurso"> &nbsp; &nbsp;
<input name="Anterior" type="button" value ="Volver" onClick = "location.href='mantenimiento.php'" /> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
<input name="Alta nuevo Curso" type="button" value ="Alta nuevo Curso" onClick="altaRegistro()" />&nbsp; &nbsp; &nbsp;
<input name="Ver Lista Web" type="button" value ="Ver Lista Web" onClick="VerListaWeb()" />

&nbsp; &nbsp;Seleccionar cursos del Organizador-aula:  <?php echo hazSelectIndiceFiltro("organizadores","id",$_REQUEST['OrganizadorID'],$_REQUEST['OrganizadorID'],$conexion,"OrganizadorID",1,1); ?>


</div>

<div class = "Separador"> &nbsp;</div><br>

<div class="envoltorioCursos">

<?php




pintaCursos($conexion);



/*echo "<br>usuario ................".$_SESSION['usuario']         ;
echo "<br>pwd.....................".$_SESSION['pwd']             ;
echo "<br>regId...................".$_SESSION['regId']           ;
echo "<br>EsCliente...............".$_SESSION['esCliente']       ;
echo "<br>autentificado...........".$_SESSION['autentificado']   ;
echo "<br>esAdmin.................".$_SESSION['esAdmin']         ;
echo "<br>registradoAcceso........".$_SESSION['registradoAcceso'];*/
?>

</div>

<div class = "TituloTablaCurso" >  &nbsp; &nbsp;
<input name="Anterior" type="button" value ="Volver" onClick = "location.href='mantenimiento.php'" /> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
<input name="Alta nuevo Curso" type="button" value ="Alta nuevo Curso" onClick="altaRegistro()" /></div>
</div>
</form>

<br>
<br>
</body>
</html>
<?php mysqli_close($conexion); ?>
