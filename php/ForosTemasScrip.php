<?php

include_once ('FicherosFunciones.php');
///////////////Otras ////////////////////////////////////
function comas($cadena) {

return "'".$cadena."'";
}

///////////////Maestros ficha ////////////////////////////////////
function elfecha($nombre,$tipo) {
	$devolver ="";
	$pos = strpos($tipo,'date');
	if ($pos !== false) {
		$devolver = '<input type="button" id="'."BOT".$nombre.'" value="..." />'; 
		
	}
	return $devolver;
}
///////////////Maestros ficha ////////////////////////////////////
function esFecha($tipo){
$pos = strpos($tipo,'date');
	if ($pos !== false) {
		return TRUE;
	}	
	return false;
}

///////////////////////////////////////////////////
function esTextArea($nombre) {

	if ($nombre == 'tema'){
		return TRUE;
	}
	return false;
}
///////////////////////////////////////////////////
function elinput($nombre, $valor,$tipo,$conexion) {
	$carpeta = "";
	$readonly = "";
	$inicio = strpos($tipo,'(');
	$final   =strpos($tipo,')');
	$long = 12;
	if ($nombre == 'id') {
		$readonly = "READONLY";
	}
	if ($nombre == 'veces_visitado') {
		$readonly = "READONLY";
	}
    if ($nombre == 'num_cuestiones') {
		$readonly = "READONLY";
	}
    //....................varchar
	$pos = strpos($tipo,'archar(');
	if ($pos !== false) {
		$long = substr($tipo,$inicio+1,$final-$inicio-1);
	    //...si es una imaIcono
		
		//echo "es string..."; //debug
		
		//if ($nombre == 'programa_pdf'){
		//    $carpeta = "../CURSOSPROGRAMAS/";	
		//}
		
	   
		
		if ($carpeta != "") {
			if (is_dir($carpeta)) {
			    if ($dh = opendir($carpeta)) { 
			     $return =  '<select name="'.$nombre.'">';
				 $return = $return.'<option></option>';
                 while (($file = readdir($dh)) !== false) { 
				     if ($file == $valor) {
						 $selected = "selected";
					 } else {
						  $selected = "";
					 }
				     if ($file!="." && $file!="..") { 
				      $return = $return. '<option '.$selected.'>'.$file.'</option>';
				     }
				 }
               $return = $return.'</select>';
		       return $return; //..................................................................................input propio
			   }
		   }
		} // es una carpeta valida	
	} //de strpost false
	//.......................................................si es entero
	
	$valida = "";
	$pos = strpos($tipo,'int(');
	if ($pos !== false) {
      $long = substr($tipo,$inicio+1,$final-$inicio-1);
	  $valida = " onKeypress='return solonumeros()'";
	
	  
	  	if ($nombre == 'id_forosclases'){  //es un campo indice hay que hacer una select a su fichero
	      $return = hazSelectIndiceForosClases("forosclases","id",$valor,$conexion,"id_forosclases",0,1); 
		  return $return; //..................................................................................input propio
	  }

	
	  	
	}
   //.....................................
	//.... si no es varchar ni int el long sera de 12  sera textarea ?????
	if ($long <= 100) {
	    return "<input ".$readonly." id = '".$nombre."' name='".$nombre."' value='".$valor."' maxlength='".$long."'".$valida.' size = "'.$long.'"'."/>";
	} else {
		$colu = ($long /100 ) +1;
		return '<textarea name="'.$nombre.'" cols="100" rows="'.$colu.'">'.$valor.'</textarea>';

	}
}
///////////////////MaestrosLista///////////////////////////////////////////////////
function pintaTemas($conexion) {
    $query = 'show columns FROM forostemas';
    $datosLista = mysqli_query($conexion, $query);
	$nColumnas = mysqli_num_rows ($datosLista); 
    if ($nColumnas > 0) {
		$n = 0;
		 while ($row = mysqli_fetch_assoc($datosLista)) {
    		 $CampoMombre[$n] = $row['Field'];
			 $CampoTipo[$row['Field']] = $row['Type'];
			 $n++;
		 }
		
	}
    

//echo " ..................................................".$_REQUEST['operacion'];

if ($_REQUEST['operacion'] == "UPDATE"){
    $FormatMaestros = "UPDATE  forostemas SET ";
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

    $FormatMaestros = $FormatMaestros." WHERE  id = ".$_REQUEST['id'];

   //  echo $FormatMaestros;  

	$resMaestros = mysqli_query($conexion, $FormatMaestros) or die(mysqli_error($conexion));
	ActualizaNumTemas($_REQUEST['registro_clase'],$conexion);
} 
if ($_REQUEST['operacion'] == "INSERT"){
    $FormatMaestros = "INSERT INTO forostemas (";
    $n = 0;
    for( $i = 0; $i < $nColumnas ; $i++ ) {
	     if($n == 0){
		    $coma = "";
	     } else {
		    $coma = ", ";
	    }
	$FormatMaestros = $FormatMaestros.$coma.$CampoMombre[$i];
	$n++;
    }
	$FormatMaestros = $FormatMaestros.") VALUES ( NULL ";
    $coma = ", ";
	
	$ValorGrabar = "";
	for( $i = 1 ; $i < $nColumnas ; $i++ ) {
	    $ValorGrabar =  ValorVacioOk($_REQUEST[$CampoMombre[$i]],  $CampoTipo[$CampoMombre[$i]]);
	    $FormatMaestros = $FormatMaestros.$coma.$ValorGrabar;
	}
	$FormatMaestros = $FormatMaestros.")";
	  //
		  
    $resMaestros = mysqli_query($conexion, $FormatMaestros) or die(mysqli_error($conexion));
	ActualizaNumTemas($_REQUEST['registro_clase'],$conexion);
}  // ...... de insert
	
	if ($_REQUEST['filtro'] == "FILTRO_ID" && $_REQUEST['registro_clase'] !=0 && $_REQUEST['FechaFiltro'] <> "" && $_REQUEST['FechaFiltro'] <> "0000-00-00"){
		
		//echo "estamos en 1";
		
		
		$FormatMaestros = "SELECT id, id_forosclases, orden, tema, veces_visitado, fecha_alta, fecha_baja, esta_activo, num_cuestiones
		                    FROM forostemas
						   WHERE forostemas.id_forosclases = %d 
						     and fecha_alta >= '%s' 
						   ORDER by id";
		                   
    $queMaestros = sprintf($FormatMaestros,$_REQUEST['registro_clase'],$_REQUEST['FechaFiltro'] ); 
	
	 //echo "hoyhoy".$queMaestros;
	
	} elseif ($_REQUEST['filtro'] == "FILTRO_ID" && $_REQUEST['registro_clase'] != 0 ){
        	//echo "estamos en 2";
		$FormatMaestros = "SELECT id, id_forosclases, orden, tema, veces_visitado, fecha_alta, fecha_baja, esta_activo, num_cuestiones
		                   FROM forostemas
						   WHERE forostemas.id_forosclases = %d 
						   ORDER by id";
	
    $queMaestros = sprintf($FormatMaestros,$_REQUEST['registro_clase']); 
	
	} elseif ($_REQUEST['filtro'] == "FILTRO_ID" && $_REQUEST['FechaFiltro'] <> "" && $_REQUEST['FechaFiltro'] <> "0000-00-00"){
			//echo "estamos en 3";
		$FormatMaestros = "SELECT id, id_forosclases, orden, tema, veces_visitado, fecha_alta, fecha_baja, esta_activo, num_cuestiones
		                   FROM forostemas
						   WHERE fecha_alta >= '%s' 
						   ORDER by id";
    $queMaestros = sprintf($FormatMaestros,$_REQUEST['FechaFiltro']); 

	} else {
			//echo "estamos en 4";
		$FormatMaestros = "SELECT id, id_forosclases, orden, tema, veces_visitado, fecha_alta, fecha_baja, esta_activo, num_cuestiones
		                   FROM forostemas
						   ORDER by id";
    $queMaestros = sprintf($FormatMaestros); 
	}
	
   //..........ejecutar query 
   $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
   $totMaestros = mysqli_num_rows($resMaestros);

//echo "<br>totMaestros--->".$totMaestros;




if ($totMaestros> 0) {  //.....Registro de conexión
   echo "<div class = rowCabeceraAlumnos >";
   for( $i = 0; $i < $nColumnas ; $i++ ) {
		echo "<div class = ClassCABVarcharMenor3>".$CampoMombre[$i]."</div>";	
	 }
   echo "</div><br>";  // de rowGrupo		
   while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {
 	          echo '<A NAME="'.$rowRegistros['id'].'">';
			  
	          echo "<div class = 'rowAlumno' onclick='edita(".$rowRegistros[$CampoMombre[0]].")'>";  //siempre pasamos el primer campo, es la id QuimGrupos
			  for( $i = 0; $i < $nColumnas ; $i++ ) {

		     // echo $CampoMombre[$i].".........".tipoClase($CampoTipo[$CampoMombre[$i]]);
		      echo "<div class = ClassCABVarcharMenor4>".contenidoFigura($rowRegistros[$CampoMombre[$i]],$CampoMombre[$i],$conexion )."</div>";
	          }
			  echo "</div><br>";  // de rowSeccion	
  
          }

   echo "<div class = rowCabeceraAlumnos >";
   for( $i = 0; $i < $nColumnas ; $i++ ) {
		echo "<div class = ClassCABVarcharMenor3>".$CampoMombre[$i]."</div>";	
	 }
   echo "</div><br>";  		
}
     
/*mysqli_close($conexion);*/
return 0;
}
///////////////////MaestrosLista///////////////////////////////////////////////////
function tipoClase($tipo,$esCuerpo) {
	$inicio = strpos($tipo,'(');
	$final   =strpos($tipo,')');
	$complemento = "";
	$CAB = "";
    if ($esCuerpo == 0) { 
	 $CAB = "CAB";
	}
	//....................varchar
	$pos = strpos($tipo,'archar(');
	if ($pos !== false) {
		$long = substr($tipo,$inicio+1,$final-$inicio-1);
	    if ($long <= 60){
			$complemento = "Menor"; 
		} else {
			$complemento = "Mayor"; 
		}
		return "Class".$CAB."Varchar".$complemento;
	}
	//....................numero
	$pos = strpos($tipo,'int(');
	if ($pos !== false) {
		$long = substr($tipo,$inicio+1,$final-$inicio-1);
	    if ($long <= 5){
			$complemento = "Menor"; 
		} else {
			$complemento = "Mayor"; 
		}
		return "Class".$CAB."Number".$complemento;
	}
	$pos = strpos($tipo,'decimal(');
	if ($pos !== false) {
		$long = substr($tipo,$inicio+1,$final-$inicio-1);
	    if ($long <= 5){
			$complemento = "Menor"; 
		} else {
			$complemento = "Mayor"; 
		}
		return "Class".$CAB."Number".$complemento;
	}
	//....................date
	$pos = strpos($tipo,'date');
	if ($pos !== false) {
		return "Class".$CAB."Date";
	}
}
///////////////////MaestrosLista///////////////////////////////////////////////////
function contenidoFigura($contenidoCampo, $mombreCampo,$conexion){

$pos = strpos($mombreCampo,'foto');	
	if ($pos !== false) {
		return '<div class="IzquierdaGrupo"><img src="../imagenes/ingredientes/'.$contenidoCampo.'" width="40" height="40" /></div>'."<div class='DerechaGrupo'>".    $contenidoCampo."</div>";
	} 


if ($contenidoCampo == NULL) {
	return "&nbsp;";	
}

if ($contenidoCampo == '0000-00-00') {
	$contenidoCampo = "&nbsp;";
}


return mysqli_real_escape_string($conexion, substr($contenidoCampo,0,50));
}

