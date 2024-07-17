<?php
session_start();
if ($_SESSION['es_admin'] != 1 && $_SESSION['es_colaborador'] != 1) {
     header("Location: ../index.php");
     exit;
}
if (!isset($_REQUEST['volver_a'])) {
	$_REQUEST['volver_a'] = "VTAlumnosListaz.php";
} else {
	if ($_REQUEST['volver_a']="") {
	    $_REQUEST['volver_a'] = "VTAlumnosListaz.php";	
	}
}
include_once('../php/VTAlumnosScripz.php');
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
			  
		  		 if (trim(document.getElementById("pwd").value).length < 5) {
	             	alert ("NO PROCESADO: (pwd) Indique una password de 6 o más caracteres");
					      document.getElementById("pwd").focus();
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
		   document.getElementById('filtro').value = "FILTRO_ID";  
		   //document.getElementById('SeccionID').value = document.getElementById('id_recetaseccion').value;
		   document.datos.submit();
		   	
	   }
	   
	//.........................
	   function VerPermisos(registro) {
		   document.getElementById("volver_a").value = "VTAlumnosFichaz.php?registro="+registro;
		   document.getElementById('operacion').value = 'NADA';
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action="VTPermisosListaz.php";
		   document.datos.submit();

		   
	   }
	   	//.........................
	   function VerActividad(registro) {
		   document.getElementById("volver_a").value = "VTAlumnosFichaz.php?registro="+registro;
		   document.getElementById('operacion').value = 'NADA';
		   document.getElementById('filtro').value = "FILTRO_ID";
		   URL = "ActividadAlumno.php?NumeroAlumno="+registro;
	       window.open(URL,"Registro actividad alumno","width=1000,height=700,scrollbars=YES,resizable=YES,LEFT=200,TOP=100") 	

   
	   }
//................................
function Posicionate() {
	document.getElementById("email").focus(); 
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


echo "<div class = 'TituloCurso' > Alumnos de Videotutoriales Registro Núm ".$_REQUEST['registro'];
echo '&nbsp; &nbsp; &nbsp;<input name="Ver Permisos" type="button" value ="Ver Permisos" onClick="VerPermisos('.$_REQUEST['registro'].')" />';
echo '&nbsp; &nbsp; &nbsp;<input name="Ver Actividad" type="button" value ="Ver Actividad" onClick="VerActividad('.$_REQUEST['registro'].')" />';

echo "</div>";
echo "<br>";

	
	echo '<form id = "datos" name= "datos" action="VTAlumnosListaz.php" method="post">';
	echo '<input id = "operacion" name="operacion" type="hidden" value="nada" />';
	echo '<input id = "filtro" name="filtro" type="hidden" value="'. $_REQUEST['filtro'].'" />';
	
	
	
	echo '<input id = "CursoID" name="CursoID" type="hidden" value="'.$_REQUEST['CursoID'].'" />';
	
	
	
	echo '<input id = "FechaFiltro" name="FechaFiltro" type="hidden" value="'.$_REQUEST['FechaFiltro'].'" />';
    echo '<input id = "volver_a" name="volver_a" type="hidden" value="'. $_REQUEST['volver_a'].'" />'; /*para volver a la página llamada,saber el registro o id*/
    echo '<input id = "id_usuario" name="id_usuario" type="hidden" value="'. $_REQUEST['registro'].'" />'; /*para filtrar la lista de permisos en VTPermisosLista*/

    //.................cabecera del fichero
    $query = 'show columns FROM vtalumnos';
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
   $FormatMaestros = "SELECT  id, es_adm, es_colaborador, telefono, pais, ciudad, skype_usuario, agente, email, pwd, nombre, apellidos,fecha_alta, fecha_baja, observaciones_medif,tipoalumno, ultima_ip, ultima_conexion, recibir_mails, alias_foro, alias_comment,bloquear_foro, mensajes_foro  
						   FROM vtalumnos   
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
	   if(esFecha($CampoTipo[$CampoMombre[$i]]) && $CampoMombre[$i] != "ultima_conexion") {
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



</body>
</html>