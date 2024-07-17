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
		   document.datos.action="VTOpcionesMenuFicha.php";
		   document.datos.submit();
	   }
	   function altaRegistro(reg) {
		   <!--document.getElementById('RecetaID').value = 0;-->
		   document.getElementById('registro').value = 0;
		   document.getElementById('alta').value = 1;
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action="VTOpcionesMenuFicha.php";
		   document.datos.submit();
	   }
	      function Selecciona(campo) {
	       document.getElementById('RecetaID').value = campo.value;
		   document.getElementById('registro').value = 0;
		   document.getElementById('alta').value = 0;
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action="VTOpcionesMenuLista.php";
		   document.datos.submit();
	   }
	
    </SCRIPT>
  

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Opciones del menú principal</title>
<link href="../css/estilosMantenimiento.css" rel="stylesheet" type="text/css" />
</head>
<?php

include_once('../php/VTOpcionesMenuScrip.php');
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
<div class="TituloLista">Opciones del menú</div>
<div class = "TituloOpcionesMenu"> &nbsp; &nbsp;
<input name="Anterior" type="button" value ="Volver" onClick = "location.href='mantenimiento.php'" /> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
<input name="Alta nueva Opción" type="button" value ="Alta nueva Opción" onClick="altaRegistro()" />
</div>
<div class = Separador> &nbsp;</div><br>

<div class="envoltorioOpcionesMenu">

<?php

pintaVTOpcionesMenu($conexion);



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
<div class = "TituloOpcionesMenu" >  &nbsp; &nbsp;
<input name="Anterior" type="button" value ="Volver" onClick = "location.href='mantenimiento.php'" /> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
<input name="Alta nueva Opción" type="button" value ="Alta nueva Opción" onClick="altaRegistro()" /></div>
</div>
</form>
<div class="clear"></div>
<br> Edición del fichero: vtparamdatosmenu
<br> Sirve para activar / desactivar las opciones del menú de la web. 1=Activada, 0=Desactivada
<br> Dar de alta nuevas opciones implica desarrollar una página PHP nueva
<br>
<br>
</body>
</html>
<?php mysqli_close($conexion); ?>
