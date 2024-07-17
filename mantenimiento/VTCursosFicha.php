<?php
session_start();
if ($_SESSION['es_admin'] != 1 ) {
     header("Location: ../index.php");
     exit;
}
include_once('../php/VTCursosScrip.php');
include_once('../conexion/conn_bbdd.php');
$numeroAvisosGrabar = 0;
$carpetaCurso = "";  
  $FormatVTCursos = "SELECT carpetadeficheros FROM vtcursos  where  id_curso = %d";
   $queVTCursos = sprintf($FormatVTCursos, $_REQUEST['registro']); 
   $resVTCursos = mysqli_query($conexion, $queVTCursos) or die(mysqli_error($conexion));
   $totVTCursos = mysqli_num_rows($resVTCursos);
   
   if ($totVTCursos> 0) {  //.....Registro de conexión
   	 while ($rowRegistros = mysqli_fetch_assoc($resVTCursos)) {
   	 	$carpetaCurso = $rowRegistros['carpetadeficheros'];
   	}
  }
mysqli_free_result($resVTCursos);
?>
<!doctype html>
<html lang="es">


<SCRIPT LANGUAGE="JavaScript"> 
	function VerCurso(numero){
		URL = "../paginas/VTCursoContenido.php?NumeroCurso="+numero;
		window.open(URL,"Contenido del VideoTutorial","width=1000,height=700,scrollbars=YES,resizable=YES,LEFT=200,TOP=100") 	
	}
	
	
	function GenerarCurso(numero) {
		URL = "../paginas/LaunchGeneradorPHP.php?NumeroCurso="+numero;
		window.open(URL,"Contenido del VideoTutorial","width=1000,height=700,scrollbars=YES,resizable=YES,LEFT=200,TOP=100") 	
	
	}
	
	function VerModulos(NdelCurso) {
	
		   document.getElementById('operacion').value = 'NADA';
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.getElementById('id_vtcurso').value = NdelCurso;
		   document.datos.action="VTModulosLista.php";
		   document.datos.submit();
	}
	
	function trim (myString)   {
     return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
    }

