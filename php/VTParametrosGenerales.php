<?php
session_start();

if ($_SESSION['es_admin'] != 1 ) {
     header("Location: ../index.php");
     exit;
}
$_REQUEST['alta'] = 0;
$_REQUEST['ID'] = 1;
include_once('../php/VTParametrosGeneralesScrip.php');
?>
<!doctype html>
<html lang="es">

<SCRIPT LANGUAGE="JavaScript"> 
function procesar(sino) {
		  if (sino == 1){
			  document.getElementById('operacion').value =<?php
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

    </SCRIPT>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Edición Parámetros Generales Aplicación</title>
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
echo "<div class = TituloRegistro > Parámetros Generales Aplicación </div>";
echo "<div class ='clear'></div>";
echo "Los logos estarán en la carpeta--> imagenes/logos/";
	include_once('../conexion/conn_bbdd.php');
	ActualizaDatos($conexion);
	echo '<form id = "datos" name= "datos" action="VTParametrosGenerales.php" method="post">';
	echo '<input id = "operacion" name="operacion" type="hidden" value="nada" />';
	echo '<input id = "ID" name="ID" type="hidden" value="'.$_REQUEST['ID'].'" />';
    //.................cabecera del fichero
    $query = 'show columns FROM  vtparamdatosweb';
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
			
			if ($CampoMombre[$i] == 'id') {
				echo elinput($CampoMombre[$i],$_REQUEST['ID'], $CampoTipo[$CampoMombre[$i]],$conexion);  
			} else {
				echo elinput($CampoMombre[$i], '', $CampoTipo[$CampoMombre[$i]],$conexion);
			}
			echo elfecha($CampoMombre[$i], $CampoTipo[$CampoMombre[$i]]);
			
	        echo "</div>";
			//.....................
	        echo "</div>"; 
	   } //for columns

	
} else {
   $FormatMaestros = "SELECT id,
                      web_dominio,
                      web_url,
                      mapslocalizacion, 
                      registro_mercantil, 
                      tituloacademico, 
                      colegioprofesional, 
                      num_colegiado, 
                      tribunal_legislacion,
                      tribunal_provincia, 
                      nif, 
                      finalidadweb, 
                      web_logocolor,
                      web_logoblanco,
                      web_logoforo,
                      descuento_activo,
                      web_usuarioskype, 
                      web_tfnWhatsapp,
                      web_facebook,
                      web_instagram,
                      web_youtube,
                      web_twitter,
                      carta_logo,
                      carta_funcionempresa,
                      carta_direcc1,
                      carta_direcc2,
                      carta_codpostal,
                      carta_poblacion,
                      carta_pais,
                      numeroprimo, 
                      curso_en_promocion,
                      moneda,
                      idioma,
                      codigo_tagmanager,
                      codigo_analytics,
                      landing_reducida, 
                      favicon_32,
                      favicon_120,
                      favicon_152                
                      FROM vtparamdatosweb
                      WHERE id = 1";

    //echo "<br>".$FormatMaestros."<br>";
  // $queMaestros = sprintf($FormatMaestros, $_REQUEST['registro']); 

    //..........ejecutar query
   $queMaestros = $FormatMaestros;

    //echo "<br>".$queMaestros."<br>"; 
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
echo "<div class ='clear'></div>";
echo "<br><div class ='TituloRegistro' >";
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