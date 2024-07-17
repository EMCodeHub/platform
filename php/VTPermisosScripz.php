<?php
include_once ('FicherosFunciones3.php');
if (!isset($_REQUEST['operacion'])) {
	$_REQUEST['operacion'] = "NADA";
}
if (!isset($_REQUEST['id'])) {
	$_REQUEST['id'] = 0;
}
if (!isset($_REQUEST['filtro'])) {
	$_REQUEST['filtro'] = "FILTRO_ID"; 
}
if (!isset($_REQUEST['FechaFiltro'])) {
		$_REQUEST['FechaFiltro'] = date("Y-m-d",strtotime($fecha_actual."- 30 days"));
}

/*if (!isset($_REQUEST['CursoID'])) {
	$_REQUEST['CursoID'] = 0;
}
*/


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

	if ($nombre == 'observaciones_medif'){
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
	 
	 
	  if ($_REQUEST['alta'] == 1) {
	 
	     if ($nombre == 'id_usuario'){  //es un campo indice hay que hacer una select a su fichero
	         $return = hazSelectIndiceUsuario("vtalumnos","id",$valor,$conexion,"id_usuario",0,1); 
		  return $return; //..................................................................................input propio
	     }
	     if ($nombre == 'id_cobro'){  //es un campo indice hay que hacer una select a su fichero
	         $return = hazSelectIndiceCobro("vtcobros","id",$valor,$conexion,"id_cobro",0,1); 
		  return $return; //..................................................................................input propio
	     }
		 if ($nombre == 'id_curso'){  //es un campo indice hay que hacer una select a su fichero
	         $return = hazSelectIndiceCursos("vtcursos","id_curso",$valor,$conexion,"id_curso",0,1); 
		  return $return; //..................................................................................input propio
	     }
	 
		 
		 
	  } else {
		 if ($nombre == 'id_usuario'){  //es un campo indice hay que hacer una select a su fichero
	         $return = hazSelectIndiceUsuario("vtalumnos","id",$valor,$conexion,"id_usuario",0,0); 
		  return $return; //..................................................................................input propio
	     }
	     if ($nombre == 'id_cobro'){  //es un campo indice hay que hacer una select a su fichero
	         $return = hazSelectIndiceCobro("vtcobros","id",$valor,$conexion,"id_cobro",0,0); 
		  return $return; //..................................................................................input propio
	     }
		 if ($nombre == 'id_curso'){  //es un campo indice hay que hacer una select a su fichero
	         $return = hazSelectIndiceCursos("vtcursos","id_curso",$valor,$conexion,"id_curso",0,0); 
		  return $return; //..................................................................................input propio
	     }
	  } // de $_REQUEST['alta'] == 1 ---------------------------
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
//////////////////////////////////////////////////////////////////////////////////
function ExistePermiso($usuario,$curso,$conexion) {  //todos los permisos, activos y caducados
	$FormatMaestros = "SELECT  vtpermisos.id_curso
                         FROM vtpermisos
				        WHERE vtpermisos.id_curso = %d
					      and id_usuario   = %d 
					  ";
    $queMaestros = sprintf($FormatMaestros, $curso, $usuario);
    $resMaestros = mysqli_query($conexion, $queMaestros) or die(mysqli_error($conexion)); 
    $totMaestros = mysqli_num_rows($resMaestros);     
     if ($totMaestros > 0){
        return true;         
     }	
	 return false;		 				 
}
///////////////////MaestrosLista///////////////////////////////////////////////////
function pintaPermisosAlumno($conexion) {
    $query = 'show columns FROM vtpermisos';
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
    $FormatMaestros = "UPDATE  vtpermisos SET ";
    $n = 0;
	$ValorGrabar = "";
    for( $i = 0; $i < $nColumnas ; $i++ ) {
	     if($n == 0){
		    $coma = "";
	     } else {
		    $coma = ", ";
	     }
	if ($CampoMombre[$i] != "id_curso" && $CampoMombre[$i] != "id_usuario" && $CampoMombre[$i] != "id_cobro") { 
	    $ValorGrabar =  ValorVacioOk($_REQUEST[$CampoMombre[$i]],  $CampoTipo[$CampoMombre[$i]]);
	    $FormatMaestros = $FormatMaestros.$coma.$CampoMombre[$i]." = ".$ValorGrabar." ";
	}
	$n++;
    }

    $FormatMaestros = $FormatMaestros." WHERE  id = ".$_REQUEST['id'];
    // echo $FormatMaestros;  
	$resMaestros = mysqli_query($conexion, $FormatMaestros) or die(mysqli_error($conexion));
} 
if ($_REQUEST['operacion'] == "INSERT"){
  if (ExistePermiso($_REQUEST['id_usuario'],$_REQUEST['id_curso'],$conexion) ) {	
	echo "<br />Usuario -->".$_REQUEST['id_usuario'];
	echo "<br />Curso --->".$_REQUEST['id_curso']."<br /><br />";
	echo "<br />NO le hemos dado de alta porque ya tiene un PERMISO para ese curso, modifique las fechas de inicio y fin ....  <br /><br />";
	
  } else {
	$FormatMaestros = "INSERT INTO vtpermisos (";
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
    $resMaestros = mysqli_query($conexion, $FormatMaestros) or die(mysqli_error($conexion));
  } // ...... de ExistePermisoActivo
	
}  // ...... de insert





	
if  ($_REQUEST['filtro'] == "FILTRO_ID" && $_REQUEST['id_usuario'] !=0 && $_REQUEST['FechaFiltro'] <> "" && $_REQUEST['FechaFiltro'] <> "0000-00-00") {
	    $FormatMaestros = "SELECT id, id_cobro, id_usuario, id_curso, fecha_ini, fecha_fin, fecha_solici_certifi, fecha_entreg_certifi
		                   FROM vtpermisos
		                   WHERE fecha_ini  >= '%s'
		                   AND  vtpermisos.id_usuario = %d
						   ORDER by fecha_ini";
	     $queMaestros = sprintf($FormatMaestros,$_REQUEST['FechaFiltro'],$_REQUEST['id_usuario']);

} elseif  ($_REQUEST['filtro'] == "FILTRO_ID"  && $_REQUEST['FechaFiltro'] <> "" && $_REQUEST['FechaFiltro'] <> "0000-00-00") {
         $FormatMaestros = "SELECT id, id_cobro, id_usuario, id_curso, fecha_ini, fecha_fin, fecha_solici_certifi, fecha_entreg_certifi
		                   FROM vtpermisos
		                   WHERE fecha_ini  >= '%s'
		                   ORDER by fecha_ini";
	     $queMaestros = sprintf($FormatMaestros,$_REQUEST['FechaFiltro']);



} elseif  ($_REQUEST['filtro'] == "FILTRO_ID" && $_REQUEST['id_usuario'] !=0 ){
		$FormatMaestros = "SELECT id, id_cobro, id_usuario, id_curso, fecha_ini, fecha_fin, fecha_solici_certifi, fecha_entreg_certifi
		                   FROM vtpermisos
						   WHERE vtpermisos.id_usuario = %d 
						   ORDER by fecha_ini";
		                   
         $queMaestros = sprintf($FormatMaestros,$_REQUEST['id_usuario']); 
         
} else {
	  		
		$FormatMaestros = "SELECT id, id_cobro, id_usuario, id_curso, fecha_ini, fecha_fin, fecha_solici_certifi, fecha_entreg_certifi
		                   FROM vtpermisos
						   ORDER by fecha_ini";
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
function hazSelectIndiceCursos($fichero,$campo,$valorID,$conexion,$nombreSelect,$activarBlanco,$open_close) {	
    if ($open_close == 0) {
	  $Activado = 'disabled';
    } else {
		$Activado = '';
	}
  $txtSelect ="";
  $FormatImagen = "select %s, titulo_cur  from %s  order by  id_curso ";
  $queImagen = sprintf($FormatImagen, $campo, $fichero); 
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
	     $valorEtiqueta =	$rowImagen['id_curso']."-".$rowImagen['titulo_cur'].'                                                                        ';	    
		 $valorEtiqueta = substr($valorEtiqueta,0,125);
		 $txtSelect = $txtSelect. '<option value = "'.$rowImagen[$campo].'" '.$selected.'>'.$valorEtiqueta;
	   
     }
	 $txtSelect = $txtSelect.'</select> ';
  }
  mysqli_free_result($resImagen);
  return $txtSelect;
}
/////////////////////////////////////////////////////////////////////////////
function hazSelectIndiceUsuario($fichero,$campo,$valorID,$conexion,$nombreSelect,$activarBlanco,$open_close) {	
    if ($open_close == 0) {
	  $Activado = 'disabled';
    } else {
		$Activado = '';
	}
  $txtSelect ="";
  $FormatImagen = "select %s, email  from %s  order by  email ";
  $queImagen = sprintf($FormatImagen, $campo, $fichero); 
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
	     $valorEtiqueta =	$rowImagen['email'].'                                                                                                                            ';	    
		 $valorEtiqueta = substr($valorEtiqueta,0,125);
		 $txtSelect = $txtSelect. '<option value = "'.$rowImagen[$campo].'" '.$selected.'>'.$valorEtiqueta;
	   
     }
	 $txtSelect = $txtSelect.'</select> ';
  }
  mysqli_free_result($resImagen);
  return $txtSelect;
}


