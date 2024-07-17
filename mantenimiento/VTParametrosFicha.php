<?php
session_start();
if ($_SESSION['es_admin'] != 1 ) {
     header("Location: ../index.php");
     exit;
}
include_once('../php/VTParametrosScrip.php');
include_once('../conexion/conn_bbdd.php');

if ($_REQUEST['operacion'] == "UPDATE"){
	$query = 'show columns FROM vtparametros';
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
    $FormatMaestros = "UPDATE  vtparametros SET ";
    $n = 0;
	$ValorGrabar = "";
    for( $i = 0; $i < $nColumnas ; $i++ ) {
	     if($n == 0){
		    $coma = "";
	     } else {
		    $coma = ", ";
	     }
	     $ValorGrabar =  ValorVacioOk($_REQUEST[$CampoMombre[$i]],  $CampoTipo[$CampoMombre[$i]]);
	     $FormatMaestros = $FormatMaestros.$coma.$CampoMombre[$i]." = ".$ValorGrabar." ";
	     $n++;
    }

    $FormatMaestros = $FormatMaestros." WHERE  id  = 1";
	
	
	$resMaestros = mysqli_query($conexion, $FormatMaestros) or die(mysqli_error($conexion));
    mysqli_free_result($resMaestros);
   
    header("Location: mantenimiento.php");
     exit;  
	
} 





?>
<!doctype html>
<html lang="es">


<SCRIPT LANGUAGE="JavaScript"> 

	
	function trim (myString)   {
     return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
    }

//................................................

	   function procesar(sino) {
		
		  if (sino == 1){
	         
	          
				 if (document.getElementById("recibir_mail_intentos_pago").value != 1) {
	             	alert ("WARNING: No se recibirán correos de intentos de pago de los clientes, cuando indican que desean pagar");
	             } else {
					 
				 }
	
	             if (trim(document.getElementById("transfer_cuenta").value).length < 5) {
	             	alert ("WARNING: Informe los datos de la transferencia");
	             	
	             }
	             
	            
				document.getElementById('operacion').value = "UPDATE";
			    
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

    </SCRIPT>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Videotutoriales. Edición de Parámetros </title>
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

<a href="mantenimiento.php">Volver</a>
<br />

<?php
    echo "<div class = 'TituloCurso' > Parámetros Cobro Videotutoriales</div>";
    echo "<br>";

	
	echo '<form id = "datos" name= "datos" action="VTParametrosFicha.php" method="post">';
	echo '<input id = "operacion" name="operacion" type="hidden" value="nada" />';

    $query = 'show columns FROM vtparametros';
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

$FormatMaestros = "SELECT id, dto_maximo, precio_asesoria, twocheck_activo, recibir_mail_intentos_pago, twocheck_notif, 
                           twocheck_respuesta, twocheck_respnocurso, twocheck_notif, twocheck_real_inicio, twocheck_real_id, 
                           twocheck_real_word, transfer_cuenta, transfer_entidad, transfer_obser, transfer_beneficiario
                     FROM vtparametros
                     WHERE id = 1";
	//echo "<br>".$FormatMaestros."<br>";
   $queMaestros = sprintf($FormatMaestros); 
    //echo "<br>".$queMaestros."<br>"; 
   //..........ejecutar query
   $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
   $totMaestros = mysqli_num_rows($resMaestros);

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