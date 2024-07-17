<?php
session_start();
if ($_SESSION['es_admin'] != 1 && $_SESSION['es_colaborador'] != 1) {
     header("Location: ../index.php");
     exit;
}
include_once('../php/VTTipoAlumnoScrip.php');
include_once('../conexion/conn_bbdd.php');

if (!isset($_REQUEST['volver_a'])) {
	$_REQUEST['volver_a'] = "";
}




if (!isset($_REQUEST['id_vtcurmodulo'])) {
	$_REQUEST['id_vtcurmodulo'] = 0;
}


?>
<!doctype html>
<html lang="es">


<script> 


	function volver() {
		<?php if ($_REQUEST['volver_a'] != "") { ?>
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action="VTTipoAlumnoLista.php";
		   
		   document.datos.submit();
		 <?php } else { ?>
		   location.href='VTTipoAlumnoLista.php';
		   <?php }?> 
		   
	   }
	
	function trim (myString)   {
     return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
    }

//................................................

	   function procesar(sino) {
		
		  if (sino == 1){
	
	             if (trim(document.getElementById("descripcion").value).length < 10) {
	             	alert ("NO PROCESADO: descripcon demasiado corta");
	             	return;
	             }
	             
	             if (trim(document.getElementById("orden").value) < 1) {
	             	alert ("NO PROCESADO: orden debe ser superior a 1");
	             	return;
	             }

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
		 document.datos.submit();
	   }
	   
//................................

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
function posicionate() {
	document.getElementById('descripcion').focus();
}
</script>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Tipos de lead-Alumno-Videotutoriales. Edición de Registros</title>

<!-- ESTILOS PROPIOS-->     
<link href="../css/estilosMantenimiento.css" rel="stylesheet" type="text/css" />

</head>

<body onLoad="javascrip:posicionate()">



<?php
/*$numero2 = count($_POST);
$tags2 = array_keys($_POST); // obtiene los nombres de las varibles
$valores2 = array_values($_POST);// obtiene los valores de las varibles

// crea las variables y les asigna el valor
for($i=0;$i<$numero2;$i++){ 
    echo $tags2[$i]."=".$valores2[$i]."   "; 
}
echo "<br>carpetaFicheros--->".$carpetaCurso."<br>";
*/
?>

<a href="Javascript:volver()">Volver</a>
<br />

<?php
echo "<div class = 'TituloCurso' > Tipos Alumnos-Videotutoriales Registro Núm ".$_REQUEST['registro'];
echo "</div>";
echo "<br>";

	
	echo '<form id = "datos" name= "datos" action="VTTipoAlumnoLista.php" method="post">';
	echo '<input id = "operacion" name="operacion" type="hidden" value="nada" />';
	echo '<input id = "filtro" name="filtro" type="hidden" value="'. $_REQUEST['filtro'].'" />';
	
	echo '<input id = "registro" name="registro" type="hidden" value="'. $_REQUEST['registro'].'" />'; /*para volver a la página llamada,saber el registro o id*/
	echo '<input id = "volver_a" name="volver_a" type="hidden" value="'. $_REQUEST['volver_a'].'" />'; /*para volver a la página llamada,saber el registro o id*/
	echo '<input id = "id_vtcurmodbloque" name="id_vtcurmodbloque" type="hidden" value="0" />'; /*para volver a la página llamada,saber el registro o id*/

	
	/*echo '<input id = "id_categoria" name="id_categoria" type="hidden" value="'.$_REQUEST['id_categoria'].'" />';*/
    //.................cabecera del fichero
    $query = 'show columns FROM vttipoalumno';
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
			
			if ($CampoMombre[$i] == '*****id_vtcurmodulo') {
				echo elinput($CampoMombre[$i],$_REQUEST['id_vtcurmodulo'], $CampoTipo[$CampoMombre[$i]],$conexion,$carpetaCurso);  
			} else {
				echo elinput($CampoMombre[$i], '', $CampoTipo[$CampoMombre[$i]],$conexion,$carpetaCurso);
			}
			
			echo elfecha($CampoMombre[$i], $CampoTipo[$CampoMombre[$i]]);
			
	        echo "</div>";
			//.....................
	        echo "</div>"; 
	   
	  } //for columns

	
} else {
	
   $FormatMaestros = "SELECT id, descripcion, conceptoalumno, orden, calculo_automatico,es_alumno_pago, landingpage, descuento_sobre_restocursos, descuento_sobre1curso 
                      FROM vttipoalumno  
                      WHERE  id = %d";
	//echo "<br>".$FormatMaestros."<br>";
   $queMaestros = sprintf($FormatMaestros, $_REQUEST['registro']); 
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
			echo elinput($CampoMombre[$i], $rowRegistros[$CampoMombre[$i]], $CampoTipo[$CampoMombre[$i]],$conexion,$carpetaCurso);
			echo elfecha($CampoMombre[$i], $CampoTipo[$CampoMombre[$i]]);
	        echo "</div>";
			
			//.....................
	        echo "</div>"; 
	   } //for columns
   }     //while
}        //$totMaestros

echo "<br><div class ='TituloCurso' >";
echo '<input name="cancelar" type="button" value ="Cancelar" onClick="procesar(0)" />';
echo '<input name="Grabar" type="button" value ="Grabar" onClick="procesar(1)" />';


echo "<div>";
echo "</form>";
mysqli_close($conexion);
?>




</body>
</html>