///////////////////MaestrosLista///////////////////////////////////////////////////

//..........................................................................
function hazSelectIndiceFiltro($fichero,$campo,$valorID,$conexion,$nombreSelect,$activarBlanco,$open_close) {
	
 	
    if ($open_close == 0) {
	  $Activado = 'disabled';
    } else {
		$Activado = '';
	}
	
  $txtSelect ="";
  $FormatImagen = "select %s, clase  from %s  order by id ";
  $queImagen = sprintf($FormatImagen, $campo, $fichero); 
 
  $resImagen = mysqli_query($conexion, $queImagen) or die(mysqli_error($conexion));
  $totImagen = mysqli_num_rows($resImagen);	
  
//echo "...filas....".$totImagen; //debug
  ///echo " 33333333333"; 
  if ($totImagen> 0) {  //.....Registro de conexión
     $txtSelect = $txtSelect.'<select '.$Activado.' id = '.$nombreSelect.' name="'.$nombreSelect.'"';                  
  }
	$txtSelect = $txtSelect.' onchange="SeleccionaClase(this)"';
	 
	 $txtSelect = $txtSelect.'>';
	 if ($activarBlanco == 1) {
		 $txtSelect = $txtSelect. '<option value = "0" >Todas las clases';
	 }
	 
//echo "@@...fuera del ciclo..."; //debug
	 
     while ($rowImagen = mysqli_fetch_assoc($resImagen)) {

           //echo "@hoyhoy@...entro en el ciclo..."; //debug
	   
	   if ($rowImagen[$campo] == $valorID) {
			$selected = " selected";
		} else {
			$selected = "";
	   }
		 $valorEtiqueta = substr($rowImagen['id']."-".$rowImagen['clase'],0,70);	    
		 $txtSelect = $txtSelect. '<option value = "'.$rowImagen[$campo].'" '.$selected.'>'.$valorEtiqueta;
	   
     }
	 $txtSelect = $txtSelect.'</select> ';
  
  mysqli_free_result($resImagen);
  return $txtSelect;
}

