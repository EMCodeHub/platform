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
		   document.datos.action="VTPrecioLoteFicha.php";
		   document.datos.submit();
	   }
	   function altaRegistro(reg) {
		   <!--document.getElementById('RecetaID').value = 0;-->
		   document.getElementById('registro').value = 0;
		   document.getElementById('alta').value = 1;
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action="VTPrecioLoteFicha.php";
		   document.datos.submit();
	   }
	      function Selecciona(campo) {
	       document.getElementById('RecetaID').value = campo.value;
		   document.getElementById('registro').value = 0;
		   document.getElementById('alta').value = 0;
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action="VTPrecioLoteLista.php";
		   document.datos.submit();
	   }
	
    </SCRIPT>
  

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lista de precios por la compra de más de un curso</title>
<link href="../css/estilosMantenimiento.css" rel="stylesheet" type="text/css" />
</head>
<?php

include_once('../php/VTPrecioLoteScrip.php');
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
<div class="TituloLista">Precios compra más de un curso</div>
<div class = TituloTablaSubfichero> &nbsp; &nbsp;
<input name="Anterior" type="button" value ="Volver" onClick = "location.href='mantenimiento.php'" /> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
<input name="Alta nuevo lote" type="button" value ="Alta nuevo lote" onClick="altaRegistro()" />
</div>
<div class = Separador> &nbsp;</div><br>

<div class="envoltorioSubfichero">

<?php

pintaVTLotes($conexion);



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
<input name="Alta nuevo lote" type="button" value ="Alta nuevo lote" onClick="altaRegistro()" /></div>
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
Es IMPORTANTE que esta tabla tenga tantos registros como cursos con descuento existan<br>De no ser así se calcularían mal los precios
</body>
</html>
<?php mysqli_close($conexion); ?>
