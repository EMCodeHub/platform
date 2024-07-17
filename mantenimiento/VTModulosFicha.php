<?php
session_start();
if ($_SESSION['es_admin'] != 1 ) {
     header("Location: ../index.php");
     exit;
}
include_once('../php/VTModulosScrip.php');
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


<SCRIPT LANGUAGE="JavaScript"> 
	function VerBloques(){
		
		   document.getElementById('operacion').value = 'NADA';
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.getElementById('registro').value = document.getElementById('id_modulo').value;
		   document.getElementById('id_vtcurmodulo').value = document.getElementById('id_modulo').value;
		   document.getElementById('volver_a').value = "VTModulosFicha.php";
		   document.datos.action="VTBloquesLista.php";
		   document.datos.submit();

	}
	function volver() {
		<?php if ($_REQUEST['volver_a'] != "") { ?>
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action="VTModulosLista.php";
		   
		   document.datos.submit();
		 <?php } else { ?>
		   location.href='VTModulosLista.php';
		   <?php }?> 
		   
	   }
	
	function trim (myString)   {
     return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
    }

//................................................

	   function procesar(sino) {
		
		  if (sino == 1){
	          if (document.getElementById("esta_activo").value < 1) {
	             	alert ("Módulo NO Activo");
	             	
	             }
	            
	
	             if (trim(document.getElementById("titulo_mod").value).length < 5) {
	             	alert ("NO PROCESADO: Título demasiado cortO");
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
	document.getElementById('esta_activo').focus();
}
    </SCRIPT>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Módulos-Videotutoriales. Edición de Registros</title>


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
}*/

?>


<table width="90%" border="0">
  <tr>
    <td class="informacionFicheros" width="6%">CURSO:</td>
    <td class="informacionFicheros" width="92%"><?php echo DescripcionCurso($_REQUEST['id_vtcurso'] ,$conexion);?>	</td>
  </tr>
    <tr>
    <td class="informacionFicheros" width="6%">MÓDULO:</td>
    <td class="informacionFicheros" width="92%"><?php echo "En pantalla .............";?>	</td>
  </tr>
</table>



<a href="Javascript:volver()">Volver</a>
<br />

<?php
echo "<div class = 'TituloCurso' > Modulos-Videotutoriales Registro Núm ".$_REQUEST['registro'];
echo '&nbsp; &nbsp; &nbsp;<input name="Ver Bloques" type="button" value ="Ver Bloques" onClick="VerBloques()" />';
echo "</div>";
echo "<br>";

	
	echo '<form id = "datos" name= "datos" action="VTModulosLista.php" method="post">';
	echo '<input id = "operacion" name="operacion" type="hidden" value="nada" />';
	echo '<input id = "filtro" name="filtro" type="hidden" value="'. $_REQUEST['filtro'].'" />';
	
	echo '<input id = "registro" name="registro" type="hidden" value="'. $_REQUEST['registro'].'" />'; /*para volver a la página llamada,saber el registro o id*/
	echo '<input id = "volver_a" name="volver_a" type="hidden" value="'. $_REQUEST['volver_a'].'" />'; /*para volver a la página llamada,saber el registro o id*/
    echo '<input id = "id_vtcurmodulo" name="id_vtcurmodulo" type="hidden" value="'. $_REQUEST['id_vtcurmodulo'].'" />'; /*para volver a la página llamada,saber el registro o id*/
	
	/*echo '<input id = "id_categoria" name="id_categoria" type="hidden" value="'.$_REQUEST['id_categoria'].'" />';*/
    //.................cabecera del fichero
    $query = 'show columns FROM vtcursomodulo';
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
			
			if ($CampoMombre[$i] == 'id_vtcurso') {
				echo elinput($CampoMombre[$i],$_REQUEST['id_vtcurso'], $CampoTipo[$CampoMombre[$i]],$conexion);  
			} else {
				echo elinput($CampoMombre[$i], '', $CampoTipo[$CampoMombre[$i]],$conexion);
			}
			
			echo elfecha($CampoMombre[$i], $CampoTipo[$CampoMombre[$i]]);
			
	        echo "</div>";
			//.....................
	        echo "</div>"; 
	   
	  } //for columns

	
} else {
	
   $FormatMaestros = "SELECT id_modulo, id_vtcurso, esta_activo, orden_mod, titulo_mod FROM vtcursomodulo  where  id_modulo = %d";
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
echo '<input name="Grabar" type="button" value ="Grabar" onClick="procesar(1)" />';



echo "<div>";
echo "</form>";
mysqli_close($conexion);
?>



</body>
</html>