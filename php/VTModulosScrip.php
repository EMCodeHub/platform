<?php
include_once ('FicherosFunciones.php');
if (!isset($_REQUEST['operacion'])) {
	$_REQUEST['operacion'] = "NADA";
}
if (!isset($_REQUEST['id_modulo'])) {
	$_REQUEST['id_modulo'] = 0;
}
if (!isset($_REQUEST['filtro'])) {
	$_REQUEST['filtro'] = "";
}

if (!isset($_REQUEST['id_vtcurso'])) {
	$_REQUEST['id_vtcurso'] = 0;
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
	
	if ($nombre == 'titulo_mod'){
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
	if ($nombre == 'id_modulo') {
		$readonly = "READONLY";
	}
	
    //....................varchar
	$pos = strpos($tipo,'archar(');
	if ($pos !== false) {
		$long = substr($tipo,$inicio+1,$final-$inicio-1);
		if ($nombre == '*****programacurso'){
		    $carpeta = "../VIDEOTUTORIALES/".$carpeta_arx."/";	
		}
	
			
		if ($carpeta != "") {
			if (is_dir($carpeta)) {
			    if ($dh = opendir($carpeta)) { 
			     $return =  '<select name="'.$nombre. '" id="'.$nombre.'">';
				 $return = $return.'<option></option>';
				 
				 
				 $files = array();
				 while(false != ($file = readdir($dh))) {
                       if(($file != ".") and ($file != "..") ) {
                            $files[] = $file; // put in array.
                       }   
                  }
				  natsort($files); // sort.
				 
				 foreach($files as $file) {
                        //echo("<a href='$file'>$file</a> <br />\n");
                     if ($file == $valor) {
						 $selected = "selected";
					 } else {
						  $selected = "";
					 }
                     $return = $return. '<option '.$selected.'>'.$file.'</option>';
				 
				 
				  }  // foreach
				 



/*				 
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
*/				 
				 
				 
				 
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
	 
	 
	  if ($nombre == 'id_vtcurso'){  //es un campo indice hay que hacer una select a su fichero
	      $return = hazSelectIndiceCurso("vtcursos","id_curso",$valor,$conexion,"id_vtcurso",0,1); 
		  return $return; //..................................................................................input propio
	  }
	 
	 if ($nombre == 'id_*********'){  //es un campo indice hay que hacer una select a su fichero
	      $return = hazSelectIndiceSecciones("tipocurso","id",$_REQUEST['RecetaID'],$_REQUEST['SeccionID'],$conexion,"id_recetaseccion",0,1); 
		  return $return; //..................................................................................input propio
	  }

	 
	  	
	}
   //.....................................
	//.... si no es varchar ni int el long sera de 12  sera textarea ?????
	if ($long <= 100) {
	    return "<input ".$readonly." id = '".$nombre."' name='".$nombre."' value='".$valor."' maxlength='".$long."'".$valida.' size = "'.$long.'"'."/>";
	} else {
		$colu = ($long /100 ) +1;
		return '<textarea name="'.$nombre.'" id = "'.$nombre.'" cols="100" rows="'.$colu.'">'.$valor.'</textarea>';

	}
}
///////////////////MaestrosLista///////////////////////////////////////////////////
function pintaVTModulos($conexion) {
    $query = 'show columns FROM vtcursomodulo';
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
    $FormatMaestros = "UPDATE  vtcursomodulo SET ";
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

    $FormatMaestros = $FormatMaestros." WHERE  id_modulo = ".$_REQUEST['id_modulo'];
		
	
	$resMaestros = mysqli_query($conexion, $FormatMaestros) or die(mysqli_error($conexion));
	
	;
	
} 
if ($_REQUEST['operacion'] == "INSERT"){
	    $FormatMaestros = "INSERT INTO vtcursomodulo (";
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
	
}  // ...... de insert

	
$FormatMaestros = "SELECT  id_modulo, id_vtcurso, vtcursomodulo.esta_activo, orden_mod, titulo_mod 
                   FROM    vtcursomodulo, vtcursos
				   where  vtcursomodulo.id_vtcurso = vtcursos.id_curso
				   ORDER   BY orden, orden_mod";


	//echo "<br>".$FormatMaestros."<br>";
	
	
	
	
	
	
	
	
	
	$queMaestros = sprintf($FormatMaestros); 
    
	
	
	//echo "<br>@@@@@@1111111@@@@@@ ".$queMaestros."<br>"; //debug

 
    if ($_REQUEST['filtro'] == "FILTRO_ID" && $_REQUEST['id_vtcurso'] !=0) {
		
	    $FormatMaestros = "SELECT  id_modulo, id_vtcurso, esta_activo, orden_mod, titulo_mod FROM vtcursomodulo  where id_vtcurso = %d ORDER BY orden_mod";

	    $queMaestros = sprintf($FormatMaestros,$_REQUEST['id_vtcurso']); 
		
		//echo  <br>@@@@@@22222222@@@@@@ ".$queMaestros."<br>"; //debug
		
    } 
    
   
    
 /*
    else if ($_REQUEST['filtro'] == "FILTRO_ID" && $_REQUEST['RecetaID'] !=0) {
		$FormatMaestros = "SELECT B.id_grupo as DESP_01, B.orden as DESP_O2,  C.orden as DESP_O3, 
        D.id, D.id_recetaseccion, D.orden, D.foto, D.descripcion, D.cantidad
        from recetas B, recetassecciones C, ingredientes D
		where B.id = %d 
        and C.id_receta = B.id   
		and   D.id_recetaseccion = C.id 
        order by DESP_01, DESP_O2, DESP_O3, D.orden";
	    $queMaestros = sprintf($FormatMaestros,$_REQUEST['RecetaID']); 	
		
		///echo "<br>@@@@@@3333333@@@@@@ ".$queMaestros."<br>"; //debug
		
		
	} else {
		;
	}
*/

   //..........ejecutar query 
   $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion));
   $totMaestros = mysqli_num_rows($resMaestros);

//echo "<br>totMaestros--->".$totMaestros;




if ($totMaestros> 0) {  //.....Registro de conexión
   echo "<div class = rowCabeceraVTCursos >";
   for( $i = 0; $i < $nColumnas ; $i++ ) {
		echo "<div class = ".tipoClase($CampoTipo[$CampoMombre[$i]],0).">".$CampoMombre[$i]."</div>";	
	 }
   echo "</div><br>";  // de rowGrupo		
   while ($rowRegistros = mysqli_fetch_assoc($resMaestros)) {
   	
  	
	          echo '<A NAME="'.$rowRegistros['id_modulo'].'">';
			  
	          echo "<div class = 'rowVTCurso' onclick='edita(".$rowRegistros[$CampoMombre[0]].")'>";  //siempre pasamos el primer campo, es la id QuimGrupos
			  for( $i = 0; $i < $nColumnas ; $i++ ) {

		     // echo $CampoMombre[$i].".........".tipoClase($CampoTipo[$CampoMombre[$i]]);
		      echo "<div class = ".tipoClase($CampoTipo[$CampoMombre[$i]],1).">".contenidoFigura($rowRegistros[$CampoMombre[$i]],$CampoMombre[$i],$conexion )."</div>";
	          }
			  echo "</div><br>";  // de rowSeccion	
			  
			  
			  
			  
          }
   
   
   
   
   
   
   
   
   echo "<div class = rowCabeceraVTCursos >";
   for( $i = 0; $i < $nColumnas ; $i++ ) {
		echo "<div class = ".tipoClase($CampoTipo[$CampoMombre[$i]],0).">".$CampoMombre[$i]."</div>";	
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
	$pos = strpos($tipo,'int');
	if ($pos !== false) {
		return "Class".$CAB."Number"."Mayor";
	}



//

    //$pos = strpos($tipo,'int(');


	//if ($pos !== false) {
		//$long = substr($tipo,$inicio+1,$final-$inicio-1);
	    //if ($long <= 5){
			//$complemento = "Menor"; 
		//} else {
			//$complemento = "Mayor"; 
		//}
		//return "Class".$CAB."Number".$complemento;
	//}

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
		return '<div class="IzquierdaGrupo"><img src="../imagenes/ingredientes/'.$contenidoCampo.'" width="40" height="40" /></div>'."<div class='DerechaGrupo'>".$contenidoCampo."</div>";
	} 


if ($contenidoCampo == NULL) {
	return "&nbsp;";	
}




return mysqli_real_escape_string($conexion, substr($contenidoCampo,0,50));
}

///////////////////MaestrosLista///////////////////////////////////////////////////
function hazSelectIndiceCurso($fichero,$campo,$valorID,$conexion,$nombreSelect,$activarBlanco,$open_close) {
	
    if ($open_close == 0) {
	  $Activado = 'disabled';
    } else {
		$Activado = '';
	}
	
 $txtSelect ="";
  $FormatImagen = "select %s, titulo_cur  from %s  order by id_curso ";
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
		$tit = $rowImagen['id_curso']."-".$rowImagen['titulo_cur'];
		if (strlen($tit) > 120) {
			$tit  = substr($tit,0,120);
		}
		
		
		 $txtSelect = $txtSelect. '<option value = "'.$rowImagen[$campo].'" '.$selected.'>'.$tit;
	   
     }
	 $txtSelect = $txtSelect.'</select> ';
  }
  mysqli_free_result($resImagen);
  return $txtSelect;
}



