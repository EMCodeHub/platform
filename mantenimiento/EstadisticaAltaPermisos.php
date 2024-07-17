<?php
session_start();
if ($_SESSION['es_admin'] != 1 ) {
     header("Location: ../index.php");
     exit;
}
if (!isset($_REQUEST['volver_a'])) {
	$_REQUEST['volver_a'] = "mantenimiento.php";
}
//......................................................
if (!isset($_REQUEST['Fecha_Ini'])) {
	$_REQUEST['Fecha_Ini'] = date("Y-m-d",strtotime(date("Y-m-d")." - 1 month")); 
}
if (!isset($_REQUEST['Fecha_Fin'])) {
	$_REQUEST['Fecha_Fin'] = date("Y-m-d");
}
if (!isset($_REQUEST['ORDEN'])) {
	$_REQUEST['ORDEN'] = "id_curso";
}
//.......................................................

//.......................................................
function elfecha($nombre,$tipo) {
	$devolver ="";
	$pos = strpos($tipo,'date');
	if ($pos !== false) {
		$devolver = '<input type="button" id="'."BOT".$nombre.'" value="..." />'; 
	}
	return $devolver;
}
//...........................................................................
function RellenaPuntos($txt,$long) {
	$longTexto = strlen($txt);
	$relleno = "";
	if ($longTexto < $long) {
		$relleno = str_repeat(".",$long-$longTexto);
		return $txt.$relleno;
	}
	return $txt;
}
//...........................................................................
function NoZero($num) {
	return ($num == 0 ? "..." : $num);
}
//...........................................................................
//...........................................................................
function PintaAltasPermisos($Dini,$Dfin,$orden,$conexion) {
    $devolver = "";
	$ordenAplicar = "vtpermisos.fecha_ini, email, vtpermisos.id_curso";
    switch ($orden) {
    case "fecha_ini":
        break;
    case "email":
        $ordenAplicar = "email, vtpermisos.id_curso";
        break;
    case "id_curso":
        $ordenAplicar = "vtpermisos.id_curso, email";
        break;
    }
   	$FormatMaestros = "select vtpermisos.fecha_ini, email, vtpermisos.id_curso, web_titulo, vtalumnos.id as IDA
                         from vtpermisos, vtalumnos, vtcursos
                        where vtpermisos.id_usuario = vtalumnos.id
                          and vtpermisos.id_curso = vtcursos.id_curso
                          and vtpermisos.fecha_ini >= '%s'
                          and vtpermisos.fecha_ini <= '%s'
                          
                     order by %s
                        ";
    $queMaestros = sprintf($FormatMaestros, $Dini, $Dfin,$ordenAplicar);
	//echo "<br />@@@ ----orden- >".$orden."     --->".$ordenAplicar;
    
    
    //$devolver .=  "<br />@@@ ----- >".$queMaestros;
    $devolver ="";
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
    $totMaestros = mysqli_num_rows($resMaestros); 
		$devolver .= "<TABLE id ='resultado' align='center' border=1><TR><TD>FECHA</TD> <TD>EMAIL</TD><TD>N.CURSO</TD>  <TD>DESCRIPCIÓN</TD></TR>";
     if ($totMaestros > 0){
       while ($rowMaestros = mysqli_fetch_assoc($resMaestros)) {
           $devolver .= "<TR class = 'rowActividadA' onclick='VerActividadAlumno2(".$rowMaestros['IDA'].")'>";
		   $devolver .= "<TD>".$rowMaestros['fecha_ini']."</TD>";
           $devolver .= "<TD>".$rowMaestros['email']."</TD>";   
           $devolver .= "<TD>".$rowMaestros['id_curso']."</TD>";   
           $devolver .= "<TD>".$rowMaestros['web_titulo']."</TD>";   
           $devolver .= "</TR>";  
       }   
     }
	 
    mysqli_free_result($resMaestros);
 	$devolver .= "</TABLE>";
    return $devolver;
}

