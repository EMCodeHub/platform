<?php
include_once ('FicherosFunciones.php');
if (!isset($_REQUEST['operacion'])) {
	$_REQUEST['operacion'] = "NADA";
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
	
                                                        
	                                        
	if ($nombre == 'twocheck_respuesta'){
		return TRUE;                             
	}  
    if ($nombre == 'twocheck_respnocurso'){
		return TRUE;                             
	} 
	                                        
	if ($nombre == 'twocheck_notif'){
		return TRUE;                             
	} 
	if ($nombre == 'twocheck_notif'){
		return TRUE;                             
	}                                          
                                         
	if ($nombre == 'twocheck_real_inicio'){
		return TRUE;                             
	}                                          
	if ($nombre == 'twocheck_real_id'){
		return TRUE;                             
	}                                          
	if ($nombre == 'twocheck_real_word'){
		return TRUE;                             
	}                                          
	if ($nombre == 'transfer_cuenta'){
		return TRUE;                             
	}                                          
	if ($nombre == 'transfer_entidad'){
		return TRUE;                             
	}                                          
	if ($nombre == 'transfer_obser'){
		return TRUE;                             
	}
	if ($nombre == 'transfer_beneficiario'){
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
	$directorio = "";
	if ($nombre == 'id') {
		$readonly = "READONLY";
	}
	
    //....................varchar
	$pos = strpos($tipo,'archar(');
	if ($pos !== false) {
		$long = substr($tipo,$inicio+1,$final-$inicio-1);
	   
	
	   

		if ($nombre == '****carpetadeficheros'){ // sera un directorio
		    $directorio = "../VIDEOTUTORIALES/";	
		}
		if ($directorio != "") { 
		
			if (is_dir($directorio)) {
			    if ($dh = opendir($directorio)) { 
			     $return =  '<select id='.$nombre.' name="'.$nombre.'"'.' onchange="procesar(1)"'.'>';
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
			   } //opendir
		   }  // is_dir
				
		
		} else {  
			
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
				 

				 
				 
/*                 while (($file = readdir($dh)) !== false) { 
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
	} // de directorio
	} //de strpost false
	//.......................................................si es entero
	
	$valida = "";
	$pos = strpos($tipo,'int(');
	if ($pos !== false) {
      $long = substr($tipo,$inicio+1,$final-$inicio-1);
	  $valida = " onKeypress='return solonumeros()'";
	 
		 
	 
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
function hazSelectIndiceCategoria($fichero,$campo,$valorID,$conexion,$nombreSelect,$activarBlanco,$open_close) {
	
    if ($open_close == 0) {
	  $Activado = 'disabled';
    } else {
		$Activado = '';
	}
	
 $txtSelect ="";
  $FormatImagen = "select %s, descripcion  from %s  order by orden ";
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
				    
		 $txtSelect = $txtSelect. '<option value = "'.$rowImagen[$campo].'" '.$selected.'>'.$rowImagen['descripcion'];
	   
     }
	 $txtSelect = $txtSelect.'</select> ';
  }
  mysqli_free_result($resImagen);
  return $txtSelect;
}


?>
