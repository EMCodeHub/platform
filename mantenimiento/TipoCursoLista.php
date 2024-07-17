<?php
session_start();
if ($_SESSION['es_admin'] != 1 ) {
     header("Location: ../index.php");
     exit;
}
?>
<!doctype html>
<html lang="es">

<head>
      <SCRIPT LANGUAGE="JavaScript"> 
	   function edita(reg) {
		   document.getElementById('registro').value = reg; 
		   document.getElementById('alta').value = 0;
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action="TipoCursoFicha.php";
		   document.datos.submit();
	   }
	   function altaRegistro(reg) {
		   <!--document.getElementById('RecetaID').value = 0;-->
		   document.getElementById('registro').value = 0;
		   document.getElementById('alta').value = 1;
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action="TipoCursoFicha.php";
		   document.datos.submit();
	   }
	      function Selecciona(campo) {
	       document.getElementById('RecetaID').value = campo.value;
		   document.getElementById('registro').value = 0;
		   document.getElementById('alta').value = 0;
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action="TipoCursoLista.php";
		   document.datos.submit();
	   }
	
    </SCRIPT>
  

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lista Tipos de cursos</title>
<link href="../css/estilosMantenimiento.css" rel="stylesheet" type="text/css" />
</head>
<?php

include_once('../php/TipoCursoScrip.php');
 ///...%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%.empieza body
  echo '<body onload="'."location.href = '#".$_REQUEST['id']."'".'">';
  
 	include_once('../conexion/conn_bbdd.php');
 
  
  
?>

<form id = "datos" name= "datos"  method="post">  <!--action="SubgruposFicha.php"-->
<input id = "registro" name="registro" type="hidden" value="0" />
<input id = "alta" name="alta" type="hidden" value="0" />
<input id = "filtro" name="filtro" type="hidden" value="<?php $_REQUEST['filtro'] ?>" />
<!--<input id = "RecetaID" name="RecetaID" type="hidden" value="<?php $_REQUEST['RecetaID'] ?>" />-->
<br>
<div class="TituloLista">Tipos de curso</div>
<div class = TituloTablaSubfichero> &nbsp; &nbsp;
<input name="Anterior" type="button" value ="Volver" onClick = "location.href='mantenimiento.php'" /> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
<input name="Alta nuevo Tipo Curso" type="button" value ="Alta nuevo Tipo Curso" onClick="altaRegistro()" />
</div>
<div class = Separador> &nbsp;</div><br>

<div class="envoltorioSubfichero">

<?php

pintaTipoCurso($conexion);



/*echo "<br>usuario ................".$_SESSION['usuario']         ;
echo "<br>pwd.....................".$_SESSION['pwd']             ;
echo "<br>regId...................".$_SESSION['regId']           ;
echo "<br>EsCliente...............".$_SESSION['esCliente']       ;
echo "<br>autentificado...........".$_SESSION['autentificado']   ;
echo "<br>esAdmin.................".$_SESSION['esAdmin']         ;
echo "<br>registradoAcceso........".$_SESSION['registradoAcceso'];*/
?>
<br>
</div>
<div class = Separador> &nbsp;</div>
<div class = TituloTablaSubfichero >  &nbsp; &nbsp;
<input name="Anterior" type="button" value ="Volver" onClick = "location.href='mantenimiento.php'" /> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
<input name="Alta nuevo Tipo Curso" type="button" value ="Alta nuevo Tipo Curso" onClick="altaRegistro()" /></div>
</div>
</form>

<br>
<br>
</body>
</html>
<?php mysqli_close($conexion); ?>
