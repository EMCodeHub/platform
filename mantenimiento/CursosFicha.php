<?php
session_start();
if ($_SESSION['es_admin'] != 1 ) {
     header("Location: ../index.php");
     exit;
}
include_once('../php/CursosScrip.php');
include_once('../conexion/conn_bbdd.php');;
?>
<!doctype html>
<html lang="es">


<SCRIPT LANGUAGE="JavaScript"> 
	function VerFicha(numero){
		URL = "../paginas/FichaDelCurso.php?NumeroCurso="+numero;
		window.open(URL,"Ficha Curso","width=1000,height=700,scrollbars=YES,resizable=YES,LEFT=200,TOP=100") 	
	}
	
	function trim (myString)   {
     return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
    }

//................................................

	   function procesar(sino) {
	   	
		
		  if (sino == 1){
		  	
		  		   //..........alguna verificacion..................
	             if (trim(document.getElementById("esta_activo").value) == 0) {
	             	alert ("WARNING: El curso no esa activo");
	             
	             }
	             	document.g
	             if (trim(document.getElementById("referencia").value).length < 3) {
	             	alert ("NO PROCESADO: Referencia demasiado corta");
	             	return;
	             	
	             }
	             
	            
	             if (document.getElementById("ponente").value =="" ) {
	             	alert ("NO PROCESADO: Nombre del ponente es corto");
	             	return;
	             	
	             }
	           
	             
	               if (trim(document.getElementById("titulo_abreviado").value).length < 3) {
	             	alert ("NO PROCESADO: Informe el titulo abreviado");
	             	return;
	             	
	             }
				 
	            
	             if (trim(document.getElementById("horario").value).length < 2) {
	             	alert ("NO PROCESADO: Informe el horario, o entre puntos o rayas, pero mayor de 2 caracteres");
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
<title>Cursos. Edición de Registros</title>
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
echo "<div class = 'TituloCurso' > Cursos Registro Núm ".$_REQUEST['registro'];
echo '&nbsp; &nbsp; &nbsp;<input name="Ver Ficha" type="button" value ="Ver Ficha" onClick="VerFicha('.$_REQUEST['registro'].')" />';
echo "</div>";
echo "<br>";

	
	echo '<form id = "datos" name= "datos" action="CursosLista.php" method="post">';
	echo '<input id = "operacion" name="operacion" type="hidden" value="nada" />';
	echo '<input id = "filtro" name="filtro" type="hidden" value="'. $_REQUEST['filtro'].'" />';
	echo '<input id = "RecetaID" name="RecetaID" type="hidden" value="'.$_REQUEST['RecetaID'].'" />';
	echo '<input id = "SeccionID" name="SeccionID" type="hidden" value="'.$_REQUEST['SeccionID'].'" />';
    //.................cabecera del fichero
    $query = 'show columns FROM cursos';
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
   $FormatMaestros = "SELECT id, referencia, esta_activo, fecha_ini, fecha_fin, ponente, id_mailcomer, id_organizador, titulo_abreviado, titulo_corto, 
titulo_largo, id_tipocurso, id_modalidad, id_periodicidad, horario, num_horas_curso, programas_utili, precio, forma_pago, 
plazas_aprox, programa_pdf, documentos_pdf, carta_inscripcion, observaciones      from cursos  where id = %d";
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

echo "<br><div class ='TituloCurso' >";
echo '<input name="cancelar" type="button" value ="Cancelar" onClick="procesar(0)" />';
echo '<input name="enviar" type="button" value ="Grabar" onClick="procesar(1)" />';

echo '&nbsp; &nbsp; &nbsp;<input name="Ver Ficha" type="button" value ="Ver Ficha" onClick="VerFicha('.$_REQUEST['registro'].')" />';



echo "<div>";
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



</body>
</html>