<?php
session_start();
if ($_SESSION['es_admin'] != 1 && $_SESSION['es_colaborador'] != 1) {
     header("Location: ../index.php");
     exit;
}
if (!isset($_REQUEST['volver_a'])) {
	$_REQUEST['volver_a'] = "VTPermisosListaz.php";
} else {
	if ($_REQUEST['volver_a'] == "") {
		$_REQUEST['volver_a'] = "VTPermisosListaz.php";
	}
}
include_once('../php/VTPermisosScripz.php');
include_once('../conexion/conn_bbdd.php');
?>
<!doctype html>
<html lang="es">


<SCRIPT LANGUAGE="JavaScript"> 
	//function VerFicha(numero){
	//	URL = "../paginas/FichaDelCurso.php?NumeroCurso="+numero;
	//	window.open(URL,"Ficha Curso","width=1000,height=700,scrollbars=YES,resizable=YES,LEFT=200,TOP=100") 	
	//}
	
	function trim (myString)   {
     return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
    }

//................................................

	   function procesar(sino) {
		  if (sino == 1){
			  fecha = document.getElementById('fecha_ini').value;
			  if (fecha == "" || fecha == "0000-00-00" ) {
				  alert ("NO PROCESADO: Informe la fecha de inicio");	
				  return;			  
			  }
			  
			  
			  		 document.getElementById('usuarioperdido').value = document.getElementById('id_usuario').value ;

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

    </SCRIPT>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Alumnos inscritos a Videotutoriales. Edición de Registros</title>
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
    echo $tags2[$i]."=".$valores2[$i]."   "; 
}
*/

 



if ($_REQUEST['alta'] == 1) {
	echo '<p class = "rojo">No tiene mucho sentido dar un ALTA manual, se hace si el alumno te ha pagado por transferencia y deseas otorgarle maualmente los permisos</p>';
}


echo "<div class = 'TituloCurso' > Permisos de alumnos Registro Núm ".$_REQUEST['registro'];
echo "</div>";
echo "<br>";

	
	echo '<form id = "datos" name= "datos" action="VTPermisosListaz.php" method="post">';
	echo '<input id = "operacion" name="operacion" type="hidden" value="nada" />';
	echo '<input id = "filtro" name="filtro" type="hidden" value="'. $_REQUEST['filtro'].'" />';
	/*echo '<input id = "CursoID" name="CursoID" type="hidden" value="'.$_REQUEST['CursoID'].'" />';*/
	echo '<input id = "FechaFiltro" name="FechaFiltro" type="hidden" value="'.$_REQUEST['FechaFiltro'].'" />';
    echo '<input id = "volver_a" name="volver_a" type="hidden" value="'. $_REQUEST['volver_a'].'" />'; /*para volver a la página llamada,saber el registro o id*/
	echo '<input id = "usuarioperdido" name="usuarioperdido" type="hidden" value="'. $_REQUEST['id_usuario'].'" />';

    //.................cabecera del fichero
    $query = 'show columns FROM vtpermisos';
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
			
			if ($CampoMombre[$i] == 'id_usuario') {
				echo elinput($CampoMombre[$i],$_REQUEST['id_usuario'], $CampoTipo[$CampoMombre[$i]],$conexion);  
			} else {
				echo elinput($CampoMombre[$i], '', $CampoTipo[$CampoMombre[$i]],$conexion);
			}
			
			echo elfecha($CampoMombre[$i], $CampoTipo[$CampoMombre[$i]]);
			
	        echo "</div>";
			//.....................
	        echo "</div>"; 
	   } //for columns

	
} else {
   $FormatMaestros = "SELECT  id, id_cobro, id_usuario, id_curso, fecha_ini, fecha_fin, fecha_solici_certifi, fecha_entreg_certifi
						   FROM vtpermisos   
                           WHERE id = %d";
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
	   if(esFecha($CampoTipo[$CampoMombre[$i]])) {
		echo 'Calendar.setup({ inputField: "'.$CampoMombre[$i].'", ifFormat : "%Y-%m-%d",  button : "'."BOT".$CampoMombre[$i].'" }); ';   
	   } 
   } //de for campos
   
/*   Calendar.setup({ 
    inputField     :    "campo_fecha",     
     ifFormat     :     "%d/%m/%Y",    
     button     :    "lanzador"     
     }); */

?>




</script> 



<?php

echo"</br>";
echo"</br>";
echo"</br>";
echo"</br>";
echo"</br>";
echo"</br>";
echo"</br>";
echo"</br>";
echo"</br>";
echo"</br>";
echo"</br>";
echo"</br>";

echo"<h2>ID_CURSO  RECORDATORIO DE LISTA DE CURSOS DISPONIBLES</h2>";

echo"<ul>";
  echo"<li>CURSO 3: ESTRUCTURAS DE HORMIGÓN   ID_CURSO</li>";
  echo"<li>CURSO 4: ESTRUCTURAS METÁLICAS  ID_CURSO</li>";
  echo"<li>CURSO 5: VIVIENDA UNIFAMILIAR ID_CURSO</li>";
  echo"<li>CURSO 6: ESTRUCTURA MIXTA ID_CURSO</li>";
  echo"<li>CURSO 7: MAMPOSTERIA ID_CURSO</li>";
  echo"<li>CURSO 8: INSTALACIONES ID_CURSO</li>";
  echo"<li>CURSO 9: GRATUITO: REVISIÓN DE PROYECTOS EJECUTADOS ID_CURSO</li>";
  echo"<li>CURSO 10: PUENTE GRUA ID_CURSO</li>";
  echo"<li>CURSO 11: PUSHOVER ID_CURSO</li>";
  echo"<li>CURSO 12: CURSO NUEVO CYPE 2022 ID_CURSO</li>";
  
  
echo"</ul>";



?>








</body>
</html>