function hazSelectIndiceGenerico($fichero,$campo,$valorID,$conexion,$nombreSelect,$activarBlanco,$open_close) {
	
    if ($open_close == 0) {
	  $Activado = 'disabled';
    } else {
		$Activado = '';
	}
	
 $txtSelect ="";
  $FormatImagen = "select %s, descripcion from %s  order by descripcion ";
  $queImagen = sprintf($FormatImagen, $campo, $fichero); 
  
  

  
  //echo " valor de conexion ".$conexion;  //debug
  
  $resImagen = mysqli_query($conexion, $queImagen) or die(mysqli_error($conexion));
  
  
  
  $totImagen = mysqli_num_rows($resImagen);	
  
//echo "...filas....".$totImagen; //debug
  ///echo " 33333333333"; 
  if ($totImagen> 0) {  //.....Registro de conexión
     $txtSelect = $txtSelect.'<select '.$Activado.' id = '.$nombreSelect.' name="'.$nombreSelect.'"';                  
	 if ($activarBlanco == 1) {
		 $txtSelect = $txtSelect.' onchange="Selecciona(this)"';
	 }
	 
	 
	 $txtSelect = $txtSelect.'>';
	 if ($activarBlanco == 1) {
		 $txtSelect = $txtSelect. '<option value = "0" >Todas';
	 }
	 
//echo "@@...fuera del ciclo..."; //debug
	 
     while ($rowImagen = mysqli_fetch_assoc($resImagen)) {

//echo "@@...entro en el ciclo..."; //debug
	   
	   if ($rowImagen[$campo] == $valorID) {
			$selected = " selected";
		} else {
			$selected = "";
	   }
				    
		 $txtSelect = $txtSelect. '<option value = "'.$rowImagen[$campo].'" '.$selected.'>'.$rowImagen['descripcion'];
	   
     }
	 $txtSelect = $txtSelect.'</select> ';
  }
  mysqli_free_result($resImagen);
  return $txtSelect;
}
///////////////////MaestrosLista///////////////////////////////////////////////////
function hazSelectIndiceFiltro($fichero,$campo,$recetaID,$valorID,$conexion,$nombreSelect,$activarBlanco,$open_close) {
	$Activado = '';
	
	
 $txtSelect ="";
  $FormatImagen = "select %s, titulo_cur from %s   order by id_curso ";
  $queImagen = sprintf($FormatImagen, $campo, $fichero); 
  $resImagen = mysqli_query($conexion, $queImagen) or die(mysqli_error($conexion));
  $totImagen = mysqli_num_rows($resImagen);	
/* if ($totImagen > 1) {  // Eliminamos la seccion General
      $FormatImagen = "select %s, descripcion_corta from %s  where id_organizador = %d  and es_visible > 0 order by orden ";
      $queImagen = sprintf($FormatImagen, $campo, $fichero, $recetaID); 
  
      $resImagen = mysqli_query($conexion, $queImagen) or die(mysqli_error($conexion));  
      $totImagen = mysqli_num_rows($resImagen);	
} */


  ///echo " 33333333333"; 
 if ($totImagen > 0) {  //.....Registro de conexión
     $txtSelect = $txtSelect.'<select '.$Activado.' id = '.$nombreSelect.' name="'.$nombreSelect.'"';                  
	 
	  $txtSelect = $txtSelect.' onchange="SeleccionaCurso(this)"';
	 
	 $txtSelect = $txtSelect.'>';
	 if ($activarBlanco == 1 and $totImagen > 1) {
		 $txtSelect = $txtSelect. '<option value = "0" >Todos';
	 }
	 
     //echo "@@...fuera del ciclo..."; //debug
	 
     while ($rowImagen = mysqli_fetch_assoc($resImagen)) {
	   
	   if ($rowImagen[$campo] == $valorID or $totImagen == 1) {
			$selected = " selected";
	   } else {
			$selected = "";
	   }
	   
	   $valorOpcion = $rowImagen['id_curso']."-".$rowImagen['titulo_cur'];	  
	   if (strlen($valorOpcion)>90){
		   $valorOpcion =  substr($valorOpcion,0,90);
	   }
	   
	   
	     
	   $txtSelect = $txtSelect. '<option value = "'.$rowImagen[$campo].'" '.$selected.'>'.$valorOpcion;
     }
	 $txtSelect = $txtSelect.'</select> ';
  }
  mysqli_free_result($resImagen);
  return $txtSelect;
}

////////////////////////////////////////////////////////////////////////////
function DescripcionCurso($idCurso,$conexion) {
   $devolver ="";
   $FormatVTCursos = "SELECT titulo_cur FROM vtcursos where  id_curso =%d";
   $queVTCursos = sprintf($FormatVTCursos, $idCurso); 

   
   $resVTCursos = mysqli_query($conexion, $queVTCursos) or die(mysqli_error($conexion));
    
   $totVTCursos = mysqli_num_rows($resVTCursos);
   if ($totVTCursos> 0) {  //.....Registro de conexión
   	 while ($rowRegistros = mysqli_fetch_assoc($resVTCursos)) {
		$tit =  $rowRegistros['titulo_cur'];
   	 	$devolver = $tit;
   	 }
    }
  mysqli_free_result($resVTCursos);	
	return $devolver;
	
}
?>