/////////////////////////////////////////////////////////////////////////////
function hazSelectIndiceCobro($fichero,$campo,$valorID,$conexion,$nombreSelect,$activarBlanco,$open_close) {	
    if ($open_close == 0) {
	  $Activado = 'disabled';
    } else {
		$Activado = '';
	}
  $txtSelect ="";
  $FormatImagen = "select %s, email_cliente, numero_factura, importe, fecha_emision  from %s  order by  email_cliente,  fecha_emision";
  $queImagen = sprintf($FormatImagen, $campo, $fichero); 
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
	     $valorEtiqueta =	$rowImagen['email_cliente'].'=>'.$rowImagen['numero_factura'].'=>'.$rowImagen['importe'].'$'.'                                                                                                                            ';	    
		 $valorEtiqueta = substr($valorEtiqueta,0,125);
		 $txtSelect = $txtSelect. '<option value = "'.$rowImagen[$campo].'" '.$selected.'>'.$valorEtiqueta;
	   
     }
	 $txtSelect = $txtSelect.'</select> ';
  }
  mysqli_free_result($resImagen);
  return $txtSelect;
}





function hazSelectIndiceFiltro($fichero,$campo,$valorID,$conexion,$nombreSelect,$activarBlanco,$open_close) {
	
 	
    if ($open_close == 0) {
	  $Activado = 'disabled';
    } else {
		$Activado = '';
	}
	
  $txtSelect ="";
  $FormatImagen = "select %s, id, email   from %s  order by email ";
  $queImagen = sprintf($FormatImagen, $campo, $fichero); 
   
  $resImagen = mysqli_query($conexion, $queImagen) or die(mysqli_error($conexion));
  $totImagen = mysqli_num_rows($resImagen);	
  
//echo "...filas....".$totImagen; //debug
  ///echo " 33333333333"; 
  if ($totImagen> 0) {  //.....Registro de conexión
     $txtSelect = $txtSelect.'<select '.$Activado.' id = '.$nombreSelect.' name="'.$nombreSelect.'"';                  
  }
	$txtSelect = $txtSelect.' onchange="SeleccionaAlumno(this)"';
	 
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
		 $valorEtiqueta = substr($rowImagen['email'],0,70);	    
		 $txtSelect = $txtSelect. '<option value = "'.$rowImagen[$campo].'" '.$selected.'>'.$valorEtiqueta;
	   
     }
	 $txtSelect = $txtSelect.'</select> ';
  
  mysqli_free_result($resImagen);
  return $txtSelect;
}

///////////////////MaestrosLista///////////////////////////////////////////////////


?>
