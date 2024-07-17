<?php
session_start();
if ($_SESSION['es_admin'] != 1 ) {
     header("Location: ../index.php");
     exit;
}
include_once('../php/VTTemasScrip.php');
include_once('../conexion/conn_bbdd.php');

if (!isset($_REQUEST['volver_a'])) {
	$_REQUEST['volver_a'] = "";
}
if (!isset($_REQUEST['id_vtcurmodbloque'])) {
	$_REQUEST['id_vtcurmodbloque'] = 0;
}
  $carpetaCurso = "";  
  
  if ($_REQUEST['id_vtcurmodbloque'] >0) {
  
    $FormatVTCursos = "SELECT carpetadeficheros 
                         FROM  vtcursos, vtcursomodulo, vtcurmodbloque
					     WHERE  vtcursomodulo.id_vtcurso = vtcursos.id_curso
					     and    vtcurmodbloque.id_vtcurmodulo = vtcursomodulo.id_modulo
					     and  id_bloque = %d";
    $queVTCursos = sprintf($FormatVTCursos, $_REQUEST['id_vtcurmodbloque']); 
  } else {
	  $FormatVTCursos = "SELECT carpetadeficheros 
                         FROM   vtcursos, vtcursomodulo, vtcurmodbloque,vtcurmodbloqtema
					     WHERE  vtcursomodulo.id_vtcurso = vtcursos.id_curso
					     and    vtcurmodbloque.id_vtcurmodulo = vtcursomodulo.id_modulo
						 and    vtcurmodbloqtema.id_vtcurmodbloque = vtcurmodbloque.id_bloque 
					     and    id = %d";
	  $queVTCursos = sprintf($FormatVTCursos, $_REQUEST['registro']); 				  
  }
					  
   
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
	function volver() {
		<?php if ($_REQUEST['volver_a'] != "") { ?>
		   document.getElementById('filtro').value = "FILTRO_ID";
		   document.datos.action="VTTemasLista.php";
		   //document.getElementById('registro').value = document.getElementById('id_vtcurmodbloque').value ;
		   document.datos.submit();
		 <?php } else { ?>
		   location.href='VTTemasLista.php';
		   <?php }?> 
		   
	   }
	
	function trim (myString)   {
     return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
    }

//................................................

	   function procesar(sino) {
		
		  if (sino == 1){
			  
			     if (document.getElementById("esta_activo").value < 1) {
	             	alert ("Tema NO Activo");
	             	
	             }
				  if (document.getElementById("es_de_pago").value < 1) {
	             	alert ("Fichero GRATIS, no es de pago");
	             	
	             }
			  
	             if (trim(document.getElementById("titulo_tema").value).length < 5) {
	             	alert ("NO PROCESADO: Título demasiado corto");
	             	return;
	             }
	            
				 
				 if (trim(document.getElementById("ficheroPDF").value).length < 5) {
	             	alert ("NO PROCESADO: Nombre del fichero asociado muy corto");
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
<title>Temas-Videotutoriales. Edición de Registros</title>

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



   <?php
      if ($_REQUEST['id_vtcurmodbloque'] !=0) {
   ?>	   
<table width="90%" border="0">
  <tr>
    <td class="informacionFicheros" width="7%"><b>CURSO:</b></td>
    <td class="informacionFicheros" width="92%"><?php echo Descripcion2Curso($_REQUEST['id_vtcurmodbloque'] ,$conexion);?>	</td>
  </tr>
  <tr>
    <td class="informacionFicheros" width="7%"><b>MÓDULO:</b></td>
    <td class="informacionFicheros" width="92%"><?php echo Descripcion2Modulo($_REQUEST['id_vtcurmodbloque'] ,$conexion);?>	</td>
  </tr>
  <tr>
    <td class="informacionFicheros" width="7%"><b>BLOQUE:</b></td>
    <td class="informacionFicheros" width="92%"><?php echo Descripcion2Bloque($_REQUEST['id_vtcurmodbloque'] ,$conexion);?>	</td>
  </tr>
  <tr>
    <td class="informacionFicheros" width="7%"><b>TEMA:</b></td>
    <td class="informacionFicheros" width="92%"><?php echo "En pantalla .....(Gereralmente un fichero PDF, puede ser de otro tipo) .....";?>	</td>
  </tr>

</table>

   <?php
     } else {
   ?>
   <table width="90%" border="0">
  <tr>
    <td class="informacionFicheros" width="7%"><b>CURSO:</b></td>
    <td class="informacionFicheros" width="92%"><?php echo Descripcion3Curso($_REQUEST['registro'] ,$conexion);?>	</td>
  </tr>
  <tr>
    <td class="informacionFicheros" width="7%"><b>MÓDULO:</b></td>
    <td class="informacionFicheros" width="92%"><?php echo Descripcion3Modulo($_REQUEST['registro'] ,$conexion);?>	</td>
  </tr>
  <tr>
    <td class="informacionFicheros" width="7%"><b>BLOQUE:</b></td>
    <td class="informacionFicheros" width="92%"><?php echo Descripcion3Bloque($_REQUEST['registro'] ,$conexion);?>	</td>
  </tr>

</table>

   <?php
     } 
   ?>

<a href="Javascript:volver()">Volver</a>
<br />

<?php
echo "<div class = 'TituloCurso' > TEMAS-Videotutoriales Registro Núm ".$_REQUEST['registro'];
echo "</div>";
echo "<br>";

	
	echo '<form id = "datos" name= "datos" action="VTTemasLista.php" method="post">';
	echo '<input id = "operacion" name="operacion" type="hidden" value="nada" />';
	echo '<input id = "filtro" name="filtro" type="hidden" value="'. $_REQUEST['filtro'].'" />';
	
	echo '<input id = "registro" name="registro" type="hidden" value="'. $_REQUEST['registro'].'" />'; /*para volver a la página llamada,saber el registro o id*/
	echo '<input id = "volver_a" name="volver_a" type="hidden" value="'. $_REQUEST['volver_a'].'" />'; /*para volver a la página llamada,saber el registro o id*/

	
	/*echo '<input id = "id_categoria" name="id_categoria" type="hidden" value="'.$_REQUEST['id_categoria'].'" />';*/
    //.................cabecera del fichero
    $query = 'show columns FROM vtcurmodbloqtema';
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
			
			if ($CampoMombre[$i] == 'id_vtcurmodbloque') {
				echo elinput($CampoMombre[$i],$_REQUEST['id_vtcurmodbloque'], $CampoTipo[$CampoMombre[$i]],$conexion,$carpetaCurso);  
			} else {
				echo elinput($CampoMombre[$i], '', $CampoTipo[$CampoMombre[$i]],$conexion,$carpetaCurso);
			}
			
			echo elfecha($CampoMombre[$i], $CampoTipo[$CampoMombre[$i]]);
			
	        echo "</div>";
			//.....................
	        echo "</div>"; 
	   
	  } //for columns

	
} else {
	
   $FormatMaestros = "SELECT id, esta_activo, id_vtcurmodbloque, orden_tema, titulo_tema, es_de_pago, ficheroPDF FROM vtcurmodbloqtema  where  id = %d";
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