?>
<!doctype html>
<html lang="es">


      <SCRIPT LANGUAGE="JavaScript"> 
	   function Procesar(campo) {
		   ini =  document.getElementById('Fecha_Ini').value;
		   fin =  document.getElementById('Fecha_Fin').value; 
		   if (fin < ini) {
			alert("Fecha FIN menor que INICIO ---->Vuelva a entrar las fechas");
			return;   
		   }
			 
		   document.datos.action="EstadisticaAltaPermisos.php";
		   document.datos.submit();
	   }
	   function EnsenyaRecalculo() {
		   document.getElementById('Recalculo').style.display = "inline"; 
           document.getElementById('resultado').style.display = "none"; 
           
	   }

	   function VerActividadAlumno2(registro) {
		   URL = "ActividadAlumno.php?NumeroAlumno="+registro;
	       window.open(URL,"Registro actividad alumno","width=1000,height=700,scrollbars=YES,resizable=YES,LEFT=250,TOP=150") 	
	   }    

    </SCRIPT>
  

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Altas de permisos entre fechas</title>
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
 	include_once('../conexion/conn_bbdd.php');
?>
<body>

<br>

<div class="TituloEstadistica">ALTA de Permisos entre fechas</div>
<br />
<div id = "cabeceraEstadistica"> 

<form id = "datos" name= "datos"  method="post">  <!--action="SubgruposFicha.php"-->
<input name="Anterior" type="button" value ="Volver" onClick = "location.href='mantenimiento.php'" /> &nbsp; &nbsp; &nbsp; &nbsp;
&nbsp; &nbsp;Fecha inicio >= a:  <input id = "Fecha_Ini" name="Fecha_Ini" size="12"  maxlength="12"  onChange="EnsenyaRecalculo()" value="<?php $_REQUEST['Fecha_Ini'] ?>" />
<?php echo elfecha('Fecha_Ini', 'date');?>
&nbsp; &nbsp;Fecha fin <= a:  <input id = "Fecha_Fin" name="Fecha_Fin" size="12"  maxlength="12"  onChange="EnsenyaRecalculo()"  value="<?php $_REQUEST['Fecha_Fin'] ?>" />
<?php echo elfecha('Fecha_Fin', 'date');?>
&nbsp; &nbsp; &nbsp; &nbsp;
Orden:  
<select  id = ORDEN name="ORDEN" onchange="EnsenyaRecalculo()">
<option value = "fecha_ini" >Fecha del Alta
<option value = "email" >E-mail
<option value = "id_curso" >Curso
</select> 
<div id="Recalculo"><input name="Precesar" type="button" value ="Recalcular" onClick = "Procesar()" /> </div>
</form>
</div>
<div class="clear"></div>
<div class="centro"> Haga click sobre el alumno para ver su actividad</div>
<script>
document.getElementById('Fecha_Ini').value = <?php echo '"'.$_REQUEST['Fecha_Ini'].'"';?>;
document.getElementById('Fecha_Fin').value = <?php echo '"'.$_REQUEST['Fecha_Fin'].'"';?>;
document.getElementById('ORDEN').value = <?php echo '"'.$_REQUEST['ORDEN'].'"';?>;
</script>


<div class="envoltorioEstadistica">
<div class="GratisCabeceraG">Altas de permisos</div>
  
    
    <?php echo PintaAltasPermisos($_REQUEST['Fecha_Ini'],$_REQUEST['Fecha_Fin'],$_REQUEST['ORDEN'],$conexion) ?>

    
</div>



<br>
<br>
<script type="text/javascript"> 

<?php
   
		echo 'Calendar.setup({ inputField: "'.'Fecha_Ini'.'", ifFormat : "%Y-%m-%d",  button : "'."BOT".'Fecha_Ini'.'" }); ';   
		echo 'Calendar.setup({ inputField: "'.'Fecha_Fin'.'", ifFormat : "%Y-%m-%d",  button : "'."BOT".'Fecha_Fin'.'" }); ';  

   	   
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