///////////////////MaestrosLista///////////////////////////////////////////////////
function hazSelectIndiceForosClases($fichero,$campo,$valorID,$conexion,$nombreSelect,$activarBlanco,$open_close) {
	
    if ($open_close == 0) {
	  $Activado = 'disabled';
    } else {
		$Activado = '';
	}
	
 $txtSelect ="";
  $FormatImagen = "select %s, clase  from %s  order by id ";
  $queImagen = sprintf($FormatImagen, $campo, $fichero); 
 
  //echo " valor de conexion ".$conexion;  //debug
  
  $resImagen = mysqli_query($conexion, $queImagen) or die(mysqli_error($conexion));
  
  $totImagen = mysqli_num_rows($resImagen);	
  
//echo "...filas....".$totImagen; //debug
  ///echo " 33333333333"; 
  if ($totImagen> 0) {  //.....Registro de conexión
     $txtSelect = $txtSelect.'<select '.$Activado.' id = '.$nombreSelect.' name="'.$nombreSelect.'"';                  
	 if ($activarBlanco == 1) {
		///// $txtSelect = $txtSelect.' onchange="Selecciona(this)"';
	 }
	 
	 
	 $txtSelect = $txtSelect.'>';
	 if ($activarBlanco == 1) {
		 $txtSelect = $txtSelect. '<option value = "0" >Todos';
	 }
	 
//echo "@@...fuera del ciclo..."; //debug
	 
     while ($rowImagen = mysqli_fetch_assoc($resImagen)) {

//echo "@hoyhoy@...entro en el ciclo..."; //debug
	   
	   if ($rowImagen[$campo] == $valorID) {
			$selected = " selected";
		} else {
			$selected = "";
	   }
				    
		 $txtSelect = $txtSelect. '<option value = "'.$rowImagen[$campo].'" '.$selected.'>'.$rowImagen['clase'];
	   
     }
	 $txtSelect = $txtSelect.'</select> ';
  }
  mysqli_free_result($resImagen);
  return $txtSelect;
}
//..............................................................
function ActualizaNumTemas($clase,$conexion) {
$numero= 0;
$FormatTemas = "SELECT count(id) AS CONTADOR
                  FROM   forostemas
                 WHERE (forostemas.fecha_baja IS NULL OR YEAR(forostemas.fecha_baja) = 0  OR forostemas.fecha_baja >= CURDATE())
                   and forostemas.esta_activo = 1 
                   and id_forosclases = %d ";
$queTemas = sprintf($FormatTemas,$clase);
$resTemas = mysqli_query($conexion, $queTemas) or die(mysqli_error($conexion));  
$totTemas = mysqli_num_rows($resTemas);     
if ($totTemas > 0){
	while ($rowTemas = mysqli_fetch_assoc($resTemas)) {
		$numero = $rowTemas['CONTADOR'];
	}
}
mysqli_free_result($resTemas); 

$FormatTemas = "UPDATE forosclases set num_temas = %d WHERE id= %d";
$queTemas = sprintf($FormatTemas,$numero,$clase);
$resTemas = mysqli_query($conexion, $queTemas) or die(mysqli_error($conexion)); 
mysqli_free_result($resTemas);  
}
//..........................................................
function Volver(){
    if ($_REQUEST['registro_clase'] != 0){
       return $_REQUEST['volver_tema'];
    } else {
       return "mantenimiento.php"; 
        
    }
    
}
?>
