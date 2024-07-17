<?php
session_start();
if ($_SESSION['es_admin'] != 1 && $_SESSION['es_colaborador'] != 1) {
     header("Location: ../index.php");
     exit;
}
//.......................................................
if (!isset($_REQUEST['volver_clase'])) {
	$_REQUEST['volver_clase'] = "ForosClasesLista.php";
}
if (!isset($_REQUEST['volver_tema'])) {
	$_REQUEST['volver_tema'] = "ForosTemasLista.php";
}
if (!isset($_REQUEST['volver_cuestion'])) {
	$_REQUEST['volver_cuestion'] = "ForosCuestionesLista.php";
}
if (!isset($_REQUEST['volver_mensaje'])) {
	$_REQUEST['volver_mensaje'] = "ForosMensajesLista.php";
}
if (!isset($_REQUEST['volver_recurso'])) {
	$_REQUEST['volver_recurso'] = "ForosRecursosLista.php";
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
include_once('../php/ForosClasesScrip.php');
include_once('../conexion/conn_bbdd.php');
?>
<!doctype html>
<html lang="es">


<SCRIPT LANGUAGE="JavaScript"> 
	function trim (myString)   {
     return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
    }
//................................................
	   function procesar(sino) {
		  if (sino == 1) {
			    document.getElementById('operacion').value =
			    <?php
			    if ($_REQUEST['alta'] == 0) {
				      $solicitad = "UPDATE";
				  } else {
				      $solicitad = "INSERT";	
				  }
				  echo "'".$solicitad."'".";";
			    ?>
				
			
		  }
		   document.getElementById('filtro').value = "FILTRO_ID";  
		   //document.getElementById('SeccionID').value = document.getElementById('id_recetaseccion').value;
		   document.datos.submit();
		   	
	   }
	   
	//.........................
	   function VerTemas(registro) {
		   document.getElementById("volver_tema").value = "ForosClasesFicha.php?registro_clase="+registro;
		   document.getElementById('operacion').value = 'NADA';
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action="ForosTemasLista.php";
		   document.datos.submit();
	   	 
	   }
//................................
function Posicionate() {
	document.getElementById("clase").focus(); 
}

function solonumeros() {
var key=window.event.keyCode;
//alert (key);
  if ((key < 48 || key > 57) && (key !=44)) {
	  window.event.keyCode=0;
	  return false;
	  //alert("Sólo números o la coma decimal")
  }
  return true;
}

    </SCRIPT>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Foros:Clases - Edición de Registros</title>
<!-Hoja de estilos del calendario --> 
  <link rel="stylesheet" type="text/css" media="all" href="../php/calendar/calendar-green.css" title="win2k-cold-1" /> 

  <!-- librería principal del calendario --> 
 <script type="text/javascript" src="../php/calendar/calendar.js"></script> 

 <!-- librería para cargar el lenguaje deseado --> 
  <script type="text/javascript" src="../php/calendar/lang/calendar-es.js"></script> 

  <!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código --> 
  <script type="text/javascript" src="../php/calendar/calendar-setup.js"></script> 

<!-- ESTILOS PROPIOS-->     
<link href="../css/estilosMantenimiento.css" rel="stylesheet" type="text/css" />

</head>

<body>

<a href="Javascript:procesar(0)">Volver</a>
<br />

<?php

/*$numero2 = count($_POST);
$tags2 = array_keys($_POST); // obtiene los nombres de las varibles
$valores2 = array_values($_POST);// obtiene los valores de las varibles

// crea las variables y les asigna el valor
for($i=0;$i<$numero2;$i++){ 
    echo '<br />'.$tags2[$i]."=".$valores2[$i]."   "; 
}

*/


echo "<div class = 'TituloCurso' > Foros:Clases Registro Núm ".$_REQUEST['registro_clase'];
echo '&nbsp; &nbsp; &nbsp;<input name="Ver Temas" type="button" value ="Ver Temas" onClick="VerTemas('.$_REQUEST['registro_clase'].')" />';

echo "</div>";
echo "<br>";
?>
	
<form id = "datos" name= "datos"  action="ForosClasesLista.php" method="post">  
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
<input id = "operacion" name="operacion" type="hidden" value="<?php echo $_REQUEST['operacion'] ?>" />
<input id = "FechaFiltro" name="FechaFiltro" type="hidden" value="<?php echo $_REQUEST['FechaFiltro'] ?>" />
    
    
<?php
    //.................cabecera del fichero
    $query = 'show columns FROM forosclases';
    $datosLista = mysqli_query($conexion, $query);
	$nColumnas = mysqli_num_rows ($datosLista); 
    if ($nColumnas > 0) {
		$n = 0;
		
		 //echo "<br>COLUMNAS ...". $nColumnas;
		 while ($row = mysqli_fetch_assoc($datosLista)) {
			 //echo "  ".$row['Field'];
			 //echo "      ".$row['Type'];
			 $CampoMombre[$n] = $row['Field'];
			 //echo "<br>nombre de campo...". $CampoMombre[$n];
			 $CampoTipo[$row['Field']] = $row['Type'];
			 $n++;
		 }
	}
//..................................
$totMaestros = 0;
$FormatMaestros = "";
$queMaestros = ""; 
$resMaestros = 0;
if ($_REQUEST['alta'] == 1) {
		   for( $i = 0; $i < $nColumnas ; $i++ ) {
	       $complemento = "Baja";
		   if (esTextArea($CampoMombre[$i])) {
			   $complemento = "TextArea";
		   }
		   echo "<div class = rowEtiqueta".$complemento.">";
		    //.....................
	        echo "<div class = ClassVarcharEtiqueta".$complemento.">";
		    echo $CampoMombre[$i];
	        echo "</div>";
			//.....................
	      //.....................
	        echo "<div class = ClassVarcharDatos".$complemento.">";
			
		    //echo $rowRegistros[$CampoMombre[$i]];
			
			if ($CampoMombre[$i] == 'id_receta') {
				echo elinput($CampoMombre[$i],$_REQUEST['RecetaID'], $CampoTipo[$CampoMombre[$i]],$conexion);  
			} else {
				echo elinput($CampoMombre[$i], '', $CampoTipo[$CampoMombre[$i]],$conexion);
			}
			
			echo elfecha($CampoMombre[$i], $CampoTipo[$CampoMombre[$i]]);
			
	        echo "</div>";
			//.....................
	        echo "</div>"; 
	   } //for columns

	
} else {
   $FormatMaestros = "SELECT id, clase, descri_clase, orden, num_curso, num_temas, fecha_alta, fecha_baja, veces_visitado
						   FROM forosclases  
                           WHERE id = %d";
	//echo "<br>".$FormatMaestros."<br>";
   $queMaestros = sprintf($FormatMaestros, $_REQUEST['registro_clase']); 
    //echo "<br>".$queMaestros."<br>"; 
   //..........ejecutar query
   $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
   $totMaestros = mysqli_num_rows($resMaestros);
}
//echo "<br>totMaestros--->".$totMaestros;


if ($totMaestros> 0) {  //.....Registro de conexión
   while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {
	   for( $i = 0; $i < $nColumnas ; $i++ ) {
	   $complemento = "Baja";
		   if  (esTextArea($CampoMombre[$i]) ) {
			   $complemento = "TextArea";
		   }
		   echo "<div class = rowEtiqueta".$complemento.">";
		    //.....................
	        echo "<div class = ClassVarcharEtiqueta".$complemento.">";
		    echo $CampoMombre[$i];
	        echo "</div>";
			//.....................
	      //.....................
	        echo "<div class = ClassVarcharDatos".$complemento.">";
			
		    //echo $rowRegistros[$CampoMombre[$i]];
			echo elinput($CampoMombre[$i], $rowRegistros[$CampoMombre[$i]], $CampoTipo[$CampoMombre[$i]],$conexion);
			echo elfecha($CampoMombre[$i], $CampoTipo[$CampoMombre[$i]]);
	        echo "</div>";
			
			//.....................
	        echo "</div>"; 
	   } //for columns
   }     //while
}        //$totMaestros

echo "<br><br><br><div class ='TituloCurso' >";
echo '<input name="cancelar" type="button" value ="Cancelar" onClick="procesar(0)" />';
echo '<input name="enviar" type="button" value ="Grabar" onClick="procesar(1)" />';

echo "</div>";
echo "</form>";
mysqli_close($conexion);
?>




<script type="text/javascript"> 

<?php
   for( $i = 0; $i < $nColumnas ; $i++ ) {
	   if(esFecha($CampoTipo[$CampoMombre[$i]]) && $CampoMombre[$i] != "ultima_conexion") {
		 echo 'Calendar.setup({ inputField: "'.$CampoMombre[$i].'", ifFormat : "%Y-%m-%d",  button : "'."BOT".$CampoMombre[$i].'" }); ';   
	   
	   } 
   } 
?>




</script> 



</body>
</html>