//................................................

	   function procesar(sino) {
		
		  if (sino == 1){
	         
	             if (trim(document.getElementById("id_categoria").value) < 1) {
	             	alert ("WARNING: Inquque a qué Categoria de cursos pertenece este");
	             }
	
	             if (trim(document.getElementById("titulo_cur").value).length < 5) {
	             	alert ("NO PROCESADO: Título demasiado cortO");
	             	return;
	             }
	             
	             if (document.getElementById("id_mailcomer").value < 1) {
	             	alert ("NO PROCESADO: Falta asignar el e-amil de contactos");
	             	return;
				 }
				 if (trim(document.getElementById("carpetadeficheros").value).length < 3) {
	             	alert ("NO PROCESADO: Nombre de la CARPETA DE FICHEROS demasiado corto");
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
		   //document.getElementById('id_categoria').value = document.getElementById('id_recetaseccion').value;
		   
		   
		   document.datos.submit();
	   }
	   
//................................
function goBack() {
    window.history.back();
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
<title>Cursos-Videotutoriales. Edición de Registros</title>
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
echo "<div class = 'TituloCurso' > Cursos-Videotutoriales Registro Núm ".$_REQUEST['registro'];
echo '&nbsp; &nbsp; &nbsp;<input name="Ver Curso" type="button" value ="Ver Curso" onClick="VerCurso('.$_REQUEST['registro'].')" />';
echo '&nbsp; &nbsp; &nbsp;<input name="Ver Modulos" type="button" value ="Ver Modulos" onClick="VerModulos('.$_REQUEST['registro'].')" />';
echo '&nbsp; &nbsp; &nbsp;<input name="GenerarCurso" type="button" value ="Generar Curso HTML" onClick="GenerarCurso('.$_REQUEST['registro'].')" />';
echo "</div>";
echo "<br>";

	
	echo '<form id = "datos" name= "datos" action="VTCursosLista.php" method="post">';
	echo '<input id = "operacion" name="operacion" type="hidden" value="nada" />';
	echo '<input id = "filtro" name="filtro" type="hidden" value="'. $_REQUEST['filtro'].'" />';
	echo '<input id = "id_vtcurso" name="id_vtcurso" type="hidden" value="'. $_REQUEST['id_vtcurso'].'" />'; /*para ligar sus hijos módulos vtcursomodulo*/
	echo '<input id = "registro" name="registro" type="hidden" value="'. $_REQUEST['registro'].'" />'; /*para volver a la página llamada,saber el registro o id*/
	echo '<input id = "volver_a" name="volver_a" type="hidden" value="VTCursosFicha.php" />'; /*para volver a la página llamada*/

	/*echo '<input id = "id_categoria" name="id_categoria" type="hidden" value="'.$_REQUEST['id_categoria'].'" />';*/
    //.................cabecera del fichero
    $query = 'show columns FROM vtcursos';
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


//echo "carpeta del curso---->".$carpetaCurso;
$totMaestros = 0;
$FormatMaestros = "";
$queMaestros = ""; 
$resMaestros = 0;
if ($_REQUEST['alta'] == 1) {

	$camposIniciales = "@id_curso@id_categoria@titulo_cur@id_mailcomer@carpetadeficheros";
	for( $i = 0; $i < $nColumnas ; $i++ ) {

		
	   if (strpos($camposIniciales,$CampoMombre[$i]) > 0) {	
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
			
			if ($CampoMombre[$i] == '***********id_categoria') {
				echo elinput($CampoMombre[$i],$_REQUEST['id_categoria'], $CampoTipo[$CampoMombre[$i]],$conexion,$carpetaCurso);  
			} else {
				echo elinput($CampoMombre[$i], '', $CampoTipo[$CampoMombre[$i]],$conexion,$carpetaCurso);
			}
			
			echo elfecha($CampoMombre[$i], $CampoTipo[$CampoMombre[$i]]);
			
	        echo "</div>";
			//.....................
	        echo "</div>"; 
		
		} else  {
			   $numeroAvisosGrabar++;
		       if ($numeroAvisosGrabar == 1 ){
		            echo "<div class = rowEtiquetaBaja> Es necesario grabar la carpeta en la que se alojará el curso. Después hay que modificar el registro para cumplimentar el resto de campos</div>"; 
			   }
		} // de campo inicial
	   
	  } //for columns

	
} else {
   $FormatMaestros = "SELECT id_curso, carpetadeficheros,  id_categoria, es_d_pago,  esta_activo,  orden,  titulo_cur, web_titulo, web_logosoftware,web_ficherophp, edicion,  descripcion_cur,  
imabackground_cur,  imaicono_cur,  videopresentacion,  programaPDF,  programasutilizados,  slogancomercial, proc_evaluacion, soporte,  
metodologia,  preciotutorial,  duracion,  id_mailcomer,  autores,  entidadescolaboradoras,  dirigidoa,  objetivos,  certificado_diploma, licencias_temporales, 
fecha_ini,  fecha_fin, tiene_descuento  FROM vtcursos  where  id_curso = %d";
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
echo '<input name="enviar" type="button" value ="Grabar" onClick="procesar(1)" />';

echo '&nbsp; &nbsp; &nbsp;<input name="Ver Modulos" type="button" value ="Ver Modulos" onClick="VerModulos('.$_REQUEST['registro'].')" />';
echo '&nbsp; &nbsp; &nbsp;<input name="GenerarCurso" type="button" value ="Generar Curso HTML" onClick="GenerarCurso('.$_REQUEST['registro'].')" />';
echo "</div>";
echo "<br><br>";

echo "</form>";

mysqli_close($conexion);
?>
<script type="text/javascript"> 

<?php

if ($numeroAvisosGrabar == 0) {
   for( $i = 0; $i < $nColumnas ; $i++ ) {
	   if(esFecha($CampoTipo[$CampoMombre[$i]])) {
		echo 'Calendar.setup({ inputField: "'.$CampoMombre[$i].'", ifFormat : "%Y-%m-%d",  button : "'."BOT".$CampoMombre[$i].'" }); ';   
	   } 
   } //de for campos
}
/*   Calendar.setup({ 
    inputField     :    "campo_fecha",     
     ifFormat     :     "%d/%m/%Y",    
     button     :    "lanzador"     
     }); */

?>




</script> 


<br><br><br>
</body>
</html>